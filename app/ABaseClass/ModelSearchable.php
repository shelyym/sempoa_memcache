<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelSearchable
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ModelSearchable extends Model{
    
    public $searchField;
    public $searchOrderBy;
    
    public function searchMe(){
        $s = isset($_GET['s'])?addslashes($_GET['s']):die('please insert search text');
        $loc = isset($_GET['loc'])?addslashes($_GET['loc']):die('please define location');
       //$mode = isset($_GET['mode'])?addslashes($_GET['mode']):die('no mode');
       // if($mode<1)die("mode hrs integer");
       // $s = isset($_GET['s'])?addslashes($_GET['s']):"";
        
        $halaman = isset($_GET['p'])?addslashes($_GET['p']):1;
        
        $limit = 2;
        $begin = ($halaman-1)*$limit;
        $searchText = "";
        if($s != ""){
            $searchText = " AND ( post_title LIKE '%$s%' OR post_content LIKE '%$s%')";
        }
        
        $page = new Page();
        
        $whereClause = "post_status = 'publish' $searchText";
        $arrPage = $page->getWhere($whereClause." ORDER BY post_modified DESC LIMIT $begin,$limit");
        
        $jml = $page->getJumlah($whereClause);
        
        
        $mode = 0;
        //$pc = new PageContainer();
        //$pc->getByID($mode);
        
        $gw = new GalleryWeb();
        
        ?>

    <h1 class="tbsh1" style="margin-bottom:20px; background-color: #efefef; padding: 10px; color: #000;">
        Pages
            <div style="float: right; width: 200px; display: none;">
                <div class="input-group">
                    <input id="seachtext" type="text" value="<?=$s;?>" class="form-control" placeholder="search ">
                    <span class="input-group-btn">
                        <button onclick="document.location='<?=_SPPATH;?>pagecontainer?mode=<?=$mode;?>&s='+$('#seachtext').val();" class="btn btn-default" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    <script>
                    $("#seachtext").keyup(function(){
                        if (event.keyCode == 13) { //on enter
                        var slc = $('#seachtext').val();
                        $('#<?=$loc;?>').load('<?=_SPPATH;?>PageWeb/search?s='+$('#seachtext').val());
                        }
                    });
                    </script>
              </div><!-- /input-group -->
            </div>
            
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
                  
                   <div class="col-md-12">
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
      <li><a onclick="$('#<?=$loc;?>').load('<?=_SPPATH;?>PageWeb/search?loc=<?=$loc;?>&s=<?=$s;?>&p=<?=$halaman-1;?>');" >
            <span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>
        </a>
    </li>
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
    
    <li <? if($x==$halaman){?>class="active"<?}?>>
        <a onclick="$('#<?=$loc;?>').load('<?=_SPPATH;?>PageWeb/search?loc=<?=$loc;?>&s=<?=$s;?>&p=<?=$x;?>');" >
        <?=$x;?>
        </a>
    </li>
    <? } ?>
    
    <?if($jml>$begin+$limit){?>
    <li>
        <a onclick="$('#<?=$loc;?>').load('<?=_SPPATH;?>PageWeb/search?loc=<?=$loc;?>&s=<?=$s;?>&p=<?=$halaman+1;?>');" >
            <span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
        </a>
    </li>
    <? } ?>
  </ul>
</nav>
       <!-- <h4><?=$jml;?> results in <?=$jmlpage;?> pages</h4>  -->

    <?
        
    }   
}
