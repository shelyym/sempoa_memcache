<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 11:47 AM
 */

class PaketBE extends WebService{

    public function Paket ()
    {
        //create the model object
        $cal = new Paket();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }

    public function PaketSyarat ()
    {
        //create the model object
        $cal = new PaketSyarat();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }
    public function PaketMatrix ()
    {
        //create the model object
        $cal = new PaketMatrix();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;
        //run the crud utility
        Crud::run($cal, $webClass);
    }

    public function createPaketTable(){


        $paket = new Paket();
        $arrPaket = $paket->getWhere("paket_active = 1");

        $syarat = new PaketSyarat();
        $arrSyarat = $syarat->getWhere("syarat_active = 1");


        ?>
<style>
    .table-bordered2 {
        border: 1px solid #666666;
    }
    .table-bordered2>thead>tr>th, .table-bordered2>tbody>tr>th, .table-bordered2>tfoot>tr>th, .table-bordered2>thead>tr>td, .table-bordered2>tbody>tr>td, .table-bordered2>tfoot>tr>td {
        border: 1px solid #666666;
    }
</style>
        <h1>Paket Tabel</h1>
    <div class="table-responsive">
        <table class="table table-bordered2 table-striped">
            <thead>
            <tr>
                <th></th>
                <?
                foreach($arrPaket as $pak){
                    ?>
                    <th><?=$pak->paket_id;?>.<?=$pak->paket_name;?></th>
                <?
                }
                ?>
            </tr>
            </thead>
            <?
            foreach($arrSyarat as $sya){
            ?>

                <tr>
                    <td><?=$sya->syarat_id;?>.<?=$sya->syarat_name;?></td>
                    <?
                    foreach($arrPaket as $pak){

                        $mm = new PaketMatrix();
                        $mmid = $pak->paket_id."_".$sya->syarat_id;

                        $mm->getByID($mmid);
                        $val = $mm->ps_isi;
                        ?>
                        <td><?
                            if($sya->syarat_rumus == "bool"){
                                ?>
                                <select id="inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>">
                                    <option value="0">no</option>
                                    <option value="1" <? if($val=="1")echo "selected";?>><b>YES</b></option>
                                </select>
                                <script>
                                    $("#inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>").change(function(){
                                        var slc = $("#inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>").val();
                                        updatePSMatrix('<?=$sya->syarat_id;?>','<?=$pak->paket_id;?>',slc);
                                    });
                                </script>
                                <?
                            }else{
                                $exp = explode(",",$sya->syarat_rumus);
                                $jenis = $exp[0];
                                $check = $exp[1];

                                if($val == "")$val = 0;

                                if($jenis == "int" && $check == "="){
                                    ?>
                                    <input id="inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>" type="number" value="<?=$val;?>">
                                <script>
//                                    $("#inp_<?//=$sya->syarat_id;?>//_<?//=$pak->paket_id;?>//").keyup(function(){
//                                        var slc = $("#inp_<?//=$sya->syarat_id;?>//_<?//=$pak->paket_id;?>//").val();
//                                        updatePSMatrix('<?//=$sya->syarat_id;?>//','<?//=$pak->paket_id;?>//',slc);
//                                    });

//                                    $("#inp_<?//=$sya->syarat_id;?>//_<?//=$pak->paket_id;?>//").blur(function(){
//                                        var slc = $("#inp_<?//=$sya->syarat_id;?>//_<?//=$pak->paket_id;?>//").val();
//                                        updatePSMatrix('<?//=$sya->syarat_id;?>//','<?//=$pak->paket_id;?>//',slc);
//                                    });

                                    $("#inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>").change(function(){
                                        var slc = $("#inp_<?=$sya->syarat_id;?>_<?=$pak->paket_id;?>").val();
                                        updatePSMatrix('<?=$sya->syarat_id;?>','<?=$pak->paket_id;?>',slc);
                                    });
                                </script>
                                    <?
                                }
                            }
                            ?>


                        </td>
                        <?
                    }
                    ?>
                </tr>
                <? } ?>
        </table>
    </div>
        <script>
            function updatePSMatrix(syarat,paket,slc){

                console.log("in");
                $.post("<?=_SPPATH;?>PaketBE/updatePSMatrix",{
                    syarat : syarat,
                    paket : paket,
                    slc : slc
                },function(data){
                    console.log(data);
//                    alert(data);
                    if(data.succ){
                        asuccess("Success");
                    }else{
                        aerror("Failed");
                    }
                },'json');
            }
        </script>
        <?

    }

    function updatePSMatrix(){

//        pr($_POST);

        $syarat_id = addslashes($_POST['syarat']);
        $paket_id = addslashes($_POST['paket']);
        $slc = addslashes($_POST['slc']);

        $mm = new PaketMatrix();
        $mm->ps_id = $paket_id."_".$syarat_id;
        $mm->ps_isi = $slc;
        $mm->ps_paket_id = $paket_id;
        $mm->ps_syarat_id = $syarat_id;
        $succ = $mm->save(1);

        $json['succ'] = $succ;
        echo json_encode($json);
        die();
    }

    public function createPaketTableCustomer(){


        $paket = new Paket();
        $arrPaket = $paket->getWhere("paket_active = 1");

        $syarat = new PaketSyarat();
        $arrSyarat = $syarat->getWhere("syarat_active = 1");

        ?>
        <style>
            body{
                background-color: #24e0ba;
            }
            label {
                /* display: inline-block; */
                /* max-width: 100%; */
                margin-bottom: 0px;
                /* font-weight: 700; */
            }
        </style>
        <div class="pricing-container">
            <div class="pricing-switcher">
                <p class="fieldset">
                    <input type="radio" name="duration-1" value="monthly" id="monthly-1" checked>
                    <label for="monthly-1">Monthly</label>
                    <input type="radio" name="duration-1" value="yearly" id="yearly-1">
                    <label for="yearly-1">Yearly</label>
                    <span class="switch"></span>
                </p>
            </div>
            <ul class="pricing-list bounce-invert">
                <?
        foreach ($arrPaket as $num=> $pak) {
         ?>
                <li <? if($num==1)echo 'class="exclusive"';?>>
                    <ul class="pricing-wrapper">
                        <li data-type="monthly" class="is-visible">
                            <header class="pricing-header">
                                <h2><?=$pak->paket_name;?></h2>
                                <div class="price">
                                    <span class="currency">IDR</span>
                                    <span class="value"><?=idrK($pak->paket_price);?></span>
                                    <span class="duration">mo</span>
                                </div>
                            </header>
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    <? foreach($arrSyarat as $sya){
                                        $mm = new PaketMatrix();
                                        $mmid = $pak->paket_id . "_" . $sya->syarat_id;

                                        $mm->getByID($mmid);
                                        $val = $mm->ps_isi;

                if($sya->syarat_rumus == "bool"){
                    if($val=="1"){
                        ?>
                        <li><?=$sya->syarat_name;?></li>
                        <?
                    }else{
                        ?>
                        <li>-</li>
                    <?
                    }
                }else {
                    $exp = explode(",", $sya->syarat_rumus);
                    $jenis = $exp[0];
                    $check = $exp[1];

                    if ($val == "") $val = 0;

                    if ($jenis == "int" && $check == "=") {

//                        echo $val;
                        if($val>0){
                            ?>
                            <li><em><?=$val;?></em> <?=$sya->syarat_name;?></li>
                            <?
                        }
                    }
                }
                                        ?>

                                    <? } ?>
<!--                                    <li><em>1</em> Template Style</li>-->
<!--                                    <li><em>25</em> Products Loaded</li>-->
<!--                                    <li><em>1</em> Image per Product</li>-->
<!--                                    <li><em>Unlimited</em> Bandwidth</li>-->
<!--                                    <li><em>24/7</em> Support</li>-->
                                </ul>
                            </div>
                            <footer class="pricing-footer">
                                <a class="select" href="#">Sign Up</a>
                            </footer>
                        </li>
                        <li data-type="yearly" class="is-hidden">
                            <header class="pricing-header">
                                <h2>Basic</h2>
                                <div class="price">
                                    <span class="currency">IDR</span>
                                    <span class="value"><?=idrK($pak->paket_price*12);?></span>
                                    <span class="duration">yr</span>
                                </div>
                            </header>
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    <? foreach($arrSyarat as $sya){
                                        $mm = new PaketMatrix();
                                        $mmid = $pak->paket_id . "_" . $sya->syarat_id;

                                        $mm->getByID($mmid);
                                        $val = $mm->ps_isi;

                                        if($sya->syarat_rumus == "bool"){
                                            if($val=="1"){
                                                ?>
                                                <li><?=$sya->syarat_name;?></li>
                                            <?
                                            }else{
                                                ?>
                                                <li>-</li>
                                            <?
                                            }
                                        }else {
                                            $exp = explode(",", $sya->syarat_rumus);
                                            $jenis = $exp[0];
                                            $check = $exp[1];

                                            if ($val == "") $val = 0;

                                            if ($jenis == "int" && $check == "=") {

//                        echo $val;
                                                if($val>0){
                                                    ?>
                                                    <li><em><?=$val;?></em> <?=$sya->syarat_name;?></li>
                                                <?
                                                }
                                            }
                                        }
                                        ?>

                                    <? } ?>
                                </ul>
                            </div>
                            <footer class="pricing-footer">
                                <a class="select" href="#">Sign Up</a>
                            </footer>
                        </li>
                    </ul>
                </li>
            <? } ?>

            </ul>
        </div>

        <style>
            ul,li{
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
            }
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure,
            footer, header, hgroup, menu, nav, section, main {
                display: block;
            }
            body {
                line-height: 1;
            }
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            *,
            *::after,
            *::before {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            html {
                font-size: 62.5%;
            }

            html * {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            body {
                font-size: 1.6rem;
                font-family: "Open Sans", sans-serif;
                color: #2d3d4f;
                background-color: #1bbc9d;
            }

            a {
                text-decoration: none;
            }

        </style>
    <?

    }
} 