<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/16/16
 * Time: 1:17 PM
 */

class Bridge extends WebApps{

    function makenew(){

        ?>
        <div class="container attop"  >
        <div class="col-md-12">
        <div class="appear_logo_pages">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-apps.png" >
            </a>
        </div>

            <div id="app_form" class="col-md-6 col-md-offset-3" style="padding: 10px;">
                <form id="formreg" class="form-horizontal" role="form">
                    <input type="hidden" name="token" value="14633799056">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="uname">App Name : </label>
                        <div class="col-sm-10">
                            <input name="uname" type="text" class="form-control" id="uname" placeholder="Enter App Name">
                            <div id="uname_err" class="err"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">App Description : </label>
                        <div class="col-sm-10">
                            <textarea name="descr" rows="3" type="text" class="form-control" id="descr" placeholder="Enter Description"></textarea>
                            <div id="descr_err" class="err"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="descr">App Icon : </label>
                        <div class="col-sm-10">
                            <input name="phone" type="tel" class="form-control" id="phone" placeholder="Enter mobile phone">
                            <div id="phone_err" class="err"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button style="width: 100%;" type="submit" class="btn btn-primary btn-appeargreen btn-lg">Submit</button>
                            <div class="back_to_button">
                                <a href="<?=_SPPATH;?>myApps">back to myApps</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    <?
    }

} 