var selected_page = '', beforepage = '';
var all_lws = [];
var all_lws_mustupdate = [];
var num_lws = 0;
var maxzIndex = 100;
var heitsisa;
var lwhistory = [];

function setUpLW() {
    console.log($('lw_content').position());
    console.log($(window).size());
    console.log($('lw_content').size());
    console.log($('lw_content').position().y);
    console.log($('lw_content').size().y);
    heitsisa = (($(window).size().y - $('lw_content').position().y) - 10);
    $('lw_content').setStyle({height: (($(window).size().y - $('lw_content').position().y) - 10) + 'px'});

}
function openLw(lid, url, ani) {
    // cek if 
    beforepage = selected_page;
    var len = all_lws.length;
    for (key = 0; key < len; key++) {
        if (lid == all_lws[key].lid) {
            // you got matched, no load needed

            selected_page = lid;
            lwhistory.push(lid);
            if (all_lws[key].urls != url)
                all_lws[key].maxreload(url, ani);
            else
                all_lws[key].max(ani);
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
}

function Lw(lid, urls, ani) { //leap window
    this.lid = lid;
    this.urls = urls;
    this.ani = ani;
    $('lw_content').insert('<div class="leap_window" id="' + lid + '" style="display:none;"><div class="leap_window_border"><div class="leap_window_header"><div style="cursor:pointer;" onclick="lwclose(\'' + lid + '\');" id="close_button_' + lid + '" class="irc_cb" ><img src="/mhssd/images/fin_close.png" height="16px" style="margin-top:3px;" /></div><div style="cursor:pointer;" onclick="lwrefresh(\'' + lid + '\');" id="ref_button_' + lid + '" class="irc_cb" ><img src="/mhssd/images/fin_refresh.png" height="16px" style="margin-top:3px;"/></div></div><div id="' + lid + '_content" class="leap_content"><div id="' + lid + '_contentdlm" class="leap_contentdlm"></div></div></div></div>', 'top');
    $(lid + '_contentdlm').load(urls, {
        spinner: $('loadingtop'),
        onSuccess: function () {

            var z = startZindexLw++;
            maxzIndex = z;
            // kurang set posisi x,y awal
            $(lid).setStyle({height: heitsisa + 'px', zIndex: z});
            $(lid + '_content').setStyle({height: (heitsisa - 25) + 'px'});
            if (ani == 'right')
                $(lid).slide('in', {direction: 'right'});
            else if (ani == 'left')
                $(lid).slide('in', {direction: 'left'});
            else if (ani == 'bottom')
                $(lid).slide('in', {direction: 'bottom'});
            else if (ani == 'top')
                $(lid).slide('in');
            else
                $(lid).fade('in');

            hideLW();
            //$(lid).show();
            //var draggable = new Draggable(lid,{range:'lw_content'});
        }
    });
}

Lw.prototype.max = function (ani) {
    //show dulu
    $('loadingtop').fade().fade();
    var lid = this.lid;
    if (ani == 'right')
        $(lid).slide('in', {direction: 'right'});
    else if (ani == 'left')
        $(lid).slide('in', {direction: 'left'});
    else if (ani == 'bottom')
        $(lid).slide('in', {direction: 'bottom'});
    else if (ani == 'top')
        $(lid).slide('in');
    else
        $(lid).fade('in');
    hideLW();
    var z = startZindexLw++;
    maxzIndex = z;
    // kurang set posisi x,y awal
    $(this.lid).setStyle({height: heitsisa + 'px', zIndex: z});
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
    $(lid + '_contentdlm').load(urls, {
        spinner: "loadingtop",
        onSuccess: function () {

            var z = startZindexLw++;
            maxzIndex = z;
            // kurang set posisi x,y awal
            $(lid).setStyle({height: heitsisa + 'px', zIndex: z});
            $(lid + '_content').setStyle({height: (heitsisa - 25) + 'px'});
            /* if(ani == 'right')
             $(lid).slide('in',  {direction: 'right'});
             else if(ani == 'left')
             $(lid).slide('in',  {direction: 'left'});
             else if(ani == 'bottom')
             $(lid).slide('in',  {direction: 'bottom'});
             else if(ani == 'top')
             $(lid).slide('in');
             else
             $(lid).fade('in');
             hideLW();*/
        }
    });
}
Lw.prototype.maxreload = function (urls, ani) {
    var lid = this.lid;
    this.urls = urls;
    $(lid + '_contentdlm').load(urls, {
        spinner: $('loadingtop'),
        onSuccess: function () {

            var z = startZindexLw++;
            maxzIndex = z;
            // kurang set posisi x,y awal
            $(lid).setStyle({height: heitsisa + 'px', zIndex: z});
            $(lid + '_content').setStyle({height: (heitsisa - 25) + 'px'});
            if (ani == 'right')
                $(lid).slide('in', {direction: 'right'});
            else if (ani == 'left')
                $(lid).slide('in', {direction: 'left'});
            else if (ani == 'bottom')
                $(lid).slide('in', {direction: 'bottom'});
            else if (ani == 'top')
                $(lid).slide('in');
            else
                $(lid).fade('in');
            hideLW();
            //$(lid).show();
            //var draggable = new Draggable(lid,{range:'lw_content'});
        }
    });

    //show dulu
    /*   $('loadingtop').fade().fade();
     $(this.lid).fade('in');
     hideLW();
     var z = startZindexLw++;
     maxzIndex = z;
     // kurang set posisi x,y awal
     $(this.lid).setStyle({height: heitsisa+'px',zIndex:z});*/
}

function hideLW() {
    var len = all_lws.length;
    for (key = 0; key < len; key++) {
        if (selected_page == all_lws[key].lid) {
            // you got matched, no load needed
            // all_lws[key].max();
            // selected_page = lid;
            // return 1;
        } else {
            //hide all others
            all_lws[key].sendBack();
        }
    }
}
function lwclose(lid) {
    var len = lwhistory.length;
    if (len > 0) {
        lwhistory.pop();
        len = lwhistory.length;
        if (len > 0) {
            len--;
            $(lwhistory[len]).show();
            selected_page = lwhistory[len];
        }
    }
    /*if(beforepage != ''){
     selected_page = beforepage;
     $(beforepage).show();
     }*/
    $(lid).fade('out');
}

Lw.prototype.min = function () {
    // kurang set posisi x,y awal
    $(this.lid).setStyle({height: ($(window).size().y - $(this.lid).position().y) + 'px'});
}

Lw.prototype.sendBack = function () {
    // kurang set posisi x,y awal
    $(this.lid).hide();
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
var startzindex = 1000000000;
var startZindexLw = 1000000;

function openpopLw(event, lid, url) {
    // cek if 
    var x = event.clientX
    var y = event.clientY
    var z = startzindex + 1000;
    $('loadingtop').setStyle({zIndex: z});
    $('oktop').setStyle({zIndex: z});

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
    $('lw_content').insert('<div class="popleap_window" id="' + lid + '" style="display:none;"><div class="popleap_window_border"><div class="popleap_window_header"><div style="cursor:pointer;" onclick="poplwclose(\'' + lid + '\');" id="close_button_' + lid + '" >close</div></div><div id="' + lid + '_content" class="popleap_content"><div id="' + lid + '_contentdlm" class="popleap_contentdlm"></div></div></div></div>', 'top');
    if (urls != 'local')$(lid + '_contentdlm').load(urls, {
        spinner: $('loadingtop'),
        onSuccess: function () {

            var z = startzindex++;

            // kurang set posisi x,y awal
            var topp = f_scrollTop() + y;
            if (x <= (f_clientWidth() / 2))
                $(lid).setStyle({top: topp + 'px', left: x + 'px', zIndex: z});
            else {
                var rr = f_clientWidth() - x;
                $(lid).setStyle({top: topp + 'px', right: rr + 'px', zIndex: z});
            }
            // $(lid).setStyle({top: f_scrollTop()+y+'px',left:x+'px'});
            //$(lid+'_content').setStyle({height: (heitsisa-25)+'px'});
            $(lid).fade('in');
            //hideLW();
            //$(lid).show();
            //var draggable = new Draggable(lid);
        }
    });
    else {

        $(lid + '_contentdlm').append($(lid + '_pop'));
        $(lid + '_pop').show();
        var z = startzindex++;

        // kurang set posisi x,y awal
        var topp = f_scrollTop() + y;
        if (x <= (f_clientWidth() / 2))
            $(lid).setStyle({top: topp + 'px', left: x + 'px', zIndex: z});
        else {
            var rr = f_clientWidth() - x;
            $(lid).setStyle({top: topp + 'px', right: rr + 'px', zIndex: z});
        }
        $(lid).fade('in');
    }
}

PopLw.prototype.max = function (x, y) {
    //show dulu
    var z = startzindex++;
    var lid = this.lid;
    // kurang set posisi x,y awal
    var topp = f_scrollTop() + y;
    if (x <= (f_clientWidth() / 2))
        $(lid).setStyle({top: topp + 'px', left: x + 'px', zIndex: z});
    else {
        var rr = f_clientWidth() - x;
        $(lid).setStyle({top: topp + 'px', right: rr + 'px', zIndex: z});
    }
    $(lid).fade('in');

    // kurang set posisi x,y awal
    //$(this.lid).setStyle({height: heitsisa+'px',zIndex:z});
}
function poplwclose(lid) {
    $(lid).fade('out');
}

PopLw.prototype.maxreload = function (urls, x, y) {
    var lid = this.lid;
    this.urls = urls;
    this.posx = x;
    this.posy = y;
    $(lid + '_contentdlm').load(urls, {
        spinner: $('loadingtop'),
        onSuccess: function () {
            var z = startZindexLw++;
            maxzIndex = z;
            var topp = f_scrollTop() + y;
            if (x <= (f_clientWidth() / 2))
                $(lid).setStyle({top: topp + 'px', left: x + 'px'});
            else {
                var rr = f_clientWidth() - x;
                $(lid).setStyle({top: topp + 'px', right: rr + 'px'});
            }

            // $(lid).setStyle({top: topp+'px',left:x+'px'});
            $(lid).fade('in');
        }
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