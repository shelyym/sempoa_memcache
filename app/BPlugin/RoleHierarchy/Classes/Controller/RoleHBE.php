<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/20/16
 * Time: 9:53 PM
 */

class RoleHBE extends WebService{


    public function AccessRight ()
    {
        //create the model object
        $cal = new AccessRight();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    public function AccessRight2Role ()
    {
        //create the model object
        $cal = new AccessRight2Role();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    public function AccessMatrix(){
        $t = time();
        //create matrix to adjust menu
        $ro = new AccessRight();
        $arr = $ro->getOrderBy("ar_folder_name ASC");

        $chn = new Role();
        $arrChn = $chn->getWhere("role_active = 1");

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
        <div  style="margin-bottom:20px; clear:both;"></div>
        <div class="table-responsive">
            <table class="table table-bordered " style="background-color: #FFFFFF;">
                <thead>
                <tr>
                    <td><?=Lang::t('Access Rights');?></td>
                    <? foreach ($arrChn as $ch){?>
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
                        <td  colspan="<?=count($arrChn)+1;?>"><?=$org->ar_folder_name;?></td>
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
                                <input <? if($savejdsatu[$org->ar_id."__".$ch->role_id]) echo "checked";?> id="mat_<?=$org->ar_id;?>_<?=$ch->role_id;?>" type="checkbox">
                            </td>
                            <script>
                                $('#mat_<?=$org->ar_id;?>_<?=$ch->role_id;?>').click(function(){
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
        public function updateSatuFolderName(){
        $roleWeb = new AccessRight2Role();
        $id = addslashes($_POST['mat_id']);
        $act = addslashes($_POST['act']);

        $roleWeb->mat_id = $id;
        $roleWeb->mat_active = $act;
        $roleWeb->mat_ar_id = addslashes($_POST['ar_id']);
        $roleWeb->mat_role_id = addslashes($_POST['role_id']);

        $bool = $roleWeb->save(1);
        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }


        echo json_encode($json);
        die();
    }

    public function update(){
        $roleWeb = new AccessRight2Role();
        $id = addslashes($_POST['mat_id']);
        $act = addslashes($_POST['act']);

        $roleWeb->mat_id = $id;
        $roleWeb->mat_active = $act;
        $roleWeb->mat_ar_id = addslashes($_POST['ar_id']);
        $roleWeb->mat_role_id = addslashes($_POST['role_id']);

        $bool = $roleWeb->save(1);
        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }


        echo json_encode($json);
        die();
    }
} 