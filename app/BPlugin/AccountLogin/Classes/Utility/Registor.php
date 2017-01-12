<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registor
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Registor {
    public static function addRole ($role)
    {
        //global $template;
        //$template->roles[$role->role_id] = $role->role_name;
        $_SESSION['Registor']['roles'][$role->role_id] = $role->role_name;
    }

    public static function getRoles ()
    {
        if (!isset($_SESSION['Registor']['roles'])) {
            $role = new Role();
            $role->loadRoleToSession();
        }

        return $_SESSION['Registor']['roles'];
    }

    public static function setDomainAndRoleMenu ($menuname)
    {
        self::setDomainAndRoleMenuWithRole(Role2Menu::getRoleForMenu($menuname), $menuname);
    }

    public static function setDomainAndRoleMenuWithRole ($role, $menuname)
    {
        global $template;
        $template->domainMenu[$role][] = $menuname;
    }

    public static function getAllAdminMenu ()
    {
        global $template;

        return $template->adminMenu;
    }

    //tambahan untuk search
    public static function getAllAdminMenuSearch ()
    {
        global $template;

        return $template->adminMenuSearch;
    }

    public static function getAllAdminMenuByRole ($role)
    {
        global $template;
        $returnArr = array ();
        foreach ($template->adminMenu as $domainMenu => $menuArr) {
            foreach ($menuArr as $menuname => $menuurl) {
                if (in_array($menuname, $template->domainMenu[$role])) {
                    $returnArr[$domainMenu][$menuname] = $menuurl;
                }
            }
        }

        return $returnArr;
    }

    public static function getAllAdminMenuByRoles ($array_role)
    {
        global $template;
        $returnArr = array ();
        foreach ($template->adminMenu as $domainMenu => $menuArr) {
            //pr($menuArr);
            foreach ($menuArr as $menuname => $menuurl) {
                //pr($menuurl);echo "menuname : ".$menuname;
                foreach ($array_role as $role) {
                    //pr($role);
                    if (isset($template->domainMenu[$role])) {
                        //echo $role." IN";
                        //pr($template->domainMenu[$role]);
                        
                        if (in_array($menuname, $template->domainMenu[$role])) {
                            //echo "inserted to arr as $role $domainMenu and $menuname";
                            $returnArr[$domainMenu][$menuname] = $menuurl;
                        }
                    }
                }
            }
        }
        ksort($returnArr);
        return $returnArr;
    }
    public static function getAllAdminMenuFromSession(){
        $arr =$_SESSION['Registor']['adminMenu'];
        sort($arr);
        return $arr;
    }

    public static function registerAdminMenu($domainMenu,$menuname,$menuurl,$menusearchText = ""){
        global $template;
        $template->adminMenu[$domainMenu][$menuname] = $menuurl;
        $template->adminMenuSearch[$domainMenu][$menuname] = $menusearchText;
        //save to DB
        $adminMenu = new AdminMenu();
        $adminMenu->menuname = $menuname;
        $adminMenu->menuurl = $menuurl;
        $adminMenu->save(1);

        //register
        self::registerOpenLwID($menuname, $menuurl);
    }

    public static function registerOpenLwID ($id, $url)
    {
        global $template;
        $template->openLW[$id] = $url;
    }

    public static function emptyAdminMenu ()
    {
        $adminMenu = new AdminMenu();
        $adminMenu->emptyAll();
    }

    public static function redirectOpenLW ($id = "EfiHome", $url = "EfiHome/homeLoad")
    {
        $st = $_GET['st'];
        global $template;
        if (array_key_exists($st, $template->openLW)) {
            $id = $st;
            $url = $template->openLW[$id];
        }
        else{
            header("Location:"._SPPATH.$url);
            die();
        }

        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                openLw('<?=$id;?>', '<?=_SPPATH;?><?=$url;?>', 'fade');
            });
        </script>
    <?
    }



}
