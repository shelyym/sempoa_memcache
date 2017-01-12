<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageContainerWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PageContainerWeb extends WebService{
    public function PageContainer ()
    {
        //create the model object
        $cal = new PageContainer();

        //send the webclass 
        $webClass = __CLASS__;

        //filter only for active theme
       // $dir = ThemeItem::getTheme();
       // $cal->read_filter_array = array("set_theme_id"=>$dir);
        
        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    
    public static function portalIndex(){
        
        $mode = isset($_GET['mode'])?addslashes($_GET['mode']):die('no mode');
        if($mode<1)die("mode hrs integer");
        
        /*
         * LOAD page con, cek apakah bisa ini sub atau main con
         */
        $a = NewsChannel::myChannels();
        //pr($a);
        foreach($a as $chn){
            $str = " page_channel_id = '$chn' ";
            $imp[] = $str;
        }
        $wherechannel = implode("OR", $imp);
        $wherechannel = "(".$wherechannel.")";
        
        $pc = new PageContainer();
        $pc->getByID($mode);
        
        $gw = new GalleryWeb();
        
        if($pc->container_parent_id == 0){
            //self::subconMenu($mode);
            $class = "col-md-7 col-md-offset-1";
            $yangdipakai = "post_gallery_id";
        }
        else{
            $pc2 = new PageContainer();
            $pc2->getByID($pc->container_parent_id);
            $breadcrumbs = "<a href='"._SPPATH."pagecontainer?mode=".$pc2->container_id."'>".$pc2->container_name."</a> / <a href='"._SPPATH."pagecontainer?mode=".$pc->container_id."'>".$pc->container_name."</a>";
            $class = "col-md-8 col-md-offset-2";
            $yangdipakai = "post_subcon_id";
            
        }
        
        $s = isset($_GET['s'])?addslashes($_GET['s']):"";
        
        $halaman = isset($_GET['p'])?addslashes($_GET['p']):1;
        
        $limit = 10;
        $begin = ($halaman-1)*$limit;
        $searchText = "";
        if($s != ""){
            $searchText = " AND ( post_title LIKE '%$s%' OR post_content LIKE '%$s%')";
        }
        
        $page = new Page();
        
        $whereClause = "$yangdipakai = '$mode' AND post_status = 'publish' AND $wherechannel $searchText";
        $arrPage = $page->getWhere($whereClause." ORDER BY post_modified DESC LIMIT $begin,$limit");
        
        $jml = $page->getJumlah($whereClause);
        
        
        if(count($arrPage) == 0){
            ?>
<h3><?=Lang::t('No Page on this category yet');?></h3>    
            <?
            return "";
        }
        
        ?>

<div class="<?=$class;?>">
    <? echo $breadcrumbs;?>
    <h1 class="tbsh1" style="margin-bottom:20px;">
            <div style="float: right; width: 200px;">
                <div class="input-group">
                    <input id="seachtext" type="text" value="<?=$s;?>" class="form-control" placeholder="search <?=$pc->container_name;?>">
                    <span class="input-group-btn">
                        <button onclick="document.location='<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s='+$('#seachtext').val();" class="btn btn-default" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    <script>
                    $("#seachtext").keyup(function(){
                        if (event.keyCode == 13) { //on enter
                        var slc = $('#seachtext').val();
                        document.location='<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s='+$('#seachtext').val();
                        }
                    });
                    </script>
              </div><!-- /input-group -->
            </div>
            <?=$pc->container_name;?>
        </h1>    
        <style>
    .post-title{
        font-size: 18px !important;
        color:#333 !important;
        font-weight: bold;
    }
    .post-title a{
        color:#555 !important;
    }
</style>    
        <?
        foreach($arrPage as $num=>$p){
            ?>
               <div class="post-preview">
                   <div class="col-md-4">
                       <img class="img-responsive" src="<?=_SPPATH.$gw->uploadURL.$p->post_image;?>">
                   </div>
                   <div class="col-md-8">
                       <div style="padding-left:10px;">
                       <div class="post-meta"><?=indonesian_date($p->post_modified);?></div>
                        <div class="post-title">
                            <a href="<?=_SPPATH;?>page?id=<?=$p->ID;?>">
                            <?=stripslashes($p->post_title);?>
                            </a>
                        </div>
                        <div class="post-subtitle">
                            
                            <?=substr(stripslashes(strip_tags($p->post_content)),0,100);?>
                            <?
                            if(strlen($p->post_content)>100){
                            ?>
                            ...
                            <? } ?><br>
                            <a href="<?=_SPPATH;?>page?id=<?=$p->ID;?>">
                            <?=Lang::t('read more');?>
                            </a>
                        </div>
                       </div>
                   </div>
                    
                   <div class="clearfix"></div>
                </div>
                <? if($num< (count($arrPage)-1)){?>
                <hr> 
                <? } ?>
                <style>
                    .post-meta{
                        font-size: 14px;
                        padding-top: 0;
                        margin-top: 0;
                    }
                    .post-title{
                        margin-bottom: 0;
                        margin-top: 0;
                        padding: 0;
                    }
                    .post-subtitle{
                        padding-top: 10px;
                    }
                    .buttonefi{
                        margin: 0 auto; text-align: center; font-weight: bold; cursor: pointer; background-color: #dedede; border-radius: 5px; padding: 10px; margin: 10px;
                    }
                    .buttonefi:hover{
                        background-color: #efefef;
                    }
                </style>
             <?
        }
        
        $jmlpage = ceil($jml/$limit);
        
        ?>
                  
                
 <nav>
  <ul class="pagination">
      <?if($halaman>1){?>
    <li><a href="<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s=<?=$s;?>&p=<?=$halaman-1;?>"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
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
    
    <li <? if($x==$halaman){?>class="active"<?}?>><a href="<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s=<?=$s;?>&p=<?=$x;?>"><?=$x;?></a></li>
    <? } ?>
    
    <?if($jml>$begin+$limit){?>
    <li><a href="<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s=<?=$s;?>&p=<?=$halaman+1;?>"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
    <? } ?>
  </ul>
</nav>
        <h4><?=$jml;?> results in <?=$jmlpage;?> pages</h4>  
</div><?

if($pc->container_parent_id == 0){
            self::subconMenu($mode);
            //$class = "col-md-7";
        }
    }
    
    public function subconMenu($mode){
        
        ?>
<style>
    .pagecon{
        text-decoration: underline;
        color: #0066cc;
        line-height: 30px;
        text-align: center;
    }
</style>
<div class="col-md-3 ">
    <div style="margin: 10px; border:1px solid #dedede; margin-left: 40px; border-radius: 10px;">
        <div style="font-size:15px; background-color: #efefef; padding: 5px;"><?=Lang::t('Sub Container');?></div>
       <? 
    $pc = new PageContainer();
    $parenttext = "AND container_parent_id = '$mode'";
            
     $arrGal = $pc->getWhere("container_active =1 $parenttext ORDER BY container_name ASC");
     //pr($arrGal);
     if(count($arrGal) == 0){
         ?>
        <div style="line-height: 30px; font-size: 12px; text-align: center;">
            <? echo Lang::t('No SubContainer yet'); ?>
        </div>
        <?
     }
     foreach($arrGal as $pcsub){
         ?>
        <div class="pagecon"><a href="<?=_SPPATH;?>pagecontainer?mode=<?=$pcsub->container_id;?>"><?=$pcsub->container_name;?></a></div>    
         <?
     }
    ?>  
    </div>
   
</div><?
    }
}
