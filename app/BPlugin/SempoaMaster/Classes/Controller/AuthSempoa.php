<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/23/17
 * Time: 2:01 PM
 */
class AuthSempoa extends Auth
{


    public static function loginSempoaIBO($row)
    {
        /*
         * load by Username
         */

        $acc = new SempoaAccount();
        $acc->fill($row);
        if ($acc->loadByUserLoginIBO($acc->admin_id)) {
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


    public static function logoutSempoa ()
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

    }
}