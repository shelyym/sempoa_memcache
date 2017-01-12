<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/28/16
 * Time: 12:24 PM
 */

class SearchMenuRoleAR extends WebService{

    function search(){
        $q = strtolower(addslashes($_GET['q']));
        $qasli = addslashes($_GET['q']);



        ?>

        <div class="content-wrapper2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <h1>Search Results for "<?=$qasli;?>"</h1>
            </h1>
            <!--        <ol class="breadcrumb">-->
            <!--            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
            <!--            <li><a href="#">Tables</a></li>-->
            <!--            <li class="active">Data tables</li>-->
            <!--        </ol>-->
        </section>
        <style>
            .murid-item-search{
                background-color: #FFFFFF;
                padding: 10px;
                margin-bottom: 10px;
            }
            .murid-item-search div{

                font-size: 17px;
            }
            .murid-item-search small{
                font-size: 15px;
            }
            h3{
                font-size: 18px;
                color: #999999;
            }
        </style>
        <!-- Main content -->
        <section class="content" id="searchcontent">
            <?
            $myOrgType = AccessRight::getMyOrgType();
            $tc_id = AccessRight::getMyOrgID();
            if ($myOrgType == KEY::$TC) {
                //search murid juga

                ?>
                <div class="col-md-6" style="padding-left: 0px;">
                    <?
//                    echo $tc_id;
                    $mm = new MuridModel();
//                    echo "nama_siswa LIKE '%$q%' OR kode_siswa LIKE '%$q%' ORDER BY nama_siswa ASC,kode_siswa ASC";
                    $arr = $mm->getWhere("(nama_siswa LIKE '%$q%' OR kode_siswa LIKE '%$q%') AND murid_tc_id = '$tc_id' ORDER BY nama_siswa ASC,kode_siswa ASC");


                    if(count($arr)<1){
                        echo "<h3>Cannot find any matching student</h3>";
                    }else {
//                    pr($arr);
                        echo "<h3>List of Students</h3>";
                        foreach ($arr as $murid) {
                            ?>
                            <div class="murid-item-search" style="cursor: pointer;" onclick="openLw('Profile_Murid','<?=_SPPATH;?>MuridWebHelper/profile?id_murid=<?=$murid->id_murid;?>','fade');">
                                <div><?= $murid->nama_siswa; ?></div>
                                <small><?= $murid->kode_siswa; ?></small>

                            </div>
                        <?
                        }
                    }
                    ?>
                </div>
                <?
            }

        if ($myOrgType == KEY::$TC) {?><div class="col-md-6">

                <?}else{?><div class="col-md-12"> <?}
            self::dosearchMenu();
            ?>
        </div>
                <div class="clearfix"></div>
            </section>
        </div>
        <script>



            $(document).ready(function () {
                highlight(document.getElementById('searchcontent'),'<?=$qasli;?>','highlight');
                highlight(document.getElementById('searchcontent'),'<?=$q;?>','highlight');
//                $('.menuicon p').highlight('<?//=$qasli;?>//','highlight');
//                $('.menuicon p').highlight('<?//=$q;?>//','highlight');

            });


        </script>


       <?
    }

    public static function dosearchMenu(){

        $q = strtolower(addslashes($_GET['q']));
        $qasli = addslashes($_GET['q']);

$arr = AccessRight::getRightShowList();

//            echo $q;


$ada = array();
$sudah = array();
foreach($arr as $ar_name=>$ar){
    if (strpos(strtolower($ar->ar_description), $q) !== false) {
        $ada[] = $ar;
        $sudah[] = $ar->ar_name;
    }//
    if(!in_array($ar->ar_name,$sudah))
        if (strpos(strtolower($ar->ar_display_name), $q) !== false) {
            $ada[] = $ar;
        }
}

if(count($ada)>0){
    ?>
    <h3>List Of Features</h3>
    <?
    foreach($ada as $num=>$ar){
        $key = $ar->ar_name;
        $re = $ar->ar_cname."/".$ar->ar_name;
        ?>
        <div class="menuicon" style="background: white; padding: 10px; margin: 10px; margin-left: 0px;">
            <h3 style="margin: 0; padding: 0; margin-bottom: 10px;">
                <a href="javascript:openLw('<?= $key; ?>','<?= _SPPATH . $re; ?>','fade');activkanMenuKiri('<?= $key; ?>');"><?= Lang::t($ar->ar_display_name); ?></a>
            </h3>

            <p>
                <?= $ar->ar_description; ?>
            </p>
        </div>
    <?
    }
}else{
    ?>
    <h3>
        <?=Lang::t('Cannot Find Any Matching Features');?>
    </h3>
<?
}
//            pr($ada);
//            pr($arr);

    }
} 