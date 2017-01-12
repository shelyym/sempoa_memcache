<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/1/16
 * Time: 10:03 AM
 */

class FinanceBE extends WebService{

    var $access_comissioning = "master_admin";
    function comissioning(){

        $komisiModel = new KomisiModel();
        global $db;
        $q = "SELECT SUM(komisi_sisa) as total FROM {$komisiModel->table_name} WHERE komisi_status != 4";
        $arrRev = $db->query($q,1);

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");
        ?>
        <h1>Comissioning</h1>
        <h1>Total Due Commision IDR <?=idr($arrRev->total);?></h1>
        Month : <select id="mon">
            <? for($x=1;$x<13;$x++){ ?>
                <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
            <? } ?>
        </select>
        Year : <select id="year">
            <? for($x=2016;$x<2030;$x++){ ?>
                <option <?if($y==$x)echo "selected";?>  value="<?=$x;?>"><?=$x;?></option>
        <? } ?>
        </select>

        <button id="change" class="btn btn-default">Change Month</button>
        <script>
            $('#change').click(function(){

               openLw("Comissioning",'<?=_SPPATH;?>FinanceBE/comissioning?mon='+$('#mon').val()+'&y='+$('#year').val(),'fade');
            });
        </script>
        <?
//        echo "<br>".$_POST['mon']."<br>";



        $date = new DateTime();
        $date->setDate($y, $mon, 1);
        $ymd= $date->format('Y-m-d');


        $thismon = $mon;
        $prev_mon = date('n',strtotime($ymd." -3 months"));
        $prev_year = date('Y',strtotime($ymd." -3 months"));

        echo "<br>".$thismon." ".$y;
        echo "<br>".$prev_mon." $prev_year<br>";

        $syarat_paid = "(komisi_status = 0 AND komisi_paket_id != 1 AND month(komisi_app_date) = $thismon AND year(komisi_app_date) = $y)";
        $syarat_free = "(komisi_status = 0 AND komisi_paket_id = 1 AND month(komisi_app_date) = $thismon AND year(komisi_app_date) = $y AND komisi_ting_tong = 1)";
        $syarat_half_paid = "(komisi_status = 2 AND komisi_paket_id != 1 AND month(komisi_app_date) = $prev_mon AND year(komisi_app_date) = $prev_year)";
        $syarat_half_free = "(komisi_status = 2 AND komisi_paket_id = 1 AND komisi_ting_tong = 1 AND month(komisi_app_date) = $prev_mon AND year(komisi_app_date) = $prev_year)";


        //syarat
        $dateAwal = $ymd;
        $date2nd = date('Y-m-d',strtotime($ymd." -3 months"));
        $syarat_piu_paid = "(komisi_status = 0 AND komisi_paket_id != 1 AND komisi_app_date < '$ymd' AND komisi_app_date >= '$date2nd')";
        $syarat_piu_free = "(komisi_status = 0 AND komisi_paket_id = 1 AND komisi_ting_tong = 1 AND komisi_app_date < '$ymd' AND komisi_app_date >= '$date2nd')";
        $syarat_piu_half_paid = "(komisi_status = 0 AND komisi_paket_id != 1 AND komisi_app_date < '$date2nd')";
        $syarat_piu_half_free = "(komisi_status = 0 AND komisi_paket_id = 1 AND komisi_ting_tong = 1  AND komisi_app_date < '$date2nd')";


//        echo $syarat_paid."<br> OR ".$syarat_free."<br> OR ".$syarat_half;

//        $arrKom = $komisiModel->getWhere($syarat_paid." OR ".$syarat_free." OR ".$syarat_half_paid." ORDER BY komisi_app_date ASC");

//        echo "komisi_status = '0' AND komisi_paket_id != 1 AND (day(komisi_app_date)>24 AND month(komisi_app_date) = $prev) OR (day(komisi_app_date)<25 AND month(komisi_app_date) = $thismon)";
//        pr($arrKom);

        echo "batesan piutang ".$dateAwal." ".$date2nd;
        echo "<br>".$syarat_piu_paid;

        $arrKomFirstPaid = $komisiModel->getWhere($syarat_paid." ORDER BY komisi_app_date ASC");
        $arrKomFirstFree = $komisiModel->getWhere($syarat_free." ORDER BY komisi_app_date ASC");
        $arrKomSecondPaid = $komisiModel->getWhere($syarat_half_paid." ORDER BY komisi_app_date ASC");
        $arrKomSecondFree = $komisiModel->getWhere($syarat_half_free." ORDER BY komisi_app_date ASC");

        $arrPiuFirstPaid = $komisiModel->getWhere($syarat_piu_paid." ORDER BY komisi_app_date ASC");
        $arrPiuFirstFree = $komisiModel->getWhere($syarat_piu_free." ORDER BY komisi_app_date ASC");
        $arrPiuSecondPaid = $komisiModel->getWhere($syarat_piu_half_paid." ORDER BY komisi_app_date ASC");
        $arrPiuSecondFree = $komisiModel->getWhere($syarat_piu_half_free." ORDER BY komisi_app_date ASC");
        ?>
        <h3>Payment For <?=$thismon;?></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Komisi ID</th>
                    <th>Komisi Date</th>
                    <th>Komisi Paket</th>
                    <th>Komisi Status</th>
                    <th>Komisi Agent Ready</th>
                    <th>Komisi Value</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6">

                        <h1>First Paid</h1>
                    </td>
                </tr>

                <?
                $total = 0;
                $totalkaliini = 0;
                foreach($arrKomFirstPaid as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_pertama_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_pertama_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">
                        <?=$totalkaliini." ".$total;?>
                        <h1>First Free</h1>
                    </td>
                </tr>
                <?

                foreach($arrKomFirstFree as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_pertama_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_pertama_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Second Paid</h1>
                    </td>
                </tr>

                <?

                foreach($arrKomSecondPaid as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_kedua_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_kedua_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Second Free</h1>
                    </td>
                </tr>

                <?

                foreach($arrKomSecondFree as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_kedua_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_kedua_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Piutang Paid </h1>
                    </td>
                </tr>

                <?

                foreach($arrPiuFirstPaid as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_pertama_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_pertama_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Piutang Free </h1>
                    </td>
                </tr>

                <?

                foreach($arrPiuFirstFree as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_pertama_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_bagi_pertama_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Piu Second Paid</h1>
                    </td>
                </tr>

                <?

                foreach($arrPiuSecondPaid as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_kedua_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_value);?></td>
                    </tr>
                <?
                }
                ?>
                <tr>
                    <td colspan="6">

                        <h1>Piu Second Free</h1>
                    </td>
                </tr>

                <?

                foreach($arrPiuSecondFree as $kom){
                    ?>
                    <tr>
                        <td><?=$kom->komisi_id;?></td>
                        <td><?=$kom->komisi_app_date;?></td>
                        <td><?=$kom->komisi_paket_id;?></td>
                        <td><?=$kom->komisi_status;?></td>
                        <td><?
                            $acc = new Account();
                            $acc->getByID($kom->komisi_acc_id);
                            echo $acc->admin_id." ".$acc->admin_nama_depan;
                            if($acc->admin_isAgent){
                                echo " <b>agent ready</b>";
                                $total += $kom->komisi_bagi_kedua_value;
                                $totalkaliini += $kom->komisi_value;
                            }else{
                                echo " <i>not ready</i>";
                            }

                            ?></td>
                        <td><?=idr($kom->komisi_value);?></td>
                    </tr>
                <?
                }
                ?>
                </tbody>
            </table>
        </div>
        <h1>Total Kali ini nya : IDR <?=idr($total);?></h1>
        <h1>Total Semuanya : IDR <?=idr($totalkaliini);?></h1>
        Eh masih hrs ditambah yang payment kedua..oh iya trus totalnya hrs dipotong 500rb ...
        Apa tanggal bisa dijadikan 1-31 dan paymentnya mundur ke tgl 10 ?
        <button class="btn btn-primary">Create this month Commisions Request</button>
        <?


    }

    var $access_revenue = "master_admin";
    function revenue(){

        $vp = new VpTransaction();
        global $db;
        $q = "SELECT SUM(order_value) as total FROM {$vp->table_name} WHERE order_status = '1'  OR order_status = '2'";

        $arrRev = $db->query($q,1);
        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
//        pr($arrRev);
        ?>
        <h1>Total Revenue</h1>
        <h1>IDR <?=idr($arrRev->total);?></h1>

        Month : <select id="mon_m">
            <? for($x=1;$x<13;$x++){ ?>
                <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
            <? } ?>
        </select>


        <button id="change_m" class="btn btn-default">Change Month</button>
        <script>
            $('#change_m').click(function(){

                openLw("Revenue",'<?=_SPPATH;?>FinanceBE/revenue?mon='+$('#mon_m').val(),'fade');
            });
        </script>

        <?
        $q = "select SUM(order_value) as total from {$vp->table_name} where month(order_date) = ".$mon." AND (order_status = '1'  OR order_status = '2')";
        $arrRev = $db->query($q,1);
        ?>
        <hr>
        <h2>Revenue This Month</h2>
        <h2>IDR <?=idr($arrRev->total);?></h2>
        <?
        $arrs = $vp->getWhere("month(order_date) = ".$mon." AND (order_status = '1'  OR order_status = '2')");

//        pr($arrs);
        ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>order_id</th>
                        <th>order_app_id</th>
                        <th>order_acc_id</th>
                        <th>order_date</th>
                        <th>order_value</th>
                        <th>order_paket_id</th>
                        <th>order_status</th>
                        <th>order_message</th>
                        <th>order_status_from</th>
                    </tr>
                </thead>
                <tbody>
                <?
                foreach($arrs as $vp){
                ?>
                    <tr>
                        <td><?=$vp->order_id;?></td>
                        <td><?=$vp->order_app_id;?></td>
                        <td><?=$vp->order_acc_id;?></td>
                        <td><?=$vp->order_date;?></td>
                        <td><?=$vp->order_value;?></td>
                        <td><?=$vp->order_paket_id;?></td>
                        <td><?=$vp->order_status;?></td>
                        <td><?=$vp->order_message;?></td>
                        <td><?=$vp->order_status_from;?></td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <?
    }

} 