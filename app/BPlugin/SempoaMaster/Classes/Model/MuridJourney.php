<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/13/16
 * Time: 10:04 AM
 */

class MuridJourney extends Model{

    var $table_name = "sempoa_murid_journey_level";
    var $main_id = "journey_id";

    //Default Coloms for read
    public $default_read_coloms = "journey_id,journey_murid_id,journey_level_mulai,journey_level_end,journey_mulai_date,journey_end_date,journey_tc_id";

//allowed colom in CRUD filter
    public $coloumlist = "journey_id,journey_murid_id,journey_level_mulai,journey_level_end,journey_mulai_date,journey_end_date,journey_tc_id";
    public $journey_id;
    public $journey_murid_id;
    public $journey_level_mulai;
    public $journey_level_end;
    public $journey_mulai_date;
    public $journey_end_date;
    public $journey_tc_id;


    public function createJourney($murid_id, $journey_level_mulai,$journey_mulai_date,$journey_tc_id){
        $this->journey_murid_id = $murid_id;
        $this->journey_level_mulai = $journey_level_mulai;
        $this->journey_mulai_date = $journey_mulai_date;
        $this->journey_tc_id = $journey_tc_id;
        $this->save();

    }

} 