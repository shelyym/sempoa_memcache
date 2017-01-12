<?php


/**
 * Description of BootstrapUX
 * Bootstrap Boilerplate for Leap Framework
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class BootstrapUX {
    
    public static function twoColoums($arrLeft = array(),$arrRight = array(), $sizeLeft = 4, $sizeRight = 8, $addedClassname = ""){
        //pr($arrLeft);
        //pr($arrRight);
        
        ?>
        <div class="row">
            <div class="col-md-<?=$sizeLeft;?> <?=$addedClassname;?>">
                <?
                
                foreach($arrLeft as $obj){
                    if(is_a($obj, "Portlet")){
                            $obj->printme();
                    }
                }
                
                ?></div>
            <div class="col-md-<?=$sizeRight;?> <?=$addedClassname;?>">

               <?
               foreach($arrRight as $obj){
                    if(is_a($obj, "Portlet")){
                            $obj->printme();
                    }
                }
               
               ?>

            </div>
            <div class="clearfix"></div>
        </div>
        
        
        <?
    }
    public static function threeColoums($arrLeft = array(),$arrMiddle = array(),$arrRight = array(), $sizeLeft = 4,$sizeMiddle = 4, $sizeRight = 4, $addedClassname = ""){
        
        
        ?>
        <div class="row">
            <div class="col-md-<?=$sizeLeft;?> <?=$addedClassname;?>">
                <?
                foreach($arrLeft as $obj){
                    if(is_a($obj, "Portlet")){
                            $obj->printme();
                    }
                }
                
                ?></div>
            <div class="col-md-<?=$sizeMiddle;?> <?=$addedClassname;?>">
                <?
                
                foreach($arrMiddle as $obj){
                    if(is_a($obj, "Portlet")){
                            $obj->printme();
                    }
                }
                
                ?></div>
            <div class="col-md-<?=$sizeRight;?> <?=$addedClassname;?>">

               <?
               foreach($arrRight as $obj){
                    if(is_a($obj, "Portlet")){
                            $obj->printme();
                    }
                }
               
               ?>

            </div>
            <div class="clearfix"></div>
        </div>
        
        
        <?
    }
    public static function createModal($modalTitle,$modalLoadContentURL,$glyphicons = "glyphicon glyphicon-plus",$extra_id = 'no'){
        $t = time();
        ?>
<i style="cursor:pointer;"  data-toggle="modal" data-target="#myModal" onclick="modalfkt_<?=$extra_id;?>_<?=$t;?>();" class="<?=$glyphicons;?>"></i>
<script type="text/javascript">
    function modalfkt_<?=$extra_id;?>_<?=$t;?>() {
        $('#myModalLabel').empty().append("<?=Lang::t($modalTitle);?>");
        $('#myModalBody').load("<?=$modalLoadContentURL;?>");
    }
</script>
        <?
    }
    public static function createModalButton($modalTitle,$modalLoadContentURL,$buttontext,$buttonclass = "btn btn-default"){
        $t = time();
        ?>
<button  data-toggle="modal" data-target="#myModal" onclick="modalfkt_<?=$t;?>();" class="<?=$buttonclass;?>"><?=$buttontext;?></button>
<script type="text/javascript">
    function modalfkt_<?=$t;?>() {
        $('#myModalLabel').empty().append("<?=Lang::t($modalTitle);?>");
        $('#myModalBody').load("<?=$modalLoadContentURL;?>");
    }
</script>
        <?
    }
    public static function accordion($arrContent){
        $t = time();
        ?>
<div class="panel-group" id="accordion_<?=$t;?>" role="tablist" aria-multiselectable="true">
     <?
                $num = 0;
               foreach($arrContent as $title=>$obj){
                    
                $id = $num."_".$t;
               
               ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?=$id;?>">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion_<?=$t;?>" href="#collapse<?=$id;?>" aria-expanded="true" aria-controls="collapse<?=$id;?>">
          <?=$title;?>
        </a>
      </h4>
    </div>
    <div id="collapse<?=$id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$id;?>">
      <div class="panel-body">
          <?
          if(is_a($obj, "Portlet")){
                $obj->printme();
        }?>
      </div>
    </div>
  </div>
               <?
               $num++;
               } ?>
</div>
        <?
        
    }
    public static function pageHeader($h1Text,$h1SubText = ""){
        ?>
<div class="page-header">
  <h1><?=Lang::t($h1Text);?> <?if($h1SubText!=""){?><small><?=Lang::t($h1SubText);?></small><?}?></h1>
</div>            
        <?
    }
    public static function listGroupOpenLw($arrList){
        ?>
<div class="list-group">
    <? foreach($arrList as $num=>$list){?>
    <a  onclick="<?=$num;?>" class="list-group-item">
    <?=$list;?>
    </a>
    <? } ?> 
</div>    
        <?
    }
    
    public static function alert($html,$type = 1,$isDismissible = 0){
        $closebutton = '';
        $dismisclass = '';
        
        if($isDismissible){
            $closebutton = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            $dismisclass = 'alert-dismissible';
        }
        switch ($type){
            case 1:
                ?>
<div class="alert alert-success <?=$dismisclass;?>" role="alert"><?=$closebutton;?>
    <?=$html;?>
</div>
                <?
            break;    
            case 0:
                ?>
<div class="alert alert-danger <?=$dismisclass;?>" role="alert"><?=$closebutton;?>
    <?=$html;?>
</div>
                <?
            break;    
            case 2:
                ?>
<div class="alert alert-warning <?=$dismisclass;?>" role="alert"><?=$closebutton;?>
    <?=$html;?>
</div>
                <?  
            break;      
            default :   
                 ?>
<div class="alert alert-info <?=$dismisclass;?>" role="alert"><?=$closebutton;?>
    <?=$html;?>
</div>
                <? 
        }        
        
    }
}
