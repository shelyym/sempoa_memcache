<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 1:14 PM
 */

class ZAppFeature extends Model{

    public $feat_name;
    public $feat_id;
    public $feat_icon;

    public $feat_tab_icon;
    public $feat_rank_tampil = 0;

    public $feat_active = 1;

    //jangan diganti...!!
    //jangan dioverwrite
    //berhub dengan featureSessionLayer
    public $arrayID = "item_array";

    public $icon_path;
    public $feat_noimage;

    function __construct() {

        $this->feat_noimage = _BPATH."images/noimage.jpg";
        $this->icon_path = _BPATH."icons/";
    }

    public static function clearSession(){
        unset($_SESSION['ZAppFeature']);
        unset($_SESSION['FeatureSessionLayer']);
    }
    public static function checkRemainingSession(){
        if(isset($_SESSION['ZAppFeature']))
            return true;
        else
            return false;
    }

    public static function getChildren(){
//        pr(get_declared_classes());

        $children = get_declared_classes();
        $hasil = array();

        foreach($children as $classes){
            if($classes!="ZAppFeatureList" && $classes!="ZAppFeatureListRTE" && $classes != 'ZAppFeatureSocial')
            if( is_subclass_of($classes,"ZAppFeature")){

                $hasil[] = $classes;
            }
        }
        return $hasil;
    }
    public static function selectedFeature(){

//        pr($_SESSION);
        if(!isset($_SESSION['ZAppFeature']['selected'])){
            $_SESSION['ZAppFeature']['selected'][] = "info";
            $_SESSION['ZAppFeature']['selected'][] = "inbox";
        }

        if(count($_SESSION['ZAppFeature']['selected'])<1)
            $_SESSION['ZAppFeature']['selected'][] = "inbox";

        return $_SESSION['ZAppFeature']['selected'];
//        return array('info','contact');
//        return array('info','contact','map');
//        return array('info','contact','map','facebook');
//        return array('info','contact','map','loyalty','facebook');
//        return array('info','contact','map','loyalty','facebook','deals');
    }

    public static function setFeature($arr){
        $_SESSION['ZAppFeature']['selected'] = $arr;
    }

    public static function updateOrder($arr){
        $sem = array();
        foreach($arr as $xx){
            if(in_array($xx,$_SESSION['ZAppFeature']['selected'])){
               $sem[] = $xx;
            }
        }

        self::setFeature($sem);
    }

    public static function addFeature($id){
        if(!in_array($id,$_SESSION['ZAppFeature']['selected']))
        $_SESSION['ZAppFeature']['selected'][] = $id;
    }

    public static function removeFeature($id){

        foreach($_SESSION['ZAppFeature']['selected'] as $key=>$val){
            if($val == $id){
                unset($_SESSION['ZAppFeature']['selected'][$key]);
            }
        }
        $_SESSION['ZAppFeature']['selected'] = array_values($_SESSION['ZAppFeature']['selected']);

    }

    public static function loadColor(){
        if(!isset($_SESSION['ZAppFeature']['themes'])){
            $_SESSION['ZAppFeature']['themes']['text_color'] = "#FFFFFF";
            $_SESSION['ZAppFeature']['themes']['panel_color'] = "#000000";
            $_SESSION['ZAppFeature']['themes']['bg_color'] = "#EFEFEF";
            $_SESSION['ZAppFeature']['themes']['bg_img'] = "";
            $_SESSION['ZAppFeature']['themes']['splash_img'] = _BPATH."images/iphone.jpg";
        }
        return $_SESSION['ZAppFeature']['themes'];
    }

    public static function saveColor($arr){
        $_SESSION['ZAppFeature']['themes'] = $arr;
    }

    public static function loadDetails(){
        if(!isset($_SESSION['ZAppFeature']['details'])){
            $_SESSION['ZAppFeature']['details']['app_icon'] = _BPATH."images/noimage2.png";
            $_SESSION['ZAppFeature']['details']['app_name'] = "app name";
            $_SESSION['ZAppFeature']['details']['app_des_short'] = "";
            $_SESSION['ZAppFeature']['details']['app_des_long'] = "";
            $_SESSION['ZAppFeature']['details']['app_feature_img'] = _BPATH."images/noimage2.png";
        }
        return $_SESSION['ZAppFeature']['details'];
    }

    public static function saveDetails($arr){
        $_SESSION['ZAppFeature']['details'] = $arr;
    }

//    public function formPembuatan(){
//        echo "please override formPembuatan method for ".$this->feat_name;
//    }
//
//    public function appPage(){

        /*?>

            <div class="mheader" id="mheader_<?=$this->feat_id;?>">
                <div class="mheadertext" id="mheadertext_<?=$this->feat_id;?>"><?=$this->feat_id;?> Blank Page</div>
            </div>
            <div class="mcontent" id="mcontent_<?=$this->feat_id;?>">
                Please define appPage <?=$this->feat_id;?>
            </div>


        <?*/
//    }

    public function formPembuatan(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);
        $contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:$this->feat_name;
        $labelname = isset($valuesNya[$this->feat_id.'_labelname'])?$valuesNya[$this->feat_id.'_labelname']:$this->feat_name;

        $this->formCustom();

        $sel = ZAppFeature::selectedFeature();

        ?>
        <hr class="garisbatas">
        <div class="form-group">
            <label for="contact_pname">Page Name</label>
            <?
            TextLimiter::inputText("text",$this->feat_id."_pname",$this->feat_id."_pname","Page Name",$contact_pname,25,1,"mheadertext_".$this->feat_id);
            ?>
        </div>
        <div class="form-group">
            <label for="<?=$this->feat_id;?>_labelname">Label Name</label>
            <?
            TextLimiter::inputText("text",$this->feat_id."_labelname",$this->feat_id."_labelname","Label Name",$labelname,8,3);
            ?>

<!--            <input type="text" class="form-control" id="--><?//=$this->feat_id;?><!--_labelname" placeholder="Label Name" value="--><?//=$labelname;?><!--">-->
        </div>

        <div class="wadahbutton" id="wadahbutton_<?=$this->feat_id;?>_1"  <? if(!in_array($this->feat_id,$sel)){?>style="display: none;"<?}?>>
            <button type="button" id="<?=$this->feat_id;?>_save" class="btn btn-success btn-lg">Save</button>
            <? if($this->feat_id != "inbox"){?>
                <div style="float: right;"><button type="button" id="<?=$this->feat_id;?>_remove" class="btn btn-danger">Remove Feature from App</button></div>

            <? } ?>
            <script>
                $('#<?=$this->feat_id;?>_save').click(function(){
                    info_save_<?=$this->feat_id;?>();
                });
                <? if($this->feat_id != "inbox"){?>
                $('#<?=$this->feat_id;?>_remove').click(function(){
                    info_remove_<?=$this->feat_id;?>();
                });
                <? } ?>
            </script>

        </div>

        <div class="wadahbutton" id="wadahbutton_<?=$this->feat_id;?>_2"  <? if(in_array($this->feat_id,$sel)){?>style="display: none;"<?}?>>
            <button type="button" id="<?=$this->feat_id;?>_save2" class="btn btn-success btn-lg">Save and Add Feature to App</button>
            <script>
                $('#<?=$this->feat_id;?>_save2').click(function(){
                    info_save_<?=$this->feat_id;?>();
                });

            </script>
        </div>


        <script>
            function info_remove_<?=$this->feat_id;?>(){
                removeAppFeature('<?=$this->feat_id;?>');
            }
        </script>
        <script>
            $("#<?=$this->feat_id;?>_labelname").keyup(function(){

                //console.log("in1");
                var slc = $("#<?=$this->feat_id;?>_labelname").val();
                $("#tabname_<?=$this->feat_id;?>").html(slc);
                //console.log("in2");

                //update object yang dipilih
                arrFeats['<?=$this->feat_id;?>'].label_name = slc;
            });

        </script>
        <style>
            .garisbatas{
                border-color: #aaaaaa;
                border-style: dashed;
            }
        </style>
    <?
    }

    public function appPage(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:$this->feat_name;


        ?>

        <div class="mheader" id="mheader_<?=$this->feat_id;?>">
            <div class="mheadertext" id="mheadertext_<?=$this->feat_id;?>"><?=$contact_pname;?></div>
        </div>
        <div class="mcontent" id="mcontent_<?=$this->feat_id;?>">
        <? $this->appPageCustom(); ?>
        </div>


    <?

    }

    public function formCustom(){

$sel = ZAppFeature::selectedFeature();

$valuesNya = FeatureSessionLayer::load($this->feat_id);

$contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:$this->feat_name;
$contact_pslogan = isset($valuesNya[$this->feat_id.'_pslogan'])?$valuesNya[$this->feat_id.'_pslogan']:"description";

?>
<h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;"><?=$this->feat_name;?></h1>
<p style="color: #666666; font-size: 12px;">Please complete one or more fields below. <em>All fields are optional.</em></p>

<div class="form-group">
    <label for="info_slogan">Page Content</label>
    <?
    TextLimiter::inputTextArea("text",$this->feat_id."_pslogan",$this->feat_id."_pslogan","Description",$contact_pslogan,5000,0,$this->feat_id."_des");

    ?>
   </div>


        <script>
            //do not change the function name
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
                var contact_pslogan = $('#<?=$this->feat_id;?>_pslogan').html();

                //label_name : mandatory
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    <?=$this->feat_id;?>_pslogan : contact_pslogan,
                    <?=$this->feat_id;?>_pname : contact_pname
                },function(data){
                    console.log(data);
                    if(data){
                        $(".hiddenform").hide();
                        //update Selected App dan Layout di Simulator
                        updateSelectedAppAndSimulator();


                    }
                });

            }
        </script>
        <style>
            #<?=$this->feat_id."_des";?>{
                white-space:pre-wrap !important;

            }
        </style>
<?

    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pslogan = isset($valuesNya[$this->feat_id.'_pslogan'])?$valuesNya[$this->feat_id.'_pslogan']:"description";

        ?>

            <div class="mdescription" id="<?=$this->feat_id;?>_des"><?=$contact_pslogan;?></div>
        <style>
            .mdescription{
                padding: 10px;
                font-weight: normal;
                margin: 10px;
                background-color: #FFFFFF;
            }

        </style>

        <?
    }
} 