<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PortalAdminWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PortalAdminWeb extends WebService {

    public function RoleOrganization ()
    {
        //create the model object
        $cal = new RoleOrganization();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    public function RoleLevel ()
    {
        //create the model object
        $cal = new RoleLevel();
        //send the webclass 
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    public function NewsChannel(){
        //create the model object
        $cal = new NewsChannel();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
    
    
    public function Account(){
        
        /*
         * get All Active Department
         */
        $dp = new RoleOrganization();
        $arrOrg = $dp->getWhere("organization_active = 1 AND organization_parent_id != 0");
        //simpan ke array yang mudah
        $arrOrg2 = array();
        foreach($arrOrg as $or){
            $arrOrg2[$or->organization_id] = $or;
        }
        //pr($arrOrg2);
         /*
         * get All Active Level
         */
        $dp = new RoleLevel();
        $arrOrg = $dp->getWhere("level_active = 1");
        //simpan ke array yang mudah
        $arrLevel = array();
        foreach($arrOrg as $or){
            $arrLevel[$or->level_id] = $or;
        }
         /*
         * get All Active Role
         */
        $dp = new Role();
        $arrOrg = $dp->getWhere("role_active = 1");
        //simpan ke array yang mudah
        $arrRoles = array();
        foreach($arrOrg as $or){
            $arrRoles[$or->role_id] = $or;
        }
        //pr($arrLevel);
        //create the model object
        $cal = new Account();
        
        $arrCal = $cal->getWhere("admin_aktiv = 1 ORDER BY admin_username ASC LIMIT 0,10");
        
        $meta = new AccountMeta();
        $t = time();
        ?>
<h1><?=Lang::t('Account Management');?></h1>
<div class="row hidden-print" style="margin-bottom: 10px;">
<div class="col-md-4 col-xs-12">

<div class="input-group">
<input type="text" class="form-control" value="" id="Account2Deptsearchpat" placeholder="<?=Lang::t('Username');?>,<?=Lang::t('Name');?>">
<span class="input-group-btn">
<button class="btn btn-default" id="Account2Deptsearchpat<?=$t;?>" type="button">Search</button>
</span>
</div>
<!-- /input-group -->
<script type="text/javascript">
    $("#Account2Deptsearchpat<?=$t;?>").click(function () {
        var slc = encodeURI($('#Account2Deptsearchpat').val());
        openLw(window.selected_page, '<?=_SPPATH;?>PortalAdminWeb/Account?page=1&word=' + slc, 'fade');
    });
    $("#Account2Deptsearchpat").keyup(function (event) {
        if (event.keyCode == 13) { //on enter
            var slc = encodeURI($('#Account2Deptsearchpat').val());
            openLw(selected_page, '/leapportal/PortalAdminWeb/Account?page=1&word=' + slc, 'fade');
        }
    });
</script>
</div>
        
            
    </div>
<table class="table table-bordered table-striped table-hover" style="background-color: white;">    
    <thead>
        <tr>
            <th><?=Lang::t('ID');?></th>
            <th><?=Lang::t('Username');?></th>
            <th><?=Lang::t('Name');?></th>
            <th><?=Lang::t('Role');?></th>
            <th><?=Lang::t('Department');?></th>            
            <th><?=Lang::t('Level');?></th>
            <th><?=Lang::t('Action');?></th>
        </tr>
    </thead>
    <tbody>
        <?
       foreach($arrCal as $acc){
            $arrMeta = $meta->getWhere("account_id = '{$acc->admin_id}'");
            $lvl = "";
            $orgs = "";
            foreach($arrMeta as $mt){
                
                if($mt->meta_key == "RoleLevel"){
                    $lvl = $mt->meta_value;
                }
                if($mt->meta_key == "RoleOrganization"){
                    $orgs = $mt->meta_value;
                }
            }
           ?>
        <tr>
            <td><?=$acc->admin_id;?></td>
            <td><?=$acc->admin_username;?></td>
            <td><input id="name_<?=$acc->admin_id;?>_<?=$t;?>" type="text" value="<?=$acc->admin_nama_depan;?>" class="form-control"></td>
            <td>
                <select id="role_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrRoles as $id=>$org){
                ?>
    <option <? if($id == $acc->admin_role)echo "selected";?> value="<?=$id;?>"><?=$org->role_name;?></option>   
                 <?
            } ?>
                </select>
            </td>
            <td>
                <select id="org_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrOrg2 as $id=>$org){
                ?>
    <option <? if($id == $orgs)echo "selected";?> value="<?=$id;?>"><?=$org->organization_name;?></option>   
                 <?
            } ?>
                </select>
                </td>
                <td>
                <select id="level_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrLevel as $id=>$org){
                ?>
    <option <? if($id == $lvl)echo "selected";?> value="<?=$id;?>"><?=$org->level_name;?></option>   
                 <?
            } ?>
                </select>
                </td>
                <td><button id="updater_<?=$acc->admin_id;?>_<?=$t;?>" class="btn btn-default"><?=Lang::t('update');?></button></td>
    <script>
        $("#updater_<?=$acc->admin_id;?>_<?=$t;?>").click(function(){
            var name = encodeURI(("#updater_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var role = encodeURI(("#role_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var lvl = encodeURI(("#level_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var org = encodeURI(("#org_<?=$acc->admin_id;?>_<?=$t;?>").val());
            
            $.post("<?=_SPPATH;?>PortalAdminWeb/updater",{
                id : '<?=$acc->admin_id;?>',
                name :name,
                lvl : lvl,
                org : org,
                role : role
            },function(data){
                if(data.bool)alert('<?=Lang::t('Update Succesful');?>');
            },'json');
        });
    </script>
        </tr>
          
           <?
           
       }
       ?>
    </tbody>
</table>
    <?
        //pr($arrCal);
        
    }
    
    
    public function AccountManagement(){
        
        /*
         * process search 
         */
        $s = TextP::getP("word");
        $page = TextP::getP("page",1);
        $new = TextP::getP("new",0);
        if($new)$invert_new = 0;
        else $invert_new = 1;
        
        $searchText = '';
        if($s!=""){
            $searchText = "
                WHERE
    admin_username LIKE '%$s%' OR admin_nama_depan LIKE '%$s%'";
            if($new){
                $searchText = " AND (admin_username LIKE '%$s%' OR admin_nama_depan LIKE '%$s%') ";
            }
        }
        
        /*
         * sort
         */
        $sort = TextP::getP("sort","admin_nama_depan");
        $ord = TextP::getP("order","ASC");
        $orderText = " $sort $ord";
        
        /*define order and sort*/
        $order = $_SESSION['account_man_order'];
        if($order == "")$order = "ASC";
        elseif($order == "ASC")$order = "DESC";
        else $order = "ASC";
        $_SESSION['account_man_order'] = $order;
        
        /*
         * Pagination
         */
        $limit = 20;
        $begin = ($page-1)*$limit;
        
        global $db;
        
        $acc = new Account();
        $rl = new RoleLevel();
        $ro = new RoleOrganization();
        $am = new AccountMeta();
        if($new){
            $q = "SELECT * FROM `sp_admin_account` WHERE NOT EXISTS (SELECT * FROM sp_admin_account__metadata WHERE sp_admin_account.admin_id = sp_admin_account__metadata.account_id) $searchText ORDER BY
    $orderText LIMIT $begin,$limit";
            
            $qjumlah = "SELECT count(*) as nr FROM `sp_admin_account` WHERE NOT EXISTS (SELECT * FROM sp_admin_account__metadata WHERE sp_admin_account.admin_id = sp_admin_account__metadata.account_id) ";
            $nr = $db->query($qjumlah,1);
            $jml = $nr->nr;
            
        }else{
            //normal query
        $q = "
SELECT
    admin_id,admin_username,admin_nama_depan,admin_role, 
    org.meta_value as org,
    level.meta_value as level
FROM {$acc->table_name}
    LEFT JOIN {$am->table_name} AS org ON org.account_id = admin_id
        AND org.meta_key='RoleOrganization'
    LEFT JOIN {$am->table_name} AS level ON level.account_id = admin_id
        AND level.meta_key='RoleLevel'
    $searchText 
ORDER BY
    $orderText LIMIT $begin,$limit";
        
        $jml = $acc->getJumlah($searchText);
    
        }
    //echo $q;
        $arrCal = $db->query($q,2);        
        //pr($arr);
        
        
        
        /*
         * get All Active Department
         */
        $dp = new RoleOrganization();
        $arrOrg = $dp->getWhere("organization_active = 1 AND organization_parent_id != 0");
        //simpan ke array yang mudah
        $arrOrg2 = array();
        foreach($arrOrg as $or){
            $arrOrg2[$or->organization_id] = $or;
        }
        //pr($arrOrg2);
         /*
         * get All Active Level
         */
        $dp = new RoleLevel();
        $arrOrg = $dp->getWhere("level_active = 1");
        //simpan ke array yang mudah
        $arrLevel = array();
        foreach($arrOrg as $or){
            $arrLevel[$or->level_id] = $or;
        }
         /*
         * get All Active Role
         */
        $dp = new Role();
        $arrOrg = $dp->getWhere("role_active = 1");
        //simpan ke array yang mudah
        $arrRoles = array();
        foreach($arrOrg as $or){
            $arrRoles[$or->role_id] = $or;
        }
        
        $t = time();
        
        
        ?>
<style>
    .clickable{
        cursor: pointer;
    }
</style>
<h1><?=Lang::t('Account Management');?></h1>
<div class="row hidden-print" style="margin-bottom: 10px;">
<div class="col-md-6 col-xs-12">

<div class="input-group">
<input type="text" class="form-control" value="<?=$s;?>" id="Account2Deptsearchpat<?=$t;?>" placeholder="<?=Lang::t('Username');?>,<?=Lang::t('Name');?>">
<span class="input-group-btn">
<button class="btn btn-default" id="Account2Deptsearchpat2_<?=$t;?>" type="button"><?=Lang::t('Search');?></button>
</span>
<span class="input-group-btn">
<button class="btn btn-default <? if($new){?> btn-warning<?}?>" id="Account2Deptsearchpat2b_<?=$t;?>" type="button"><?=Lang::t('w/o Departments and Level');?></button>
</span>
</div>
<!-- /input-group -->
<script type="text/javascript">
    $("#Account2Deptsearchpat2_<?=$t;?>").click(function () {
        var slc = encodeURI($('#Account2Deptsearchpat<?=$t;?>').val());
        openLw(window.selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=1&new=<?=$new;?>&word=' + slc, 'fade');
    });
    $("#Account2Deptsearchpat<?=$t;?>").keyup(function (event) {
        if (event.keyCode == 13) { //on enter
            var slc = encodeURI($('#Account2Deptsearchpat<?=$t;?>').val());
            openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=1&new=<?=$new;?>&word=' + slc, 'fade');
        }
    });
    $('#Account2Deptsearchpat2b_<?=$t;?>').click(function(){
        var slc = encodeURI($('#Account2Deptsearchpat<?=$t;?>').val());
         openLw(window.selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=1&new=<?=$invert_new;?>&word=' + slc, 'fade');
    });
</script>
</div>
</div>
<table class="table table-bordered table-striped table-hover" style="background-color: white;">    
    <thead>
        <tr>
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=admin_id&order=<?=$order;?>', 'fade');"><?=Lang::t('ID');?></th>
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=admin_username&order=<?=$order;?>', 'fade');"><?=Lang::t('Username');?></th>
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=admin_nama_depan&order=<?=$order;?>', 'fade');"><?=Lang::t('Name');?></th>
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=admin_role&order=<?=$order;?>', 'fade');"><?=Lang::t('Role');?></th>
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=org.meta_value&order=<?=$order;?>', 'fade');"><?=Lang::t('Department');?></th>            
            <th class="clickable" onclick="openLw(selected_page, '<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page;?>&word=<?=$s;?>&sort=level.meta_value&order=<?=$order;?>', 'fade');"><?=Lang::t('Level');?></th>
            <th><?=Lang::t('Action');?></th>
        </tr>
    </thead>
    <tbody>
        <?
       foreach($arrCal as $acc){
            
           ?>
        <tr>
            <td><?=$acc->admin_id;?></td>
            <td><?=$acc->admin_username;?></td>
            <td><input id="name_<?=$acc->admin_id;?>_<?=$t;?>" type="text" value="<?=$acc->admin_nama_depan;?>" class="form-control"></td>
            <td>
                <select id="role_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrRoles as $id=>$org){
                ?>
    <option <? if($id == $acc->admin_role)echo "selected";?> value="<?=$id;?>"><?=$org->role_name;?></option>   
                 <?
            } ?>
                </select>
            </td>
            <td>
                <select id="org_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrOrg2 as $id=>$org){
                ?>
    <option <? if($id == $acc->org)echo "selected";?> value="<?=$id;?>"><?=$org->organization_name;?></option>   
                 <?
            } ?>
                </select>
                </td>
                <td>
                <select id="level_<?=$acc->admin_id;?>_<?=$t;?>" class="form-control">
                <? foreach($arrLevel as $id=>$org){
                ?>
    <option <? if($id == $acc->level)echo "selected";?> value="<?=$id;?>"><?=$org->level_name;?></option>   
                 <?
            } ?>
                </select>
                </td>
                <td><button id="updater_<?=$acc->admin_id;?>_<?=$t;?>" class="btn btn-default"><?=Lang::t('update');?></button></td>
    <script>
        $("#updater_<?=$acc->admin_id;?>_<?=$t;?>").click(function(){
            var name = encodeURI($("#name_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var role = encodeURI($("#role_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var lvl = encodeURI($("#level_<?=$acc->admin_id;?>_<?=$t;?>").val());
            var org = encodeURI($("#org_<?=$acc->admin_id;?>_<?=$t;?>").val());
            
            $.post("<?=_SPPATH;?>PortalAdminWeb/updater",{
                id : '<?=$acc->admin_id;?>',
                name :name,
                lvl : lvl,
                org : org,
                role : role
            },function(data){
                console.log(data.post);
                console.log(data.isi);
                if(data.bool)alert('<?=Lang::t('Update Succesful');?>');
                else alert(data.err);
            },'json');
        });
    </script>
        </tr>
          
           <?
           
       }
       ?>
    </tbody>
</table>
<?
$halaman = $page;
$jmlpage = ceil($jml/$limit);
?>
<nav>
  <ul class="pagination">
      <?if($halaman>1){?>
    <li><a class="clickable" onclick="openLw(selected_page,'<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page-1;?>&word=<?=$s;?>&sort=<?=$sort;?>&order=<?=$order;?>&new=<?=$new;?>','fade');"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
    <? } ?>
    <? //ambil 3 bh terdekat // 
    $mulai = $halaman-2;
    $akhir = $halaman+2;
    //echo $mulai.$akhir;
    $min = max($mulai,1);
    $max = min($akhir,$jmlpage);
    //echo "<br> max :".$max;
    //echo "<br> min :".$min;
    
    for($x=$min;$x<=$max;$x++){?>
    
    <li <? if($x==$halaman){?>class="active"<?}?>><a onclick="openLw(selected_page,'<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$x;?>&word=<?=$s;?>&sort=<?=$sort;?>&order=<?=$order;?>&new=<?=$new;?>','fade');"><?=$x;?></a></li>
    <? } ?>
    
    <?if($jml>$begin+$limit){?>
    <li><a class="clickable" onclick="openLw(selected_page,'<?=_SPPATH;?>PortalAdminWeb/AccountManagement?page=<?=$page+1;?>&word=<?=$s;?>&sort=<?=$sort;?>&order=<?=$order;?>&new=<?=$new;?>','fade');"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
    <? } ?>
  </ul>
</nav>
        <h4><?=$jml;?> <?=Lang::t('results in');?> <?=$jmlpage;?> <?=Lang::t('pages');?></h4>  
        <?
    }
    public function updater(){
        $id = TextP::postP("id","");
        $name = TextP::postP("name","");
        $lvl = TextP::postP("lvl","");
        $org = TextP::postP("org","");
        $role = TextP::postP("role","");
        $json = array();
        $json['post'] = $_POST;
        $json['isi'][] = $role;
        $json['isi'][]= $name;
        $json['isi'][] = $lvl;
        $json['isi'][] = $org;
        $json['isi'][] = $id;
        
        $json['bool'] = 0;
        
        if($id == "" || $name == "" || $lvl == "" || $org == "" || $role == ""){
            
            $json['err'] = Lang::t('Please provide all data');
            die(json_encode($json));
        }
        $acc = new Account();
        $acc->getByID($id);
        $acc->admin_nama_depan = urldecode($name);
        $acc->admin_role = urldecode($role);
        $acc->load = 1;
        $suc = $acc->save();
        $json['isi'][] = $suc;
        //if($suc){
            //update role2acc
            $role2acc = new Role2Account();
            $arrR2c = $role2acc->getWhere("role_admin_id = '$id' LIMIT 0,1");
            $role2acc->getByID($arrR2c[0]->rc_id);
            $role2acc->role_id =  $role;
            $role2acc->load = 1;
            $suc2 = $role2acc->save();
            $json['isi'][] = $suc2;
            //if($suc2){
                //update lvl dan org
                $am = new AccountMeta();
                $arrMeta = $am->getWhere("account_id = $id");
                if(count($arrMeta)<1){
                    //create new
                    $am2 = new AccountMeta();
                    $am2->account_id = $id;
                    $am2->meta_key = "RoleLevel";
                    $am2->meta_value = $lvl;
                    $am2->save();
                    //create new
                    $am2 = new AccountMeta();
                    $am2->account_id = $id;
                    $am2->meta_key = "RoleOrganization";
                    $am2->meta_value = $org;
                    $am2->save();
                }else{
                    foreach($arrMeta as $mt){
                        if($mt->meta_key == "RoleLevel"){
                            $am2 = new AccountMeta();
                            $am2->getByID($mt->meta_id);
                            $am2->meta_value = $lvl;
                            $am2->load = 1;
                            $am2->save();
                            
                        }
                        if($mt->meta_key == "RoleOrganization"){
                            $am2 = new AccountMeta();
                            $am2->getByID($mt->meta_id);
                            $am2->meta_value = $org;
                            $am2->load = 1;
                            $am2->save();
                        }
                    }
                }
           // }
            $json['bool'] = $suc2;
        //}
        
        die(json_encode($json));
    }
}
