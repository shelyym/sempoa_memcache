<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class RoleWeb extends WebService{

    var $access_Role2Menu = "admin";
    public function Role2Menu(){
        $t = time();
        //create matrix to adjust menu
        $arrMenu = Registor::getAllAdminMenuFromSession();
        ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <td><?=Lang::t('Menu');?></td>
                <td><?=Lang::t('Min-Role');?></td>
            </tr>
        </thead>
        <tbody>
            <? 
            $r = new Role();
            $existingRoles = $r->getWhere("role_active = 1 ORDER BY role_id ASC"); 
            foreach($arrMenu as $menu){ 
                $role = Role2Menu::getRoleForMenu($menu);
                ?>
            <tr>
                <td><?=Lang::t($menu);?></td>
                <td>
                    <select id="role_select_<?=$menu;?>_<?=$t;?>">
                <? foreach($existingRoles as $ro){?>
                
                        <option value="<?=$ro->role_id;?>" <? if($ro->role_id == $role)echo "selected";?>><?=$ro->role_id;?></option>
                <? } ?>
                    </select>
                    <script>
                    $("#role_select_<?=$menu;?>_<?=$t;?>").change(function(){
                        var slc = $("#role_select_<?=$menu;?>_<?=$t;?>").val();
                       $.get("<?=_SPPATH;?>RoleWeb/ins?menu=<?=base64_encode($menu);?>&role_id="+slc); 
                    });    
                    </script>
                </td>
            </tr>
            <? } ?>
        </tbody>
       
    </table>
</div>    
        <?
    }
    public function ins(){
        $roleWeb = new Role2Menu();
        $roleWeb->menu_id = addslashes(base64_decode($_GET['menu']));
        $roleWeb->role_id = addslashes($_GET['role_id']);
        $roleWeb->save(1);
    }
}
