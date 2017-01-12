<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FBUtility
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class FBUtility {
    public static function loadFBJS(){
        Mold::plugin("FacebookLogin", "facebookjs");
    }
    public static function loginbutton(){
        ?>
<div class="tminput" id="fblogin" style="text-align: center;">
             <img onclick="my_fb_login();" style="cursor: pointer;" src="<?=_SPPATH;?>app/BPlugin/FacebookLogin/Images/button.png" width="300px">
</div>
<div class="tminput" id="fbstatus" style="display: none;">
</div> 
<div id="tungguSebentar" style="padding: 10px; display: none;"><h3 class="blink_me">login sukses..<br>harap tunggu sebentar</h3></div>
<?/*
 * <fb:login-button scope="public_profile,email" >
</fb:login-button>

<div id="fbstatus">
</div>
         <div class="tminput" id="fblogin" style="text-align: center;">
             <img onclick="checkLoginState();" style="cursor: pointer;" src="<?=_SPPATH;?>app/BPlugin/FacebookLogin/Images/button.png" width="70%">
             
            
        </div>
<div class="tminput" id="fbstatus" style="display: none;">
    </div>   */
         
    }
}
