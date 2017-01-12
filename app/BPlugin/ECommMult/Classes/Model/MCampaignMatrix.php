<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 9:52 AM
 */

class MCampaignMatrix extends Model{
    //Nama Table
    public $table_name = "ecommultiple__campaign_matrix";

    //Primary
    public $main_id = 'cm_id';

    //Default Coloms for read
    public $default_read_coloms = 'cm_id,cm_camp_id,cm_prod_id';

    //allowed colom in CRUD filter
    public $coloumlist = 'cm_id,cm_camp_id,cm_prod_id,cm_latest_added';

    public $cm_id;
    public $cm_camp_id;
    public $cm_prod_id;
    public $cm_latest_added;
}
