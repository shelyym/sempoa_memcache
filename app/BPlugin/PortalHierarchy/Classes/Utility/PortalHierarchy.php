<?php

//dependencies AccountLogin

/**
 * Description of PortalHierarchy
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PortalHierarchy {
    //put your code here
    //portal hierarchy Logik disini

    /*
     * get Hierarchy using sessions
     */
    public static function getMyLevel ()
    {
        if (isset($_SESSION['account']->RoleLevel)) {
            return $_SESSION['account']->RoleLevel;
        }

        return 0;
    }

    public static function getMyLevelName ()
    {
        if (isset($_SESSION['account']->RoleLevelObj)) {
            return $_SESSION['account']->RoleLevelObj->level_name;
        }

        return 0;
    }

    public static function getMyOrganization ()
    {
        if (isset($_SESSION['account']->RoleOrganization)) {
            return $_SESSION['account']->RoleOrganization;
        }

        return 0;
    }

    public static function getMyOrganizationName ()
    {
        if (isset($_SESSION['account']->RoleOrganizationObj)) {
            return $_SESSION['account']->RoleOrganizationObj->organization_name;
        }

        return 0;
    }

    public function getSelectedHierarchy ()
    {
        if (isset($_SESSION['account']->RoleLevel)) {
            $rl = new RoleLevel();
            $rl->getByID($_SESSION['account']->RoleLevel);
            $_SESSION['account']->RoleLevelObj = $rl;
        }
        if (isset($_SESSION['account']->RoleOrganization)) {
            $rl = new RoleOrganization();
            $rl->getByID($_SESSION['account']->RoleOrganization);
            $_SESSION['account']->RoleOrganizationObj = $rl;
        }
    }

    /*
     * halaman department isinya persis seperti class di leap
     */
    public function departmentPage(){

        //$org = RoleOrganization::getMy();

        //if(!isset($org))
        //    die('no organization');

        $targetID = (isset($_GET['kelasid'])?addslashes($_GET['kelasid']):die("No Target ID"));
        $targetName = (isset($_GET['type'])?addslashes($_GET['type']):die("No Target Name"));

        $r = new RoleOrganization();
        $r->getByID($targetID);

        ?>
<div class="col-md-7 col-md-offset-1">
<h1><?=$r->organization_name; ?></h1>
</div>
<div class="clearfix"></div>
        <style>
    .widget {
        background-color: #cee2ec;
        border-radius: 5px;
        padding: 10px;
        color: #074d72;
        margin-bottom: 10px;
    }

    .widgethead h3 {
        border-bottom: 0px solid #074d72;
        padding: 0;
        margin: 0;
        font-size: 23px;
    }

    .widgethead {

    }

    .widget hr {
        border-bottom: 1px solid #074d72;
        padding: 0;
        margin: 0;
        margin-top: 5px;
    }

    .widgetBig {
        background-color: white;
        padding: 10px;
        clear: both;
        margin-bottom: 10px;
    }
</style>
<div class="row">
    <div class="col-md-7 col-md-offset-1">
        <div id="all_class_wall" class="widgetBig" style="padding-right: 20px; ">
                <?
                $wall = new WallPortalWeb();
                //$wall->limit = 5;
                $wall->printDepartmentWall();
                ?>
            </div>
    </div>
    <div class="col-md-3 visible-md-block visible-lg-block">
            <div id="myClassmate" class="widgetBig">
                <?
            //    $mw = new Muridweb();
             //   $mw->myClassmate(4);
                $this->myCollagues();
                ?>
            </div>
         <div id="mySchoolCalendarWidget" >
            <?
           // $wid = new Widget();
          //  $wid->mySchoolCalendarWidget();
            ?>
        </div>
    </div>

</div> <?
    }
    public function myCollagues(){
        $targetID = (isset($_GET['kelasid'])?addslashes($_GET['kelasid']):die("No Target ID"));

        $acc = new AccountMeta();
        $arrM = $acc->getWhere("meta_key = 'RoleOrganization' AND meta_value = '$targetID'");
        $arrAcc = array();
        foreach($arrM as $mt){
            $ac = new Account();
            $ac->getByID($mt->account_id);
            $arrAcc[$mt->account_id]['acc'] = $ac;
            $arrAcc[$mt->account_id]['meta'] = $mt;
        }
        ?>
<h3 style="background-color: #dedede; padding: 5px; font-size: 18px;"><?=Lang::t('My Colleagues');?></h3>
        <?
        //pr($arrAcc);
        $nrRow = 4;
        foreach($arrAcc as $a){
            $murid = $a['acc'];
            ?>
<style type="text/css">
    .fotoresponsive {
    // padding : 10 px;
    // background-color : white;
    height: 91px;
    overflow: hidden;
    }
	.foto50{
		height: 50px;
		overflow: hidden;
	}
</style>
<div  style="cursor:pointer; float: left; width: 70px; height:120px; overflow:hidden; padding: 10px;"
     onclick="openProfile('<?= $murid->admin_id; ?>');">

    <? Account::makeFotoIterator($murid->admin_foto, 50); ?>
    <div style="text-align: center; margin-bottom: 15px; margin-top: 5px; font-size: 11px;">
        <?= getNamaPendek($murid->getName()); ?>
    </div>
</div>
<?php

        }
    }
}
