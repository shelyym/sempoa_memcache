<?php

/**
 * Description of Role2Role
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Role2Role extends Model {

    //Nama Table
    public $table_name = "sp_role2role";
    //Primary
    public $main_id = 'rr_id';
    //Default Coloms for read
    public $default_read_coloms = 'role_big,role_small';
    //allowed colom in CRUD filter
    public $coloumlist = 'role_big,role_small';

    public $rr_id;
    public $role_big;
    public $role_small;

    public function getSmallerRoles ($role_id)
    {
        global $db;

        $sql = "SELECT * FROM {$this->table_name} WHERE role_big = '$role_id'";
        $role2role = $db->query($sql, 2);

        return $role2role;
    }
    public function getHierarchy($role){
        $r2r = new Role2Role();
        
        $udahdi = array();
        $sem = array();
        while(sizeof($sem)>0){
            $r = array_pop($sem);
            if(!in_array($r,$udahdi)){
                
                $role2role = $r2r->getSmallerRoles($r);
                foreach($role2role as $ri){
                     if(!in_array($ri->role_small,$sem) && $ri->role_small!=""){
                        //$_SESSION["roles"][] = $ri->role_small;
                        $sem[] = $ri->role_small;
                     }
                }
                $udahdi[]=$r;
            }
        }
        return $sem;
    }
    public function findLevels(){
        //create the model object
        $cal = new Role2Role();
        
        //get all role2role to work with
        $arr = $cal->getAll();
        
        $arrUrutan = array();
        $arrBig =  array();
        $arrSmall = array();
        $arrSkip = array();
        $bigger = 0;
        $smaller = 0;
        
        /*
         * init all the urutan with 0, it stay 0 if it was a leaf
         */
        foreach($arr as $rr){
            $rb = $rr->role_big;
            
            $rs = $rr->role_small;
           // $arrUrutan[$rr->role_big][] = $rr->role_small;
            if(!in_array($rs, $arrSmall))
            $arrSmall[] = $rr->role_small;
            if(!in_array($rb, $arrBig))
            $arrBig[] = $rr->role_big;
            
            $arrUrutan[$rs] = 0;
            $arrUrutan[$rb] = 0;
           // $arrUrutan[$rr->role_small] = $smaller;
        }
        
        //get leaves to get started
        $arrLeaves = array();
        foreach ($arrSmall as $rr){
            if(!in_array($rr, $arrBig)){
                //$arrLeaves[] = $rr;
                $arrSkip[] = $rr;
            }
        }
       
        
        
        while(count($arr)>0){
           // echo count($arrSkip)."<br>";
            //cari yang punya leaves
            foreach($arr as $num=>$rr){
                $rb = $rr->role_big;           
                $rs = $rr->role_small;

                //is direkt grosser than the leaves
                if(in_array($rs, $arrSkip)){
                    $arrUrutan[$rb] = $arrUrutan[$rs]+1;
                    $arrSkip[] = $rb;
                    unset($arr[$num]);
                }
            }
            //pr($arrSkip);
        }
        
        // urutkan untuk penampilan
        
        $finArr = array();
        foreach($arrUrutan as $rname => $level){
            $finArr[$level][] = $rname;
        }
        
        
      
       // pr($arrUrutan);
        
        
        ksort($finArr);
        //pr($finArr);
        return $finArr;
    }
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
        $r = new Role();
        $arr = $r->getAll();
        foreach($arr as $rol){
            if($rol->role_active)
            $arrNew[$rol->role_id] = $rol->role_id;
        }
        $return['role_big']= new Leap\View\InputSelect($arrNew,"role_big", "role_big",$this->role_big);            
        $return['role_small'] = new Leap\View\InputSelect($arrNew,"role_small", "role_small",$this->role_small);

        return $return;
    }
    
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if($this->role_big == $this->role_small){
            $err['role_big'] = Lang::t('err role_big same with role_small');
            $err['role_small'] = Lang::t('err role_big same with role_small');
        }
        
        return $err;
    }
}
