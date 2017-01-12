<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsChannelWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class NewsChannelWeb extends WebService{
    
    public function NewsChannelMatrix(){
        $t = time();
        //create matrix to adjust menu
        $ro = new RoleOrganization();
        $arr = $ro->getWhere("organization_active = 1"); 
        
        $chn = new NewsChannel();
        $arrChn = $chn->getWhere("channel_active = 1");
        
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
</style>
<div class="selectchannel">
    <? foreach($arrChn as $ch){?>
    <div class="buttonselectchannel buttonselectchannelactive" id="chan_<?=$ch->channel_id;?>_<?=$t;?>"><?=$ch->channel_name;?></div>
    <script>
        $("#chan_<?=$ch->channel_id;?>_<?=$t;?>").click(function(){
            for(var x in channelSelected){
                //console.log(x+" in2222 "+channelSelected[x]);
                $("#chan_"+channelSelected[x]+"_<?=$t;?>").addClass("buttonselectchannelactive");
                $('.channel_form_'+channelSelected[x]).hide();
            }
            var index = jQuery.inArray("<?=$ch->channel_id;?>", channelSelected);
            //console.log(index);
            if(index == -1){
                channelSelected.push("<?=$ch->channel_id;?>");
            }else{
                //var index2 = channelSelected.indexOf("<?=$ch->channel_id;?>");
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
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <td><?=Lang::t('Department');?></td>
                <? foreach ($arrChn as $ch){?>
                <td  style="display:none;" class="channel_form_<?=$ch->channel_id;?>"><?=$ch->channel_name;?></td>
                <? } ?>
            </tr>
        </thead>
        <tbody>
            <? 
            $rl = new RoleLevel();
            $existingRoles = $rl->getWhere("level_active = 1 ORDER BY level_tingkatan ASC");
            $nc = new NewsChannel2Org();
            $arrNC = $nc->getAll();
            if(isset($arrNC))
            foreach($arrNC as $cn){
                $arrNN[$cn->c2d_id] = $cn;
            }
            //pr($existingRoles);
            foreach($arr as $org){ 
                if($org->organization_id == '1')
                  continue;
                ?>
            <tr>
                <td><?=$org->organization_name;?></td>
                <? foreach ($arrChn as $ch){ 
                    $menu = $org->organization_id."_".$ch->channel_id;
                    ?>
                <td class="channel_form_<?=$ch->channel_id;?>" style="display:none;">
                    <select id="role_lvl_<?=$menu;?>_<?=$t;?>">
                        <option class="no_text" value="no"></option>
                <? foreach($existingRoles as $ro){
                    $id = $ch->channel_id."_".$org->organization_id;
                    $curlvl = "0";
                    if(isset($arrNN[$id])){
                        $curlvl = $arrNN[$id]->c2d_level_id; 
                    }
                    ?>
                
                        <option value="<?=$ro->level_id;?>" <? if($ro->level_id == $curlvl)echo "selected";?>><?=$ro->level_name;?></option>
                <? } ?>
                    </select>
                    <script>
                    $("#role_lvl_<?=$menu;?>_<?=$t;?>").change(function(){
                        
                       var slc = $("#role_lvl_<?=$menu;?>_<?=$t;?>").val();
                       //if(slc != "no")
                       $.get("<?=_SPPATH;?>NewsChannelWeb/ins?org=<?=$org->organization_id;?>&chn=<?=$ch->channel_id;?>&level_id="+slc,function(data){
                           //alert(data);
                       }); 
                    });    
                    </script>
                </td>
                <? } ?>
            </tr>
            <? } ?>
        </tbody>
       
    </table>
</div>    
        <?
    }
    public function ins(){
        $roleWeb = new NewsChannel2Org();
        $id = $_GET['chn']."_".$_GET['org'];
        $roleWeb->c2d_id = $id;


        if($_GET['level_id'] == "no")$lvl = 0;
        else $lvl = $_GET['level_id'];
        
        $roleWeb->c2d_level_id = addslashes($lvl);
        $roleWeb->c2d_channel_id = addslashes($_GET['chn']);
        $roleWeb->c2d_org_id = addslashes($_GET['org']);        
        $roleWeb->insertOnDuplicate();
    }

	public function update(){
		$roleWeb = new NewsChannel2Org();
		$id = $_GET['chn']."_".$_GET['org'];
		$roleWeb->getByID($id);


		if($_GET['level_id'] == "no")$lvl = 0;
		else $lvl = $_GET['level_id'];

		$roleWeb->c2d_level_id = addslashes($lvl);
		$roleWeb->c2d_channel_id = addslashes($_GET['chn']);
		$roleWeb->c2d_org_id = addslashes($_GET['org']);
		$roleWeb->save();
	}
}
