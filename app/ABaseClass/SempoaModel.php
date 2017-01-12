<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SempoaModel
 *
 * @author efindiongso
 */
class SempoaModel extends Model {


    //put your code here
    public function readMy($whereCustom, $perpage = 20) {
        global $db;
        $page = (isset($_GET['page']) ? addslashes($_GET['page']) : 1);
        $all = 0;
        if ($page == "all") {
            $page = 1;
            $all = 1;
        }
        $begin = ($page - 1) * $perpage;
        $limit = $perpage;
        // get columnlist filter
        $clms = (isset($_GET['clms']) ? addslashes($_GET['clms']) : '');
        if ($clms == "") {
            $clms = $this->default_read_coloms;
        }
        $clmsPlaceholder = $clms;
        $clms = $this->main_id . "," . $clms; // add main id to the filter
        $arrClms = explode(",", $clms);
        // searchh
        $searchdb = " ";
        $search = (isset($_GET['search']) ? addslashes($_GET['search']) : 0);

        $w = (isset($_GET['word']) ? addslashes($_GET['word']) : '');

        if ($search == 1 && $w != '') {
            $searchdb .= " WHERE " . $whereCustom . " AND (";
            foreach ($arrClms as $col) {

                //disini di filter...
                if (!array_key_exists($col, $this->read_filter_array)) {
                    $imp[] = " $col LIKE '%{$w}%' ";
                }

                //tambahkan search jika multiple
                if (count($this->crud_read_gabungan) > 0) {
                    foreach ($this->crud_read_gabungan as $tableClassname => $clms2) {
                        foreach ($clms2 as $clm23)
                            $imp[] = " $clm23 LIKE '%{$w}%' ";
                    }
                }
            }
            $searchdb .= implode(" OR ", $imp);
            $searchdb .= ") ";
        } else {
            $searchdb.= " WHERE " . $whereCustom;
        }
        //begin filter
        //edit by roy 2 des 2014
        $imp2 = array();
        if (count($this->read_filter_array) > 0) {
            foreach ($arrClms as $col) {
                if (array_key_exists($col, $this->read_filter_array)) {
                    $imp2[] = " $col = '" . $this->read_filter_array[$col] . "' ";
                }
            }

            if ($searchdb != " ") {
                //ada search
                //kita kasi kurung dan kasi AND
                $searchdb = str_replace("WHERE ", "WHERE (", $searchdb);
                $searchdb = $searchdb . ") AND " . implode(" AND ", $imp2);
            } else {
                //kalau masi kosong
                $searchdb = "WHERE " . implode(" AND ", $imp2);
            }
        }

        // get placeholder
        $placeholder = "";
        $p = array();
        foreach ($arrClms as $col) {
            $p[] = Lang::t($col);
        }
        $placeholder = implode(",", $p);

        $t = time();
        $q = "SELECT count(*) as nr FROM {$this->table_name} $searchdb";
        $nr = $db->query($q, 1);
//        echo $q;echo "<br>";
        $sortdb = $this->main_id . " ASC";
        $sort = (isset($_GET['sort']) ? addslashes($_GET['sort']) : $sortdb);
        $sortdb = $sort;

        $beginlimit = "LIMIT $begin,$limit";
        if ($all) {
            $beginlimit = "";
            $perpage = $nr->nr;
        }

        //echo $searchdb;
        //dynamic table name
        $cl = array();
        $imp = array();
        $tablename = $this->table_name;
        if (count($this->crud_read_gabungan) > 0) {
            foreach ($this->crud_read_gabungan as $tableClassname => $clms2) {
                $m = new $tableClassname();
                $tn = $m->table_name;
                $on = implode(" = ", $this->crud_read_link[$tableClassname]);

                $leftjoin[] = "LEFT JOIN $tn ON $on ";
                foreach ($clms2 as $clm23)
                    $cl[] = $clm23;
            }
            $imp_clms = implode(",", $cl);
            $implode = implode(" ", $leftjoin);
            $clms = $clms . "," . $imp_clms;
            $tablename = $this->table_name . " " . $implode;

            //update search
            //echo "sd ".$searchdb;
            $sem3 = array();
            //pr($this->crud_read_link);
            foreach ($this->crud_read_link as $tableClassname => $arr3) {
                //echo $tableClassname;
                $sem3[] = $arr3[0] . " = " . $arr3[1];
            }
            if ($searchdb == " ") {

                $searchdb = "WHERE " . implode(" AND ", $sem3);
            } else {
                $searchdb = $searchdb . " AND (" . implode(" AND ", $sem3) . ")";
            }
        }


        $q = "SELECT $clms FROM {$tablename} $searchdb  ORDER BY $sortdb $beginlimit";
//        pr($q);
        //create return array
        $return['objs'] = $db->query($q, 2);
        $return['totalpage'] = ceil($nr->nr / $perpage);
        $return['perpage'] = $perpage;
        $return['page'] = $page;
        $return['sort'] = $sort;
        $return['search'] = $placeholder;
        $return['search_keyword'] = $w;
        $return['search_triger'] = $search;
        $return['coloms'] = $clmsPlaceholder;
        $column = "";
        foreach ($this->getColumnlist() as $col) {
            if ($column) {
                $column .= ",";
            }
            $column .= $col->Field;
        }
        $return['colomslist'] = $column;
        $return['main_id'] = $this->main_id;
        $return['classname'] = get_class($this);

        $export = (isset($_GET['export']) ? addslashes($_GET['export']) : 0);
        if ($export) {
            $this->exportIt($return);
        }

        return $return;
    }

}
