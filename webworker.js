var i = 0;

//simple XHR request in pure JavaScript
function load(url, callback) {
    var xhr;

    if (typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest();
    else {
        var versions = ["MSXML2.XmlHttp.5.0",
            "MSXML2.XmlHttp.4.0",
            "MSXML2.XmlHttp.3.0",
            "MSXML2.XmlHttp.2.0",
            "Microsoft.XmlHttp"]

        for (var i = 0, len = versions.length; i < len; i++) {
            try {
                xhr = new ActiveXObject(versions[i]);
                break;
            }
            catch (e) {
            }
        } // end for
    }

    xhr.onreadystatechange = ensureReadiness;

    function ensureReadiness() {
        if (xhr.readyState < 4) {
            return;
        }

        if (xhr.status !== 200) {
            return;
        }

        // all is well
        if (xhr.readyState === 4) {
            callback(xhr);
        }
    }

    xhr.open('GET', url, true);
    xhr.send('');
}


function timedCount() {
    var d = new Date();
    var n = d.getTime();
    //and here is how you use it to load a json file with ajax
    load('webworker/pull?t=' + n, function (xhr) {
        var result = xhr.responseText;
        //var hasil = JSON.parse(result);
        postMessage(result);
        setTimeout("timedCount()", 1000);
    });


    /*
     Xhr.load('inbox/pull?t='+n,{
     onSuccess : function(request){
     //alert("hi");
     var json = request.responseText;
     //alert(json);
     var hasil = JSON.parse(json);
     postMessage(hasil["inbox"]);
     setTimeout("timedCount()",1000);
     }
     });*/
//i = i + 1;
//postMessage(i);
}

timedCount();