var selected_page = '', beforepage = '';
var all_lws = [];
var all_lws_mustupdate = [];
var num_lws = 0;
var maxzIndex = 100;
var heitsisa;
var lwhistory = [];
var array_rte = [];

function setUpLW() {
    console.log($('#lw_content').position());
    console.log($(window).size());
    console.log($('#lw_content').size());
    console.log($('#lw_content').position().y);
    console.log($('#lw_content').size().y);
    heitsisa = (($(window).size().y - $('#lw_content').position().y) - 10);
    $('#lw_content').css({height: (($(window).size().y - $('#lw_content').position().y) - 10) + 'px'});

}
function openLw(lid, url, ani) {
    //alert(url);
    // cek if 
    var mywit = viel_width();

    beforepage = selected_page;

    //tambahan roy utk process history
    //var lw = new Lw(lid, url, ani);
    //selected_page = lid;
    //all_lws.push(lw);
    //lwhistory.push(lid);
    //num_lws++;



    var len = all_lws.length;
    for (key = 0; key < len; key++) {
        if (lid == all_lws[key].lid) {
            // you got matched, no load needed
            //alert("match");
            selected_page = lid;
            lwhistory.push(lid);
            if (all_lws[key].urls != url) {
                //alert("in");
                all_lws[key].maxreload(url, ani);

            }
            else {
                //alert('openlw');
                all_lws[key].max(ani);
            }
            $('#content_utama').hide();
            if (mywit <= 992) {
                //cuman untuk admin LTE themes
                $('.row-offcanvas').removeClass('active');
                $('.left-side').removeClass("collapse-left");
                $(".right-side").removeClass("strech");
                $('.row-offcanvas').removeClass("relative");
                zugeklappt();
            }
//// modify history
            var obj = {'lid': lid, 'url': url, 'ani': ani};
            var title = lid;
            var url = '?st=' + lid;
            history.pushState(obj, title, url);


            return 1;
        } else {
            //hide all others
            //all_lws[key].sendBack();
        }
    }

    var lw = new Lw(lid, url, ani);
    selected_page = lid;
    all_lws.push(lw);
    lwhistory.push(lid);
    num_lws++;

    $('#content_utama').hide();
    if (mywit <= 992) {
        //cuman untuk admin LTE themes
        $('.row-offcanvas').removeClass('active');
        $('.left-side').removeClass("collapse-left");
        $(".right-side").removeClass("strech");
        $('.row-offcanvas').removeClass("relative");
        zugeklappt();
    }
}

function Lw(lid, urls, ani) { //leap window
    this.lid = lid;
    this.urls = urls;
    this.ani = ani;
    //$('#lw_content').append('<div class="col-md-12" id="' + lid + '" style="display:none;"><div class="leap_window_border"><div class="leap_window_header"><div style="cursor:pointer;" onclick="lwclose(\'' + lid + '\');" id="close_button_' + lid + '" class="irc_cb" ><span class="glyphicon glyphicon-remove viel_glyph hidden-print"></span></div><div style="cursor:pointer;" onclick="lwrefresh(\'' + lid + '\');" id="ref_button_' + lid + '" class="irc_cb" ><span  class="glyphicon glyphicon-refresh viel_glyph hidden-print"></span></div></div><div id="' + lid + '_content" class="row"><div id="' + lid + '_contentdlm" class="col-md-12"></div></div></div></div>');
    $('#lw_content').append('<div class="col-md-12 lw_item" id="' + lid + '" style="display:none;"><div class="leap_window_border"><div class="leap_window_header"><div style="cursor:pointer;" onclick="lwrefresh(\'' + lid + '\');" id="ref_button_' + lid + '" class="irc_cb" ><span  class="glyphicon glyphicon-refresh viel_glyph hidden-print"></span></div></div><div id="' + lid + '_content" class="row"><div id="' + lid + '_contentdlm" class="col-md-12"></div></div></div></div>');
    
    $('#' + lid + '_contentdlm').load(urls, function (responseTxt, statusTxt, xhr) {
        if (statusTxt == "success") {
            var z = startZindexLw++;
            maxzIndex = z;
            //unset array for rtes
            //array_rte = [];
            // kurang set posisi x,y awal
            $('#' + lid).css({"height": heitsisa + 'px', "z-index": z});
            $('#' + lid + '_content').css({"height": (heitsisa - 25) + 'px'});
            $('#' + lid).fadeIn();
            hideLW();
            
            //ani scrollbottom mainly for chat
            if(ani == "scrollBottom")
                viel_scroll2Bottom();
            //// modify history
            var obj = {'lid': lid, 'url': urls, 'ani': ani};
            var title = lid;
            var url = '?st=' + lid;
            history.pushState(obj, title, url);
        }
        if (statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
}

Lw.prototype.max = function (ani) {
    //show dulu
    //$('#loadingtop').fade().fade();
    var lid = this.lid;
    $('#' + lid).fadeIn();
    hideLW();
    var z = startZindexLw++;
    maxzIndex = z;
    // kurang set posisi x,y awal
    $('#' + this.lid).css({"height": heitsisa + 'px', "z-index": z});
    // modify history
    var obj = {'lid': this.lid, 'url': this.urls, 'ani': this.ani};
    var title = this.lid;
    var url = '?st=' + this.lid;
    history.replaceState(obj, title, url);
    
    //ani scrollbottom mainly for chat
    if(ani == "scrollBottom")
        viel_scroll2Bottom();
}
function lwrefresh(lid) {
    var len = all_lws.length;
    for (key = 0; key < len; key++) {
        if (lid == all_lws[key].lid) {
            // you got matched, no load needed


            all_lws[key].refreshe(all_lws[key].urls, all_lws[key].ani);
            
            return 1;
        } else {
            //hide all others
            //all_lws[key].sendBack();
        }
    }
}
Lw.prototype.refreshe = function (urls, ani) {
    var lid = this.lid;
    this.urls = urls;
    $('#' + lid + '_contentdlm').load(urls, function (responseTxt, statusTxt, xhr) {
        if (statusTxt == "success") {
            var z = startZindexLw++;
            maxzIndex = z;
            //unset array for rtes
            //array_rte = [];
            
            // kurang set posisi x,y awal
            $('#' + lid).css({"height": heitsisa + 'px', "z-index": z});
            $('#' + lid + '_content').css({"height": (heitsisa - 25) + 'px'});
            //ani scrollbottom mainly for chat
            if(ani == "scrollBottom")
                viel_scroll2Bottom();
        }
        if (statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);

    });
}
Lw.prototype.maxreload = function (urls, ani) {
    var lid = this.lid;
    this.urls = urls;
    //alert(urls);
    $('#' + lid + '_contentdlm').load(urls, function (responseTxt, statusTxt, xhr) {
        if (statusTxt == "success") {
            var z = startZindexLw++;
            maxzIndex = z;
            //unset array for rtes
            //array_rte = [];
            // kurang set posisi x,y awal
            $('#' + lid).css({"height": heitsisa + 'px', "z-index": z});
            $('#' + lid + '_content').css({"height": (heitsisa - 25) + 'px'});
            $('#' + lid).fadeIn();
            hideLW();
            // modify history
            var obj = {'lid': lid, 'url': urls, 'ani': ani};
            var title = lid;
            var url = '?st=' + lid;
            history.replaceState(obj, title, url);
            
            //ani scrollbottom mainly for chat
            if(ani == "scrollBottom")
                viel_scroll2Bottom();
        }
        if (statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
    });

}

function hideLW() {
    var len = all_lws.length;
    for (key = 0; key < len; key++) {
        if (selected_page == all_lws[key].lid) {

        } else {
            //hide all others
            all_lws[key].sendBack();
        }
    }
}

function hideAllLW() {
    var len = all_lws.length;
    for (key = 0; key < len; key++) {

        all_lws[key].sendBack();

    }
    $('#content_utama').fadeIn();
}
function lwclose(lid) {

    //lwclr();

    var len = lwhistory.length;
    if (len > 0) {
        lwhistory.pop();
        len = lwhistory.length;
        if (len > 0) {
            len--;
            $('#' + lwhistory[len]).show();
            selected_page = lwhistory[len];
        }
        else {
            //ini dulunya
            $('#content_utama').show();
            //edit roy 29 nov 2016
            //lwclr();
        }
    }


    /*if(beforepage != ''){
     selected_page = beforepage;
     $(beforepage).show();
     }*/
    $('#' + lid).fadeOut();
}
function lwclr() {

    //$("body").addClass("sidebar-collapse");
    $('.lw_item').fadeOut();
    $('#content_utama').fadeIn();
    window.scrollTo(0, 0);

    //var obj = {'lid': 'home', 'url': '/home', 'ani': 'fade'};
    //var title = 'home';
    //var url = '?st=';
    //history.pushState(obj, title, url);
}

function lwshow() {

    $("body").removeClass("sidebar-collapse");
    //$('.lw_item').fadeOut();
    //$('#content_utama').fadeIn();
}
Lw.prototype.min = function () {
    // kurang set posisi x,y awal
    $(this.lid).setStyle({height: ($(window).size().y - $(this.lid).position().y) + 'px'});
}

Lw.prototype.sendBack = function () {
    // kurang set posisi x,y awal
    $('#' + this.lid).hide();
}

Lw.prototype.bringFront = function () {
    // kurang set posisi x,y awal
    $(this.lid).setStyle({height: ($(window).size().y - $(this.lid).position().y) + 'px'});
}

Lw.prototype.restoreDown = function () {
    // kurang set posisi x,y awal
    $(this.lid).setStyle({height: ($(window).size().y - $(this.lid).position().y) + 'px'});
}

var selected_poppage = '';
var all_poplws = [];
var num_poplws = 0;
var poplwhistory = [];
var startzindex = 100;
var startZindexLw = 10;

function openpopLw(event, lid, url) {
    // cek if 
    var x = event.clientX
    var y = event.clientY
    var z = startzindex + 1000;
    //$('loadingtop').setStyle({zIndex: z});
    //$('oktop').setStyle({zIndex: z});

    var len = all_poplws.length;
    for (key = 0; key < len; key++) {
        if (lid == all_poplws[key].lid) {
            // you got matched, no load needed

            selected_poppage = lid;
            poplwhistory.push(lid);
            if (all_poplws[key].urls != url)
                all_poplws[key].maxreload(url, x, y);
            else
                all_poplws[key].max(x, y);
            return 1;
        } else {
            //hide all others
            //all_lws[key].sendBack();
        }
    }

    var lw = new PopLw(lid, url, x, y);
    selected_poppage = lid;
    all_poplws.push(lw);
    poplwhistory.push(lid);
    num_poplws++;
}

function PopLw(lid, urls, x, y) { //leap pop window
    this.lid = lid;
    this.posx = x;
    this.posy = y;
    this.urls = urls;
    $('#lw_content').append('<div class="popleap_window" id="' + lid + '" style="display:none;"><div class="popleap_window_border"><div class="popleap_window_header"><div style="cursor:pointer;" onclick="poplwclose(\'' + lid + '\');" id="close_button_' + lid + '" >close</div></div><div id="' + lid + '_content" class="popleap_content"><div id="' + lid + '_contentdlm" class="popleap_contentdlm"></div></div></div></div>');
    if (urls != 'local')
       $('#' + lid + '_contentdlm').load(urls, function (responseTxt, statusTxt, xhr) {
            if (statusTxt == "success") {
                var z = startZindexLw++;
                maxzIndex = z;
                // kurang set posisi x,y awal
                var topp = f_scrollTop() + y;
                if (x <= (f_clientWidth() / 2))
                    $('#'+lid).css({top: topp + 'px', left: x + 'px', zIndex: z});
                else {
                    var rr = f_clientWidth() - x;
                    $('#'+lid).css({top: topp + 'px', right: rr + 'px', zIndex: z});
                }
            }
            if (statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
     else {

        $('#'+lid + '_contentdlm').append($('#'+lid + '_pop'));
        $('#'+lid + '_pop').show();
        var z = startzindex++;

        // kurang set posisi x,y awal
        var topp = f_scrollTop() + y;
        if (x <= (f_clientWidth() / 2))
            $('#'+lid).css({top: topp + 'px', left: x + 'px', zIndex: z});
        else {
            var rr = f_clientWidth() - x;
            $('#'+lid).css({top: topp + 'px', right: rr + 'px', zIndex: z});
        }
        $('#'+lid).fade('in');
    }
    
    
}

PopLw.prototype.max = function (x, y) {
    //show dulu
    var z = startzindex++;
    var lid = this.lid;
    // kurang set posisi x,y awal
    var topp = f_scrollTop() + y;
    if (x <= (f_clientWidth() / 2))
        $('#'+lid).css({top: topp + 'px', left: x + 'px', zIndex: z});
    else {
        var rr = f_clientWidth() - x;
        $('#'+lid).css({top: topp + 'px', right: rr + 'px', zIndex: z});
    }
    $('#'+lid).fadeIn();

    // kurang set posisi x,y awal
    //$(this.lid).setStyle({height: heitsisa+'px',zIndex:z});
}
function poplwclose(lid) {
    $('#'+lid).fadeOut();
}

PopLw.prototype.maxreload = function (urls, x, y) {
    var lid = this.lid;
    this.urls = urls;
    this.posx = x;
    this.posy = y;
    $('#' + lid + '_contentdlm').load(urls, function (responseTxt, statusTxt, xhr) {
            if (statusTxt == "success") {
                var z = startZindexLw++;
                maxzIndex = z;
                // kurang set posisi x,y awal
                var topp = f_scrollTop() + y;
                if (x <= (f_clientWidth() / 2))
                    $('#'+lid).css({top: topp + 'px', left: x + 'px', zIndex: z});
                else {
                    var rr = f_clientWidth() - x;
                    $('#'+lid).css({top: topp + 'px', right: rr + 'px', zIndex: z});
                }
            }
            if (statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
    
}
function f_scrollLeft() {
    return f_filterResults(
        window.pageXOffset ? window.pageXOffset : 0,
        document.documentElement ? document.documentElement.scrollLeft : 0,
        document.body ? document.body.scrollLeft : 0
    );
}
function f_scrollTop() {
    return f_filterResults(
        window.pageYOffset ? window.pageYOffset : 0,
        document.documentElement ? document.documentElement.scrollTop : 0,
        document.body ? document.body.scrollTop : 0
    );
}

function f_filterResults(n_win, n_docel, n_body) {
    var n_result = n_win ? n_win : 0;
    if (n_docel && (!n_result || (n_result > n_docel)))
        n_result = n_docel;
    return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

function f_clientWidth() {
    return f_filterResults(
        window.innerWidth ? window.innerWidth : 0,
        document.documentElement ? document.documentElement.clientWidth : 0,
        document.body ? document.body.clientWidth : 0
    );
}
function f_clientHeight() {
    return f_filterResults(
        window.innerHeight ? window.innerHeight : 0,
        document.documentElement ? document.documentElement.clientHeight : 0,
        document.body ? document.body.clientHeight : 0
    );
}

function viel_width() {
    return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
}
function viel_height() {
    return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
}


var $loading = $('#loadingtop').hide();
$(document)
    .ajaxStart(function () {
        $loading.show();
    })
    .ajaxStop(function () {
        $loading.hide();
    });

var blink = function () {
    $('.blink_me').fadeOut().fadeIn();
};
$(document).ready(function () {
    setInterval(blink, 500);
});

// back/forward hit
window.addEventListener("popstate", function (e) {

    /*
    check di history apa sudah ada, kalau sudah brati show page, kalau blom brati new page,
    kalau show masukin ke history browser
     */

    lwclose(selected_page);
    /*
    // console.log(e);
    // state
    var state = e.state;
    console.log(state);
    console.log(history);
    // lwrefresh(state.lid);
    // lwclose(state.lid);
    openLw(state.lid, state.url, state.ani);
    //console.log(location.pathname);
    //console.log(location);
    //LogEvent("Location: " + document.location + ", state: " + JSON.stringify(e.state))
    //alert('change');*/
});
function viel_scroll2Bottom(){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    }
/* hhhhh
 * untuk hilangkan garis 3 di nav toggle
 * 
 $( document ).ready(function() {
 // Handler for .ready() called.
 var mywit = viel_width();
 if(mywit <= 992){
 $('#toggleNav').show();
 }
 else
 $('#toggleNav').hide();
 });

 $( window ).resize(function() {
 var mywit = viel_width();
 if(mywit <= 992){
 $('#toggleNav').show();
 }
 else
 $('#toggleNav').hide();
 });
 */

function winBaru4ByPass(id,loc,ani){
    openLw(id,loc,ani);
}

//highlighter

$.fn.highlight = function(what,spanClass) {
    return this.each(function(){
        var container = this,
            content = container.innerHTML,
            pattern = new RegExp('(>[^<.]*)(' + what + ')([^<.]*)','g'),
            replaceWith = '$1<span ' + ( spanClass ? 'class="' + spanClass + '"' : '' ) + '">$2</span>$3',
            highlighted = content.replace(pattern,replaceWith);
        container.innerHTML = highlighted;
    });
}

function highlight(container,what,spanClass) {
    var content = container.innerHTML,
        pattern = new RegExp('(>[^<.]*)(' + what + ')([^<.]*)','g'),
        replaceWith = '$1<span ' + ( spanClass ? 'class="' + spanClass + '"' : '' ) + '">$2</span>$3',
        highlighted = content.replace(pattern,replaceWith);
    return (container.innerHTML = highlighted) !== content;
}