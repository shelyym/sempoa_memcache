<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageCommentWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PageCommentWeb extends WebService{
    
    public static function beginComment($pid,$type = "page"){
         $t = time();
        self::createBox($pid,$type);
        ?>
<div id="lc_<?=$pid;?>" style="margin-top: 10px;">
<?
$pcw = new PageCommentWeb();
$pcw->getLatestComments($pid,$type);
?>
</div>
  <?           
        
    }
    public static function createBox($pid,$type = "page"){
        $t = time();
        ?>
<h3 class="h3pv">
<div style="float: right;  cursor: pointer;" onclick="$('#cb_<?=$pid;?>_<?=$t;?>').fadeToggle();">
    <i style="font-size:14px;"  class="glyphicon glyphicon-plus"></i>
</div>
    <?=Lang::t('Comments');?>
</h3>
<div id="cb_<?=$pid;?>_<?=$t;?>" class="commentbox col-md-12" style="padding:10px; margin-bottom: 10px; background-color: #efefef;display: none;">
    <div class="col-md-1 col-xs-2">
        <div style="padding:10px; padding-top: 0px;">
        <? Account::makeMyFoto100percent();?>
        </div>
    </div>
    <div class="col-md-11 col-xs-10">
        <textarea class="form-control" rows="3" id="ta_<?=$pid;?>_<?=$t;?>"></textarea>
        <div style="float:right; padding: 10px;">
        <button id="bt_<?=$pid;?>_<?=$t;?>" class="btn btn-default"><?=Lang::t('submit');?></button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script>
    $("#bt_<?=$pid;?>_<?=$t;?>").click(function(){
        var slc = $("#ta_<?=$pid;?>_<?=$t;?>").val();
        if(slc != "")
        $.post("<?=_SPPATH;?>PageCommentWeb/ins?type=<?=$type;?>&pid=<?=$pid;?>",{tex:slc},function(data){
            if(data.bool){
                //alert("in");
                $("#lc_<?=$pid;?>").load("<?=_SPPATH;?>PageCommentWeb/getLatestComments?type=<?=$type;?>&pid=<?=$pid;?>");
                $("#ta_<?=$pid;?>_<?=$t;?>").val('');
            }
        },'json');
    });
</script>
        <?
    }
    public function ins(){
        $pid = isset($_GET['pid'])?addslashes($_GET['pid']):die("no pid");
        $tex = isset($_POST['tex'])?addslashes($_POST['tex']):die("no pid");
        $type = isset($_GET['type'])?addslashes($_GET['type']):"page";
        $json = array();
        $json['bool'] = 0;
        $pc = new PageComment();
        $pc->comment_text = $tex;
        $pc->comment_date = leap_mysqldate();
        $pc->comment_author = Account::getMyID();
        $pc->comment_page_id = $pid;
        $pc->comment_type = $type;
        $json['bool'] = $pc->save();
        die(json_encode($json));
    }
    public function getLatestComments($pid = -1,$type = "page"){
        
        if(isset($_GET['pid'])){
            $pid = isset($_GET['pid'])?addslashes($_GET['pid']):die("no pid");
            $type = isset($_GET['type'])?addslashes($_GET['type']):"page";
        }
        
        $pc = new PageComment();
        $acc = new Account();
        
        $q = "SELECT * FROM {$pc->table_name},{$acc->table_name} WHERE admin_id = comment_author AND comment_page_id = '$pid' AND comment_type = '$type' ORDER BY comment_date DESC LIMIT 0,10";
        global $db;
        $arr = $db->query($q,2);
        //pr($arr);
        foreach($arr as $c){
            $src = Account::getMyFotoAcc($c->admin_foto);
            
            ?>
<div class="comment-item col-md-12" style="border-bottom: 1px solid #dedede; margin-bottom: 10px;">
    <div class="col-md-2 col-xs-3">
        <div style="padding:20px; padding-top: 0px;">
        <? Account::makeMyFoto100percent($src);?>
        </div>
    </div>
    <div class="col-md-10 col-xs-9">
        <div class="admin-name" style="font-style: italic;"><?=$c->admin_nama_depan;?></div>
        <div class="admin-date" style="font-style: italic; font-size: 11px;"><?=  indonesian_date($c->comment_date);?></div>
        <div class="commentext" style="padding:10px; padding-left: 0px;">
        <?=  stripslashes($c->comment_text);?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
                  
             <?
        }

    }
     
}
