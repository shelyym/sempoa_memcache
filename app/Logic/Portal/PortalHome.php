<?php

/*
 * This is the Logic of the Portal Home
 * Can only contain logic without any db query and html
 */

/**
 * Description of PortalHome
 *
 * @author User
 */
class PortalHome extends WebApps {

	/*
	 * Web View For Index
	 */
	function index ()
	{
		$acc = new AccountLogin();
		$acc->loginForm();
	}

	/*
	 * login webview
	 */
	function login ()
	{
		/*
		 * login logic
		 */
		$acc = new AccountLogin();
		$acc->login_hook = array (
			"PortalHierarchy" => "getSelectedHierarchy",
			"NewsChannel"     => "loadSubscription",
			"Role"            => "loadRoleToSession"
		);

		$acc->process_login();
	}

	/*
	 * Web View For logout
	 */
	function logout ()
	{
		$acc = new AccountLogin();
		$acc->process_logout();
	}


	/*
	 * function to print session
	 * development only
	 */
	//var $access_ses = "master_admin";
	function ses ()
	{
		pr($_SESSION);
                pr($_COOKIE);
	}

	/*
	 * function to create home
	 */
	//to limit access to home
	var $access_home = "normal_user";

	function home ()
	{
		//print_r(PDO::getAvailableDrivers());
		//pr($_SESSION);
		//sebelah kanan
		$arrLeft = array (
			new Portlet("CarouselPortalWeb", "createCarousel"),
			new Portlet("Quotes","printQuote"),
			new Portlet("LeapFacebook","facebookfeed"),
			new Portlet("LeapTwitter","twitterFeed"),
			new Portlet("LeapYoutube","youtubeFeed"),
			new Portlet("VideoWeb","videoFeed"),
                        new Portlet("PopUpWeb","createPopUp")
		);
		$arrRight = array (
			new Portlet("NewsFeedWeb","getFeed"),
			new Portlet("PortalTemplate","printIcons")
		);
		BootstrapUX::twoColoums($arrLeft, $arrRight, 8, 4);
	}
        function testPopUp ()
	{
		$_SESSION['alreadyPopUp'] =  0;
                $_SESSION['testPopUp'] =  1;
		$arrLeft = array (

                        new Portlet("PopUpWeb","createPopUp")
		);
		$arrRight = array (
	//		new Portlet("NewsFeedWeb","getFeed"),
	//		new Portlet("PortalTemplate","printIcons")
		);
		BootstrapUX::twoColoums($arrLeft, $arrRight, 8, 4);
	}
	var $access_newsfeed = "normal_user";

	function newsfeed ()
	{
		//news feed
		NewsFeedWeb::portalIndex();                
	}
        var $access_viewfeed = "normal_user";

	function viewfeed ()
	{
		//news feed
		//NewsFeedWeb::portalIndex();                
                NewsFeedWeb::viewFeed();
	}
	var $access_page = "normal_user";

	function page ()
	{
		//portal
		PageWeb::portalIndex();
	}
        var $access_pagecontainer = "normal_user";

	function pagecontainer ()
	{
		
                PageContainerWeb::portalIndex();
	}
	var $access_mydepartment = "normal_user";

	public function mydepartment ()
	{

		//wall setting is done here
		$org = RoleOrganization::getMy();
		//set the target_id
		$_GET['kelasid'] = $org->organization_id;
		//pr($org);
		if (!isset($_GET['kelasid'])) {
			die("No Target ID");
		}
		//set the target name
		$_GET['type'] = "RoleOrganization";

		$p = new PortalHierarchy();
		$p->departmentPage();
	}

	var $access_myprofile = "normal_user";

	public function myprofile ()
	{
		$al = new AccountLoginWeb();

		$al->myProfile();
	}

	var $access_loadDepartmentWall = "normal_user";

	public function loadDepartmentWall ()
	{
		$n = new WallPortalWeb();

		$_GET['kelasid'] = $_GET['klsid'];
		$_GET['type'] = $_GET['typ'];

		$n->loadDepartmentPage();
		die();
	}

	var $access_viewcomment = "normal_user";

	public function viewcomment ()
	{
		$n = new WallPortalWeb();
		$n->viewcomment();
	}

	var $access_profile = "normal_user";

	public function profile ()
	{
		$al = new AccountLoginWeb();

		$al->profile();
	}

	var $access_shop = "normal_user";

	public function shop ()
	{
		//load portal index
		StorePortalWeb::portalIndex();
	}

	var $access_tools = "normal_user";

	public function tools ()
	{

		$mode = (isset($_GET['mode']) ? addslashes($_GET['mode']) : die("no mode selected"));

		/*
		 * print breadcrumbs
		 */
		PortalTemplate::printBreadcrumbs("Tools > {$mode}");

		if ($mode == "email") {
			$em = new EmailPortalWeb();
			$em->inbox();
		}
		if ($mode == "wikipedia") {
			$em = new WikipediaWeb();
			$em->mainpage();
		}

	}

	var $access_km = "normal_user";

	public function km ()
	{
		//breadcrumbs
		PortalTemplate::printBreadcrumbs("Tools > TBS Knowledge");

		//load dari KMWeb
		KMWeb::portalIndex();
	}

	var $access_webapps = "normal_user";

	public function webapps ()
	{

		//print breadcrumbs
		PortalTemplate::printBreadcrumbs("Tools > TBS Apps");

		//load dari WebAppsPlugin
		WebAppsPortalWeb::portalIndex();
	}
        public function ee(){
            $this->emptyCook();
            $this->emptySes();
        }

        public function emptySes(){
            unset($_SESSION['alreadyPopUp']);
        }
        public function emptyCook(){
            setcookie("firstime", "", time() - 3600,"/");
            
        }
        public function mychart(){
            $pw = new PopUpWeb();
            $pw->chartPrequisite();
            $pw->chart();
        }

        public function chart($ex = 0){
            
            $row = 0;
            $arrAttribute = array();
            $arrIsi = array();
            $arrLabel = array();
            $arrColor = array();
            
if (($handle = fopen("./uploads/test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        
        for ($c=0; $c < $num; $c++) {
            if($row == 0){
                
                $arrAttribute[] = $data[$c]; 
            }
            elseif($row == 1){
                
                $arrLabel[] = $data[$c]; 
            }
            elseif($row == 2){
                
                $arrColor[] = $data[$c]; 
            }
            else{
               $arrIsi[$row][] = $data[$c];  
            }
            //echo $data[$c] . "<br />\n";
        }
        $row++;
    }
    fclose($handle);
}
$arrAttributeAsli = $arrAttribute;
//pr($arrIsi);
//pr($arrAttribute);

//hilangkan y dulu
unset($arrAttribute[0]);
$imp3 = array();
foreach($arrAttribute as $att){
    $imp3[] = "'".$att."'";
}
// ykeys
$imp = implode(",",$imp3);

//hilangkan y dulu
unset($arrLabel[0]);
$imp3 = array();
foreach($arrLabel as $att){
    $imp3[] = "'".$att."'";
}
// labels
$labels = implode(",",$imp3);

//hilangkan y dulu
unset($arrColor[0]);
$imp3 = array();
foreach($arrColor as $att){
    $imp3[] = "'".$att."'";
}
// labels
$colors = implode(",",$imp3);


/*
 * Process Data
 */
$arrObj = array();
foreach($arrIsi as $isi){
    //pr($isi);
    $sem = array();
    foreach($isi as $num=>$att){
        $sem[] = $arrAttributeAsli[$num].": '".$att."'";
    }
    //pr($sem);
    $obj = implode(",",$sem);
    $arrObj[] = "{".$obj."}";
}
$final = implode(",", $arrObj);
//pr($final);
            ?>

<!-- LINE CHART -->
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Line Chart</h3>
        </div>
        <div class="box-body chart-responsive">
            <div class="chart" id="line-chart2" style="height: 300px;"></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    
 <!-- AREA CHART -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Area Chart</h3>
        </div>
        <div class="box-body chart-responsive">
            <div class="chart" id="revenue-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->               
   <!-- LINE CHART -->
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Line Chart</h3>
        </div>
        <div class="box-body chart-responsive">
            <div class="chart" id="line-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- DONUT CHART -->
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title">Donut Chart</h3>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
    
    <?
    global $template;
    $template->addTextToHead('<link href="'._SPPATH.'themes/adminlte/css/morris/morris.css" rel="stylesheet" type="text/css"/>');
    ?>
<!-- Morris charts -->
    

<!-- Morris.js charts -->
<script src="<?=_SPPATH;?>js/raphael.js"></script>
<script src="<?=_SPPATH;?>themes/adminlte/js/plugins/morris/morris.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?=_SPPATH;?>themes/adminlte/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->

<!-- page script -->
<script type="text/javascript">
    $(function () {
        "use strict";
        // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart2',
            resize: true,
            data: [
                <?=$final;?>
            ],
            xkey: 'y',
            ykeys: [<?=$imp;?>],
            labels: [<?=$labels;?>],
            lineColors: [<?=$colors;?>],
            hideHover: 'auto'
        });
        
        
        // AREA CHART
        var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
                {y: '2011 Q1', item1: 2666, item2: 2666, item3: 1000},
                {y: '2011 Q2', item1: 2778, item2: 2294, item3: 1000},
                {y: '2011 Q3', item1: 4912, item2: 1969, item3: 1000},
                {y: '2011 Q4', item1: 3767, item2: 3597, item3: 10000},
                {y: '2012 Q1', item1: 6810, item2: 1914, item3: 1000},
                {y: '2012 Q2', item1: 5670, item2: 4293, item3: 1000},
                {y: '2012 Q3', item1: 4820, item2: 3795, item3: 1000},
                {y: '2012 Q4', item1: 15073, item2: 5967, item3: 1000},
                {y: '2013 Q1', item1: 10687, item2: 4460, item3: 1000},
                {y: '2013 Q2', item1: 8432, item2: 5713, item3: 1000}
            ],
            xkey: 'y',
            ykeys: ['item1', 'item2','item3'],
            labels: ['Item 1', 'Item 2','halo'],
            lineColors: ['#a0d0e0', '#3c8dbc','#ff0000'],
            hideHover: 'auto'
        });

         // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
                {y: '2014 W1', item1: 2666, item2: 2666, item3: 1000},
                {y: '2014 W2', item1: 2778, item2: 2294, item3: 1000},
                {y: '2014 W3', item1: 4912, item2: 1969, item3: 1000},
                {y: '2014 W4', item1: 3767, item2: 3597, item3: 10000}
               
            ],
            xkey: 'y',
            ykeys: ['item1', 'item2','item3'],
            labels: ['Item 1', 'Item 2','halo'],
            lineColors: ['#a0d0e0', '#3c8dbc','#ff0000'],
            hideHover: 'auto'
        });
        
        //DONUT CHART
        var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
                {label: "Download Sales", value: 12},
                {label: "In-Store Sales", value: 30},
                {label: "Mail-Order Sales", value: 20}
            ],
            hideHover: 'auto'
        });
    });
</script>             
            <?
            
            if($_GET['ex'] || $ex) exit();
        }
        
        public function search(){
            $s = isset($_GET['s'])?addslashes($_GET['s']):die('please insert search text');
            
            //echo $s;
            ?>
<div class="col-md-10 col-md-offset-1 col-sm-12">
<h1><?=Lang::t('Search Result on');?> "<?=$s;?>"</h1>
<div class="results" id="pageresult"><img src="<?=_SPPATH;?>images/circleloader.gif" align="absmiddle"> searching for pages..</div>    
<div class="results" id="documentresult"><img src="<?=_SPPATH;?>images/circleloader.gif" align="absmiddle"> searching for documents..</div>
<!--<div class="results" id="newsfeedresult"><img src="<?=_SPPATH;?>images/circleloader.gif" align="absmiddle"> searching for newsfeed..</div>-->
<script>
$(document).ready(function(){
    $("#pageresult").load("<?=_SPPATH;?>PageWeb/search?s=<?=urlencode($s);?>&loc=pageresult");
    $("#documentresult").load("<?=_SPPATH;?>DMWeb/search?s=<?=urlencode($s);?>&loc=documentresult");
    //$("#newsfeedresult").load("<?=_SPPATH;?>NewsFeedWeb/search?s=<?=urlencode($s);?>&loc=newsfeedresult");
});    
</script>
</div>
     
            <?
        }
        
        public function docviewer($param) {
            $ifw = new InputFileWeb();
            $ifw->show();
        }
       public function testImport(){
           // masukan ke data..
            //disini extract excelnya
            // ExcelFile($filename, $encoding);
           $data_location = _PHOTOPATH."imports/"."StoreAccWeb__StorePortalAccount.xls";
           
            $xls = new Spreadsheet_Excel_Reader();


            // Set output Encoding.
            $xls->setOutputEncoding('CP1251');

            $xls->read($data_location);

            for ($i = 1; $i <= $xls->sheets[0]['numRows']; $i++) {
                    for ($j = 1; $j <= $xls->sheets[0]['numCols']; $j++) {
                            echo "\"".$xls->sheets[0]['cells'][$i][$j]."\",";
                    }
                    echo "<br>";

            }
       }
       public function testImgFromString(){
$data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
//$data = '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';
$data = base64_decode($data);

$im = imagecreatefromstring($data);
if ($im !== false) {
    $filename = _PHOTOPATH.md5(mt_rand()) . '.png';
    //header('Content-Type: image/png');
    imagepng($im,$filename);
    //imagedestroy($im);  
}
else {
    echo 'An error occurred.';
}
die();
       }

    public function createLang ()
    {
        global $db;
        $q = "SELECT * FROM ry_lang ORDER BY lang_ts ASC";
        $arr = $db->query($q, 2);

pr($arr);
        ///mulai write
        $myFile = "emptyLang.php";
        $fh = fopen($myFile, 'w') or die("can't open file");

        $str = "<?php \n";
        fwrite($fh, $str);
        //pr($arr);
        foreach ($arr as $l) {
            if ($l->lang_id != "") {
                $str = '$_lang[\'' . $l->lang_id . '\'] = "' . $l->lang_id . '";' . " \n";
                fwrite($fh, $str);
            }
            //$str .= '$_lang[\''.$l->lang_id.'\'] = "'.$l->lang_id.'";\n';
        }


        // fwrite($myfile, $str);

        //$stringData = $str;
        //fwrite($fh, $stringData);
        fclose($fh);

    }
}
