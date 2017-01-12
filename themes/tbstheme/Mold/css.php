<style>
    body {
        font-family: verdana;
        <?         
        $bgcolor = ThemeReg::mod("bodybg", "#ffffff","color"); 
        $bgimage = ThemeReg::mod("bodybgimage", "","image"); 
        $strbgimage = '';
        if($bgimage!=""){
            $strbgimage = 'background-image: url("'.$bgimage.'"); background-repeat: repeat;
    background-attachment: fixed;';
        }
        
        ?>
        background: <?=$bgcolor;?>;
        <?=$strbgimage;?>
        
    }

    #mainheader {
        <?         
        $bgitem = ThemeReg::mod("headbg", _SPPATH."images/grass-pattern.jpg","image"); 
        ?>
        background: #209b59 url('<?=$bgitem;?>') repeat-x top left;
        height: 130px;
        width: 100%;
    }

    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-left: 0;
        padding-right: 0;
    }

    h3.portlethead {
        <?         
        $bgcolor = ThemeReg::mod("portlet_headbgcolor", "#038563","color"); 
        $bgimage = ThemeReg::mod("portlet_headbg", _SPPATH._THEMEPATH."/images/h3bg2.jpg","image"); 
        $strbgimage = '';
        if($bgimage!=""){
            $strbgimage = 'background-image: url("'.$bgimage.'");';
        }
        
        ?>
        background: <?=$bgcolor;?>;
        <?=$strbgimage;?>
        <?         
        //$bgitem2 = ThemeReg::mod("portlet_headbg", _SPPATH._THEMEPATH."/images/h3bg2.jpg","image"); 
        ?>
        //background: #038563 url('<?=$bgitem2;?>') no-repeat top left;
        height: 48px;
        width: 100%;
        padding: 0;
        margin: 0;
        color: white;
        line-height: 48px;
        text-align: right;
        font-family: verdana;
        font-weight: bold;
        font-size: 20px;
        letter-spacing: 2px;
    }

    h3.portlethead .rb {
        margin-right: 10px;
    }

    .admin-button {
        text-align: center;
        position: absolute;
        z-index: 1;
        right: 100px;
        top: 0px;
        padding-left: 10px;
        padding-right: 10px;
        height: 30px;
        line-height: 30px;
        color: white;
        background-color: #2e7d67;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }
    .admin-button2 {
        text-align: center;
        //position: absolute;
        //z-index: 1;
        //right: 100px;
        //top: 0px;
        padding-left: 10px;
        padding-right: 10px;
        height: 30px;
        line-height: 30px;
        <?
        $admintextcolor = ThemeReg::mod("admin_textcolor", "#ffffff","color");
        ?>
        color: <?=$admintextcolor;?>;
        <?
        $adminbgcolor = ThemeReg::mod("admin_bgcolor", "#2e7d67","color");
        ?>
        background-color: <?=$adminbgcolor;?>;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .navbar-default {
        <?
        $bgcolor = ThemeReg::mod("mobile_headbgcolor", "#038563","color");
        ?>
        background: <?=$bgcolor;?>;
        border: 0px;
    }

    .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
        background: none;
    }

    .navbar-default .navbar-nav > li > a {
        <?
        $bgcolor = ThemeReg::mod("mobile_headtextcolor", "#fff","color");
        ?>
        color: <?=$bgcolor;?>;
        font-size: 15px;
        font-family: 'Open Sans', sans-serif;
        letter-spacing: 2px;
    // font-weight : bold;
        font-style: italic;
    }

    .navbar-custom .nav li a {
        text-transform: none;
        font-weight: normal;
    }

    .navbar-default .navbar-nav > li > a:hover {
        text-decoration: underline;
        color: white;
    }

    .navbar-default .navbar-toggle, .navbar-default .navbar-collapse,
    .navbar-default .navbar-form,
    .navbar-default .navbar-toggle .icon-bar {
        border-color: #e5d3ab;
        color: #e5d3ab;

    }

    
     //  menu and stuffs
    .mainmenutbs {
        background-color: #e8e9d7;
        height: 30px;
        width: 100%;
    }

    .topmenu {
        float: left;
        height: 30px;
        line-height: 30px;
        padding-left: 30px;
        padding-right: 30px;
        text-align: center;
    }

    .topmenu a {
        <?
        $topacolor = ThemeReg::mod("topmenu_acolor", "#7e7e7e","color");
        ?>
        color: <?=$topacolor;?>;
    // text-decoration : underline;
    }

    .topmenu:hover {
        <?
        $tophoverbgcolor = ThemeReg::mod("topmenu_hover_bgcolor", "#e1e5a9","color");
        ?>
        background-color: <?=$tophoverbgcolor;?>;
    }

    .topmenu:hover a {
        <?
        $tophovertextcolor = ThemeReg::mod("topmenu_hover_textcolor", "#ffffff","color");
        ?>
        color: <?=$tophovertextcolor;?>;
    }

    .topmenu_active {
        <?
        $topactivebgcolor = ThemeReg::mod("topmenu_active_bgcolor", "#939941","color");
        ?>
        background-color: <?=$topactivebgcolor;?>;
    }

    .topmenu_active a {
        <?
        $topactiveacolor = ThemeReg::mod("topmenu_active_textcolor", "#fff","color");
        ?>
        color: <?=$topactiveacolor;?>;
        text-decoration: none;
    }

    h1.tbsh1 {
        font-size: 24px;
        color: #2e7d67;
    }

    .ads {
        margin-bottom: 5px;
    }

    /* footer*/
    #footer {
        <?
        $footbgcolor = ThemeReg::mod("footer_bgcolor", "#ffffff","color");
        ?>
        background-color: <?=$footbgcolor;?>;
        <?         
        //$bgcolor = ThemeReg::mod("portlet_headbgcolor", "#038563","color"); 
        $bgimage = ThemeReg::mod("footer_bg",'',"image"); 
        $strbgimage = '';
        if($bgimage!=""){
            $strbgimage = 'background-image: url("'.$bgimage.'"); background-repeat: repeat-x;
    background-attachment: fixed;';
        }
        
        ?>
        
        <?=$strbgimage;?>
        color: #494c05;
        margin-top: 20px;
        
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .bottom {

    // bottom : 0 px;
    // left : 0 px;
        background: #494c05 url('<?=_SPPATH;?>images/bottom3.jpg') repeat-x top left;
    // position : absolute;
        width: 100%;
        padding-bottom: 10px;
        padding-top: 10px;
    }

    .bottom a {
        color: #494c05;
    }

    .sosmed2 img {
        width: 30px;
        cursor: pointer;
        /* IE 8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)";

        /* IE 5-7 */
        filter: alpha(opacity=60);

        /* Netscape */
        -moz-opacity: 0.6;

        /* Safari 1.x */
        -khtml-opacity: 0.6;
        opacity: 0.6;
    }

    .sosmed2 img:hover {

    }

    .alamat {
        font-family: 'Open Sans', sans-serif;
        font-size: 12px;
        letter-spacing: 2px;
        color:#494c05;
        
    }

    .singkatan {
        font-family: 'Open Sans', sans-serif;
        font-style: italic;
        font-size: 16px;

        color: #494c05;
        letter-spacing: 2px;
    }
    
    h1{
        font-size: 30px;
        color:#4c4e18;
        
    }
    .breadcrumbs{
        padding-top: 10px;
        color: #494c05;
        padding-bottom: 10px;
    }
    /*media*/
    @media (max-width: 768px) {

        .monly {
            display: initial;
        }

        .donly {
            display: none;
        }

        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        h1,h1.tbsh1 {
            margin-top: 70px;

        }
        .breadcrumbs{
        padding-top: 60px;
        
        }
    }

    @media (min-width: 768px) {
        .monly {
            display: none;
        }

        .donly {
            display: initial;
        }
    }

    @media (max-width: 992px) {

    }

</style>
<style type="text/css">
        .fotomurid_wall {
            width: 55px;
            height: 55px;
            overflow: hidden;
            float: left;
            margin-left: 20px;
        }

        .namamuridwall {
            margin-left: 10px;
            float: left;
        }

        .namamuridwallname {
            font-weight: bold;
            color: #666666;
        }

        .namamuridwalldate {
            font-style: italic;
            color: #999999;
        }

        .wallpicked {
            background-color: #fff;
            color: #999999;
        }

        .wallnotpicked {
            background-color: #ccc;
            color: #fff;
        }

        .wallfoto {
            width: 200px;
            height: 200px;
            overflow: hidden;
            float: left;
        }

        .walltext {
            clear: both;
        }

        .fotocontainer {
            margin-bottom: 10px;
        }
        #lw_content{
            margin-top: 20px;
        }
</style>   
