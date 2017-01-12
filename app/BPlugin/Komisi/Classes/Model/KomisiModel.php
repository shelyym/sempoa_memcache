<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/27/16
 * Time: 8:41 PM
 */

class KomisiModel extends Model{
    var $table_name = "vp__komisi";
    var $main_id    = "komisi_id";

    //Default Coloms for read
    public $default_read_coloms = "komisi_id,komisi_order_id,komisi_acc_id,komisi_app_id,komisi_app_client_id,komisi_app_date,komisi_paket_id,komisi_value,komisi_status";

//allowed colom in CRUD filter
    public $coloumlist = "komisi_id,komisi_order_id,komisi_acc_id,komisi_app_id,komisi_app_client_id,komisi_app_date,komisi_paket_id,komisi_value,komisi_status,komisi_bagi_pertama_date,komisi_bagi_pertama_value,komisi_sisa,komisi_bagi_kedua_date,komisi_bagi_kedua_value,komisi_ting_tong,komisi_tingtong_date";
    public $komisi_id;
    public $komisi_order_id;
    public $komisi_acc_id;
    public $komisi_app_id;
    public $komisi_app_client_id;
    public $komisi_app_date;
    public $komisi_paket_id;
    public $komisi_value;
    public $komisi_status; //0 = unpaid //1= processed half paid //2=paid half //3=processed full paid //4=full paid
    public $komisi_bagi_pertama_date;
    public $komisi_bagi_pertama_value;
    public $komisi_sisa;
    public $komisi_bagi_kedua_date;
    public $komisi_bagi_kedua_value;
    public $komisi_ting_tong;
    public $komisi_tingtong_date;

    public $crud_webservice_allowed = "komisi_id,komisi_order_id,komisi_acc_id,komisi_app_id,komisi_app_client_id,komisi_app_date,komisi_paket_id,komisi_value,komisi_status,komisi_bagi_pertama_date,komisi_bagi_pertama_value,komisi_sisa,komisi_bagi_kedua_date,komisi_bagi_kedua_value,komisi_ting_tong,komisi_tingtong_date";


    public static function log($app,$vpt){

        if($app->app_active != 1){
            die("App harus active utk dapat komisi");
        }

        $acc = new Account();
        $acc->getByID($app->app_client_id);

//        AppAccount::checkOwnership($app);

        if($acc->admin_marketer!=""){
            $arrAcc = $acc->getWhere("admin_username = '{$acc->admin_marketer}' LIMIT 0,1");
            if(count($arrAcc)>0) {
                $marketer = $arrAcc[0];
            }else{
                //set default marketer to 7 /elroy
                $marketer = new Account();
                $marketer->getByID(Efiwebsetting::getData("Default_Agent_ID"));
            }
        }
        else{
            //set default marketer to 7 /elroy
            $marketer = new Account();
            $marketer->getByID(Efiwebsetting::getData("Default_Agent_ID"));
        }

        $paket = new Paket();
        $paket->getByID($app->app_paket_id);



        $komisi = new KomisiModel();
        $komisi->komisi_acc_id = $marketer->admin_id;
        $komisi->komisi_app_client_id = $app->app_client_id;
        $komisi->komisi_app_date = leap_mysqldate();
        $komisi->komisi_app_id = $app->app_id;
        $komisi->komisi_paket_id = $paket->paket_id;
        $komisi->komisi_value = $paket->paket_komisi;
        $komisi->komisi_status = 0; //blm dibayarkan
        $komisi->komisi_sisa = $paket->paket_komisi;
        $komisi->komisi_order_id = $vpt->order_id;
        $komisi->komisi_bagi_pertama_value = $paket->paket_komisi_satu;
        $komisi->komisi_bagi_kedua_value = $paket->paket_komisi_dua;

        //langsung save datenya saja sehingga gampang


        $pay1_date = getFirstDayOfNextMonth(date("n",strtotime($komisi->komisi_app_date)),date("Y",strtotime($komisi->komisi_app_date)));
        $pay2_date = getFirstDayOfNext4Month(date("n",strtotime($komisi->komisi_app_date)),date("Y",strtotime($komisi->komisi_app_date)));


        if($paket->paket_id != 1) {
            $komisi->komisi_bagi_pertama_date = $pay1_date;
            $komisi->komisi_bagi_kedua_date = $pay2_date;
        }


        $succ = $komisi->save();

        if($succ) {
            $isPending = 0;
            if ($paket->paket_id == 1) {
                $isPending = 1;
            }

            //email dpt komisi
            $dpt = new DataEmail();
            $dpt->dapatKomisi($marketer->admin_email, $paket->paket_komisi, $isPending, $acc->admin_nama_depan, $marketer->admin_isAgent);


            //tambah counter paket //atau ambil counter paket disini
            if ($paket->paket_id == 1) { //free

                //check sudah ada brp paid yang sudah dibayar dll
                //cek apa bisa tingtong
                self::checkTingTongFree($app, $marketer,$succ,$paket,$acc,"free");

                $komisi = new KomisiModel();
                $nr = $komisi->getJumlah("komisi_acc_id = '{$marketer->admin_id}' AND komisi_paket_id = 1");

                $marketer->admin_total_free_sales = $nr;
                $marketer->load = 1;
                $marketer->save();


            } else {


                //pakai BagiKomisi

                //cek apa bisa di tingtong
                self::checkTingTongFree($app, $marketer,$succ,$paket,$acc,"paid");

                $komisi = new KomisiModel();
                $nr = $komisi->getJumlah("komisi_acc_id = '{$marketer->admin_id}' AND (komisi_paket_id = 2 OR komisi_paket_id = 3)");

                $marketer->admin_total_paid_sales = $nr;
                $marketer->load = 1;
                $marketer->save();

                //cek sudah kena kelipatan 6 blom
                $bonus = new BonusKomisi();
                $bonus->getByID($nr);

                if($bonus->bk_bonus_paid != "" && $bonus->bk_bonus_paid>0 ){
                    //masukan ke bonus
                    $bagiKomisi = new BagiKomisi();
                    $bagiKomisi->bagi_id = $marketer->admin_id."_".$nr;
                    $bagiKomisi->bagi_acc_id = $marketer->admin_id;
                    $bagiKomisi->bagi_bk_id = $nr;
                    $bagiKomisi->bagi_date_acquire = leap_mysqldate();
                    $bagiKomisi->bagi_status = 0; //unpaid
                    $bagiKomisi->bagi_value = $bonus->bk_bonus_paid;
                    $bagiKomisi->save();
                }
            }


        }
    }


    static function checkTingTong($app,$agent,$kom_id,$paket,$acc,$mode="free"){

        $km = new KomisiModel();

        if($mode == "free") {
            //cari yang paid
            $arrKom = $km->getWhere("komisi_acc_id = '{$agent->admin_id}' AND (komisi_paket_id = 2 OR komisi_paket_id = 3) AND komisi_ting_tong = 0 ORDER BY komisi_app_date ASC LIMIT 0,1");
        }else{
            $arrKom = $km->getWhere("komisi_acc_id = '{$agent->admin_id}' AND (komisi_paket_id = 1) AND komisi_ting_tong = 0 ORDER BY komisi_app_date ASC LIMIT 0,1");

        }

        if(count($arrKom)>0){
            //ada yang paid bisa ditingtong
            $km = $arrKom[0];
            $km->komisi_ting_tong = 1; //tingtong
            $km->komisi_tingtong_date = leap_mysqldate();
            $km->save();

            $pay1_date = getFirstDayOfNextMonth(date("n",strtotime($km->komisi_tingtong_date)),date("Y",strtotime($km->komisi_tingtong_date)));
            $pay2_date = getFirstDayOfNext4Month(date("n",strtotime($km->komisi_tingtong_date)),date("Y",strtotime($km->komisi_tingtong_date)));




            if($km->komisi_paket_id == "1"){

                $km->komisi_bagi_pertama_date = $pay1_date;
                $km->komisi_bagi_kedua_date = $pay2_date;
                $km->save();

            }

            $kmsatunya = new KomisiModel();
            $kmsatunya->getByID($kom_id);
            $kmsatunya->komisi_ting_tong = 1;
            $kmsatunya->komisi_tingtong_date = leap_mysqldate();
            $kmsatunya->save();

            if($kmsatunya->komisi_paket_id == "1"){

                $kmsatunya->komisi_bagi_pertama_date = $pay1_date;
                $kmsatunya->komisi_bagi_kedua_date = $pay2_date;
                $kmsatunya->save();

            }

            //send email
            //email dpt komisi
            $dpt = new DataEmail();
            $dpt->dapatKomisiTingTong($agent->admin_email, $paket->paket_komisi, 0, $acc->admin_nama_depan, $agent->admin_isAgent);


            //nanti cari yang free dan sudah tingtong dan belum dibayarkan
            //untuk dibayarkan
        }


    }


} 