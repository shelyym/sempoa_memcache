<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Leap\Utility\Ausnahme;

/**
 * Description of Auth
 * Kelas Auth adalah Utility Class untuk cek authentification, login, logout, dll
 * isinya semua static methods
 * yang merubah/mengecek isi $_SESSION['account']
 *
 * @author Elroyhardoyo
 */
class Auth {
    protected $admin_username;
    protected $admin_password;
    protected $rememberme;
    protected $admin_email;

    /*
     * default constructor
     */
    /*public function __construct($username,$email,$password,$remember) {
        $this->admin_username = $username;
        $this->admin_password = $password;
        $this->rememberme = $remember;
        $this->admin_email = $email;
    }*/
    /*
     * Cek apakah role terpenuhi
     */
    public static function checkRole ($minRoleFromPage)
    {
        if (!self::isLogged()) {
            Ausnahme::notAuth();
        }
        if (!self::hasRole($minRoleFromPage)) {
            Ausnahme::notAuthToView();
        }
    }

    /*
     * Cek apakah role terpenuhi
     */

    public static function isLogged ()
    {
        if (!isset($_SESSION["admin_session"])) {
            return 0;
        }
        if ($_SESSION["admin_session"] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Cek apakah logged
     */

    public static function hasRole ($minRoleFromPage)
    {
        return in_array($minRoleFromPage, $_SESSION["roles"]);
    }

    /*
     *   Cek if ada cookie
     */

    public static function cekDanLoginin ($msg)
    {
        if (!self::isLogged()) {
            global $params;
            if ($params[1] != "logout") {
                self::indexCheckRemember();
            }
            Redirect::index($msg);
        } else {
            Redirect::firstPage();
        }

        return 0;
    }

    /*
     * getCookie
     */

    public static function indexCheckRemember ()
    {
        $row = self::checkRemember();

        //dilogout dulu sebelum di registerin
//        $_SESSION["admin_session"] = 0;
//        session_unset();
//        session_destroy();
//        session_write_close();


//        setcookie(session_name(), '', 0, '/');
//        session_regenerate_id(true);

        if (count($row) > 0) {
            self::login($row);
        }
    }

    /*
     * Full Check, cek apakah logged, kalu tidak, cek cookie, kalau tidak lempar ke luar, kalau 
     * ada cookie, coba logginin
     */

    public static function checkRemember ()
    {
        // if(self::isLogged())return array;
        $rowIDs = self::getCookie();

        return $rowIDs;
    }

    public static function getCookie ()
    {
        $cookieLID = ((isset($_COOKIE['leapID'])) ? $_COOKIE['leapID'] : 0);
        if ($cookieLID > 0) {
            $token = base64_decode($_COOKIE['leapTk']);
            $encypass = base64_decode($_COOKIE['leapPass']);
            $exp = explode("8bCL9", $encypass);
            $username = $_COOKIE['leapName'];
            $password = $exp[0];
            $rememberme = 1;
            //mobile
            $isMobile = Mobile::getCookie();
            Mobile::setMobile($isMobile);
            //lang
            $lang = Lang::getCookie();
            Lang::setLang($lang);
            //dbchooser
            $dbchooser = DbChooser::getCookie();
            DbChooser::setDBChooser($dbchooser);

            $row = array ("admin_username" => $username, "admin_password" => $password, "rememberme" => $rememberme);


            return $row;
        }

        return array ();
    }

    public static function login ($row)
    {
        /*
         * load by Username
         */
        $acc = new Account();
        $acc->fill($row);

        if ($acc->loadByUserLogin()) {
            //login succesfull

            //loading metadata
            $meta = new AccountMeta();
            $meta->getMeta($acc->admin_id);

            //now loading roles
            $acc->loadRole();
            //set cookie
            self::setCookie($acc->rememberme, $acc->admin_id, $acc->admin_username, $acc->admin_password);
            //Redirect::firstPage();
        } else {
            Redirect::loginFailed();
        }
    }

    /*
     * Login Controller
     */

    public static function setCookie ($remember, $id, $username, $pass)
    {
        if ($remember) {
            $token = rand(100, 200) * time();
            setcookie("leapID", $id, time() + 60 * 60 * 24 * 365, '/');
            setcookie("leapName", $username, time() + 60 * 60 * 24 * 365, '/');
            setcookie("leapTk", base64_encode($token), time() + 60 * 60 * 24 * 365, '/');
            setcookie("leapPass", base64_encode($pass . "8bCL9" . $token), time() + 60 * 60 * 24 * 365, '/');
            //mobile cookie
            Mobile::setCookie();
            /// Lang cookie
            Lang::setCookie();
            //db settingnya
            DbChooser::setCookie();
        } else {
            self::unsetAllCookies();
        }
    }

    public static function unsetAllCookies ()
    {
        self::unsetCook("leapID");
        self::unsetCook("leapName");
        self::unsetCook("leapTk");
        self::unsetCook("leapPass");
    }

    protected static function unsetCook ($cookiename)
    {
        if (isset($_COOKIE[$cookiename])) {
            unset($_COOKIE[$cookiename]);
            setcookie($cookiename, null, -1, '/');

            return true;
        } else {
            return false;
        }
    }

    public static function logout ()
    {
        $_SESSION["admin_session"] = 0;
        session_unset();
        session_destroy();
        session_write_close();


        setcookie(session_name(), '', 0, '/');
        session_regenerate_id(true);

        self::unsetCook("leapID");
        self::unsetCook("leapName");
        self::unsetCook("leapTk");
        self::unsetCook("leapPass");

        //pr($_COOKIE);
        Redirect::index("You are now logged out.");
    }
}
