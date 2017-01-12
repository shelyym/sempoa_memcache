<?
$cal = new Calendar();
$arrCl = $cal->arrCl;
//pr($arr);
//pr($awal);
//echo $awal['akhir'];
?>
    <style type="text/css">
        table.EffDay {
            border-collapse: collapse;
            text-align: center;
            border: 1px solid #bbbbbb;
        }

        table.EffDay td, table.EffDay th {
            text-align: center;
        }

        table.EffDay thead, table.EffDay .headsamping {
            background-color: #dedede;
            font-weight: normal;
        }

        table.EffDay .highlight {
            background-color: #efefef;
        }

        table.EffDay td.dailyDay {
            width: 30px;
        }

        table.EffDay tbody tr:hover {
            background-color: #efefef;
        }

        table.EffDay tbody td:hover {
            background-color: #f7edad;
        }

        .day_eff_menu {
            clear: both;
            margin-bottom: 20px;
        }

        .day_eff_menu a {
            text-decoration: none;
            background-color: #dedede;
            border-radius: 5px;
            padding: 5px;
            margin: 5px;
        }

        .weekend {
            background-color: <?=$arrCl['weekend'];?>;
        }

        .dot_holiday {
            background-color: <?=$arrCl['holiday'];?>;
            opacity: 0.8;
        }

        .dot_awal {
            background-color: <?=$arrCl['awal'];?>;
        }

        .dot_exam {
            background-color: <?=$arrCl['exam'];?>;
        }

        .dot_event {
            background-color: <?=$arrCl['event'];?>;
        }

        .dot_dues {
            background-color: <?=$arrCl['dues'];?>;
        }

        .dot_duesmurid {
            background-color: <?=$arrCl['duesmurid'];?>;
        }

        .eventdot {
            text-align: center;
            line-height: 20px;
        / / position : absolute;
            height: 20px;
            width: 100%;
            opacity: 0.7;
            overflow: hidden;
            cursor: pointer;
            font-size: 10px;
        / / margin-top : - 5 px;
        / / margin-left : - 1 px;
        }

        .nav.nav-pills > li > a:hover {
            background-color: #cccccc;
            color: #fff;
            border-radius: 10px;
        }
    </style>
    <h1><?= Lang::t("lang_day_eff"); ?>
        <small><?= TahunAjaran::ta(); ?></small>
    </h1>
    <div class="hidden-print">
        <div class="btn-group">
            <button id="set_mulai_ajaran_baru" type="button"
                    class="btn btn-default"><?= Lang::t('lang_start_1st_sem'); ?></button>
            <button id="set_mulai_ajaran_baru2" type="button"
                    class="btn btn-default"><?= Lang::t('lang_start_2nd_sem'); ?></button>
            <button id="set_mulai_ajaran_baru3" type="button"
                    class="btn btn-default"><?= Lang::t('lang_end_sem'); ?></button>
            <button id="set_Holiday" type="button" class="btn btn-default"><?= Lang::t('lang_holiday'); ?></button>
        </div>

        <script>
            <?
            //siapkan awal
            $firstText = "";
            if($awal['first']!='0'){
                $firstText = "&load=1&id=".$awal['first'];
            }
            ?>
            $('#set_mulai_ajaran_baru').click(function () {
                openLw('Calendar_View_1stSem', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&act=first<?=$firstText;?>', 'fade');
            });
            <?
            //siapkan awal
            $firstText = "";
            if($awal['second']!='0'){
                $firstText = "&load=1&id=".$awal['second'];
            }
            ?>
            $('#set_mulai_ajaran_baru2').click(function () {
                openLw('Calendar_View_2ndSem', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&act=second<?=$firstText;?>', 'fade');
            });
            <?
            //siapkan awal
            $akhirText = "";
            //echo 'alert("'.$awal['akhir'].'");';
            if($awal['akhir']!='0'){
                $akhirText = "&load=1&id=".$awal['akhir'];
            }
            ?>
            $('#set_mulai_ajaran_baru3').click(function () {
                openLw('Calendar_View_akhirSem', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&act=akhir<?=$akhirText;?>', 'fade');
            });

            $('#set_Holiday').click(function () {
                openLw('Calendar_View_Holiday', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&act=holiday', 'fade');
            });
        </script>

        <style type="text/css">
            .legend-entry {
                float: left;
                padding: 5px;
                line-height: 30px;
                width: 10%;
            }

            .legend-icon {
                width: 20px;
                height: 20px;
                border-radius: 20px;
            }

            .legend-symbol {
            }

            .legendicontable {
                text-align: left;
                margin-bottom: 10px;
                margin-top: 10px;
            }
        </style>
        <div class="row">
            <? foreach ($arrCl as $jenis => $color) { ?>
                <div class="col-md-1 col-xs-3" onclick="showInCalendar('<?= $jenis; ?>');">
                    <table width="100%" class="legendicontable">
                        <tr>
                            <td>
                                <div id="<?= $jenis; ?>_col" class="legend-icon"
                                     style="background:<?= $color; ?>;"></div>
                            </td>
                            <td>
                                <div class="legend-text"><?= Lang::t($jenis); ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
            <? } ?>
        </div>
    </div>

    <script type="text/javascript">
        var arrSemua = []; //arr buat semua element
        var arr_holiday = [];
        var arr_event = [];
        var arr_dues = [];
        var arr_exam = [];
        var arr_duesmurid = [];
        var arr_awal = [];
    </script>

    <div class="table-responsive visible-md visible-lg visible-print-block">
        <table class="EffDay" width="100%" border="1">
            <thead>
            <tr>
                <th rowspan="2">
                    <?= Lang::t('S'); ?>
                </th>
                <th rowspan="2">
                    <?= Lang::t('Month'); ?>
                </th>
                <th colspan="31">
                    <?= Lang::t('Date'); ?>
                </th>
            </tr>
            <tr>
                <? for ($x = 1; $x < 32; $x++) { ?>
                    <td id="day_<?= $x; ?>"><?= $x; ?></td>
                <? } ?>
            </tr>
            </thead>
            <tbody>
            <?
            //total hari counter
            $cnt = 0;
            $active = 0;
            $totalkejadian = 0;
            for ($x = 7;
            $x < 19;
            $x++){
            if ($x > 12) {
                $n = $x % 12;
            } else {
                $n = $x;
            }
            $monname = date("F", mktime(0, 0, 0, $n, 1, 2011));
            ?>
            <tr>
                <? if ($n == 7) { ?>
                    <td rowspan="6" class="headsamping">
                        <?= Lang::t('1st'); ?>
                    </td>
                <? } ?>
                <? if ($n == 1) { ?>
                    <td rowspan="6" class="headsamping">
                        <?= Lang::t('2nd'); ?>
                    </td>
                <? } ?>
                <td class="headsamping" id="mon_<?= $n; ?>"><?= $monname; ?></td>
                <?
                $classcounter = 0;
                foreach ($bulanan[$n] as $num => $kejadianDiHari) {
                    $classcounter++;
                    // implode to class
                    $classname = implode(" ", $kejadianDiHari['type']);
                    if ($kejadianDiHari['eff']) {
                        $cnt++;
                    }
                    if (in_array("2ndday", $kejadianDiHari['type'])) {
                        $cnt = 1;
                    }
                    ?>
                    <td id="td_<?= $num; ?><?= $x; ?>" class="dailyDay <?= $classname; ?>"
                        onmouseover="AddHighlight('<?= $n; ?>','<?= $classcounter; ?>');"
                        onmouseout="removeHighlight('<?= $n; ?>','<?= $classcounter; ?>');"
                        style="padding:0;margin:0; vertical-align: top;">
                        <?

                        $marginleft = -1;
                        $margintop = -5;
                        $numm = 0;
                        if (isset($kejadianDiHari['activities'])) {
                            foreach ($kejadianDiHari['activities'] as $firstdayof) {
                                //full block td utk kedua tipe ini
                            if ($firstdayof->cal_type == "holiday" || $firstdayof->cal_type == "awal"){
                                $mtop = -5;
                                if ($firstdayof->cal_type == "holiday") {
                                    $mtop = -13;
                                }
                                $mtop = 0;
                                ?>
                                <div id="kej_<?= $totalkejadian; ?>" title="<?= $firstdayof->cal_name; ?>"
                                     style="margin-top:<?= $mtop; ?>px; margin-left:0px;width:100%px; height: 20px; opacity: 0.8; background-color: <?= $arrCl[$firstdayof->cal_type]; ?>;">
                                </div>
                            <?
                            }else{
                                // untuk yang inbi dot kecil2
                                if ($numm % 3 == 2) {
                                    $margintop += 10;
                                }
                                ?>
                                <div id="kej_<?= $totalkejadian; ?>" title="<?= $firstdayof->cal_name; ?>"
                                     class="eventdot dot_<?= $firstdayof->cal_type; ?>">
                                </div>

                            <?
                            $numm++;

                            }
                            $marginleft = $marginleft + 10;

                            ?>
                                <script type="text/javascript">
                                    arrSemua.push("kej_<?=$totalkejadian;?>");
                                    arr_<?=$firstdayof->cal_type;?>.push("kej_<?=$totalkejadian;?>");
                                </script>
                            <?
                            $actnow = "holiday";
                            //kalau bukan awal bs di edit
                            if ($firstdayof->cal_type == "awal") {
                                foreach ($awal as $acttype => $id) {
                                    if ($firstdayof->cal_id == $id) {
                                        $actnow = $acttype;
                                        break;
                                    }
                                }
                            }
                            ?>
                                <script type="text/javascript">
                                    $("#kej_<?=$totalkejadian;?>").click(function (event) {
                                        openLw('Calendar_View_<?=$totalkejadian;?>', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&load=1&id=<?=$firstdayof->cal_id;?>&act=<?=$actnow;?>', 'fade');
                                        event.stopPropagation();
                                    });
                                </script>

                                <?
                                $totalkejadian++;
                            }
                        }
                        //cek apakah harus tulis eff day
                        if ($cnt != $active) {
                            echo $cnt;
                            $active = $cnt;
                        }
                        ?>
                    </td>

                    <script>
                        $("#td_<?=$num;?><?=$x;?>").click(function () {
                            openLw('Calendar_View_<?=$num;?><?=$x;?>', '<?=_SPPATH;?>Schoolsetup/calendar?cmd=edit&act=holiday&tglmulai=<?=$num;?>', 'fade');
                        });
                    </script>

                <? } ?>
                <? } ?>
            </tr>
            </tbody>

        </table>
    </div>
    <script type="text/javascript">
        function AddHighlight(mon, day) {
            $('#mon_' + mon).addClass('highlight');
            $('#day_' + day).addClass('highlight');
        }
        function removeHighlight(mon, day) {
            $('#mon_' + mon).removeClass('highlight');
            $('#day_' + day).removeClass('highlight');
        }

        function showInCalendar(id) {
            /* for(var key=0;key<arrSemua.length;key++){
             $('#'+arrSemua[key]).hide();
             //console.log(key+" "+arrSemua[key]);
             }*/
            if (id == "holiday") {
                for (var key = 0; key < arr_holiday.length; key++) {
                    $('#' + arr_holiday[key]).fadeToggle();
                }
            }
            if (id == "awal") {
                for (var key = 0; key < arr_awal.length; key++) {
                    $('#' + arr_awal[key]).fadeToggle();
                }
            }
            if (id == "dues") {
                for (var key = 0; key < arr_dues.length; key++) {
                    $('#' + arr_dues[key]).fadeToggle();
                }
            }
            if (id == "event") {
                for (var key = 0; key < arr_event.length; key++) {
                    $('#' + arr_event[key]).fadeToggle();
                }
            }
            if (id == "exam") {
                for (var key = 0; key < arr_exam.length; key++) {
                    $('#' + arr_exam[key]).fadeToggle();
                }
            }
            if (id == "duesmurid") {
                for (var key = 0; key < arr_duesmurid.length; key++) {
                    $('#' + arr_duesmurid[key]).fadeToggle();
                }
            }
            // alert($("#"+id+"_col").css("opacity"));
            if ($("#" + id + "_col").css("opacity") < 1)
                $("#" + id + "_col").fadeTo("slow", 1);
            else
                $("#" + id + "_col").fadeTo("slow", 0.2);
        }
        //console.log(arrSemua);
        //console.log(arr_holiday);
    </script><?php //pr($bulanan);


