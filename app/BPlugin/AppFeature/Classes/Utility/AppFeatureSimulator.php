<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/26/16
 * Time: 9:10 PM
 */

class AppFeatureSimulator {

    function make(){

        $selectedFeature = ZAppFeature::selectedFeature();
        $homePage = $selectedFeature[0];

        ?>
        <div id="navigator" >
            <a href="<?=_SPPATH;?>myapps">back to myapps</a> <span class="glyphicon glyphicon-backward"></span>
        </div>
        <div class="monly" >
            <div class="alert alert-danger" role="alert" style="margin: 15px;">
                Please edit using desktop to benefit using App Simulator.
            </div>
        </div>
        <div class="bgblur" style="display: none;"></div>
        <div class="attop container" >
        <div class="col-md-6 col-md-offset-1"  >

            <div class="begin">
                <!-- class="nav nav-pills nav-wizard" -->
                <ul class="nav nav-tabs">
                    <li class="active" >
                        <a  href="#page_feat" data-toggle="tab"><span class="glyphicon glyphicon-th"></span>  Features</a>

                    </li>
                    <li >

                        <a  href="#page_themes" data-toggle="tab"><span class="glyphicon glyphicon-tint"></span> Themes</a>

                    </li>
                    <li >

                        <a  href="#page_details" data-toggle="tab"><span class="glyphicon glyphicon-phone"></span> Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="page_feat">
                        <?
                            AppPageFeat::page();
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="page_themes">
                        <?
                        AppTheme::page();
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="page_details">
                        <? AppDetails::page();?>
                    </div>

                </div>

                <script>
                    // handle on tab move
                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                        console.log(e.target); // newly activated tab
                        console.log(e.relatedTarget); // previous active tab

                        var dari = $(e.relatedTarget).attr('href');
                        var dest = $(e.target).attr('href');
                        console.log(dest);

                        if(dest == "#page_details"){
                            $('#app_desktop').show();
                            $('#isiapp').hide();
                            $('#mfooter').hide();
                            $('.menubatterei').hide();
                        }else{

                            $('#app_desktop').hide();
                            $('#isiapp').show();
                            $('#mfooter').show();
                            $('.menubatterei').show();
                        }

                        if(dari == "#page_themes"){
                            //save
                            saveColors();
                        }

                        if(dari == "#page_details"){
                            //save
                            saveAppDetails(0);
                        }
                    });
                </script>

            </div>
            <div class="clearfix" style="padding-bottom: 28px;"></div>
        </div>
        <div class="col-md-5 donly">

            <? AppSimulator::page(); ?>
        </div>

        <div class="clearfix"></div>
        </div>
        <!-- above BGBlur -->
        <?
//        pr($_SESSION['ZAppFeature']);

//        pr($_SESSION['FeatureSessionLayer']);

        global $modalReg;
        $modalReg->printAboveBGBlur();
    }
} 