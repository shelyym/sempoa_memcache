<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SempoaExport
 *
 * @author efindiongso
 */
class SempoaExport
{

    //put your code here
    public function header_rekap_kupon_tc($bln)
    {
        $zeile = 2;
        $header = array();
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "namatc";
        $xsl->name = "Nama TC.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "bulan";
            $xsl->name = Generic::getMonthName($bln);
            $xsl->anzahlcolumn = 2;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            $xsl->textAllign = "center";
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "";
            $xsl->name = "";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 1;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "";
            $xsl->name = "";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "kt";
            $xsl->name = "Kupon Terjual";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "A";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bulan";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 2;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                $xsl->textAllign = "center";
                array_push($header, $xsl);
            }
            $col = "C";
            foreach ($arrAllmonth as $key => $val) {

                $xsl = new GeneralExcel();
                $xsl->id = "kt";
                $xsl->name = "Kupon Terjual";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                array_push($header, $xsl);
                $col++;
                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "A";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
            }
        }


        return $header;
    }

    public function content_rekap_kupon_tc($ibo_id, $bln, $thn)
    {
//        unset($content);
        $content = array();
        $i = 2;
        $arrMyTC = Generic::getAllMyTC($ibo_id);
        $arrAllmonth = Generic::getAllMonths();
        $totalTerjual = 0;
        $totalAktiv = 0;
        $arrtotalTerjual = array();
        $arrtotalAktiv = array();
        foreach ($arrAllmonth as $key => $val) {
            $arrtotalTerjual[$val] = 0;
            $arrtotalAktiv[$val] = 0;
        }
        foreach ($arrMyTC as $keyTC => $tc) {
            if ($bln != KEY::$KEY_MONTH_ALL) {

                $birekap = new RekapSiswaIBOModel();
                $birekap->getWhereOne("bi_rekap_tc_id=$keyTC AND bi_rekap_bln=$bln AND bi_rekap_tahun=$thn");

                $totalTerjual += $birekap->bi_rekap_kupon;
                $totalAktiv += $birekap->bi_rekap_aktiv;


                $xsl = new GeneralExcel();
                $xsl->id = "no";
                $xsl->name = $i - 1;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "namatc";
                $xsl->name = $tc;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "kpn";
                $xsl->name = $birekap->bi_rekap_kupon;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "A";
                $xsl->name = $birekap->bi_rekap_aktiv;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $i++;
            } else {


                $xsl = new GeneralExcel();
                $xsl->id = "no";
                $xsl->name = $i - 1;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "namatc";
                $xsl->name = $tc;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                foreach ($arrAllmonth as $key => $val) {

                    $birekap = new RekapSiswaIBOModel();
                    $birekap->getWhereOne("bi_rekap_tc_id=$keyTC AND bi_rekap_bln=$val AND bi_rekap_tahun=$thn");

                    if ($birekap->bi_rekap_kupon == "") {
                        $kupon = 0;
                    } else {
                        $kupon = $birekap->bi_rekap_kupon;
                    }

                    if ($birekap->bi_rekap_aktiv == "") {
                        $aktiv = 0;
                    } else {
                        $aktiv = $birekap->bi_rekap_aktiv;
                    }

                    $arrtotalTerjual[$val] += $birekap->bi_rekap_kupon;
                    $arrtotalAktiv[$val] += $birekap->bi_rekap_aktiv;
                    $xsl = new GeneralExcel();
                    $xsl->id = "kpn";
                    $xsl->name = $kupon;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                    $xsl = new GeneralExcel();
                    $xsl->id = "A";
                    $xsl->name = $aktiv;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
                $i++;
            }
        }

        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "totalTerjual";
            $xsl->name = $totalTerjual;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 4;
            $xsl->mulaiColumn = "C";
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "totalAktiv";
            $xsl->name = $totalAktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 5;
//        $xsl->mulaiColumn = "A";
            array_push($content, $xsl);
        } else {
            $awal = 4;
            $mulaiColumn = "C";
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "totalTerjual";
                $xsl->name = $arrtotalTerjual[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->mulaiColumn = $mulaiColumn;
                $mulaiColumn++;
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "totalAktiv";
                $xsl->name = $arrtotalAktiv[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->mulaiColumn = $mulaiColumn;
                array_push($content, $xsl);
                $mulaiColumn++;
            }
        }


        return $content;
    }

    public function header_rekap_siswa_ibo($bln)
    {
        $zeile = 2;
        $header = array();
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "kodetc";
        $xsl->name = "Kode TC.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namatc";
        $xsl->name = "Nama TC.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namaDr";
        $xsl->name = "Nama Director";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);


        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "bulan";
            $xsl->name = Generic::getMonthName($bln);
            $xsl->anzahlcolumn = 7;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            $xsl->textAllign = "center";
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "";
            $xsl->name = "BL";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->mulaiColumn = "E";
            $xsl->awal = 2;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "";
            $xsl->name = "B";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "kt";
            $xsl->name = "K";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "C";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "L";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "A";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "KPN";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bulan";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 7;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                $xsl->textAllign = "center";
                array_push($header, $xsl);
            }
            $col = "E";
            foreach ($arrAllmonth as $key => $val) {

                $xsl = new GeneralExcel();
                $xsl->id = "";
                $xsl->name = "BL";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->mulaiColumn = "E";
                $xsl->awal = 2;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "";
                $xsl->name = "B";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "kt";
                $xsl->name = "K";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "C";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "L";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "A";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "KPN";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                $xsl->mulaiColumn = $col;
                $col++;
                array_push($header, $xsl);
            }
        }


        return $header;
    }

    public function content_rekap_siswa_ibo($ibo_id, $bln, $thn)
    {
        $content = array();
        $i = 2;
        $arrMyTC = Generic::getAllMyTC($ibo_id);
        $arrBulan = Generic::getAllMonths();

        $arrTotal_bl = array();
        $arrTotal_baru = array();
        $arrTotal_keluar = array();
        $arrTotal_cuti = array();
        $arrTotal_lulus = array();
        $arrTotal_aktiv = array();
        $arrTotal_kupon = array();

        foreach ($arrMyTC as $id_tc => $tc) {
            $orgTC = new SempoaOrg();
            $orgTC->getByID($id_tc);

            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i - 1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "kodetc";
            $xsl->name = $orgTC->org_kode;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "namatc";
            $xsl->name = $orgTC->nama;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "namaDr";
            $xsl->name = $orgTC->nama_pemilik;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);


            if ($bln != KEY::$KEY_MONTH_ALL) {
                // Ermiteln data2
                $org_tc = new RekapSiswaIBOModel();
                $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);

                // Einfuellen die Werten
                $help = '0';
                $help = $arrDaten[0]->bi_rekap_bl;
                $xsl = new GeneralExcel();
                $xsl->id = "BL";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_baru;
                $xsl = new GeneralExcel();
                $xsl->id = "Baru";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_keluar;
                $xsl = new GeneralExcel();
                $xsl->id = "Keluar";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_cuti;
                $xsl = new GeneralExcel();
                $xsl->id = "Cuti";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);


                $help = 0;
                $help = $arrDaten[0]->bi_rekap_lulus;
                $xsl = new GeneralExcel();
                $xsl->id = "Lulus";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_aktiv;
                $xsl = new GeneralExcel();
                $xsl->id = "Aktiv";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_kupon;
                $xsl = new GeneralExcel();
                $xsl->id = "Kupon";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                // fuer Footer
                $total_bl += $arrDaten[0]->bi_rekap_bl;
                $total_baru += $arrDaten[0]->bi_rekap_baru;
                $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                $total_kupon += $arrDaten[0]->bi_rekap_kupon;
            } else {
                foreach ($arrBulan as $val) {
                    $org_tc = new RekapSiswaIBOModel();
                    $arrDaten = $org_tc->getDaten($val, $thn, $orgTC->nama);
                    $arrTotal_bl[$val] += $arrDaten[0]->bi_rekap_bl;
                    $arrTotal_baru[$val] += $arrDaten[0]->bi_rekap_baru;
                    $arrTotal_keluar[$val] += $arrDaten[0]->bi_rekap_keluar;
                    $arrTotal_cuti[$val] += $arrDaten[0]->bi_rekap_cuti;
                    $arrTotal_lulus[$val] += $arrDaten[0]->bi_rekap_lulus;
                    $arrTotal_aktiv[$val] += $arrDaten[0]->bi_rekap_aktiv;
                    $arrTotal_kupon [$val] += $arrDaten[0]->bi_rekap_kupon;

                    if (is_null($arrDaten[0]->bi_rekap_bl)) {
                        $bl = 0;
                    } else {
                        $bl = $arrDaten[0]->bi_rekap_bl;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_baru)) {
                        $baru = 0;
                    } else {
                        $baru = $arrDaten[0]->bi_rekap_baru;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_keluar)) {
                        $keluar = 0;
                    } else {
                        $keluar = $arrDaten[0]->bi_rekap_keluar;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_cuti)) {
                        $cuti = 0;
                    } else {
                        $cuti = $arrDaten[0]->bi_rekap_cuti;
                    }


                    if (is_null($arrDaten[0]->bi_rekap_lulus)) {
                        $lulus = 0;
                    } else {
                        $lulus = $arrDaten[0]->bi_rekap_lulus;
                    }
                    if (is_null($arrDaten[0]->bi_rekap_aktiv)) {
                        $aktiv = 0;
                    } else {
                        $aktiv = $arrDaten[0]->bi_rekap_aktiv;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_kupon)) {
                        $kpn = 0;
                    } else {
                        $kpn = $arrDaten[0]->bi_rekap_kupon;
                    }

                    // Einfuellen die Werten
                    $help = '0';
                    $help = $arrDaten[0]->bi_rekap_bl;
                    $xsl = new GeneralExcel();
                    $xsl->id = "BL";
                    $xsl->name = $bl;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_baru;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Baru";
                    $xsl->name = $baru;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_keluar;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Keluar";
                    $xsl->name = $help;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_cuti;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Cuti";
                    $xsl->name = $cuti;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);


                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_lulus;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Lulus";
                    $xsl->name = $lulus;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_aktiv;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Aktiv";
                    $xsl->name = $aktiv;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $help = 0;
                    $help = $arrDaten[0]->bi_rekap_kupon;
                    $xsl = new GeneralExcel();
                    $xsl->id = "Kupon";
                    $xsl->name = $kpn;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                    // fuer Footer
                    $total_bl += $arrDaten[0]->bi_rekap_bl;
                    $total_baru += $arrDaten[0]->bi_rekap_baru;
                    $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                    $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                    $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                    $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                    $total_kupon += $arrDaten[0]->bi_rekap_kupon;
                }
            }
            $i++;
        }


        // Footer
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "totalBL";
            $xsl->name = $total_bl;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            $xsl->mulaiColumn = "E";
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalBaru";
            $xsl->name = $total_baru;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKeluar";
            $xsl->name = $total_keluar;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalCuti";
            $xsl->name = $total_cuti;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalLulus";
            $xsl->name = $total_lulus;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalAktiv";
            $xsl->name = $total_aktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKupon";
            $xsl->name = $total_kupon;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
        } else {
            foreach ($arrBulan as $val) {


                $xsl = new GeneralExcel();
                $xsl->id = "totalBL";
                $xsl->name = $arrTotal_bl[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                if ($val == 1) {
                    $xsl->mulaiColumn = "E";
                }
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalBaru";
                $xsl->name = $arrTotal_baru[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKeluar";
                $xsl->name = $arrTotal_keluar[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalCuti";
                $xsl->name = $arrTotal_cuti[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalLulus";
                $xsl->name = $arrTotal_lulus[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalAktiv";
                $xsl->name = $arrTotal_aktiv[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKupon";
                $xsl->name = $arrTotal_kupon[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }
        }


        return $content;
    }

    public function header_rekap_bulanan_kupon($bln)
    {
        $zeile = 2;
        $header = array();
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "bln";
        $xsl->name = "Bulan";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Stock";
        $xsl->name = "Stock";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Kupon_Masuk";
        $xsl->name = "Kupon Masuk";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "tr_bln_ini";
        $xsl->name = "Transaksi Bulan ini";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Stock_Akhir";
        $xsl->name = "Stock Akhir";
        $xsl->anzahlcolumn = $zeile;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        return $header;
    }

    public function content_rekap_bulanan_kupon($tc_id, $bln, $thn)
    {
        $content = array();
        $i = 1;
        $arrBulan = Generic::getAllMonths();
        $arrMyTC = Generic::getAllMyTC($tc_id);
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $objRekapKupon = new BIRekapKuponModel();
            $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$bln AND bi_kupon_thn=$thn");

            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = Generic::getMonthName($arrRekap[0]->bi_kupon_bln);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_stock;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_kupon_masuk;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_trs_bln;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_stock_akhir;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
            $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
            $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
            $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;
            $i++;
        } else {

            foreach ($arrBulan as $val) {
                $objRekapKupon = new BIRekapKuponModel();
                $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$val AND bi_kupon_thn=$thn");
                $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
                $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
                $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
                $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;

                if (is_null($arrRekap[0]->bi_kupon_stock)) {
                    $kupon_stock = 0;
                } else {
                    $kupon_stock = $arrRekap[0]->bi_kupon_stock;
                }
                if (is_null($arrRekap[0]->bi_kupon_kupon_masuk)) {
                    $kupon_masuk = 0;
                } else {
                    $kupon_masuk = $arrRekap[0]->bi_kupon_kupon_masuk;
                }
                if (is_null($arrRekap[0]->bi_kupon_trs_bln)) {
                    $kupon_trs_bln = 0;
                } else {
                    $kupon_trs_bln = $arrRekap[0]->bi_kupon_trs_bln;
                }

                if (is_null($arrRekap[0]->bi_kupon_stock_akhir)) {
                    $kupon_stock_akhir = 0;
                } else {
                    $kupon_stock_akhir = $arrRekap[0]->bi_kupon_stock_akhir;
                }


                $xsl = new GeneralExcel();
                $xsl->id = "no";
                $xsl->name = $i;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_stock;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_masuk;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_trs_bln;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_stock_akhir;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $i++;
            }
        }


        // Footer
        $xsl = new GeneralExcel();
        $xsl->id = "total";
        $xsl->name = "Total";
        $xsl->anzahlcolumn = 2;
        $xsl->zeile = $i;
        $xsl->awal = 1;
        $xsl->textAllign = "center";
        array_push($content, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "totalStock";
        $xsl->name = $arrKuponStock;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        $xsl->mulaiColumn = "C";
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "kpn_msk";
        $xsl->name = $arrKuponmasuk;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "tr_bln_ini";
        $xsl->name = $arrKuponTraBln;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "stockAkhir";
        $xsl->name = $arrKuponStockAkhir;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);
        return $content;
    }

    public function header_rekap_jumlah_siswa_kpo($bln)
    {
        $header = array();
        $zeile = 2;
        $xsl = new GeneralExcel();
        $xsl->id = "lvl";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = Generic::getMonthName($bln);
            $xsl->anzahlcolumn = 3;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "ttl";
            $xsl->name = "Total Keluar";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "aktif";
            $xsl->name = "Aktif";
            $xsl->anzahlcolumn = 1;
            $xsl->awal = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->mulaiColumn = "B";
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "cuti";
            $xsl->name = "Cuti";
            $xsl->anzahlcolumn = 1;
            $xsl->awal = 0;
            $xsl->zeile = $zeile + 1;
//         $xsl->zeile = 1;
            array_push($header, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "keluar";
            $xsl->name = "Keluar";
            $xsl->anzahlcolumn = 1;
            $xsl->awal = 0;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 3;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                array_push($header, $xsl);
            }
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "aktif";
                $xsl->name = "Aktif";
                $xsl->anzahlcolumn = 1;
                $xsl->awal = 0;
                $xsl->zeile = $zeile + 1;
                if ($val == 1) {
                    $xsl->mulaiColumn = "B";
                }

                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "cuti";
                $xsl->name = "Cuti";
                $xsl->anzahlcolumn = 1;
                $xsl->awal = 0;
                $xsl->zeile = $zeile + 1;
//         $xsl->zeile = 1;
                array_push($header, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "keluar";
                $xsl->name = "Keluar";
                $xsl->anzahlcolumn = 1;
                $xsl->awal = 0;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);
            }
            $xsl = new GeneralExcel();
            $xsl->id = "ttl";
            $xsl->name = "Total Keluar";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);
        }
        return $header;
    }

    public function content_rekap_jumlah_siswa_kpo($ibo_id, $bln, $thn)
    {
        $arrLevel = Generic::getAllLevel();
        $aktiv = 0;
        $cuti = 0;
        $keluar = 0;
        $aktivTotal = 0;
        $cutiTotal = 0;
        $keluarTotal = 0;
        $i = 2;
        $content = array();
        foreach ($arrLevel as $keylvl => $level) {
            if ($bln != KEY::$KEY_MONTH_ALL) {
                $hlp = new StatusHisMuridModel();
                $aktiv = $hlp->getJumlahMuridAktivByMonth($ibo_id, $keylvl, $bln, $thn);
                $aktivTotal += $aktiv;
                $cuti = $hlp->getJumlahMuridCutiByMonth($ibo_id, $keylvl, $bln, $thn);
                $cutiTotal += $cuti;
                $keluar = $hlp->getJumlahMuridKeluarByMonth($ibo_id, $keylvl, $bln, $thn);
                $keluarTotal[$keylvl] += $keluar;

                $xsl = new GeneralExcel();
                $xsl->id = "lvl";
                $xsl->name = $level;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "aktiv";
                $xsl->name = $aktiv;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "cuti";
                $xsl->name = $cuti;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "keluar";
                $xsl->name = $keluar;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalkeluar";
                $xsl->name = $keluar;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            } else {
                $xsl = new GeneralExcel();
                $xsl->id = "lvl";
                $xsl->name = $level . Generic::getTCNamebyID($ibo_id);
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);
                $arrAllmonth = Generic::getAllMonths();
                $arrKeluar = array();
                foreach ($arrAllmonth as $key => $val) {
                    $hlp = new StatusHisMuridModel();
                    $aktiv = $hlp->getJumlahMuridAktivByMonth($ibo_id, $keylvl, $val, $thn);
                    $aktivTotal += $aktiv;
                    $cuti = $hlp->getJumlahMuridCutiByMonth($ibo_id, $keylvl, $val, $thn);
                    $cutiTotal += $cuti;
                    $keluar = $hlp->getJumlahMuridKeluarByMonth($ibo_id, $keylvl, $val, $thn);
                    $keluarTotal += $keluar;
                    $arrKeluar[$level] += $keluar;


                    $xsl = new GeneralExcel();
                    $xsl->id = "aktiv";
                    $xsl->name = $aktiv;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "cuti";
                    $xsl->name = $cuti;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "keluar";
                    $xsl->name = $keluar;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
                $xsl = new GeneralExcel();
                $xsl->id = "total_keluar";
                $xsl->name = $arrKeluar[$level];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }

            $i++;
        }


        return $content;
    }

    public function header_rekap_all_siswa($bln)
    {
        $header = array();
        $zeile = 2;
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "wilayah";
        $xsl->name = "Wilayah";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namaIbo";
        $xsl->name = "Nama IBO";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);


        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = Generic::getMonthName($bln);
            $xsl->anzahlcolumn = 7;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;

            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bl";
            $xsl->name = "BL";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            $xsl->mulaiColumn = "D";
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "b";
            $xsl->name = "B";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "k";
            $xsl->name = "K";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "c";
            $xsl->name = "C";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "l";
            $xsl->name = "L";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "a";
            $xsl->name = "A";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "kpn";
            $xsl->name = "KPN";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->awal = 0;
            array_push($header, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 7;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                array_push($header, $xsl);
            }
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bl";
                $xsl->name = "BL";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                if ($val == 1) {
                    $xsl->mulaiColumn = "D";
                }
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "b";
                $xsl->name = "B";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "k";
                $xsl->name = "K";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "c";
                $xsl->name = "C";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "l";
                $xsl->name = "L";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "a";
                $xsl->name = "A";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "kpn";
                $xsl->name = "KPN";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                $xsl->awal = 0;
                array_push($header, $xsl);
            }
        }
        return $header;
    }

    public function content_rekap_all_siswa($bln, $thn)
    {
        $i = 2;
        $content = array();
        $arrAllIBO = Generic::getAllIBO();

        foreach ($arrAllIBO as $key => $ibo) {
            $ibo_org = new SempoaOrg;
            $ibo_org->getByID($key);

            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i - 1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "ibo_propinsi";
            $xsl->name = $ibo_org->propinsi;;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "ibo_name";
            $xsl->name = $ibo_org->nama;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $hasilIBO[$key]['bl'] = 0;
            $hasilIBO[$key]['baru'] = 0;
            $hasilIBO[$key]['keluar'] = 0;
            $hasilIBO[$key]['cuti'] = 0;
            $hasilIBO[$key]['lulus'] = 0;
            $hasilIBO[$key]['aktiv'] = 0;
            $hasilIBO[$key]['kupon'] = 0;

            if ($bln != KEY::$KEY_MONTH_ALL) {
                $waktu = $bln . "-" . $thn;
                $rekap_siswa = new RekapSiswaIBOModel();
                $arrRekapSiswa = $rekap_siswa->getWhere("bi_rekap_ibo_id='$key' AND bi_rekap_siswa_waktu = '$waktu' ");

                foreach ($arrRekapSiswa as $val) {
                    $hasilIBO[$key]['bl'] += $val->bi_rekap_bl;
                    $hasilIBO[$key]['baru'] += $val->bi_rekap_baru;
                    $hasilIBO[$key]['keluar'] += $val->bi_rekap_keluar;
                    $hasilIBO[$key]['cuti'] += $val->bi_rekap_cuti;
                    $hasilIBO[$key]['lulus'] += $val->bi_rekap_lulus;
                    $hasilIBO[$key]['aktiv'] += $val->bi_rekap_aktiv;
                    $hasilIBO[$key]['kupon'] += $val->bi_rekap_kupon;
                }

                $xsl = new GeneralExcel();
                $xsl->id = "bl";
                $xsl->name = $hasilIBO[$key]['bl'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "baru";
                $xsl->name = $hasilIBO[$key]['baru'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "keluar";
                $xsl->name = $hasilIBO[$key]['keluar'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "cuti";
                $xsl->name = $hasilIBO[$key]['cuti'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "lulus";
                $xsl->name = $hasilIBO[$key]['lulus'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "aktiv";
                $xsl->name = $hasilIBO[$key]['aktiv'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "kupon";
                $xsl->name = $hasilIBO[$key]['kupon'];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            } else {

                $arrAllmonth = Generic::getAllMonths();
                foreach ($arrAllmonth as $keybln => $valbln) {
                    $hasilIBO[$key][$valbln]['bl'] = 0;
                    $hasilIBO[$key][$valbln]['baru'] = 0;
                    $hasilIBO[$key][$valbln]['keluar'] = 0;
                    $hasilIBO[$key][$valbln]['cuti'] = 0;
                    $hasilIBO[$key][$valbln]['lulus'] = 0;
                    $hasilIBO[$key][$valbln]['aktiv'] = 0;
                    $hasilIBO[$key][$valbln]['kupon'] = 0;
                }

                foreach ($arrAllmonth as $keybln => $valbln) {
                    $waktu = $valbln . "-" . $thn;
                    $rekap_siswa = new RekapSiswaIBOModel();
                    $arrRekapSiswa = $rekap_siswa->getWhere("bi_rekap_ibo_id='$key' AND bi_rekap_siswa_waktu = '$waktu' ");
                    foreach ($arrRekapSiswa as $valRekap) {
                        $hasilIBO[$key][$valbln]['bl'] += $valRekap->bi_rekap_baru;
                        $hasilIBO[$key][$valbln]['baru'] += $valRekap->bi_rekap_baru;
                        $hasilIBO[$key][$valbln]['keluar'] += $valRekap->bi_rekap_keluar;
                        $hasilIBO[$key][$valbln]['cuti'] += $valRekap->bi_rekap_cuti;
                        $hasilIBO[$key][$valbln]['lulus'] += $valRekap->bi_rekap_lulus;
                        $hasilIBO[$key][$valbln]['aktiv'] += $valRekap->bi_rekap_aktiv;
                        $hasilIBO[$key][$valbln]['kupon'] += $valRekap->bi_rekap_kupon;
                    }

                    $xsl = new GeneralExcel();
                    $xsl->id = "bl";
                    $xsl->name = $hasilIBO[$key][$valbln]['bl'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "baru";
                    $xsl->name = $hasilIBO[$key][$valbln]['baru'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "keluar";
                    $xsl->name = $hasilIBO[$key][$valbln]['keluar'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "cuti";
                    $xsl->name = $hasilIBO[$key][$valbln]['cuti'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "lulus";
                    $xsl->name = $hasilIBO[$key][$valbln]['lulus'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "aktiv";
                    $xsl->name = $hasilIBO[$key][$valbln]['aktiv'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "kupon";
                    $xsl->name = $hasilIBO[$key][$valbln]['kupon'];
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
            }

            $i++;
        }

        return $content;
    }

    public function header_rekap_siswa_kpo($bln)
    {
        $header = array();
        $zeile = 2;

        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "kodeTC";
        $xsl->name = "Kode TC.";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namaTC";
        $xsl->name = "Nama TC";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namaDirector";
        $xsl->name = "Nama Director";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = Generic::getMonthName($bln);
            $xsl->anzahlcolumn = 7;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bl";
            $xsl->name = "BL";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            $xsl->mulaiColumn = "E";
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "baru";
            $xsl->name = "B";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "keluar";
            $xsl->name = "K";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "cuti";
            $xsl->name = "Cuti";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "lulus";
            $xsl->name = "L";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "aktif";
            $xsl->name = "A";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "kupon";
            $xsl->name = "KPN";
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile + 1;
            array_push($header, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 7;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                array_push($header, $xsl);
            }
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "bl";
                $xsl->name = "BL";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                if ($val == 1) {
                    $xsl->mulaiColumn = "E";
                }

                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "baru";
                $xsl->name = "B";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "keluar";
                $xsl->name = "K";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "cuti";
                $xsl->name = "Cuti";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "lulus";
                $xsl->name = "L";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "aktif";
                $xsl->name = "A";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "kupon";
                $xsl->name = "KPN";
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile + 1;
                array_push($header, $xsl);
            }
        }

        return $header;
    }

    public function content_rekap_siswa_kpo($ibo_id, $bln, $thn)
    {
        $i = 2;
        $content = array();
        $arrMyTC = Generic::getAllMyTC($ibo_id);
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $total_bl = 0;
            $total_baru = 0;
            $total_keluar = 0;
            $total_cuti = 0;
            $total_lulus = 0;
            $total_aktiv = 0;
            $total_kupon = 0;
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $keybln => $valbln) {
                $total_bl[$valbln] = 0;
                $total_baru[$valbln] = 0;
                $total_keluar[$valbln] = 0;
                $total_cuti[$valbln] = 0;
                $total_lulus[$valbln] = 0;
                $total_aktiv[$valbln] = 0;
                $total_kupon[$valbln] = 0;
            }
        }
        $bl = 0;
        $baru = 0;
        $keluar = 0;
        $cuti = 0;
        $lulus = 0;
        $aktiv = 0;
        $kupon = 0;

        foreach ($arrMyTC as $id_tc => $tc) {
            $orgTC = new SempoaOrg();
            $orgTC->getByID($id_tc);
            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i - 1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "org_kode";
            $xsl->name = $orgTC->org_kode;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "nama";
            $xsl->name = $orgTC->nama;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "nama_pemilik";
            $xsl->name = $orgTC->nama_pemilik;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            if ($bln != KEY::$KEY_MONTH_ALL) {


                $org_tc = new RekapSiswaIBOModel();
                $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                $org_tc = new RekapSiswaIBOModel();
                $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);
                $total_bl += $arrDaten[0]->bi_rekap_bl;
                $total_baru += $arrDaten[0]->bi_rekap_baru;
                $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                $total_kupon += $arrDaten[0]->bi_rekap_kupon;

                $bl = $arrDaten[0]->bi_rekap_bl;
                $baru = $arrDaten[0]->bi_rekap_baru;
                $keluar = $arrDaten[0]->bi_rekap_keluar;
                $cuti = $arrDaten[0]->bi_rekap_cuti;
                $lulus = $arrDaten[0]->bi_rekap_lulus;
                $aktiv = $arrDaten[0]->bi_rekap_aktiv;
                $kupon = $arrDaten[0]->bi_rekap_kupon;

                $xsl = new GeneralExcel();
                $xsl->id = "bl";
                $xsl->name = $bl;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "baru";
                $xsl->name = $baru;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "keluar";
                $xsl->name = $keluar;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "Cuti";
                $xsl->name = $cuti;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "lulus";
                $xsl->name = $lulus;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "aktiv";
                $xsl->name = $aktiv;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "kupon";
                $xsl->name = $kupon;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            } else {

                foreach ($arrAllmonth as $keybln => $valbln) {
                    $org_tc = new RekapSiswaIBOModel();
                    $arrDaten = $org_tc->getDaten($valbln, $thn, $orgTC->nama);
                    $org_tc = new RekapSiswaIBOModel();
                    $arrDaten = $org_tc->getDaten($valbln, $thn, $orgTC->nama);

                    $total_bl[$valbln] += $arrDaten[0]->bi_rekap_bl;
                    $total_baru[$valbln] += $arrDaten[0]->bi_rekap_baru;
                    $total_keluar[$valbln] += $arrDaten[0]->bi_rekap_keluar;
                    $total_cuti[$valbln] += $arrDaten[0]->bi_rekap_cuti;
                    $total_lulus[$valbln] += $arrDaten[0]->bi_rekap_lulus;
                    $total_aktiv[$valbln] += $arrDaten[0]->bi_rekap_aktiv;
                    $total_kupon[$valbln] += $arrDaten[0]->bi_rekap_kupon;

                    if (is_null($arrDaten[0]->bi_rekap_bl)) {
                        $bl = 0;
                    } else {
                        $bl = $arrDaten[0]->bi_rekap_bl;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_baru)) {
                        $baru = 0;
                    } else {
                        $baru = $arrDaten[0]->bi_rekap_baru;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_keluar)) {
                        $keluar = 0;
                    } else {
                        $keluar = $arrDaten[0]->bi_rekap_keluar;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_cuti)) {
                        $cuti = 0;
                    } else {
                        $cuti = $arrDaten[0]->bi_rekap_cuti;
                    }


                    if (is_null($arrDaten[0]->bi_rekap_lulus)) {
                        $lulus = 0;
                    } else {
                        $lulus = $arrDaten[0]->bi_rekap_lulus;
                    }
                    if (is_null($arrDaten[0]->bi_rekap_aktiv)) {
                        $aktiv = 0;
                    } else {
                        $aktiv = $arrDaten[0]->bi_rekap_aktiv;
                    }

                    if (is_null($arrDaten[0]->bi_rekap_kupon)) {
                        $kpn = 0;
                    } else {
                        $kpn = $arrDaten[0]->bi_rekap_kupon;
                    }

                    $xsl = new GeneralExcel();
                    $xsl->id = "bl";
                    $xsl->name = $bl;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "baru";
                    $xsl->name = $baru;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "keluar";
                    $xsl->name = $keluar;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "Cuti";
                    $xsl->name = $cuti;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "lulus";
                    $xsl->name = $lulus;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "aktiv";
                    $xsl->name = $aktiv;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "kupon";
                    $xsl->name = $kpn;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $i;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
            }


            $i++;
        }

        $xsl = new GeneralExcel();
        $xsl->id = "total";
        $xsl->name = "Total";
        $xsl->anzahlcolumn = 2;
        $xsl->zeile = $i;
        $xsl->awal = 1;
        $xsl->textAllign = "center";
        array_push($content, $xsl);

        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "totalBL";
            $xsl->name = $total_bl;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            $xsl->mulaiColumn = "E";
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "totalB";
            $xsl->name = $total_baru;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKeluar";
            $xsl->name = $total_keluar;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalCuti";
            $xsl->name = $total_cuti;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalulus";
            $xsl->name = $total_lulus;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalAktiv";
            $xsl->name = $total_aktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKpnL";
            $xsl->name = $total_kupon;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
        } else {
            $arrAllmonth = Generic::getAllMonths();
            foreach ($arrAllmonth as $keybln => $valbln) {

                $xsl = new GeneralExcel();
                $xsl->id = "totalBL";
                $xsl->name = $total_bl[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                if ($valbln == 1) {
                    $xsl->mulaiColumn = "E";
                }
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "totalB";
                $xsl->name = $total_baru[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKeluar";
                $xsl->name = $total_keluar[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalCuti";
                $xsl->name = $total_cuti[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalulus";
                $xsl->name = $total_lulus[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalAktiv";
                $xsl->name = $total_aktiv[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKpnL";
                $xsl->name = $total_kupon[$valbln];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }
        }
        return $content;
    }

    public function header_rekap_absen_guru($week, $tgl)
    {
        $header = array();
        $zeile = 2;

        $xsl = new GeneralExcel();
        $xsl->id = "judul";
        $xsl->name = "Absen Coach " . $tgl . " Minggu ke: " . $week;
        $xsl->anzahlcolumn = 15;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $zeile = $zeile + 1;
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "NamaGuru";
        $xsl->name = "Nama Guru";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Jadwal Mengajar";
        $xsl->name = "Jadwal Mengajar";
        $xsl->anzahlcolumn = 11;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);
        $zeile = $zeile + 1;

        $xsl = new GeneralExcel();
        $xsl->id = "senin";
        $xsl->name = "Senin";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        $xsl->mulaiColumn = "C";
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "seninLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = "Selasa";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = "Rabu";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = "Kamis";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = "Jumat";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = "Sabtu";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "Level";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);
        return $header;
    }

    public function content_rekap_absen_guru($week, $thn, $org_id)
    {
        $i = 3;
        $senin = 0;
        $selasa = 0;
        $rabu = 0;
        $kamis = 0;
        $jumat = 0;
        $sabtu = 0;
        $keytc = $org_id;
        $content = array();
        $j = 1;

        $birekap = new RekapAbsenCoach();
        $arrRekap = $birekap->getWhere("ac_tc_id=$keytc AND ac_week=$week AND ac_tahun=$thn");
        foreach ($arrRekap as $valRekap) {
            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $j;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);
            $j++;

            $xsl = new GeneralExcel();
            $xsl->id = "nama_guru";
            $xsl->name = $valRekap->ac_nama_guru_dtg;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "senin";
            $xsl->name = $valRekap->ac_1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $senin += $valRekap->ac_1;

            $arrLevel = explode(",", $valRekap->ac_level_1);

            $xsl = new GeneralExcel();
            $xsl->id = "seninLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);


            $xsl = new GeneralExcel();
            $xsl->id = "selasa";
            $xsl->name = $valRekap->ac_2;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $selasa += $valRekap->ac_2;

            unset($arrLevel);
            $arrLevel = explode(",", $valRekap->ac_level_2);
            $xsl = new GeneralExcel();
            $xsl->id = "selasaLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);


            $xsl = new GeneralExcel();
            $xsl->id = "rabu";
            $xsl->name = $valRekap->ac_3;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $rabu += $valRekap->ac_3;

            unset($arrLevel);
            $arrLevel = explode(",", $valRekap->ac_level_3);
            $xsl = new GeneralExcel();
            $xsl->id = "rabuLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "kamis";
            $xsl->name = $valRekap->ac_4;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $kamis += $valRekap->ac_4;

            unset($arrLevel);
            $arrLevel = explode(",", $birekap->ac_level_4);

            $xsl = new GeneralExcel();
            $xsl->id = "kamisLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "jumat";
            $xsl->name = $valRekap->ac_5;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $jumat += $valRekap->ac_5;

            unset($arrLevel);
            $arrLevel = explode(",", $birekap->ac_level_5);

            $xsl = new GeneralExcel();
            $xsl->id = "jumatLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "sabtu";
            $xsl->name = $valRekap->ac_6;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $jumat += $valRekap->ac_5;

            unset($arrLevel);
            $arrLevel = explode(",", $birekap->ac_level_6);

            $xsl = new GeneralExcel();
            $xsl->id = "sabtuLevel";
            $xsl->name = Generic::getLevelAbsenCoach($arrLevel);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $sabtu += $valRekap->ac_6;
            $i++;
        }

        $xsl = new GeneralExcel();
        $xsl->id = "total";
        $xsl->name = "Total";
        $xsl->anzahlcolumn = 2;
        $xsl->zeile = $i;
        $xsl->awal = 1;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "senin";
        $xsl->name = $senin;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);


        $xsl = new GeneralExcel();
        $xsl->id = "seninLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);


        $xsl = new GeneralExcel();
        $xsl->id = "selasa";
        $xsl->name = $selasa;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "selasaLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);


        $xsl = new GeneralExcel();
        $xsl->id = "rabu";
        $xsl->name = $rabu;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "rabuLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "kamis";
        $xsl->name = $kamis;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "kamisLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "jumat";
        $xsl->name = $jumat;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);


        $xsl = new GeneralExcel();
        $xsl->id = "jumatLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "sabtu";
        $xsl->name = $birekap->ac_6;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "sabtuLevel";
        $xsl->name = "";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        return $content;
    }

    public function header_rekap_lama_belajar()
    {
        $header = array();
        $zeile = 2;

        $xsl = new GeneralExcel();
        $xsl->id = "judul";
        $xsl->name = "Laporan Absen Coach Bulanan";
        $xsl->anzahlcolumn = 4;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $zeile = $zeile + 1;
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Nama Siswa";
        $xsl->name = "Nama Siswa";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "levelSiswa";
        $xsl->name = "Level Siswa";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "Lama Belajar";
        $xsl->name = "Lama Belajar";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);


        return $header;
    }

    public function content_rekap_lama_belajar($tc_id)
    {
        $zeile = 1;
        $i = 1;

        $sudah = array();
        $muridMatrix = new MuridKelasMatrix();
        $arrGuru = $muridMatrix->getWhere("tc_id=$tc_id AND active_status = 1");
        $firstime = true;
        $now = new DateTime();
        $kelasByGuru = array();
        $content = array();
        foreach ($arrGuru as $mm) {
            $kelasByGuru[$mm->guru_id][] = $mm;
        }


        $num = 1;
        foreach ($kelasByGuru as $guru_id => $arrmm) {
            $zeile = $zeile + 1;
            $guru = new SempoaGuruModel();
            $guru->getByID($guru_id);

            $xsl = new GeneralExcel();
            $xsl->id = "namaGuru";
            $xsl->name = $guru->nama_guru;
            $xsl->anzahlcolumn = 4;
            $xsl->zeile = $zeile;
            $xsl->awal = 1;
            $xsl->mulaiColumn = "A";
            array_push($content, $xsl);


            foreach ($arrmm as $mm) {

                $datetime2 = new DateTime($mm->active_date);
                $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                $interval = $datetime2->diff($datetime1);

                if (in_array($mm->murid_id . $guru_id, $sudah)) {
                    $datetime2 = new DateTime($mm->active_date);
                    $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                    $interval2 = $datetime2->diff($datetime1);
                    if ($interval2 > $interval) {
                        $interval = $interval2;
                    }
                    continue;
                } else {
                    $zeile = $zeile + 1;
                    $sudah[] = $mm->murid_id . $guru_id;
                    $murid = new MuridModel();
                    $murid->getByID($mm->murid_id);
//                                    Generic::getMuridNamebyID($mm->murid_id);
                    $datetime2 = new DateTime($mm->active_date);
                    $datetime1 = new DateTime(date('Y-m-d H:i:s'));
                    $interval = $datetime2->diff($datetime1);

                    $xsl = new GeneralExcel();
                    $xsl->id = "no";
                    $xsl->name = $num;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 1;
                    array_push($content, $xsl);
                    $num++;

                    $xsl = new GeneralExcel();
                    $xsl->id = "no";
                    $xsl->name = Generic::getMuridNamebyID($mm->murid_id);
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 0;
                    array_push($content, $xsl);


                    $xsl = new GeneralExcel();
                    $xsl->id = "no";
                    $xsl->name = Generic::getLevelNameByID($murid->id_level_sekarang);
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 0;
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "no";
                    $xsl->name = floor($interval->format('%R%a ') / 30) . " bulan";
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
            }
        }
        return $content;
    }

    public function header_rekap_perkembanganIBO($thn)
    {

        $header = array();
        $zeile = 2;
        $zeile = $zeile + 1;
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "wilayah";
        $xsl->name = "Wilayah";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 0;
        array_push($header, $xsl);

        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;
        foreach ($arrTahun as $valThn) {
            $xsl = new GeneralExcel();
            $xsl->id = $valThn;
            $xsl->name = $valThn;
            $xsl->anzahlcolumn = 3;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);
        }
        $zeile++;
        foreach ($arrTahun as $key => $valThn) {

            $xsl = new GeneralExcel();
            $xsl->id = 'tc';
            $xsl->name = 'TC';
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            if ($key == 0) {
                $xsl->awal = 1;
                $xsl->mulaiColumn = "C";
            }
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = 'tc';
            $xsl->name = 'Coach';
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = 'tc';
            $xsl->name = 'Siswa';
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);
        }
        return $header;
    }

    public function content_rekap_perkembanganIBO($ibo_id, $thn)
    {
        $arrMyIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;
        $i = 1;
        $zeile = 3;
        $content = array();
        $thn_skrg = date("Y");
        $bln_skrg = date("n");
        foreach ($arrMyIBO as $keyIBO => $iboname) {
            $xsl = new GeneralExcel();
            $xsl->id = "id";
            $xsl->name = $i;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "ibo";
            $xsl->name = $iboname;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $zeile++;
            $arrmytc = Generic::getAllMyTC($keyIBO);
            foreach ($arrmytc as $keytc => $tcname) {

                foreach ($arrTahun as $keythn => $valthn) {
                    $rekap_siswa = new RekapSiswaIBOModel();
                    if ($valthn == $thn_skrg) {
                        $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_tc_id=$keytc AND bi_rekap_tahun = $valthn AND bi_rekap_bln=$bln_skrg");
                    } else {
                        $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_tc_id=$keytc AND bi_rekap_tahun = $valthn AND bi_rekap_bln =12");
                    }
                    $arrCoach[$keytc][$valthn] = 0;
                    $arrSiswa[$keytc][$valthn] = 0;
                    foreach ($arrRekapSiswa as $rekap) {

                        $arrCoach[$keytc][$valthn] += $rekap->bi_rekap_jumlah_guru;
                        $arrSiswa[$keytc][$valthn] += $rekap->bi_rekap_aktiv;
                    }
                    if (is_null($rekap->bi_rekap_jumlah_guru)) {
                        $jmlh_guru = 0;
                    } else {
                        $jmlh_guru = $rekap->bi_rekap_jumlah_guru;
                    }
                    if (is_null($rekap->bi_rekap_aktiv)) {
                        $jmlh_aktiv = 0;
                    } else {
                        $jmlh_aktiv = $rekap->bi_rekap_aktiv;
                    }
                    $xsl = new GeneralExcel();
                    $xsl->id = "tc";
                    $xsl->name = $tcname;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    if ($keythn == 0) {
                        $xsl->awal = 1;
                        $xsl->mulaiColumn = "C";
                    } else {
                        $xsl->awal = 0;
                    }
                    array_push($content, $xsl);

                    $xsl = new GeneralExcel();
                    $xsl->id = "Coach";
                    $xsl->name = $jmlh_guru;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                    $xsl = new GeneralExcel();
                    $xsl->id = "Siswa";
                    $xsl->name = $jmlh_aktiv;
                    $xsl->anzahlcolumn = 1;
                    $xsl->zeile = $zeile;
                    $xsl->awal = 0;
                    array_push($content, $xsl);
                }
                $zeile++;
            }

            $i++;
        }
        return $content;
    }

    public function header_rekap_jumlah_siswa_buku_kupon($thn)
    {

        $header = array();
        $zeile = 2;
        $zeile = $zeile + 1;
        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = "No";
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $zeile;
        $xsl->awal = 1;
        array_push($header, $xsl);


        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;
        foreach ($arrTahun as $valThn) {
            $xsl = new GeneralExcel();
            $xsl->id = $valThn;
            $xsl->name = $valThn;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 0;
            array_push($header, $xsl);
        }

        return $header;
    }

    public function content_rekap_jumlah_siswa_buku_kupon($ibo_id, $thn)
    {
        $kpo_id = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($kpo_id);
        $ibo_id = isset($_GET['ibo_id']) ? addslashes($_GET['ibo_id']) : key($arrMyIBO);
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $thn_skrg = date("Y");
        $bln_skrg = date("n");
        $t = time();
        $title = KEY::$JUDUL_REPORT_REKAP_PENJUALAN_B_K_S;
        $arrTahun = array();
        $arrTahun[] = $thn - 3;
        $arrTahun[] = $thn - 2;
        $arrTahun[] = $thn - 1;
        $arrTahun[] = $thn;

        $arrKey[1] = "Siswa";
        $arrKey[2] = "Buku";
        $arrKey[3] = "Kupon";

        $content = array();
        $zeile = 2;
        foreach ($arrKey as $val) {


            $xsl = new GeneralExcel();
            $xsl->id = "nama brg";
            $xsl->name = $val;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $zeile;
            $xsl->awal = 1;
            array_push($content, $xsl);

            foreach ($arrTahun as $valthn) {
                $rekap_siswa = new RekapSiswaIBOModel();
                if ($valthn == $thn_skrg) {
                    $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_ibo_id='$ibo_id' AND bi_rekap_tahun = $valthn AND bi_rekap_bln=$bln_skrg");
                } else {
                    $arrRekapSiswa = $rekap_siswa->getWhere(" bi_rekap_ibo_id='$ibo_id' AND bi_rekap_tahun = $valthn AND bi_rekap_bln =12");
                }
                $total[$val][$valthn] = 0;

                foreach ($arrRekapSiswa as $valRekap) {
                    if ($val == "Siswa") {
                        $total[$val][$valthn] += $valRekap->bi_rekap_aktiv;
                    }
                    if ($val == "Buku") {
                        $total[$val][$valthn] += $valRekap->bi_rekap_buku;
                    }
                    if ($val == "Kupon") {
                        $total[$val][$valthn] += $valRekap->bi_rekap_kupon;
                    }
                }
            }

            foreach ($arrTahun as $valthn) {
                $xsl = new GeneralExcel();
                $xsl->id = "nama brg";
                $xsl->name = $total[$val][$valthn];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $zeile;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }
            $zeile++;
        }
        return $content;
    }

    public function content_rekap_kupon_tc_lvl($tc_id, $bln, $thn)
    {
//        unset($content);
        $content = array();
        $i = 2;
//        $arrMyTC = Generic::getAllMyTC($ibo_id);
        $arrAllmonth = Generic::getAllMonths();
        $totalTerjual = 0;
        $totalAktiv = 0;
        $arrtotalTerjual = array();
        $arrtotalAktiv = array();
        foreach ($arrAllmonth as $key => $val) {
            $arrtotalTerjual[$val] = 0;
            $arrtotalAktiv[$val] = 0;
        }
        if ($bln != KEY::$KEY_MONTH_ALL) {

            $birekap = new RekapSiswaIBOModel();
            $birekap->getWhereOne("bi_rekap_tc_id=$tc_id AND bi_rekap_bln=$bln AND bi_rekap_tahun=$thn");

            $totalTerjual += $birekap->bi_rekap_kupon;
            $totalAktiv += $birekap->bi_rekap_aktiv;


            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i - 1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "namatc";
            $xsl->name = Generic::getTCNamebyID($tc_id);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "kpn";
            $xsl->name = $birekap->bi_rekap_kupon;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "A";
            $xsl->name = $birekap->bi_rekap_aktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $i++;
        } else {


            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i - 1;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "namatc";
            $xsl->name = Generic::getTCNamebyID($tc_id);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            foreach ($arrAllmonth as $key => $val) {

                $birekap = new RekapSiswaIBOModel();
                $birekap->getWhereOne("bi_rekap_tc_id=$tc_id AND bi_rekap_bln=$val AND bi_rekap_tahun=$thn");

                if ($birekap->bi_rekap_kupon == "") {
                    $kupon = 0;
                } else {
                    $kupon = $birekap->bi_rekap_kupon;
                }

                if ($birekap->bi_rekap_aktiv == "") {
                    $aktiv = 0;
                } else {
                    $aktiv = $birekap->bi_rekap_aktiv;
                }

                $arrtotalTerjual[$val] += $birekap->bi_rekap_kupon;
                $arrtotalAktiv[$val] += $birekap->bi_rekap_aktiv;
                $xsl = new GeneralExcel();
                $xsl->id = "kpn";
                $xsl->name = $kupon;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "A";
                $xsl->name = $aktiv;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }
            $i++;
        }

        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "totalTerjual";
            $xsl->name = $totalTerjual;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 4;
            $xsl->mulaiColumn = "C";
            array_push($content, $xsl);
            $xsl = new GeneralExcel();
            $xsl->id = "totalAktiv";
            $xsl->name = $totalAktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 5;
//        $xsl->mulaiColumn = "A";
            array_push($content, $xsl);
        } else {
            $awal = 4;
            $mulaiColumn = "C";
            foreach ($arrAllmonth as $key => $val) {
                $xsl = new GeneralExcel();
                $xsl->id = "totalTerjual";
                $xsl->name = $arrtotalTerjual[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->mulaiColumn = $mulaiColumn;
                $mulaiColumn++;
                array_push($content, $xsl);
                $xsl = new GeneralExcel();
                $xsl->id = "totalAktiv";
                $xsl->name = $arrtotalAktiv[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->mulaiColumn = $mulaiColumn;
                array_push($content, $xsl);
                $mulaiColumn++;
            }
        }


        return $content;
    }

    public function content_rekap_siswa_tc_lvl($tc_id, $bln, $thn)
    {
        $content = array();
        $i = 2;
        $arrBulan = Generic::getAllMonths();

        $arrTotal_bl = array();
        $arrTotal_baru = array();
        $arrTotal_keluar = array();
        $arrTotal_cuti = array();
        $arrTotal_lulus = array();
        $arrTotal_aktiv = array();
        $arrTotal_kupon = array();

        $orgTC = new SempoaOrg();
        $orgTC->getByID($tc_id);

        $xsl = new GeneralExcel();
        $xsl->id = "no";
        $xsl->name = $i - 1;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 1;
        array_push($content, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "kodetc";
        $xsl->name = $orgTC->org_kode;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "namatc";
        $xsl->name = $orgTC->nama;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "namaDr";
        $xsl->name = $orgTC->nama_pemilik;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);


        if ($bln != KEY::$KEY_MONTH_ALL) {
            // Ermiteln data2
            $org_tc = new RekapSiswaIBOModel();
            $arrDaten = $org_tc->getDaten($bln, $thn, $orgTC->nama);

            // Einfuellen die Werten
            $help = '0';
            $help = $arrDaten[0]->bi_rekap_bl;
            $xsl = new GeneralExcel();
            $xsl->id = "BL";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $help = 0;
            $help = $arrDaten[0]->bi_rekap_baru;
            $xsl = new GeneralExcel();
            $xsl->id = "Baru";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $help = 0;
            $help = $arrDaten[0]->bi_rekap_keluar;
            $xsl = new GeneralExcel();
            $xsl->id = "Keluar";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $help = 0;
            $help = $arrDaten[0]->bi_rekap_cuti;
            $xsl = new GeneralExcel();
            $xsl->id = "Cuti";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);


            $help = 0;
            $help = $arrDaten[0]->bi_rekap_lulus;
            $xsl = new GeneralExcel();
            $xsl->id = "Lulus";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $help = 0;
            $help = $arrDaten[0]->bi_rekap_aktiv;
            $xsl = new GeneralExcel();
            $xsl->id = "Aktiv";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $help = 0;
            $help = $arrDaten[0]->bi_rekap_kupon;
            $xsl = new GeneralExcel();
            $xsl->id = "Kupon";
            $xsl->name = $help;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            // fuer Footer
            $total_bl += $arrDaten[0]->bi_rekap_bl;
            $total_baru += $arrDaten[0]->bi_rekap_baru;
            $total_keluar += $arrDaten[0]->bi_rekap_keluar;
            $total_cuti += $arrDaten[0]->bi_rekap_cuti;
            $total_lulus += $arrDaten[0]->bi_rekap_lulus;
            $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
            $total_kupon += $arrDaten[0]->bi_rekap_kupon;
        } else {
            foreach ($arrBulan as $val) {
                $org_tc = new RekapSiswaIBOModel();
                $arrDaten = $org_tc->getDaten($val, $thn, $orgTC->nama);
                $arrTotal_bl[$val] += $arrDaten[0]->bi_rekap_bl;
                $arrTotal_baru[$val] += $arrDaten[0]->bi_rekap_baru;
                $arrTotal_keluar[$val] += $arrDaten[0]->bi_rekap_keluar;
                $arrTotal_cuti[$val] += $arrDaten[0]->bi_rekap_cuti;
                $arrTotal_lulus[$val] += $arrDaten[0]->bi_rekap_lulus;
                $arrTotal_aktiv[$val] += $arrDaten[0]->bi_rekap_aktiv;
                $arrTotal_kupon [$val] += $arrDaten[0]->bi_rekap_kupon;

                if (is_null($arrDaten[0]->bi_rekap_bl)) {
                    $bl = 0;
                } else {
                    $bl = $arrDaten[0]->bi_rekap_bl;
                }

                if (is_null($arrDaten[0]->bi_rekap_baru)) {
                    $baru = 0;
                } else {
                    $baru = $arrDaten[0]->bi_rekap_baru;
                }

                if (is_null($arrDaten[0]->bi_rekap_keluar)) {
                    $keluar = 0;
                } else {
                    $keluar = $arrDaten[0]->bi_rekap_keluar;
                }

                if (is_null($arrDaten[0]->bi_rekap_cuti)) {
                    $cuti = 0;
                } else {
                    $cuti = $arrDaten[0]->bi_rekap_cuti;
                }


                if (is_null($arrDaten[0]->bi_rekap_lulus)) {
                    $lulus = 0;
                } else {
                    $lulus = $arrDaten[0]->bi_rekap_lulus;
                }
                if (is_null($arrDaten[0]->bi_rekap_aktiv)) {
                    $aktiv = 0;
                } else {
                    $aktiv = $arrDaten[0]->bi_rekap_aktiv;
                }

                if (is_null($arrDaten[0]->bi_rekap_kupon)) {
                    $kpn = 0;
                } else {
                    $kpn = $arrDaten[0]->bi_rekap_kupon;
                }

                // Einfuellen die Werten
                $help = '0';
                $help = $arrDaten[0]->bi_rekap_bl;
                $xsl = new GeneralExcel();
                $xsl->id = "BL";
                $xsl->name = $bl;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_baru;
                $xsl = new GeneralExcel();
                $xsl->id = "Baru";
                $xsl->name = $baru;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_keluar;
                $xsl = new GeneralExcel();
                $xsl->id = "Keluar";
                $xsl->name = $help;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_cuti;
                $xsl = new GeneralExcel();
                $xsl->id = "Cuti";
                $xsl->name = $cuti;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);


                $help = 0;
                $help = $arrDaten[0]->bi_rekap_lulus;
                $xsl = new GeneralExcel();
                $xsl->id = "Lulus";
                $xsl->name = $lulus;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_aktiv;
                $xsl = new GeneralExcel();
                $xsl->id = "Aktiv";
                $xsl->name = $aktiv;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $help = 0;
                $help = $arrDaten[0]->bi_rekap_kupon;
                $xsl = new GeneralExcel();
                $xsl->id = "Kupon";
                $xsl->name = $kpn;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                // fuer Footer
                $total_bl += $arrDaten[0]->bi_rekap_bl;
                $total_baru += $arrDaten[0]->bi_rekap_baru;
                $total_keluar += $arrDaten[0]->bi_rekap_keluar;
                $total_cuti += $arrDaten[0]->bi_rekap_cuti;
                $total_lulus += $arrDaten[0]->bi_rekap_lulus;
                $total_aktiv += $arrDaten[0]->bi_rekap_aktiv;
                $total_kupon += $arrDaten[0]->bi_rekap_kupon;
            }
        }
        $i++;


        // Footer
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $xsl = new GeneralExcel();
            $xsl->id = "totalBL";
            $xsl->name = $total_bl;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            $xsl->mulaiColumn = "E";
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalBaru";
            $xsl->name = $total_baru;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKeluar";
            $xsl->name = $total_keluar;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalCuti";
            $xsl->name = $total_cuti;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalLulus";
            $xsl->name = $total_lulus;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalAktiv";
            $xsl->name = $total_aktiv;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "totalKupon";
            $xsl->name = $total_kupon;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
        } else {
            foreach ($arrBulan as $val) {


                $xsl = new GeneralExcel();
                $xsl->id = "totalBL";
                $xsl->name = $arrTotal_bl[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                if ($val == 1) {
                    $xsl->mulaiColumn = "E";
                }
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalBaru";
                $xsl->name = $arrTotal_baru[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKeluar";
                $xsl->name = $arrTotal_keluar[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalCuti";
                $xsl->name = $arrTotal_cuti[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalLulus";
                $xsl->name = $arrTotal_lulus[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalAktiv";
                $xsl->name = $arrTotal_aktiv[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "totalKupon";
                $xsl->name = $arrTotal_kupon[$val];
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
            }
        }


        return $content;
    }


    public function content_rekap_bulanan_kupon_tc_lvl($tc_id, $bln, $thn)
    {
        $content = array();
        $i = 1;
        $arrBulan = Generic::getAllMonths();
        if ($bln != KEY::$KEY_MONTH_ALL) {
            $objRekapKupon = new BIRekapKuponModel();
            $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$bln AND bi_kupon_thn=$thn");

            $xsl = new GeneralExcel();
            $xsl->id = "no";
            $xsl->name = $i;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 1;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = Generic::getMonthName($arrRekap[0]->bi_kupon_bln);
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_stock;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_kupon_masuk;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_trs_bln;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);

            $xsl = new GeneralExcel();
            $xsl->id = "bln";
            $xsl->name = $arrRekap[0]->bi_kupon_stock_akhir;
            $xsl->anzahlcolumn = 1;
            $xsl->zeile = $i;
            $xsl->awal = 0;
            array_push($content, $xsl);
            $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
            $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
            $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
            $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;
            $i++;
        } else {

            foreach ($arrBulan as $val) {
                $objRekapKupon = new BIRekapKuponModel();
                $arrRekap = $objRekapKupon->getWhere("bi_kupon_tc_id=$tc_id AND bi_kupon_bln=$val AND bi_kupon_thn=$thn");
                $arrKuponStock += $arrRekap[0]->bi_kupon_stock;
                $arrKuponmasuk += $arrRekap[0]->bi_kupon_kupon_masuk;
                $arrKuponTraBln += $arrRekap[0]->bi_kupon_trs_bln;
                $arrKuponStockAkhir += $arrRekap[0]->bi_kupon_stock_akhir;

                if (is_null($arrRekap[0]->bi_kupon_stock)) {
                    $kupon_stock = 0;
                } else {
                    $kupon_stock = $arrRekap[0]->bi_kupon_stock;
                }
                if (is_null($arrRekap[0]->bi_kupon_kupon_masuk)) {
                    $kupon_masuk = 0;
                } else {
                    $kupon_masuk = $arrRekap[0]->bi_kupon_kupon_masuk;
                }
                if (is_null($arrRekap[0]->bi_kupon_trs_bln)) {
                    $kupon_trs_bln = 0;
                } else {
                    $kupon_trs_bln = $arrRekap[0]->bi_kupon_trs_bln;
                }

                if (is_null($arrRekap[0]->bi_kupon_stock_akhir)) {
                    $kupon_stock_akhir = 0;
                } else {
                    $kupon_stock_akhir = $arrRekap[0]->bi_kupon_stock_akhir;
                }


                $xsl = new GeneralExcel();
                $xsl->id = "no";
                $xsl->name = $i;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 1;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = Generic::getMonthName($val);
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_stock;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_masuk;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_trs_bln;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);

                $xsl = new GeneralExcel();
                $xsl->id = "bln";
                $xsl->name = $kupon_stock_akhir;
                $xsl->anzahlcolumn = 1;
                $xsl->zeile = $i;
                $xsl->awal = 0;
                array_push($content, $xsl);
                $i++;
            }
        }


        // Footer
        $xsl = new GeneralExcel();
        $xsl->id = "total";
        $xsl->name = "Total";
        $xsl->anzahlcolumn = 2;
        $xsl->zeile = $i;
        $xsl->awal = 1;
        $xsl->textAllign = "center";
        array_push($content, $xsl);
        $xsl = new GeneralExcel();
        $xsl->id = "totalStock";
        $xsl->name = $arrKuponStock;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        $xsl->mulaiColumn = "C";
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "kpn_msk";
        $xsl->name = $arrKuponmasuk;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "tr_bln_ini";
        $xsl->name = $arrKuponTraBln;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);

        $xsl = new GeneralExcel();
        $xsl->id = "stockAkhir";
        $xsl->name = $arrKuponStockAkhir;
        $xsl->anzahlcolumn = 1;
        $xsl->zeile = $i;
        $xsl->awal = 0;
        array_push($content, $xsl);
        return $content;
    }
}
