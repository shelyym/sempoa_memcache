<?php

/**
 * Description of AdminMenu
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class AdminMenu extends Model {
    //Nama Table
    public $table_name = "sp_admin__menu";

    //Primary
    public $main_id = 'menuname';

    //Default Coloms for read
    public $default_read_coloms = 'menuname,menuurl';

    //allowed colom in CRUD filter
    public $coloumlist = 'menuname,menuurl';

    public $menuname;
    public $menuurl;

    public function save ($onDuplicateKey = 0)
    {
        //parent::save($onDuplicateKey);
        if ($onDuplicateKey == 1) {
            //dibypass supaya tidak di save ke db
            $_SESSION['Registor']['adminMenu'][$this->menuname] = $this->menuname;
        }
    }

    public function emptyAll ()
    {
        unset($_SESSION['Registor']['adminMenu']);
    }
}
