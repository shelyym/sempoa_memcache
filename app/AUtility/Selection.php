<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Berkaitan dengan semua selectbox dan apa yang akan dilakukan saat onchange
 *
 * @author ElroyHardoyo
 */
class Selection {
    /*
     * selector month refresh ID
     */
    public static function monthSelectorInTARefreshID ($IDtoRefresh, $actualMon, $actualTa, $urlOnChange)
    {
        $t = time() . rand(0, 10000);
        $exp = explode("/", $actualTa);

        $arr[7] = "Jul " . $exp[0];
        $arr[8] = "Aug " . $exp[0];
        $arr[9] = "Sep " . $exp[0];
        $arr[10] = "Oct " . $exp[0];
        $arr[11] = "Nov " . $exp[0];
        $arr[12] = "Dec " . $exp[0];
        $arr[1] = "Jan " . $exp[1];
        $arr[2] = "Feb " . $exp[1];
        $arr[3] = "Mar " . $exp[1];
        $arr[4] = "Apr " . $exp[1];
        $arr[5] = "May " . $exp[1];
        $arr[6] = "Jun " . $exp[1];
        ?>
        <select id="selectmon_<?= $t; ?>" class="form-control">
            <? foreach ($arr as $n => $name) {
                if ($actualMon == $n) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $n; ?>" <?= $selected; ?>><?= $name; ?></option>
            <? } ?>
        </select>
        <script type="text/javascript">
            $("#selectmon_<?=$t;?>").change(function () {
                var slc = $("#selectmon_<?=$t;?>").val();

                var year = <?=$exp[0];?>;
                if (slc < 7)year = <?=$exp[1];?>;
                $('#<?=$IDtoRefresh;?>').load("<?=$urlOnChange;?>&mon=" + slc + "&year=" + year);
            });
        </script>
    <?

    }

    /*
     * selector for mon refresh whole page
     */
    public static function monthSelectorInTA ($actualMon, $actualTa, $urlOnChange)
    {
        $t = time();
        $exp = explode("/", $actualTa);

        $arr[7] = "Jul " . $exp[0];
        $arr[8] = "Aug " . $exp[0];
        $arr[9] = "Sep " . $exp[0];
        $arr[10] = "Oct " . $exp[0];
        $arr[11] = "Nov " . $exp[0];
        $arr[12] = "Dec " . $exp[0];
        $arr[1] = "Jan " . $exp[1];
        $arr[2] = "Feb " . $exp[1];
        $arr[3] = "Mar " . $exp[1];
        $arr[4] = "Apr " . $exp[1];
        $arr[5] = "May " . $exp[1];
        $arr[6] = "Jun " . $exp[1];
        ?>
        <select id="selectmon_<?= $t; ?>" class="form-control">
            <? foreach ($arr as $n => $name) {
                if ($actualMon == $n) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $n; ?>" <?= $selected; ?>><?= $name; ?></option>
            <? } ?>
        </select>
        <script type="text/javascript">
            $("#selectmon_<?=$t;?>").change(function () {
                var slc = $("#selectmon_<?=$t;?>").val();

                var year = <?=$exp[0];?>;
                if (slc < 7)year = <?=$exp[1];?>;
                openLw(window.selected_page, "<?=$urlOnChange;?>&mon=" + slc + "&year=" + year, "fade");
            });
        </script>
    <?

    }

    /*
     * Selector for kelas
     */
    public static function kelasSelector ($kelasActual, $urlOnChange)
    {
        $t = time();
        $kelas = new Kelas();
        $arr = $kelas->getWhere("kelas_aktiv=1 ORDER BY kelas_tingkatan ASC, kelas_name ASC", "kelas_id,kelas_name");
        //pr($arr);
        ?>
        <select id="selectkelas_<?= $t; ?>" class="form-control">
            <? foreach ($arr as $n => $kls) {
                if ($kelasActual->kelas_id == $kls->kelas_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $kls->kelas_id; ?>" <?= $selected; ?>><?= $kls->kelas_name; ?></option>
            <? } ?>
        </select>
        <script type="text/javascript">
            $("#selectkelas_<?=$t;?>").change(function () {
                var slc = $("#selectkelas_<?=$t;?>").val();
                openLw(window.selected_page, "<?=$urlOnChange;?>&klsid=" + slc, "fade");
            });
        </script>
    <?
    }

    /*
     * Selector for tingkatan
     */
    public static function levelSelector ($levelActual, $urlOnChange)
    {
        $t = time();

        ?>
        <select id="selectlevel_<?= $t; ?>" class="form-control">
            <? for ($x = 1; $x <= Schoolsetting::getTingkatanMax(); $x++) {
                if ($levelActual == $x) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $x; ?>" <?= $selected; ?>><?= $x; ?></option>
            <? } ?>
        </select>
        <script type="text/javascript">
            $("#selectlevel_<?=$t;?>").change(function () {
                var slc = $("#selectlevel_<?=$t;?>").val();
                openLw(window.selected_page, "<?=$urlOnChange;?>&klslevel=" + slc, "fade");
            });
        </script>
    <?
    }

    /*
     * Tahun ajaran selector
     */
    public static function tahunAjaranSelector ($taActual)
    {
        global $params;
        $t = time();
        $imp = implode("/", $params);
        ?>
        <select id="ta_select_<?= $t; ?>" class="form-control">
            <?
            $ta = $taActual;
            $taarr = explode("/", $ta);

            for ($x = 1; $x < 2; $x++) {
                $nextyear = date("Y", mktime(0, 0, 0, date("m"), date("d"), $taarr[1] + $x));
                $nextyear1 = date("Y", mktime(0, 0, 0, date("m"), date("d"), $taarr[1] + $x - 1));
                $prevyear = date("Y", mktime(0, 0, 0, date("m"), date("d"), $taarr[0] - $x));
                $prevyear1 = date("Y", mktime(0, 0, 0, date("m"), date("d"), $taarr[0] - $x + 1));
                $taprev[] = $prevyear . "/" . $prevyear1;
                $tanext[] = $nextyear1 . "/" . $nextyear;
            }

            for ($x = (count($taprev) - 1); $x >= 0; $x--) {
                $selected = "";
                if ($taActual == $taprev[$x]) {
                    $selected = "selected";
                }
                ?>
                <option value="<?= $taprev[$x]; ?>" <?= $selected; ?>><?= $taprev[$x]; ?></option>
            <?
            }
            ?>
            <option value="<?= $ta; ?>" selected="true"><?= $ta; ?></option>
            <?
            for ($x = 0; $x < count($tanext); $x++) {
                $selected = "";
                if ($taActual == $tanext[$x]) {
                    $selected = "selected";
                }
                ?>
                <option value="<?= $tanext[$x]; ?>" <?= $selected; ?>><?= $tanext[$x]; ?></option>
            <?
            }
            ?>
        </select>
        <script type="text/javascript">
            $("#ta_select_<?=$t;?>").change(function () {
                var slc = $("#ta_select_<?=$t;?>").val();
                document.location = '<?=_SPPATH;?><?=$imp;?>?ta=' + slc;
            });
        </script>
    <?
    }

    public static function languageSelector ($actLang)
    {
        $t = time();
        global $params;
        $imp = implode("/", $params);

        $arrAllowedLang = array ("en" => "EN", "id" => "ID");
        ?>
        <select id="lang_select_<?= $t; ?>" class="form-control">
            <? foreach ($arrAllowedLang as $id => $val) {
                if ($id == $actLang) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $id; ?>" <?= $selected; ?>><?= $val; ?></option>
            <?
            }
            ?>
        </select>
        <script type="text/javascript">
            $("#lang_select_<?=$t;?>").change(function () {
                var slc = $("#lang_select_<?=$t;?>").val();
                document.location = '<?=_SPPATH;?><?=$imp;?>?setlang=' + slc;
            });
        </script>
    <?
    }

    //$subjectActual ist ein Object
    public static function subjectSelector ($subjectActual, $urlOnChange)
    {
        $t = time();
        $matapelajaran = new Matapelajaran();
        $sujectValue = $matapelajaran->getWhere("mp_aktiv=1 ORDER BY mp_name ASC", "mp_id, mp_name, mp_singkatan");
        ?>
        <select id="selectSubject_<?= t; ?>" class="form-control">
            <?
            foreach ($sujectValue as $n => $mp) {
                if (($subjectActual->mp_id) == ($mp->mp_id)) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                ?>
                <option value="<?= $mp->mp_id; ?>"<?= $selected; ?>><?= $mp->mp_name; ?></option>
            <?
            }
            ?>
        </select>
        <script>
            $("#selectSubject_<?=t;?>").change(function () {
                var slc = $("#selectSubject_<?=t;?>").val();
                openLw(window.selected_page, "<?=$urlOnChange;?>&mp_id=" + slc, "fade");
            });
        </script>
    <?
    }

    //$subjectActual ist ein Object
    public static function daySelector ($subjectActual, $urlOnChange)
    {

    }
}
