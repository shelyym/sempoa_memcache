<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/28/16
 * Time: 8:31 PM
 */

class BonusKomisi extends Model{

    //
    var $table_name = "vp__bonus_komisi";
    var $main_id    = "bk_id";

    //Default Coloms for read
    public $default_read_coloms = "bk_id,bk_bonus,bk_komisi_paid,bk_bonus_paid";
//allowed colom in CRUD filter
    public $coloumlist = "bk_id,bk_bonus,bk_komisi_paid,bk_bonus_paid";
    public $bk_id;
    public $bk_bonus;
    public $bk_komisi_paid;
    public $bk_bonus_paid;

    public static function fillBK(){

        $bk = new BonusKomisi();
        $bk->truncate();

        $bonus6 = 3000000;
        $bonus12 = 3000000;
        $bonus24 = 6000000;

        $paid = 0;
        $bonus = 0;
        for($x=6;$x<2000;$x=$x+6){
            $bk = new BonusKomisi();
            $bk->bk_id = $x;


            $bk->bk_bonus = (floor($x/6)*$bonus6)+(floor($x/12)*$bonus12)+(floor($x/24)*$bonus24);


            $bk->bk_bonus_paid = $bk->bk_bonus-$bonus;

            $paid += $bk->bk_bonus_paid;
            $bk->bk_komisi_paid = $paid;

            $bk->save();

            $bonus = (floor($x/6)*$bonus6)+(floor($x/12)*$bonus12)+(floor($x/24)*$bonus24);
        }

    }
} 