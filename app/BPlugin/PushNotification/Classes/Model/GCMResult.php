<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/15
 * Time: 9:34 AM
 */

class GCMResult extends Model{
    //ll__gcm_result
    public $table_name = "push__gcm_result";

    //Primary
    public $main_id = 'multicast_id';

    //Default Coloms for read
//    public $default_read_coloms = 'multicast_id,success,failure,canonical_ids,results,camp_id,gcm_date';

    //allowed colom in CRUD filter
//    public $coloumlist = 'multicast_id,success,failure,canonical_ids,results,camp_id,gcm_date';


    public $default_read_coloms = 'multicast_id,camp_id,gcm_date,success,failure,gcm_test';

    //allowed colom in CRUD filter
    public $coloumlist = 'multicast_id,success,failure,camp_id,gcm_date,gcm_test,app_id,client_id,seen_by';

    public $multicast_id;
    public $success;
    public $failure;
    public $canonical_ids;
    public $results;
    public $camp_id;
    public $gcm_date;
    public $gcm_test;

    public $client_id;
    public $app_id;
    public $seen_by;

} 