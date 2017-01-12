<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 9:57 PM
 */
class TcWeb extends WebService {

    static $lvl = "tc";
    static $webclass = "TcWeb";
    static $orgModel = "TorgTC";


    /*
     * [0] =>
      [1] =>
      [2] =>
      [3] =>
     */
/*
 * User di Tingkat IBO
 */
    function create_tc() {
        $myOrgId = AccessRight::getMyOrgID();
        $objIBO = new SempoaOrg();
        $objIBO->getByID($myOrgId);
        $kode_ibo = Generic::getMyParentID($myOrgId);
        OrgWebContainer::create(self::$orgModel, self::$webclass, self::$lvl,  $objIBO->org_kode);
        
        
    }

    function update_semua_tc() {
        OrgWebContainer::update_semua(self::$orgModel, self::$webclass, self::$lvl);
    }

    function delete_semua_tc() {
        
    }

    function read_semua_tc() {
        OrgWebContainer::read_semua(self::$orgModel, self::$webclass, self::$lvl);
    }

    public function get_my_tc() {
         Generic::myOrgData();
    }




    public function dashboard_tc(){

        SempoaMain::operationalDaily();
        die();



    }
}
