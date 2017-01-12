<?php

/**
 * Description of AccountMeta
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class AccountMeta extends Model {

    //Nama Table
    public $table_name = "sp_admin_account__metadata";
    //Primary
    public $main_id = 'meta_id';
    //Default Coloms for read
    public $default_read_coloms = 'account_id,meta_key,meta_value';
    //allowed colom in CRUD filter
    public $coloumlist = 'account_id,meta_key,meta_value';

    public $meta_id;
    public $meta_key;
    public $meta_value;
    public $account_id;

    public function getMeta ($id)
    {
       
        $arrMeta = $this->getMetaToArray($id);

        $this->processSession($arrMeta);
    }

    public function processSession ($arrMeta)
    {
        //pr($arrMeta);
        //pr($_SESSION);
        foreach ($arrMeta as $meta) {
            $_SESSION['account']->{$meta->meta_key} = $meta->meta_value;
        }
    }
    public function getMetaToArray($id)
    {
        global $db;
        $q = "SELECT * FROM {$this->table_name} WHERE account_id = '$id'";
        $arrMeta = $db->query($q, 2);

        return $arrMeta;
    }
    
}
