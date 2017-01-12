<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelAccount
 *
 * @author User
 */
class ModelAccount extends Model {

    public $accObj;
    public $account_id;
    public $nama_depan;
    public $foto;
    public $try;

    public function getByAccountID ($id)
    {
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE account_id = '$id'";
        $obj = $db->query($q, 1);

        $row = toRow($obj);
        $this->fill($row);
    }

    public function getSelfAndAccount ($id)
    {
        global $db;
        $acc = new Account();
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name},{$acc->table_name} WHERE account_id = '$id' AND admin_id = account_id";
        $obj = $db->query($q, 1);

        $row = toRow($obj);
        $this->fill($row);
    }

    /*
     * Untuk penyamaan kalau pas save ditambahkan di tabele account dan role
     */
    public function save ($onDuplicateKey = 0)
    {
        if (parent::save($onDuplicateKey)) {
            //save the account
            $load = (isset($this->load) ? addslashes($this->load) : 0);
            if (!isset($this->qid)) {
                die('QID is empty');
            }

            if ($load) {
                //save di account bdsrkan account_id nya
                $acc = new Account();
                $acc->load = $load;
                $acc->admin_id = $this->account_id;
                $acc->admin_nama_depan = $this->nama_depan;
                $acc->admin_foto = $this->foto;

                return $acc->save();
            } else {
                $acc = new Account();
                //create username dan password
                $acc->admin_username = $this->createUsername($this->nama_depan);
                $acc->admin_password = $this->generate_password(6);
                $acc->admin_nama_depan = $this->nama_depan;
                $acc->admin_foto = $this->foto;
                $acc->admin_aktiv = 1;
                $acc->admin_ip = $_SERVER['REMOTE_ADDR'];
                $acc->admin_role = strtolower(get_called_class());
                //this return admin id krn load = 0
                $acc->admin_id = $acc->save();
                if ($acc->admin_id) {
                    $this->account_id = $acc->admin_id;
                    $this->{$this->main_id} = $this->qid;
                    $this->load = 1;
                    if ($this->save()) {
                        return $acc->insertNewRole();
                    }

                    return 0;
                }

                return 0;
            }

            return 0;
        }

        return 0;
    }

    /*
     * Untuk penyamaan kalau pas save ditambahkan di tabele account dan role
     */

    function createUsername ($nd_asli, $length = 3)
    {
        $chars = "0123456789";
        $exp = explode(" ", $nd_asli);
        $nd = $exp[0];
        $nb = $exp[1];
        //if(strlen($nd_asli)<6)$this->try = 3;
        $chars2 = substr(strtolower(str_replace(" ", "", $nd . $nb)), 0, 8);
        if ($this->try == 1) {
            $chars2 = substr(strtolower($nd . "." . $nb), 0, 8);
        }
        if ($this->try == 2) {
            $chars2 = substr(strtolower($nd . "_" . $nb), 0, 8);
        }
        if ($this->try > 2) {
            $chars2 = $chars2 . substr(str_shuffle($chars), 0, $length);
        }

        global $db;
        $acc = new Account();
        $this->try++;
        $hasil = $db->query("SELECT admin_username FROM {$acc->table_name} WHERE admin_username = '$chars2'", 1);
        if (isset($hasil->admin_username)) {
            $chars2 = $this->createUsername($nd_asli);
        }

        return $chars2;
    }

    function generate_password ($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);

        return $password;
    }

    public function delete ($id)
    {
        //get account_id nya dulu
        global $db;
        $this->getByID($id);

        //delete account
        $acc = new Account();
        $acc->delete($this->account_id);
        $acc->deleteRole($this->account_id);

        return parent::delete($id);
    }

    /*
     * get name return admin nama depan kl ga ada return nama depan
     */

    public function getName ()
    {
        $nama = (isset($this->admin_nama_depan) ? $this->admin_nama_depan : $this->nama_depan);

        return $nama;
    }

    /*
     * ModelAccount READ includes read, getByID, fill, save, export As Excel
     * overwrite Model Read
     */
    public function read2 ($perpage = 20)
    {
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
        $searchdb = "WHERE admin_id = account_id";
        $search = (isset($_GET['search']) ? addslashes($_GET['search']) : 0);

        $w = (isset($_GET['word']) ? addslashes($_GET['word']) : '');
        if ($search == 1 && $w != '') {
            $searchdb .= " AND (";
            foreach ($arrClms as $col) {
                $imp[] = " $col LIKE '%{$w}%' ";

            }
            $searchdb .= implode(" OR ", $imp);
            $searchdb .= " )";

        }
        // get placeholder
        $placeholder = "";
        $p = array ();
        foreach ($arrClms as $col) {
            $p[] = Lang::t($col);
        }
        $placeholder = implode(",", $p);

        /*
         * Account Object
         */
        $acc = new Account();

        $t = time();
        $q = "SELECT count(*) as nr FROM {$this->table_name},{$acc->table_name} $searchdb";
        $nr = $db->query($q, 1);
        //echo $q;echo "<br>";
        $sortdb = $this->main_id . " ASC";
        $sort = (isset($_GET['sort']) ? addslashes($_GET['sort']) : $sortdb);
        $sortdb = $sort;

        $beginlimit = "LIMIT $begin,$limit";
        if ($all) {
            $beginlimit = "";
            $perpage = $nr->nr;
        }
        $q = "SELECT $clms FROM {$this->table_name},{$acc->table_name} $searchdb ORDER BY $sortdb $beginlimit";
        //echo $q;

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
        $return['colomslist'] = $this->coloumlist;
        $return['main_id'] = $this->main_id;
        $return['classname'] = get_class($this);

        $export = (isset($_GET['export']) ? addslashes($_GET['export']) : 0);
        if ($export) {
            $this->exportIt($return);
        }

        return $return;
    }

    /*
     * getGallert
     */
    public function getGallery ($acc_id)
    {
        //pr($acc_id);
        $targetClass = "Account";
        $fotoweb = new Fotoweb();
        $target = $fotoweb->createTarget($acc_id, $targetClass);
        $fotoweb->getPicsReadOnly($target);
    }
}
