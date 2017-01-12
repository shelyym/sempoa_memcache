<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcelExporter
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ExcelExporter {
    
    public static function exportIt ($arr_objects,$filename = "")
    {
            if($filename=="")
            $filename = date('Ymd') . ".xls";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
            $flag = false;

            foreach ($arr_objects as $key => $obj) {

                    foreach ($arr_objects as $name => $value) {
                            echo Lang::t($name) . "\t";
                    }
                    break;
            }
            print("\n");
            foreach ($arr_objects as $key => $obj) {

                    foreach ($obj as $name => $value) {
                            echo $value . "\t";
                    }
                    print("\n");
            }
            exit;
    }
    public static function saveIt ($arr_objects,$filename = "")
    {
            if($filename=="")
            $filename = date('Ymd') . ".xls";
            
            //pr($arr_objects);
            $file = fopen($filename, "w+");
            //echo $filename;
            //header("Content-Disposition: attachment; filename=\"$filename\"");
            //header("Content-Type: application/vnd.ms-excel");
            $flag = false;
            $str = "";
            foreach ($arr_objects as $key => $obj) {

                    foreach ($obj as $name => $value) {
                            $str .= Lang::t($name) . "\t";
                    }
                    break;
            }
            $str .= "\n";
            foreach ($arr_objects as $key => $obj) {

                    foreach ($obj as $name => $value) {
                            $str .= $value . "\t";
                    }
                    $str .="\n";
            }
            fwrite($file, $str);
            fclose($file);
            //exit;
            //pr($file);
            //pr($str);
            
    }
}
