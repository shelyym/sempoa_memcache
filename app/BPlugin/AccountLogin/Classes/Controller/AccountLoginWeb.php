<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountLoginWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class AccountLoginWeb extends WebService {

    var $access_Account = "admin";
    public function Account ()
    {
        //create the model object
        $cal = new Account();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_Role = "admin";
    public function Role ()
    {
        //create the model object
        $cal = new Role();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    public function Role2Role(){
        
         //create the model object
        $cal = new Role2Role();
        
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }

    var $access_ShowRole2RoleLevel = "admin";
    public function ShowRole2RoleLevel(){
        //create the model object
        $cal = new Role2Role();
        $arr = $cal->findLevels();
        $t = time();
        //pr($arr);
        $rr = new Role();
        $arrRoles = $rr->getWhere("role_active = 1");
        
        ?>
<script>
    var arrayOfRoles = [];
</script>            
         <?
        foreach($arrRoles as $role){
            ?>
<script>
    var r = {id:'<?=$role->role_id;?>',level:0};
    arrayOfRoles.push(r);
</script>
            <?
            foreach($arr as $lvl=>$arrRole){
                foreach($arrRole as $role2){
                    if($role->role_id == $role2){
                        $arrSudahAda[$role2] = $role2;
                    }
                }
            }
        }
        //pr($arrSudahAda);
        foreach($arrRoles as $role){
            if(!in_array($role->role_id, $arrSudahAda))
                    $arrBlmAda[$role->role_id] = $role->role_id;
        }
        //pr($arrBlmAda);
        
        foreach($arr as $lvl=>$x){
            $arrSorts[] = "#sortable_{$lvl}";
        }
        $str = implode(",", $arrSorts);
        ?>
<style>
    .droptrue li{
        list-style-type: none;
        margin:5px;
        background-color: #dedede;
        padding:5px;
        border-radius: 5px;
    }
</style>
<script>
  $(function() {
    $( "ul.droptrue" ).sortable({
      connectWith: "ul",
      receive: function(event, ui) {
          var sem = this.id;
          var exp = sem.split("_");
          for(var key in arrayOfRoles){
                if(arrayOfRoles[key].id == ui.item.html()){
                    arrayOfRoles[key].level = parseInt(exp[1]);
                }
            }
            console.log("[" + this.id + "] received [" + ui.item.html() + "] from [" + ui.sender.attr("id") + "]");
            console.log(arrayOfRoles);
        }
    });
    console.log(arrayOfRoles);
    /*$( "ul.dropfalse" ).sortable({
      connectWith: "ul",
      dropOnEmpty: false
    });*/
 
    $( "<?=$str;?>" ).disableSelection();
  });
  </script>
  <style>
      .droptrue{
          width: 150px;  
          border:1px solid #888;
          padding: 10px;
           
      }
      .lvlcon{
          float: left;
          width: 150px; 
          margin-right: 10px;
          background-color: #efefef; 
      }
      .lvlcon h3{
          text-align: center;
      }
  </style>
  <h1><?=Lang::t('Role Adjuster');?></h1>
  <button id="addsub_<?=$t;?>" class="btn btn-default"><?=Lang::t('Add Sub Level');?></button>
  <button id="addsuper_<?=$t;?>" class="btn btn-default"><?=Lang::t('Add Super Level');?></button>
  <div class="clearfix" style="padding:10px;"></div>
  <?
  $lvl = -1;
  ?>
  <div id="treecontainer_<?=$t;?>">
  <div class="lvlcon">
      <h3><? if($lvl < 0) echo 'Deactivate'; else echo $lvl;?></h3>
      <ul id="sortable_<?=$lvl;?>" class="droptrue">                    
        <? foreach($arrBlmAda as $role){?>
          <li id="<?=$role;?>" class="ui-state-highlight"><?=$role;?></li>
          <script>
              for(var key in arrayOfRoles){
                  if(arrayOfRoles[key].id == '<?=$role;?>'){
                      arrayOfRoles[key].level = <?=$lvl;?>;
                  }
              }
          </script>
        <? } ?>
    </ul>
  </div>
 <?
        foreach($arr as $lvl=>$arrRole){
            ?>
  <div class="lvlcon">
                <h3 ><?=$lvl;?></h3>
                <ul id="sortable_<?=$lvl;?>" class="droptrue">
                    
                    <? foreach($arrRole as $role){?>
                        <li id="<?=$role;?>" class="ui-state-highlight"><?=$role;?></li>
                        <script>
                        for(var key in arrayOfRoles){
                            if(arrayOfRoles[key].id == '<?=$role;?>'){
                                arrayOfRoles[key].level = <?=$lvl;?>;
                            }
                        }
                    </script>
                    <? } ?>
                </ul>
  </div>
            <?
        }
        ?>
  </div>
  <div class="clearfix" style="margin-top:20px;"></div>
  <p id="printer<?=$t;?>" style="margin: 20px;">
  
  </p>
  <script>
  var lvlmin = -1;
  var lvlmax = <?=$lvl;?>;
  $("#addsub_<?=$t;?>").click(function(){
      lvlmin--;
      $("#treecontainer_<?=$t;?>").prepend('<div class="lvlcon"><h3>'+lvlmin+'</h3><ul id="sortable_'+lvlmin+'" class="droptrue"> </ul></div>');
      $( "ul.droptrue" ).sortable({
      connectWith: "ul",
      receive: function(event, ui) {
        var sem = this.id;
          var exp = sem.split("_");
          for(var key in arrayOfRoles){
                if(arrayOfRoles[key].id == ui.item.html()){
                    arrayOfRoles[key].level  = parseInt(exp[1]);
                }
            }
            console.log("[" + this.id + "] received [" + ui.item.html() + "] from [" + ui.sender.attr("id") + "]");
            console.log(arrayOfRoles);
        }
        });
  });
  $("#addsuper_<?=$t;?>").click(function(){
      lvlmax++;
      $("#treecontainer_<?=$t;?>").append('<div class="lvlcon"><h3>'+lvlmax+'</h3><ul id="sortable_'+lvlmax+'" class="droptrue"> </ul></div>');
      $( "ul.droptrue" ).sortable({
      connectWith: "ul",
      receive: function(event, ui) {
        var sem = this.id;
          var exp = sem.split("_");
          for(var key in arrayOfRoles){
                if(arrayOfRoles[key].id == ui.item.html()){
                    arrayOfRoles[key].level  = parseInt(exp[1]);
                }
            }
            console.log("[" + this.id + "] received [" + ui.item.html() + "] from [" + ui.sender.attr("id") + "]");
            console.log(arrayOfRoles);
        }
        });
  });
  </script>
 
   <button id="saveTree_<?=$t;?>" class="btn btn-default"><?=Lang::t('Save Role Connections');?></button> 
   <script>
   $("#saveTree_<?=$t;?>").click(function(){
       console.log(arrayOfRoles);
       var myJsonString = JSON.stringify(arrayOfRoles);
       $.post("<?=_SPPATH;?>AccountLoginWeb/saveTree",{tree:myJsonString},function(data){
           console.log(data);
           $("#printer<?=$t;?>").html(data);
       });
   });    
   </script>
        <?
    }
    
    public function saveTree(){
        $tree = addslashes($_POST['tree']);
        $arr = json_decode($_POST['tree']);
        $showlog = 0;
        /*pr($tree);
        echo "haa";
        pr($arr);
         * 
         */
        if(count($arr)<1)die("Arr ERR");
        $arrNachLevel = array();
        $maxLvl = 0;
        $minLvl = 0;
        foreach($arr as $c){
            $id = $c->id;
            $level = $c->level;
            $arrNachLevel[$level][] = $id;
            if($level>$maxLvl)
                $maxLvl = $level;
            if($level<$minLvl)
                $minLvl = $level;
        }
        ksort($arrNachLevel);
        
        //cek apakah level berurutan
        $active = $minLvl;
        foreach($arrNachLevel as $lvl=>$num){           
            if($lvl-$active>1){
                die("<div class='alert alert-danger'>No empty Level Please</div>");
            }
            else{
                $active = $lvl;
            }           
        }
        /*
         * pertama empty dulu semuanya
         * dipunyai role_big dan role_small
         */
        $role = new Role2Role();
        $role->truncate();
        
        
        if($showlog)echo "<h1>maxlvl ".$maxLvl."</h1>";
        $active = 0;
        $nextlvl = 1;
        foreach($arrNachLevel as $lvl=>$arrA){
            if($showlog)echo "lvl : ".$lvl."<br>";
            $active = (int)$lvl;
            $nextlvl = $active+1;
            if($showlog)echo "active ".$active." next ".$nextlvl." <br>";
            if($showlog)pr($arrA);
            if($nextlvl<=$maxLvl)
            foreach($arrA as $rolesmall){
                foreach($arrNachLevel[$nextlvl] as $rolebig ){
                    if($rolebig!=$rolesmall){
                    $rr = new Role2Role();
                    $rr->role_big = $rolebig;
                    $rr->role_small = $rolesmall;
                    $rr->save();
                    //pr($rr);
                    if($showlog)echo " SMALL : ".$rolesmall." BIG : ".$rolebig. "<br>";
                    }
                }
            }
        }
        
        if($showlog)pr($arrNachLevel);
        die("<div class='alert alert-info'>Success</div>");
        
    }


    public function Role2Account(){
        //create the model object
        $cal = new Role2Account();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
   /*
     * Profiles
     */
    public function profile(){
        
        // get posted ID
        $acc_id = (isset($_GET['id']) ? addslashes($_GET['id']) : die('Acc ID empty'));

        //cek if this profile is mine
        if ($acc_id == Account::getMyID()) {
            $this->myProfile();
            //die();
        }
        else{
        //Model
        $acc = new Account();

        //getByID using superclass function
        $acc->getByID($acc_id);

        //get the role
        $role = ucfirst($acc->admin_role);

        //kill the program if roleless
        if ($role == "") {
            die('Role Empty');
        }

        //create dynamic object, all subclass from ModelAccount
        //$murid = new $role();

        //get and fill Object
        // $murid->getByAccountID($acc_id);

        //create Return Object
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['roleObj'] = $acc;
        $return['acc'] = $acc;

        //Molding Design
        Mold::plugin("AccountLogin", "profile", $return);
        }
    }

    /*
     * myProfile
     */
    public function myProfile ()
    {
        //Model
        $acc = new Account();

        //getByID using superclass function
        $acc->getByID(Account::getMyID());

        //get the role
        $role = ucfirst($acc->admin_role);

        //kill the program if roleless
        if ($role == "") {
            die('Role Empty');
        }

        //create dynamic object, all subclass from ModelAccount
        //$murid = new $role();

        //get and fill Object
        // $murid->getByAccountID($acc_id);

        //create Return Object
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['roleObj'] = $acc;
        $return['acc'] = $acc;

        //Molding Design
        Mold::plugin("AccountLogin", "myprofile", $return);

        //to add as webservice
        exit();
    }
}
