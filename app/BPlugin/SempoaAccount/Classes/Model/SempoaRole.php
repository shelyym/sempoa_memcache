<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/28/16
 * Time: 2:55 PM
 */

class SempoaRole extends Role{

    var $cname = "UserWeb";
    var $fktname = "update_user_grup_kpo";

    function __construct() {
//        parent::__construct();
//        print "In SubClass constructor\n";

        //set org_parent_id
        $this->role_level = AccessRight::getMyOrgType();
        $this->role_org_id = AccessRight::getMyOrgID();
    }

    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {

            $obj->role_edit_ar = "<button class='btn btn-default' onclick=\"openLw('edit_ugrup_ar','"._SPPATH.$this->cname."/".$this->fktname."?mode=edit_ugrup_ar&role_id=".$obj->role_id."','fade');\">Edit Access Right</button>";

        }
        return $return;
    }
    public function onSaveNewItemSuccess($id){


        $role2role = new Role2Role();

        global $db;
        $q = "DELETE FROM {$role2role->table_name} WHERE role_big = '$id' OR role_small = '$id'";
        $db->query($q,0);

        $role2role->role_big = $id;
        $role2role->role_small = "normal_user";
        $role2role->save();

        $role2role = new Role2Role();
        $role2role->role_big = "admin";
        $role2role->role_small = $id;
        $role2role->save();

    }

    public function onDeleteSuccess($id){
        //if success delete
        //hapus role2role dan hilangkan admin_role = id dr account
        global $db;
        $role2role = new Role2Role();
        $q = "DELETE FROM {$role2role->table_name} WHERE role_big = '$id' OR role_small = '$id'";
        $db->query($q,0);

        //coba apa bisa
        $acc = new SempoaAccount();
        $q = "UPDATE {$acc->table_name} SET admin_role = ''  WHERE admin_role = '$id'";
        $db->query($q,0);

        //Role2Account
        $role2acc = new Role2Account();
        $q = "DELETE FROM {$role2acc->table_name} WHERE role_id = '$id'";
        $db->query($q,0);

    }

    public static function role2armatrix($role_org_id,$level){
        $t = time();
        //create matrix to adjust menu
        $ro = new AccessRight();
        $arr = $ro->getWhere("ar_level = '$level' ORDER BY ar_folder_name ASC");

        $chn = new SempoaRole();
        $arrChn = $chn->getWhere("role_org_id = '$role_org_id' AND role_active = 1");

        $curlvl = "";

        ?>
        <script>
            var channelSelected = [];
        </script>
        <style>
            select option.no_text{
                color: #dedede !important;
            }
            .selectchannel{

                margin-bottom:30px;
            }
            .buttonselectchannel{
                border-radius: 5px;
                background-color: #efefef;
                float:left;
                padding: 10px;
                margin: 5px;
                cursor:pointer;
            }
            .buttonselectchannelactive{
                background-color: #bbb;
                text-decoration:line-through;
            }
            .warna{
                background-color: #f6f6f6;
                font-weight: bold;
            }
            thead td{
                background-color: #cccccc;
                font-weight: bold;
                font-size: 15px;
            }
        </style>
        <div class="selectchannel">
            <? foreach($arrChn as $ch){?>
                <div class="buttonselectchannel buttonselectchannelactive" id="chan_<?=$ch->role_id;?>_<?=$t;?>"><?=$ch->role_name;?></div>
                <script>
                    $("#chan_<?=$ch->role_id;?>_<?=$t;?>").click(function(){
                        for(var x in channelSelected){
                            //console.log(x+" in2222 "+channelSelected[x]);
                            $("#chan_"+channelSelected[x]+"_<?=$t;?>").addClass("buttonselectchannelactive");
                            $('.channel_form_'+channelSelected[x]).hide();
                        }
                        var index = jQuery.inArray("<?=$ch->role_id;?>", channelSelected);
                        //console.log(index);
                        if(index == -1){
                            channelSelected.push("<?=$ch->role_id;?>");
                        }else{
                            //var index2 = channelSelected.indexOf("<?=$ch->role_id;?>");
                            channelSelected.splice(index,1);
                            /*$("#chan_"+channelSelected[index2]+"_<?=$t;?>").removeClass("buttonselectchannelactive");
                             console.log("in");
                             console.log(index2);
                             for(var x in channelSelected){
                             if(channelSelected[x] =="<?=$ch->channel_id;?>" )
                             channelSelected.splice(x,1);
                             $("#chan_"+channelSelected[x]+"_<?=$t;?>").removeClass("buttonselectchannelactive");
                             }*/
                        }

                        for(var x in channelSelected){
                            //console.log(x+" in "+channelSelected[x]);
                            $("#chan_"+channelSelected[x]+"_<?=$t;?>").removeClass("buttonselectchannelactive");
                            $('.channel_form_'+channelSelected[x]).show();
                        }
                    });
                </script>
            <? } ?>
        </div>
        <script>
        function roleselectAll(id,status){
          var act = 0;
            if(status){
                $('.'+id).prop('checked', true);
                act = 1;
            }else{
                $('.'+id).prop('checked', false);
                act = 0;
            }
            $('.'+id).each(function(i, obj) {
    //test  
    var id = $(obj).attr('id');
    var arr = id.split("__");
    var role_id = arr[1];
    var ar_id = arr[0].split("mat_")[1];
    
    console.log(arr);
    console.log(role_id);
    console.log(ar_id);
    
    $.post('<?=_SPPATH;?>RoleHBE/update',
                                        {
                                            mat_id:ar_id+'__'+role_id,
                                            act :act,
                                            ar_id : ar_id,
                                            role_id : role_id
                                        },
                                        function(data){
                                            if(data.status_code){

                                            }else{
                                                alert(data.status_message);
                                            }
                                        },'json'
                                    );
//                console.log();
        });
            
            
            
            
        }
        </script>
        <? //  pr($arr);?>
        <div  style="margin-bottom:20px; clear:both;"></div>
        <div class="table-responsive">
            <table class="table table-bordered " style="background-color: #FFFFFF;">
                <thead>
                <tr>
                    <td><?=Lang::t('Access Rights');?></td>
                    <? 
                    foreach ($arrChn as $ch){?>
                        <td  style="display:none;" class="channel_form_<?=$ch->role_id;?>"><?=$ch->role_name;?></td>
                    <? } ?>
                </tr>
                </thead>
                <tbody>
                <?
                $active_folder = "";
                $ar2role = new AccessRight2Role();
                $matrix = $ar2role->getOrderBy("mat_ar_id ASC,mat_role_id ASC");
                $savejdsatu = array();
                foreach($matrix as $mat){
                    $saved[$mat->mat_ar_id][$mat->mat_role_id] = $mat->mat_active;
                    $savejdsatu[$mat->mat_ar_id."__".$mat->mat_role_id]= $mat->mat_active;
                }
                foreach($arr as $org){
                    if($active_folder != $org->ar_folder_name){
                        ?>
                        <tr class="warna">
                            <td  >
                            <?=$org->ar_folder_name;?>
                            </td>
                            <? foreach ($arrChn as $ch){

                            ?>
                            <td class="channel_form_<?=$ch->role_id;?>" style="display:none;">
                            <input type="checkbox" onclick="roleselectAll('chn_<?=  ($ch->role_id."_".str_replace(" ", "_", $org->ar_folder_name));?>',$(this).prop('checked'));">
                            </td>
                            <? } ?>
                        </tr>
                        <?
                        $active_folder = $org->ar_folder_name;
                    }

                    ?>
                    <tr>
                        <td><?=$org->ar_name;?></td>
                        <? foreach ($arrChn as $ch){

                            ?>
                            <td class="channel_form_<?=$ch->role_id;?>" style="display:none;">
                                <input class="chn_<?=  ($ch->role_id."_".str_replace(" ", "_", $org->ar_folder_name));?>" <? if($savejdsatu[$org->ar_id."__".$ch->role_id]) echo "checked";?> id="mat_<?=$org->ar_id;?>__<?=$ch->role_id;?>" type="checkbox">
                            </td>
                            <script>
                                
                                $('#mat_<?=$org->ar_id;?>__<?=$ch->role_id;?>').click(function(){
                                    var act = 0;
                                    if($(this).prop("checked")){
                                        act = 1;
                                    }

                                    $.post('<?=_SPPATH;?>RoleHBE/update',
                                        {
                                            mat_id:'<?=$org->ar_id;?>__<?=$ch->role_id;?>',
                                            act :act,
                                            ar_id : '<?=$org->ar_id;?>',
                                            role_id : '<?=$ch->role_id;?>'
                                        },
                                        function(data){
                                            if(data.status_code){

                                            }else{
                                                alert(data.status_message);
                                            }
                                        },'json'
                                    );
                                });
                            </script>
                        <? } ?>
                    </tr>
                <? } ?>
                </tbody>

            </table>
        </div>
    <?
    }
} 