<style type="text/css">

    //LEAP WINDOWS
    .leap_window {
        position: absolute;
        z-index: 100;
        width: 100%;
        background-color: #fff;

    }

    .leap_window_header {
        height: 30px;
        text-align: right;
        margin-top: -20px;
    }

    .leap_window_border {
    }

    .leap_content {
        width: 100%;
        overflow: auto;
    }

    .leap_contentdlm {
    }

    .popleap_window {
        min-width: 300px;
        position: absolute;
        z-index: 1000000000000;
        background-color: #AAAAAA;
        color: white;
    }

    .popleap_contentdlm {
        padding: 10px;
        background-color: #fff;
        color: #444;
    }

    .irc_cb {
        height: 30px;
        cursor: pointer;
        float: right;

        width: 20px;
        font-family: cursive;
        font-size: larger;
        line-height: 30px;
    }

    .irc_cb:hover {
        opacity: .5;
    }

    .leap_window h1 {
        margin: 0;
        padding: 0;
        font-size: 1.5em;
        color: #057fd0;
        margin-bottom: 10px;
        padding-left: 20px;
    }

    .viel_glyph {
        color: #AAAAAA;
        font-size: 12px;
    }

    .foto100 {
        width: 100px;
        height: 100px;
        overflow: hidden;
    }

    .foto100 img {
    }

    .foto85 {
        width: 85px;
        height: 85px;
        overflow: hidden;
        float: left;
    }

    /*
    * TABLE FOR CRUD TABLE
    */
    table.standard_table a:link {
        color: #666;
        font-weight: bold;
        text-decoration: none;
    }

    table.standard_table a:visited {
        color: #999999;
        font-weight: bold;
        text-decoration: none;
    }

    table.standard_table a:active,
    table.standard_table a:hover {
        color: #bd5a35;
        text-decoration: underline;
    }

    table.standard_table {

        color: #666;
        font-size: 14px;
        text-shadow: 1px 1px 0px #fff;
        background: #eaebec;
        margin: 10px;
    // border : #ddd 1 px solid;

        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;

        -moz-box-shadow: 0 1px 2px #d1d1d1;
        -webkit-box-shadow: 0 1px 2px #d1d1d1;
        box-shadow: 0 1px 2px #d1d1d1;
    }

    table.standard_table th {
        padding: 11px 15px 12px 15px;
    // border-top : 1 px solid #fafafa;
    // border-bottom : 1 px solid #e0e0e0;

        background: #ededed;
        background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
        background: -moz-linear-gradient(top, #ededed, #ebebeb);
    }

    table.standard_table th:first-child {
        text-align: left;
        padding-left: 20px;
    }

    table.standard_table tr:first-child th:first-child {
        -moz-border-radius-topleft: 3px;
        -webkit-border-top-left-radius: 3px;
        border-top-left-radius: 3px;
    }

    table.standard_table tr:first-child th:last-child {
        -moz-border-radius-topright: 3px;
        -webkit-border-top-right-radius: 3px;
        border-top-right-radius: 3px;
    }

    table.standard_table tr {
        text-align: center;
        padding-left: 20px;
    }

    table.standard_table td:first-child {
        text-align: left;
        padding-left: 20px;
        border-left: 0;
    }

    table.standard_table td {
        padding: 9px;
    // border-top : 1 px solid #ffffff;
    // border-bottom : 1 px solid #e0e0e0;
    // border-left : 1 px solid #e0e0e0;

        background: #fafafa;
        background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
        background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
    }

    table.standard_table tr.even td {
        background: #f6f6f6;
        background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
        background: -moz-linear-gradient(top, #f8f8f8, #f6f6f6);
    }

    table.standard_table tr:last-child td {
        border-bottom: 0;
    }

    table.standard_table tr:last-child td:first-child {
        -moz-border-radius-bottomleft: 3px;
        -webkit-border-bottom-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    table.standard_table tr:last-child td:last-child {
        -moz-border-radius-bottomright: 3px;
        -webkit-border-bottom-right-radius: 3px;
        border-bottom-right-radius: 3px;
    }

    table.standard_table tr:hover td {
        background: #f2f2f2;
        background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
        background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
    }


    .blink_me {
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;

        -moz-animation-name: blinker;
        -moz-animation-duration: 1s;
        -moz-animation-timing-function: linear;
        -moz-animation-iteration-count: infinite;

        animation-name: blinker;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    @-moz-keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }

    @-webkit-keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }

    @keyframes blinker {
        0% {
            opacity: 1.0;
        }
        50% {
            opacity: 0.0;
        }
        100% {
            opacity: 1.0;
        }
    }
</style><?php


