<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/6/16
 * Time: 10:19 AM
 */

class AppearSales {

    /*
     * AGENT FUNCTIONS
     */

    //hitung free total agent
    public static function calculateFree($agent_id, $mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        $arr = $komisiModel->getWhere("komisi_paket_id = 1 AND komisi_acc_id = '$agent_id' $text");

        $pending = array();
        $tingtong = array();
        $free = array();


        $total = 0;
        $total_tingtong = 0;
        $total_nontingtong = 0;

        foreach($arr as $komisiModel){
            if($komisiModel->komisi_ting_tong == "1"){
                //sudah tingtong
                $tingtong[] = $komisiModel;

                //lihat status
                if($komisiModel->komisi_status == "0"){
                    //blm dibayar
                    $free["0"][] = Crud::clean2printEinzeln($komisiModel);
                }
                if($komisiModel->komisi_status == "1"){
                    //blm dibayar
                    $free["1"][] = Crud::clean2printEinzeln($komisiModel);
                }
                if($komisiModel->komisi_status == "2"){
                    //blm dibayar
                    $free["2"][] = Crud::clean2printEinzeln($komisiModel);
                }
                if($komisiModel->komisi_status == "3"){
                    //blm dibayar
                    $free["3"][] = Crud::clean2printEinzeln($komisiModel);
                }
                if($komisiModel->komisi_status == "4"){
                    //blm dibayar
                    $free["4"][] = Crud::clean2printEinzeln($komisiModel);
                }
                $total_tingtong += $komisiModel->komisi_value;
            }else{
                $pending[] = $komisiModel;
                $total_nontingtong += $komisiModel->komisi_value;
            }
            $total += $komisiModel->komisi_value;
        }
        $return['total'] = $total;
        $return['total_nontingtong'] = $total_nontingtong;
        $return['total_tingtong'] = $total_tingtong;
        $return['date'] = array("mon"=>$mon,"year"=>$year);
        $return['total_free'] = count($arr);
        $return["tingtong"] = array("jml"=>count($tingtong),"arr"=>Crud::clean2print($komisiModel,$tingtong));
        $return["pending"] = array("jml"=>count($pending),"arr"=>Crud::clean2print($komisiModel,$pending));
        $return['status_based'] = $free;

        return $return;

    }

    public static function calculateTarget($total_sales){

        $bk = new BonusKomisi();

        $arrBk = $bk->getWhere("bk_id> $total_sales LIMIT 0,1");

        $bk = $arrBk[0];
//        pr($arrBk);

        $ret['nr'] = $bk->bk_id-$total_sales;


        $sisanya = (($bk->bk_id-$total_sales)*1000000)+$bk->bk_bonus_paid;
        $ret['total'] = $sisanya;
//        pr($ret);
        return $ret;
    }
    //hitung paid sales total agent
    public static function calculateTotalSales($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        $arr = $komisiModel->getWhere("komisi_paket_id != 1 AND komisi_acc_id = '$agent_id' $text");

        $pending = array();
        $tingtong = array();
        $free = array();
        $paket = array();



        foreach($arr as $komisiModel){

            //lihat status
            if($komisiModel->komisi_status == "0"){
                //blm dibayar
                $free["0"][] = Crud::clean2printEinzeln($komisiModel);
            }
            if($komisiModel->komisi_status == "1"){
                //blm dibayar
                $free["1"][] = Crud::clean2printEinzeln($komisiModel);
            }
            if($komisiModel->komisi_status == "2"){
                //blm dibayar
                $free["2"][] = Crud::clean2printEinzeln($komisiModel);
            }
            if($komisiModel->komisi_status == "3"){
                //blm dibayar
                $free["3"][] = Crud::clean2printEinzeln($komisiModel);
            }
            if($komisiModel->komisi_status == "4"){
                //blm dibayar
                $free["4"][] = Crud::clean2printEinzeln($komisiModel);
            }

            $paket[$komisiModel->komisi_paket_id][] = Crud::clean2printEinzeln($komisiModel);
            if($komisiModel->komisi_ting_tong == "1"){
                //sudah tingtong
                $tingtong[] = $komisiModel;


            }else{
                $pending[] = $komisiModel;
            }
        }

        $return['date'] = array("mon"=>$mon,"year"=>$year);
        $return['total_sales'] = count($arr);
        $return['status_based'] = $free;
        $return['paket_based'] = $paket;
        $return["tingtong"] = array("jml"=>count($tingtong),"arr"=>Crud::clean2print($komisiModel,$tingtong));
        $return["no_tingtong"] = array("jml"=>count($pending),"arr"=>Crud::clean2print($komisiModel,$pending));


        return $return;
    }

    public static function paidCount($agent_id){
        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT count(*) as nr FROM {$komisiModel->table_name} WHERE komisi_paket_id != 1 AND komisi_acc_id = '$agent_id'";
        $arrRev = $db->query($q,1);
        return $arrRev->nr;
    }
    public static function freeCount($agent_id){
        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT count(*) as nr FROM {$komisiModel->table_name} WHERE komisi_paket_id = 1 AND komisi_acc_id = '$agent_id'";
        $arrRev = $db->query($q,1);
        return $arrRev->nr;
    }


    //hitung revenue by date
    public static function calculatePaidSalesCount($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_value) as total,count(*) as nr FROM {$komisiModel->table_name} WHERE komisi_paket_id != 1 AND komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,1);
        return $arrRev;
    }

    //hitung revenue by date
    public static function calculateRevenue($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_value) as total FROM {$komisiModel->table_name} WHERE komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,1);
        return $arrRev->total;
    }
    //hitung revenue by date
    public static function calculateRevenueCount($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_value) as total,count(*) as nr FROM {$komisiModel->table_name} WHERE komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,1);
        return $arrRev;
    }

    //hitung revenue by date
    public static function getRevenueArray($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT * FROM {$komisiModel->table_name} WHERE komisi_paket_id != 1 AND komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,2);
        return $arrRev;
//        return Crud::clean2print($komisiModel,$arrRev);
    }

    public static function getFreebiesRevenueArray($agent_id,$mon = "",$year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT * FROM {$komisiModel->table_name} WHERE komisi_paket_id = 1 AND komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,2);
        return $arrRev;
//        return Crud::clean2print($komisiModel,$arrRev);
    }

    //hitung revenue yang blm dibayar ....
    public static function calculatePiutang($agent_id,$mon = "", $year = ""){

        if($mon == ""){
            $text = "";
        }else{
            $text = "AND month(komisi_app_date) = $mon AND year(komisi_app_date) = $year";
        }
        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_value) as total FROM {$komisiModel->table_name} WHERE komisi_status != 4 AND komisi_acc_id = '$agent_id' $text";
        $arrRev = $db->query($q,1);
        return $arrRev->total;
    }

    public static function calculatePayout($agent_id,$mon = "", $year = ""){

        if($mon == ""){
            $text = "";
            $text2 = "";
            $text3 = '';
        }else{
            $text = "AND month(komisi_bagi_pertama_date) = $mon AND year(komisi_bagi_pertama_date) = $year";
            $text2 = "AND month(komisi_bagi_kedua_date) = $mon AND year(komisi_bagi_kedua_date) = $year";
            $text3 = "AND month(bagi_date_acquire) = $mon AND year(bagi_date_acquire) = $year";
        }
        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_bagi_pertama_value) as total FROM {$komisiModel->table_name} WHERE komisi_status < 2 AND komisi_acc_id = '$agent_id' $text";
//        echo $q."<br>";
        $arrRev = $db->query($q,1);



        $q = "SELECT SUM(komisi_bagi_kedua_value) as total FROM {$komisiModel->table_name} WHERE komisi_status != 4 AND komisi_acc_id = '$agent_id' $text2";
//        echo $q."<br>";
        $arrRev2 = $db->query($q,1);

        $bg = new BagiKomisi();
        $q = "SELECT SUM(bagi_value) as total FROM {$bg->table_name} WHERE bagi_acc_id = '$agent_id' $text3";
        $arrRev3 = $db->query($q,1);

        $arr['pertama'] = $arrRev->total;
        $arr['kedua'] = $arrRev2->total;
        $arr['bonus'] = $arrRev3->total;

        $arr['total'] = $arr['pertama']+$arr['kedua']+$arr['bonus'];
        return $arr;


        //payout first sales

        //payout second sales

        //payout
    }

    public static function getPayoutArray($agent_id,$mon = "", $year = ""){

        if($mon == ""){
            $text = "";
            $text2 = "";
            $text3 = '';
        }else{
            $text = "AND month(komisi_bagi_pertama_date) = $mon AND year(komisi_bagi_pertama_date) = $year";
            $text2 = "AND month(komisi_bagi_kedua_date) = $mon AND year(komisi_bagi_kedua_date) = $year";
            $text3 = "AND month(bagi_date_acquire) = $mon AND year(bagi_date_acquire) = $year";
        }
        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT * FROM {$komisiModel->table_name} WHERE komisi_status < 2 AND komisi_acc_id = '$agent_id' $text";
//        echo $q."<br>";
        $arrRev = $db->query($q,2);



        $q = "SELECT * FROM {$komisiModel->table_name} WHERE komisi_status != 4 AND komisi_acc_id = '$agent_id' $text2";
//        echo $q."<br>";
        $arrRev2 = $db->query($q,2);

        $bg = new BagiKomisi();
        $q = "SELECT * FROM {$bg->table_name} WHERE bagi_acc_id = '$agent_id' $text3";
        $arrRev3 = $db->query($q,2);

        $arr['pertama'] = $arrRev;
        $arr['kedua'] = $arrRev2;
        $arr['bonus'] = $arrRev3;

        $arr['total'] =  array_merge($arr['pertama'], $arr['kedua'],$arr['bonus']);
        return $arr;


        //payout first sales

        //payout second sales

        //payout
    }

    /*
     * END AGENT FUNCTIONS
     */


} 