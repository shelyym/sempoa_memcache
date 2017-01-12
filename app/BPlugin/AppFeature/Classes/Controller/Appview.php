<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 1:15 PM
 */

class Appview extends WebApps{

    function edit(){

        ?>
        <div class="attop container" style="margin-top: 25px" >


            <div class="col-md-6">
               <div class="begin">
                   <h1 class="your_business_header">Tell us about your business</h1>
                   <section id="your_business_fields">


                           <div class="form-group">
                               <label for="bname">What is the name of your business?</label>
                               <input type="text" class="form-control" id="bname" placeholder="Business Name">
                           </div>
                           <div class="form-group">
                               <label for="slogan">What is your slogan? </label>
                               <input type="text" class="form-control" id="slogan" placeholder="Slogan">
                           </div>




                   </section>
                   <section id="feature">
                       <div class="feat">
                           <div class="feat-img">
                           <i class="glyphicon glyphicon-user"></i>
                               </div>
                           <div class="feat-text">
                               Contact
                           </div>
                       </div>
                       <div class="feat">
                           <div class="feat-img">
                           <i class="glyphicon glyphicon-tag"></i>
                               </div>
                           <div class="feat-text">
                               Deals
                           </div>
                       </div>
                       <div class="clearfix"></div>
                   </section>
               </div>
            </div>
            <div class="col-md-6">
                <div style="margin-left: -50px">
                <div class="nexus">
                    <div id="loadingmobile">loading..</div>
                    <div class="menubatterei"></div>

                    <div class="isiapp" id="isiapp">

                    </div>
                    <div class="mfooter" id="mfooter">
                        <div class="mtab mtab-selected" id="tabhome">
                            <div class="mtab-img"><i class="glyphicon glyphicon-apple"></i></div>
                            <div class="mtab-text">home</div>

                        </div>
                        <div class="mtab" id="tabcontact">
                            <div class="mtab-img"><i class="glyphicon glyphicon-pawn"></i></div>
                            <div class="mtab-text">contact</div>

                        </div>
                        <div class="mtab">
                            <div class="mtab-img"><i class="glyphicon glyphicon-lamp"></i></div>
                            <div class="mtab-text">map</div>

                        </div>
                        <div class="mtab">
                            <div class="mtab-img"><i class="glyphicon glyphicon-sunglasses"></i></div>
                            <div class="mtab-text">deals</div>

                        </div>
                        <div class="mtab ">
                            <div class="mtab-img"><i class="glyphicon glyphicon-option-horizontal"></i></div>
                            <div class="mtab-text">more</div>

                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="clearfix"></div>


             </div>
<style>
    .feat{
        float: left;
        width: 100px;
        height: 120px;

    }
    .feat-img{
        margin-left: 10px;
        background-color: #dedede;
        width: 80px;
        height: 80px;
        border-radius: 50px;
        text-align: center;
        font-size: 40px;
        padding-top: 15px;
        color: #999;
    }
    .feat-text{
        width: 100px;
        text-align: center;
    }

    .begin{
        margin-top: 50px;
    }
    .navbar-default{
        background-color: rgba(255,255,255,0.5);
    }
    .nexus{
        width: 422px;
        height: 612px;
        background: url(<?=_SPPATH;?>images/nexus5.png);
        background-size: 422px 612px;
        background-repeat: no-repeat;

        font-family: 'Roboto', sans-serif;
    }
    .menubatterei{
        /*background-color: blue;*/
        width: 271px;
        height: 16px;
        position: relative;
        top: 57px;
        left: 75px;
        overflow: hidden;
        background: url(<?=_SPPATH;?>images/atasbar.png);
        background-size: 271px 16px;
        background-repeat: no-repeat;
    }
    /*.mheader {*/
        /*width: 271px;*/
        /*height: 40px;*/
        /*line-height: 40px;*/
        /*background-color: #000000;*/
        /*color: white;*/
        /*position: relative;*/
        /*top: 57px;*/
        /*left: 75px;*/
        /*overflow: hidden;*/
    /*}*/
    /*#mheadertext,#mslogantext{*/
        /*padding-left: 10px;*/
        /*font-size: 14px;*/
        /*font-family: 'Roboto', sans-serif;*/
    /*}*/
    #mslogantext{
        font-size: 13px;
    }
    .isiapp{
        background-color: #ffff00;
        position: relative;
        top: 57px;
        left: 75px;
        width: 271px;
        height: 425px;
        /*overflow-x: auto;*/
        overflow: hidden;
    }
    #mfooter{
        width: 271px;
        height: 41px;
        line-height: 41px;
        background-color: black;
        position: relative;
        top: 57px;
        left: 75px;
        overflow: hidden;
    }


    .mtab{
        float: left;
        width: 54px;
        height: 40x;
        line-height: 40x;
        text-align: center;
        color: white;
    }
    .mtab-img{
        margin-top: -5px;
    }
.mtab-text{
    margin-top: -25px;
    font-size: 9px;
}
    .mtab-selected{
        background-color: #555555;
        color: white;
    }

    #loadingmobile{
        position: absolute;
        width: 80px;
        height: 80px;
        margin-left:170px;
        margin-top: 240px;
        z-index: 1000;
        background-color: #8fdf82;
    }
</style>
        <script>

            var listOfFeat = [];

            $( document ).ready(function() {
                // Handler for .ready() called.

                $("#isiapp").append($('<div>').load("<?=_SPPATH;?>Appview/mobile"));
                listOfFeat.push("mobile");
            });

            $("#bname").keyup(function(){

                console.log("in1");
                var slc = $("#bname").val();
                $("#mheadertext").html(slc);
                console.log("in2");
            });
            $("#slogan").keyup(function(){

                console.log("in1");
                var slc = $("#slogan").val();
                $("#mslogantext").html(slc);
                console.log("in2");
            });

            $("#tabhome").click(function(){
                $(".mtab").removeClass("mtab-selected");
                $("#tabhome").addClass("mtab-selected");
                $(".mpage").hide();

                if(jQuery.inArray( "mobile", listOfFeat )>-1){
                    $("#m_mobile").show();
                    console.log("gak diload1");
                }else {
                    listOfFeat.push("mobile");
                    $("#isiapp").append($('<div>').load("<?=_SPPATH;?>Appview/mobile"));
                }
            });
            $("#tabcontact").click(function(){
                $(".mtab").removeClass("mtab-selected");
                $("#tabcontact").addClass("mtab-selected");
                $(".mpage").hide();


                if(jQuery.inArray( "contact", listOfFeat )>-1){
                    $("#m_contact").show();
                    console.log("gak diload2");
                }else {
                    listOfFeat.push("contact");
                    $("#isiapp").append($('<div>').load("<?=_SPPATH;?>Appview/contact"));
                }

            });
        </script>
        <?
    }

    function mobile(){

        ?>
        <div class="mpage" id="m_mobile">
        <div class="mheader" id="mheader">
            <div id="mheadertext">Business Name</div>
        </div>
        <div class="mcontent">
        <div class="mbanner" id="mbanner">


            <div class="mslogan" id="mslogan"><div id="mslogantext"></div></div>
            <div class="mlogo" id="mlogo">
            </div>
        </div>

        <div class="mslist">
            <? for($x=0;$x<10;$x++){?>
            <div class="mlist-item">
                <i class="glyphicon glyphicon-phone"></i> &nbsp; 081298291812
            </div>
            <div class="mlist-item">
                <i class="glyphicon glyphicon-book"></i> &nbsp;  Jl Jenderal Sudirman 81
            </div>
            <? } ?>
        </div>
        </div>
        </div>
        <style>
            .mcontent{
                width: 271px;
                height: 385px;
                overflow-x: auto;
            }
            .mcontent::-webkit-scrollbar {
                width: 2px;
            }
            .mcontent::-webkit-scrollbar-button {
                width: 2px;
                height:5px;
            }
            .mcontent::-webkit-scrollbar-track {
                background:#eee;
                border: thin solid lightgray;
                box-shadow: 0px 0px 3px #dfdfdf inset;
                border-radius:10px;
            }
            .mcontent::-webkit-scrollbar-thumb {
                background:#999;
                border: thin solid gray;
                border-radius:10px;
            }
            .isiapp::-webkit-scrollbar-thumb:hover {
                background:#7d7d7d;
            }


            .mheader {
                width: 100%;
                height: 40px;
                line-height: 40px;
                background-color: #000000;
                color: white;

                overflow: hidden;
            }
            #mheadertext,#mslogantext{
                padding-left: 10px;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
            }
            .mbanner{
                width: 100%;
                height: 200px;
                /*background-color: orange;*/
                background: url(<?=_SPPATH;?>images/iphone.jpg);
                background-size: 100% auto;
                background-repeat: repeat;
            }

            .mlogo{
                position: relative;
                width: 80px;
                height: 80px;
                border: 3px solid #dedede;
                background-color: white;
                top: 70px;
                left: 180px;
            }
            .mslogan{
                position: relative;
                top: 160px;
                width: 100%;
                height: 40px;
                line-height: 40px;
                background-color: rgba(0,0,0,0.5);
                color: white;
                /*margin-top: -30px;*/
            }
            .mlist-item{
                height: 50px;
                line-height: 50px;
                padding-left: 10px;
                border-bottom: 1px solid #dedede;
                background-color: white;
            }
        </style>
        <?
        die();
    }

    function contact(){

        ?>
        <div class="mpage" id="m_contact">
            <div class="mheader" id="mheadercontact">
                <div id="mheadertextcontact">Contact</div>
            </div>
        <div class="map">
            Peta peta
        </div>
            </div>

        <?
        die();
    }
} 