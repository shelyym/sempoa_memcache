<?php

/**
 * Description of ModelPortalContent
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ModelWebApps extends Model{
    
    
    /*
    * fungsi untuk ezeugt select/checkbox
    *
    */
    public function overwriteForm ($return, $returnfull)
    {
        
        $channel = new NewsChannel();
        $temp = $channel->getWhere("channel_active=1 AND channel_type = 'webapps'");
        foreach($temp as $c){
            $arrChannel[$c->channel_id] = $c->channel_name;
        }
        
        
        $return['webapps_channel_id'] = new Leap\View\InputSelect($arrChannel, "webapps_channel_id", "webapps_channel_id", $this->webapps_channel_id);
        
        return $return;
    }

    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead ($return)
    {
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            
            if (isset($obj->webapps_channel_id)) {
                $acc = new NewsChannel();
                $acc->getByID($obj->webapps_channel_id);
                $obj->webapps_channel_id = $acc->channel_name;
            }
        }

        //pr($return);
        return $return;
    }
    
    public function getByChannel($channel_id,$sort = ""){
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE webapps_channel_id = '$channel_id' $sort";
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
    public function getByMyChannels($array_channels,$sort = ""){
        //pr($array_channels);
        if(count($array_channels)<1)return array();
        
        $strpp = array();
        foreach($array_channels as $chn){
            $strpp[] = " webapps_channel_id = '$chn' ";
        }
        $imp = implode(" OR ", $strpp);
        //echo $imp;
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE ($imp) $sort";
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
    public function getJumlahByChannel($channel_id,$sort = ""){
        global $db;
        $q = "SELECT count(*) as nr FROM {$this->table_name} WHERE webapps_channel_id = '$channel_id'  $sort";
        $obj = $db->query($q,1);
        return $obj->nr;
    }
    
    
}
