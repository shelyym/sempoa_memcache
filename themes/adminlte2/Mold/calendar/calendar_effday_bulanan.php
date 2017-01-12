<?
$cal = new Calendar();
$arrCl = $cal->arrCl;
//pr($arr);
?>
    <style type="text/css">

        .legend-icon-small {
            width: 15px;
            height: 15px;
            border-radius: 15px;
            float: left;
            margin-right: 5px;
        }

        .tablebulanan th {
            background-color: #dedede;
        }

        .tablebulanan td.bulananMonthName {
            font-size: 23px;
        }

        .kejadianBulanan {
            padding: 10px;
            background-color: #efefef;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
    <h1 style="margin-top: 20px;"><?= Lang::t('Monthly View'); ?></h1>
    <div class="table-responsive" style="margin-top: 10px;">
        <table class="table table-bordered table-hover tablebulanan">
            <thead>
            <tr>
                <th>
                    <?= Lang::t('Month'); ?>
                </th>
                <th>
                    <?= Lang::t('Event'); ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?
            $active = null;
            $totalkejadian = 0;
            foreach ($bulanan as $n => $bln) {
                $dateObj = DateTime::createFromFormat('!m', $n);
                $monthName = $dateObj->format('F');
                ?>
                <tr>
                    <td class="bulananMonthName">
                        <?= $monthName; ?>
                    </td>
                    <td>
                        <?
                        $kejBulanan = array ();

                        foreach ($bln as $hari) {

                            if (isset($hari['activities'])) {
                                foreach ($hari['activities'] as $num => $act) {
                                    //supaya bisa skip
                                    if (in_array($act->cal_id, $kejBulanan)) {
                                        continue;
                                    }

                                    $kejBulanan[] = $act->cal_id;


                                    $datem = date("j M", strtotime($act->cal_mulai));
                                    $daten = date("j M", strtotime($act->cal_akhir));
                                    if ($datem == $daten) {
                                        $fdate = $datem;
                                    } else {
                                        $fdate = $datem . "-" . $daten;
                                    }

                                    ?>
                                    <div id="kejbulanan_<?= $totalkejadian; ?>" class="kejadianBulanan">
                                        <div class="legend-icon-small"
                                             style="background:<?= $arrCl[$act->cal_type]; ?>;"></div>
                                        <?
                                        echo "<small>" . $fdate . "</small><br>";

                                        echo "<b>" . $act->cal_name . "</b>";
                                        ?>
                                    </div>
                                <?
                                $actnow = "holiday";
                                //kalau bukan awal bs di edit
                                if ($act->cal_type == "awal") {
                                    foreach ($awal as $acttype => $id) {
                                        if ($act->cal_id == $id) {
                                            $actnow = $acttype;
                                            break;
                                        }
                                    }
                                }
                                if (!$muridview){
                                ?>
                                    <script type="text/javascript">
                                        $("#kejbulanan_<?=$totalkejadian;?>").click(function (event) {
                                            openLw('Calendar_View_bulanan_<?=$totalkejadian;?>', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&load=1&id=<?=$act->cal_id;?>&act=<?=$actnow;?>', 'fade');
                                        });
                                    </script>
                                <?
                                }
                                    $totalkejadian++;
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>

<?php
//pr($bulanan);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

