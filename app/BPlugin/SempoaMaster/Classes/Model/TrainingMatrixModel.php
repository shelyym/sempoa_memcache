<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingMatrixModel
 *
 * @author efindiongso
 */
class TrainingMatrixModel extends Model {

    //put your code here
    var $table_name = "sempoa__training_matrix";
    var $main_id = "tm_id";
    //Default Coloms for read
    public $default_read_coloms = "tm_id,tm_training_id,tm_guru_id,tm_level,tm_keterangan,tm_status";
//allowed colom in CRUD filter
    public $coloumlist = "tm_id,tm_training_id,tm_guru_id,tm_level,tm_keterangan,tm_status";
    public $tm_id;
    public $tm_training_id;
    public $tm_guru_id;
    public $tm_level;
    public $tm_keterangan;
    public $tm_status;

    
    public function getTrainingLevelTrainer($trainer_id){
        
    }
}
