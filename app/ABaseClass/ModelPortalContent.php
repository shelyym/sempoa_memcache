<?php

/**
 * Description of ModelPortalContent
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ModelPortalContent extends Model{
    public $news_author;
    public $news_comment_allow;
    public $news_commentcount;
    public $news_validity_begin;
    public $news_validity_end;
    public $news_tag;
    public $news_postdate;
    public $news_updatedate;
    public $news_channel_id;
    
    /*
    * fungsi untuk ezeugt select/checkbox
    *
    */
    public function overwriteForm ($return, $returnfull)
    {
        $return['news_author'] = new Leap\View\InputText("hidden", "news_author", "news_author", Account::getMyID());
        $return['news_comment_allow'] = new Leap\View\InputSelect(array ('0' => "No", '1' => "Yes"), "news_comment_allow", "news_comment_allow",
            $this->news_comment_allow);
        $return['news_commentcount'] = new Leap\View\InputText("hidden", "news_commentcount", "news_commentcount", $this->news_commentcount);
        $return['news_validity_begin'] = new Leap\View\InputText("date", "news_validity_begin", "news_validity_begin", $this->news_validity_begin);
        $return['news_validity_end'] = new Leap\View\InputText("date", "news_validity_end", "news_validity_end", $this->news_validity_end);
        
        if(isset($_GET['load']) && $_GET['load'])
            $return['news_postdate'] = new Leap\View\InputText("hidden", "news_postdate", "news_postdate", $this->news_postdate);    
        else
            $return['news_postdate'] = new Leap\View\InputText("hidden", "news_postdate", "news_postdate", leap_mysqldate());
        
        $return['news_updatedate'] = new Leap\View\InputText("hidden", "news_updatedate", "news_updatedate", leap_mysqldate());
        
        $channel = new NewsChannel();
        $temp = $channel->getWhere("channel_active=1 AND channel_type = 'content'");
        foreach($temp as $c){
            $arrChannel[$c->channel_id] = $c->channel_name;
        }
        
        
        $return['news_channel_id'] = new Leap\View\InputSelect($arrChannel, "news_channel_id", "news_channel_id", $this->news_channel_id);
        
        return $return;
    }

    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead ($return)
    {
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->news_postdate)) {
                $obj->news_postdate = date("d-m-Y", strtotime($obj->news_postdate));
            }
            if (isset($obj->news_updatedate)) {
                $obj->news_updatedate = date("d-m-Y", strtotime($obj->news_updatedate));
            }
            if (isset($obj->news_validity_begin)) {
                $obj->news_validity_begin = date("d-m-Y", strtotime($obj->news_validity_begin));
            }
            if (isset($obj->news_validity_end)) {
                $obj->news_validity_end = date("d-m-Y", strtotime($obj->news_validity_end));
            }
            if (isset($obj->news_author)) {
                $acc = new Account();
                $acc->getByID($obj->news_author);
                $obj->news_author = $acc->admin_nama_depan;
            }
            if (isset($obj->news_channel_id)) {
                $acc = new NewsChannel();
                $acc->getByID($obj->news_channel_id);
                $obj->news_channel_id = $acc->channel_name;
            }
        }

        //pr($return);
        return $return;
    }
    
    public function getByChannel($channel_id,$sort = ""){
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE news_channel_id = '$channel_id' $sort";
        $muridkelas = $db->query($q, 2);
        $newMurid = array ();
        $classname = get_called_class();
        foreach ($muridkelas as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }
    public function getByChannelAndIsValid($channel_id,$sort = ""){
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE news_channel_id = '$channel_id' AND news_validity_begin <= CURDATE() AND news_validity_end >= CURDATE() $sort";
	    $muridkelas = $db->query($q, 2);
        $newMurid = array ();
        $classname = get_called_class();
        foreach ($muridkelas as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }
    public function getJumlahByChannelAndIsValid($channel_id,$sort = ""){
        global $db;
        $q = "SELECT count(*) as nr FROM {$this->table_name} WHERE news_channel_id = '$channel_id' AND news_validity_begin <= CURDATE() AND news_validity_end >= CURDATE() $sort";
        $obj = $db->query($q,1);
        return $obj->nr;
    }
    
    public function sqlAdd(){
        global $db;        
        $sql = "ALTER TABLE `{$this->table_name}` ADD `news_author` BIGINT UNSIGNED NOT NULL, ADD `news_comment_allow` TINYINT NOT NULL DEFAULT \'0\', ADD `news_commentcount` INT NOT NULL, ADD `news_validity_begin` DATE NOT NULL, ADD `news_validity_end` DATE NOT NULL, ADD `news_tag` TEXT NOT NULL, ADD `news_postdate` DATETIME NOT NULL, ADD `news_updatedate` DATETIME NOT NULL, ADD `news_channel_id` INT UNSIGNED NOT NULL;";
        $db->query($sql,0);
        
        /*mysql comments*/
        /*
         * ALTER TABLE `tablename`  ADD `news_author` BIGINT UNSIGNED NOT NULL,  ADD `news_comment_allow` TINYINT NOT NULL DEFAULT '0',  ADD `news_commentcount` INT NOT NULL,  ADD `news_validity_begin` DATE NOT NULL,  ADD `news_validity_end` DATE NOT NULL,  ADD `news_tag` TEXT NOT NULL,  ADD `news_postdate` DATETIME NOT NULL,  ADD `news_updatedate` DATETIME NOT NULL,  ADD `news_channel_id` INT UNSIGNED NOT NULL;
         */
    }
    /*
     * get by my channels
     */
    public function getByMyChannels($array_channels,$sort = ""){
        //pr($array_channels);
        if(count($array_channels)<1)return array();
        
        $strpp = array();
        foreach($array_channels as $chn){
            $strpp[] = " news_channel_id = '$chn' ";
        }
        $imp = implode(" OR ", $strpp);
        //echo $imp;
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE $imp $sort";
        $muridkelas = $db->query($q, 2);
        $newMurid = array ();
        $classname = get_called_class();
        foreach ($muridkelas as $databasemurid) {

            $m = new $classname();
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }

        return $newMurid;
    }
}
