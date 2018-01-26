<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/23/18
 * Time: 2:38 PM
 */
class WalletModel extends Model
{

    var $table_name = "sempoa__app_wallet";
    var $main_id = "wallet_id";

    //Default Coloms for read
    public $default_read_coloms = "wallet_id,wallet_parent_id,wallet_kodsiswa,wallet_jumlah,wallet_created,wallet_updated,wallet_active";

//allowed colom in CRUD filter
    public $coloumlist = "wallet_id,wallet_parent_id,wallet_kodsiswa,wallet_jumlah,wallet_created,wallet_updated,wallet_active";
    public $wallet_id;
    public $wallet_parent_id;
    public $wallet_kodsiswa;
    public $wallet_jumlah;
    public $wallet_created;
    public $wallet_updated;
    public $wallet_active;


    public function getMyCoin($kode_siswa){
        $this->getWhereOne("wallet_kodsiswa='$kode_siswa'");
        if(is_null($this->wallet_id)){
            return 0;
        }
        return $this->wallet_jumlah;
    }
}