<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/3/15
 * Time: 3:06 PM
 */

class MCampApp extends WebService{

    var $access_MCampaignModel = "normal_user";

    public function MCampaignModel ()
    {
        $sortdb = "camp_updatedate DESC";
        if(!isset($_GET['sort']))$_GET['sort'] = $sortdb;

        //create the model object
        $cal = new MCampaignModel();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }

    var $access_catTree = "normal_user";
    public function catTree ()
    {
        //create the model object
        /*
         * INGAT !! parent_id di mysql harus bisa negatif jangan unsigned
         */
        $cal = new MProdCat();
        //tentukan field untuk parent nya..
        $cal->parentID = "cat_parent_id";
        //tentukan field untuk namanya nya..
        $cal->nameID = "cat_name";
        //what to print in box
        $cal->printToEditBox = array(
            /*
             * associative array, dimana key adalah nama fieldnya
             * valuenya adalah array dimana pos 0 adalah textnya
             * dan pos 1 adalah syaratnya sementara syarat hanya ada not_empty hahaha
             */
            "cat_name"=>array("text","not_empty")
//            "cat_metatitle"=>array("text","not_empty"),
//            "cat_metadesc"=>array("text","not_empty"),
//            "cat_metatag"=>array("text","not_empty")
        );
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        TreeStructure::run($cal, $webClass,__FUNCTION__);
    }

    var $access_MProdModel = "normal_user";
    public function MProdModel(){
        $sortdb = "prod_kode ASC";
        if(!isset($_GET['sort']))$_GET['sort'] = $sortdb;

        //create the model object
        $cal = new MProdModel();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }


    var $access_inputProduct = "normal_user";
    public function inputProduct(){

        $myapp_id = AppAccount::getAppID();
        if($myapp_id == "" || $myapp_id<1)die("Not valid App ID");
        $cam = new MCampaignModel();
        $arrCam = $cam->getWhere("camp_app_id = '$myapp_id' ");

        $prod = new MProdModel();
        $arrProd = $prod->getWhere("prod_app_id = '$myapp_id' ");
        $_SESSION['arrProd'] = $arrProd;
        ?>
        <div class="input-group">

            <span class="input-group-addon" id="basic-addon1">Select Campaign :</span>
            <select class="form-control" onchange="getMatrix();" id="camp_select">
                <option value=""></option>
                <?
                foreach($arrCam as $c){?>
                    <option value="<?=$c->camp_id;?>"><?=$c->camp_name;?></option>
                <? } ?>
            </select>
        </div><!-- /input-group -->



        <div id="camp_matrix" style="padding-top: 20px;">

        </div>

        <script>
            function getMatrix(){
                var slc = $("#camp_select").val();
                if(slc!="")
                    $("#camp_matrix").load("<?=_SPPATH;?>MCampApp/getMatrix?cid="+slc);
            }
        </script>
        <style>
            .productcamp{
                background-color: #dedede;
                margin: 5px;
                padding: 5px;
            }

        </style>
        <?
        //pr($arrProd);
    }

    var $access_getMatrix = "normal_user";

    function getMatrix(){
        $cid = addslashes($_GET['cid']);
        //get campaign for owner verification
        $camms = new MCampaignModel();
        $camms->getByID($cid);

        if($camms->camp_app_id != AppAccount::getAppID())die("Not Allowed");

        $as = new MCampaignMatrix();
        $arr = $as->getWhere("cm_camp_id = '$cid'");

        $arrProd = $_SESSION['arrProd'];
        foreach($arrProd as $pp){
            $arrProds[$pp->prod_id] =  $pp;
        }
        //pr($arrProds);
        //pr($arr);
        $t = time();



        ?>
        <div class="col-md-6">
            <?
            foreach($arr as $g){
                $prod = $arrProds[$g->cm_prod_id];
                $sudahAda[] = $g->cm_prod_id;
                ?>
                <div class="productcamp">

                    <div class="productcamp_title">

                        <div style="float:right;width: 20px;">
                            <i id="cm_<?=$g->cm_id;?>" class="glyphicon glyphicon-arrow-right" style="cursor:pointer;"></i>
                        </div>
                        <?=$prod->prod_name;?>
                    </div>
                </div>
                <script>
                    $("#cm_<?=$g->cm_id;?>").click(function(){
                        $.get("<?=_SPPATH;?>MCampApp/delMatrix?cmid=<?=$g->cm_id;?>",function(data){
                            console.log(data);
                            if(data.bool){
                                $("#camp_matrix").load("<?=_SPPATH;?>MCampApp/getMatrix?cid=<?=$cid;?>");
                            }else{
                                alert('<?=Lang::t('Delete Error');?>');
                            }
                        },'json');
                    });
                </script>
            <?
            }?>
        </div>
        <div class="col-md-6" >
            <div style="background-color: #AAA; margin: 5px; padding: 10px; ">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Select Product To Insert to Campaign</span>

                </div>
                <div class="input-group">
            <span class="input-group-btn">
                <button id="add_to_camp_<?=$t;?>" class="btn btn-default" type="button"><i class="glyphicon glyphicon-arrow-left"></i></button>
            </span>
                    <select id="sel_to_camp_<?=$t;?>" class="form-control">
                        <? foreach($arrProds as $key=>$prod){
                            if(in_array($key,$sudahAda))
                                continue;
                            ?>
                            <option value="<?=$prod->prod_id;?>"><?=$prod->prod_name;?></option>
                        <? } ?>
                    </select>
                </div><!-- /input-group -->
            </div>
        </div>
        <script>
            $("#add_to_camp_<?=$t;?>").click(function(){
                var slc = $("#sel_to_camp_<?=$t;?>").val();
                $.get("<?=_SPPATH;?>MCampApp/insProd?cid=<?=$cid;?>&pid="+slc,function(data){
                    console.log(data);
                    if(data.bool){
                        $("#camp_matrix").load("<?=_SPPATH;?>MCampApp/getMatrix?cid=<?=$cid;?>");
                    }else{
                        alert('<?=Lang::t('Insert Error');?>');
                    }
                },'json');
            });

        </script>
        <?
        exit();
    }
    var $access_insProd = "normal_user";
    function insProd(){
        //$cid = addslashes($_GET['cid']);
        //$pid = addslashes($_GET['pid']);
        $cid = isset($_GET['cid'])?addslashes($_GET['cid']):die("no id");
        $pid = isset($_GET['pid'])?addslashes($_GET['pid']):die("no id");

        $matrix = new MCampaignMatrix();
        $matrix->cm_camp_id = $cid;
        $matrix->cm_prod_id = $pid;
        $matrix->cm_latest_added = leap_mysqldate();
        $json['bool'] = $matrix->save();
        echo json_encode($json);
    }
    var $access_delMatrix = "normal_user";
    function delMatrix(){
        $cmid = isset($_GET['cmid'])?addslashes($_GET['cmid']):die("no id");
        $matrix = new MCampaignMatrix();
        $json['bool'] = $matrix->delete($cmid);
        echo json_encode($json);

    }
} 