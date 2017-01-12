<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?= $title; ?></title>
	<?= $metaKey; ?>
	<?= $metaDescription; ?>

	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
	      name='viewport'>
	<link href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/css/bootstrap.min.css"
	      rel="stylesheet">
	<link rel="icon"
	      type="image/png"
	      href="<?= _SPPATH; ?>kcfinder/favicon.ico" />
	<!--set all paths as javascript-->
	<? $this->printPaths2JS(); ?>
	<script src="<?= _SPPATH; ?>js/jquery-1.11.1.js"></script>
	<? $this->getHeadfiles(); ?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<?
	//load default css
	Mold::theme("css");
	//PortalTemplate::headercss();
	?>
	<style>
		<?
		 //load custon css
		 echo ThemeReg::mod("custom_css","","text");
		 ?>
	</style>
</head>
<body onload="pullContentPortal();">

<? Mold::theme("afterBodyJS"); ?>
<? Mold::theme("ajaxLoader"); ?>
<? Mold::theme("headerMobile"); ?>
<? Mold::theme("header"); ?>

<div id="holderall"
     class="container">
	<div id="lw_content"></div>

	<div id="content_utama">
		<?= $content; ?>
	</div>
</div>

<? Mold::theme("footer"); ?>
<? ChatMsgWeb::chatpanel(); ?>

<? Mold::theme("modalLoader"); ?>
<!-- Load JS here for greater good =============================-->

<script src="<?= _SPPATH; ?><?= _THEMEPATH; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript"
        src="<?= _SPPATH; ?>js/viel-windows-jquery.js"></script>
<script src="<?= _SPPATH; ?><?= _THEMEPATH; ?>/js/jqueryui.js"></script>
<script>

	/*
	 * pull content
	 */
	var w;
	var anzahlInbox = 0;
	var tstamp = 0;
	var updateInbox = [];
	var maxInboxID = [];

	function pullContentPortal() {
		//loadGroupChatProcess();
		//set default cookie
		//fungsi ini ada di header
		leap_setCookie("active_gid", 0, 1);

		if (typeof(Worker) !== "undefined") {

			if (typeof(w) == "undefined") {

				w = new Worker("<?=_SPPATH;?>webworker_portal.js");

			}
			// w.postMessage({'cmd': 'start', 'maxInboxID': maxInboxID});
			w.onmessage = function (event) {

				// var rres = event.data;
				var hasil = JSON.parse(event.data);
				var reload = 0;
				var mengecil = 0;
				console.log(hasil);

				var aa = parseInt(hasil.totalmsg);
				updateInbox = hasil.updateArr;
				var ts = parseInt(hasil.timestamp);
				if (tstamp != ts)reload = 1;
				tstamp = ts;

				//cek apakah mengurangi
				if (aa < anzahlInbox)mengecil = 1;
				anzahlInbox = aa;
				//$('oktop').fade().fade();

				//document.getElementById("content_utama").innerHTML = document.getElementById("content_utama").innerHTML+event.data;
				if (reload) {
					//ada hasil baru
					//lwrefresh("Inbox");
					//$('#jmlEnvBaru').html(aa);
					//$("#envelopebaloon").html(aa);
					$("#envelopebaloon").attr({'data-badge': aa});

					if (aa < 1) {
						$("#envelopebaloon").hide();
					}
					else {
						$("#envelopebaloon").fadeIn();
					}
					resetBadges();
					// if(!mengecil){
					//update link diatas
					//$('#envelopeul').load('<?=_SPPATH;?>Inboxweb/fillEnvelope');
					//update window chat..\
					//var apaperludiulang = 0;
					for (var gid in updateInbox) {
						var actual_gid = gid;
						var open_gid = chatleap_getCookie("active_gid");
						//chatleap_setCookie("active_gid",'<?=$gr->group_id;?>',1);
						if (actual_gid == open_gid) {
							//lwrefresh("groupchat");
							/*$.get('
							<?=_SPPATH;?>ChatMsgWeb/getLastEntries?latest='+latest_entry+"&gid="+active_gid,function(data){
							 $('#chatboxcontainer').append(data);
							 scroll2Bottom();

							 });*/
							$.ajax({
								//timeout: 35000,
								url: '<?=_SPPATH;?>ChatMsgWeb/getLastEntries?latest=' + latest_entry + "&gid=" + active_gid,
								success: function (data) {
									$('#chatboxcontainer').append(data);
									scroll2Bottom();
								},
								global: false     // this makes sure ajaxStart is not triggered
								//dataType: 'json',
								//complete: longpoll
							});
						}
						else {
							//yg pasti kalau gidnya blm ada hrs di load baru...
							pos = jQuery.inArray(gid, loaded_gid);
							if (pos >= 0) {
								$(".gg_icon_" + gid).attr({'data-badge': updateInbox[gid]});
								$(".gg_icon_" + gid).show();
								//$(".gg_icon_"+gid).html(updateInbox[gid]);
							} else {
								//kalo blom ada di load lagi..
								alreadyLoad = 0;
								loadGroupChatProcess();
								//apaperludiulang = 1;
							}
						}
					}

					//}
				}

			};

		}

		else {
			console.log("Sorry, your browser does not support Web Workers...");
		}
	}

	function zugeklappt() {

	}

	function resetBadges() {
		if (loaded_gid !== undefined)
			for (var gid in loaded_gid) {

				$(".gg_icon_" + gid).attr({'data-badge': ''});
				$(".gg_icon_" + gid).hide();
				//$(".gg_icon_"+gid).html(updateInbox[gid]);

			}
	}
</script>
<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-57533726-1', 'auto');
	ga('send', 'pageview');

</script>
<? $this->getLastBodyFiles(); ?>
<? BLogger::addLog();?>
</body>
</html>