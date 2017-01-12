<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud
 *
 * @author User
 */
class Crud {
    public static function run ($obj, $webClass)
    {
        if ($obj instanceof Model) {

            $cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
            if ($cmd == "edit") {
                Crud::createForm($obj, $webClass);
                die();
            }
            if ($cmd == "add") {
                //Crud::createForm($obj,$webClass);
                $json = Crud::addPrecon($obj);
                die(json_encode($json));
            }
            if ($cmd == "delete") {
                $json['bool'] = 1;
                $id = (isset($_POST['id']) ? addslashes($_POST['id']) : '');
                $json['bool'] = $obj->delete($id);
                die(json_encode($json));
            }
            if ($cmd == "ws") {
                Crud::workWebService($obj, $webClass);
                die();
            }

            Crud::read($obj, $webClass);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    /*
     * add all preconditions and constraints
     */

    public static function createForm ($obj, $webClass)
    {
        //pr($obj);
        if ($obj instanceof Model) {
            $mps = $obj->createForm();
            //pr($obj);
            $mps['webClass'] = $webClass;
            $mps['action'] = $webClass . "/" . $mps['classname'] . "?cmd=add";
            $mps['formID'] = "editform_" . $mps['classname'] . "_" . time();
            $mps['obj'] = $obj;
            $mps['ajax'] = new Ajax($mps);
            //pr($mps);
            //echo $webClass;
            Mold::plugin("Crud","createForm", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }

    }

    public static function addPrecon ($obj)
    {

        if ($obj instanceof Model) {
            $json['bool'] = 1;
            $obj->insertPostDataToObject();
            //$json['post'] = $obj;
            $json['err'] = $obj->constraints();

            if (count($json['err']) > 0) {
                $json['bool'] = 0;
            } else {
                $json['bool'] = $obj->save();
                if ($json['bool']) {

                    $main_id = $obj->main_id;
                    if(!$obj->load)$obj->$main_id = $json['bool'];

                    $obj->onCrudSaveSuccess();

                }else{
                    $json['err'] = array ("all" => Lang::t('Save Failed. Make Sure ID is unique.'));
                }
            }

            return $json;
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function read ($obj, $webClass)
    {
        if ($obj instanceof Model) {

            $mps = $obj->read();
            $mps['webClass'] = $webClass;
            $mps = $obj->overwriteRead($mps);

            Mold::plugin("Crud","read", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function sortBy ($return, $webClass, $divID, $clmID)
    {
        $c = $return['classname'];

        $page = $return['page'];
        $sort = $return['sort'];
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $t = time() - 10000000;
        $colomlist = $return['colomslist'];
        $clms = $return['coloms'];
        $giliran = "ASC";
        if (isset($_SESSION[$webClass]['sort'][$clmID])) {
            $urutan = $_SESSION[$webClass]['sort'][$clmID];
            if ($urutan == "ASC") {
                $giliran = "DESC";
            } else {
                $giliran = "ASC";
            }
        } else {
            $giliran = "ASC";

        }
        $_SESSION[$webClass]['sort'][$clmID] = $giliran;
        $sort = $clmID . "%20" . $giliran;
        ?>
        <script type="text/javascript">
            $("#<?=$divID;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=strtolower($c);?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=<?=$clms;?>', 'fade');
            });
        </script>
    <?

    }

    public static function searchBox ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>
        <div class="col-md-4 col-xs-12">

            <div class="input-group">
                <input type="text" class="form-control" value="<?= $w; ?>" id="<?= $c; ?>searchpat_text_<?=$t;?>">
      <span class="input-group-btn">
        <button class="btn btn-default" id="<?= $c; ?>searchpat<?= $t; ?>"
                type="button"><?= Lang::t('search'); ?></button>
      </span>
            </div>
            <!-- /input-group -->


            <script type="text/javascript">
                $("#<?=$c;?>searchpat<?=$t;?>").click(function () {
                    var slc = encodeURI($('#<?=$c;?>searchpat_text_<?=$t;?>').val());
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                });
                $("#<?=$c;?>searchpat_text_<?=$t;?>").keyup(function (event) {
                    if (event.keyCode == 13) { //on enter
                        var slc = encodeURI($('#<?=$c;?>searchpat_text_<?=$t;?>').val());
                        openLw(selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                    }
                });
            </script>
        </div>
    <?
    }

    public static function viewAll ($return, $webClass)
    {
        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>viewall<?= $t; ?>"
                type="button"><?= Lang::t('viewall'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>viewall<?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
        </script>
    <?

    }
    //update roy webserviice
    public static function listWebService($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>export<?= $t; ?>" type="button" onclick="$('#<?= $c; ?>kompl_ws_<?= $t; ?>').toggle();"><?= Lang::t('WebService'); ?></button>
        
        <div id="<?= $c; ?>kompl_ws_<?= $t; ?>" style="display:none;">
            <div class="ws">
                GetAll <a target="_blank" href="<?=_SPPATH.$webClass."/".$c;?>?cmd=ws&mws=getall">Link</a>
            </div>
            <div class="ws">
                GetByPage <a target="_blank" href="<?=_SPPATH.$webClass."/".$c;?>?cmd=ws&mws=getByPage&page=1&limit=20">Link</a>
            </div>
            <div class="ws">
                GetWhere <a target="_blank" href="<?=_SPPATH.$webClass."/".$c;?>?cmd=ws&mws=getByPageWhere&page=1&limit=20&orderby=&search=">Link</a>
            </div>
            <div class="ws">
                GetByID <a target="_blank" href="<?=_SPPATH.$webClass."/".$c;?>?cmd=ws&mws=getbyid&id=">Link</a>
            </div>
            <div class="ws">
                GetPair <a target="_blank" href="<?=_SPPATH.$webClass."/".$c;?>?cmd=ws&mws=getPair&page=1&limit=20&orderby=&search=">Link</a> exact,anywhere,start,end
            </div>
        </div>
        
    <?
    }
    public static function exportExcel ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>export<?= $t; ?>" type="button"><?= Lang::t('export'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>export<?=$t;?>").click(function () {
                window.open('<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&export=1', "_blank ");
            });
        </script>
    <?
    }
    //tambahan roy import
    public static function importExcel ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button onclick="addnewfileImport_<?=$t;?>();" class="btn btn-default" id="<?= $c; ?>import<?= $t; ?>" type="button"><?= Lang::t('Import'); ?></button>
        <div id="hiduploadImport_<?=$t;?>" style="display:none; position: absolute; padding: 10px; z-index: 2; background-color: green; color:white; border-radius: 8px; margin-top: 5px; margin-left: 5px;">
            loading..
            <input type="file" id="uploadImport_<?=$t;?>" name="upload" style="visibility: hidden; width: 1px; height: 1px"  />
        </div>
        <script type="text/javascript">
            function addnewfileImport_<?=$t;?>(){               
                document.getElementById('uploadImport_<?=$t;?>').click(); return false;
            }
            
            // Variable to store your files
var files;

// Add events
$('#hiduploadImport_<?=$t;?> input[type=file]').on('change', uploadFilesImport_<?=$t;?>);

// Catch the form submit and upload the files
function uploadFilesImport_<?=$t;?>(event)
{
    files = event.target.files;
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE
    $('#hiduploadImport_<?=$t;?>').show();
    // Create a formdata object and add the files
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});

    $.ajax({
        url: '<?=_SPPATH;?>CrudUploaded/uploadfiles?t=<?=$t;?>&files=1&c=<?=$c;?>&wc=<?=$webClass;?>',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
                console.log(data);
                $('#hiduploadImport_<?=$t;?>').hide();
        	if(typeof data.error === 'undefined')
        	{
        		// Success so call function to process the form
        		//submitForm(event, data);
                        console.log("success");
                        //loadfolder_<?=$t;?>(activeTID_<?=$t;?>);
                        lwrefresh(window.selected_page);
        	}
        	else
        	{
        		// Handle errors here
        		console.log('ERRORS: ' + data.error);
                        alert(data.error);
                        if(data.err_size){
                            alert('Size mismatch, please try upload again');
                        }
        	}
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
        	// Handle errors here
        	console.log('ERRORS: ' + textStatus);
        	// STOP LOADING SPINNER
                $('#hiduploadImport_<?=$t;?>').hide();
        }
    });
}
        </script>
    <?
    }
    public static function AddButton ($return, $webClass)
    {

        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>

        <button class="btn btn-default" id="<?= $c; ?>addpat<?= $t; ?>" type="button"><?= Lang::t('add'); ?></button>

        <script type="text/javascript">
            $("#<?=$c;?>addpat<?=$t;?>").click(function () {
                openLw('<?=$c;?>AddPage', '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?cmd=edit&t=' + $.now() + '&parent_page=' + window.selected_page, 'fade');
            });
        </script>
    <?
    }

    public static function filter ($return, $webClass,$t)
    {
        $c = $return['classname'];
        
        $m = new $c();  
        if(count($m->crud_read_gabungan)>0){
           return "";
        }
        
        ?>

        <button class="btn btn-default" id="<?= $c; ?>_FilterButton_<?=$t;?>" type="button"
                onclick="$('#<?= $c; ?>Filter_<?=$t;?>').fadeToggle();"><?= Lang::t('toggle filter'); ?></button>



    <?
    }

    public static function filterButton ($return, $webClass,$t1)
    {
        $c = $return['classname'];
        $m = new $c();  
        if(count($m->crud_read_gabungan)>0){
           return "";
        }
        
        
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;

        $colomlist = $return['colomslist'];
        $actual_coloms = $return['coloms'];

        $exp = explode(",", $colomlist);
        $expAct = explode(",", $actual_coloms);
        ?>
        <div class="col-md-12 col-xs-12" id="<?= $c; ?>Filter_<?=$t1;?>" class="CrudViewFilter <?= $c; ?>_Filter"
             style="display:none; padding: 10px;">


            <style type="text/css">
                .selectable_clm {
                    margin: 5px;
                    padding: 5px;
                    background-color: #efefef;
                    border-radius: 5px;
                }

                .sslc {
                    background-color: #ccc;
                    font-weight: bold;
                }
            </style>
            <script type="text/javascript">
                tofilter = [];

                function RemoveFromfilter(id) {
                    var index = tofilter.indexOf(id);
                    if (index > -1) {
                        tofilter.splice(index, 1);
                        $('#' + id + "_<?=$t;?>").removeClass('sslc');
                    } else {
                        tofilter.push(id);
                        $('#' + id + "_<?=$t;?>").addClass('sslc');
                    }
                    $("#<?=$c;?>filterHide<?=$t;?>").val(tofilter.join());
                }
            </script>
            <?
            foreach ($exp as $clm) {
                $clm = trim(rtrim($clm));
                if (in_array($clm, $expAct)) {
                    $sel = "sslc";
                    $onclick = "RemoveFromfilter('{$clm}');";
                    ?>
                    <script type="text/javascript">tofilter.push('<?=$clm;?>');</script>
                <?
                } else {
                    $sel = "";
                    $onclick = "RemoveFromfilter('{$clm}');";
                }

                //if hide coloums
                if(in_array($clm,$m->hideColoums))continue;
                ?>
                <div id="<?= $clm; ?>_<?= $t; ?>" class="selectable_clm <?= $sel; ?> col-md-1 col-xs-3 col-sm-2"
                     onclick="<?= $onclick; ?>">
                    <?= Lang::t($clm); ?>
                </div>
            <? } ?>
            <input type="hidden" id="<?= $c; ?>filterHide<?= $t; ?>" value="<?= $actual_coloms; ?>">

            <div class="col-md-1 col-xs-3 col-sm-2">
                <button class="btn btn-default" id="<?= $c; ?>filterButton<?= $t; ?>"
                        type="button"><?= Lang::t('filter'); ?></button>
            </div>
            <script type="text/javascript">
                $("#<?=$c;?>filterButton<?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=' + $('#<?=$c;?>filterHide<?=$t;?>').val(), 'fade');
                });
            </script>
        </div>
    <?
    }

    public static function pagination ($return, $webClass)
    {
        $c = $return['classname'];
        $page = $return['page'];
        $sort = urlencode($return['sort']);
        $w = (isset($return['search_keyword']) ? $return['search_keyword'] : "");
        $search = $return['search_triger'];
        $totalpage = $return['totalpage'];
        $perpage = $return['perpage'];
        $clms = $return['coloms'];
        $t = time() - 10000000;
        ?>
    <div class="CrudViewPagination <?= $c; ?>_Pagination" id="<?= $c; ?>_Pagination">
        <? if (!($page <= 1)) { ?>
        <span class="CrudViewPagebutton"
              id="<?= $webClass; ?>firstpagepat_<?= $page; ?><?= $t; ?>"><?= Lang::t('first'); ?></span>
        <span class="CrudViewPagebutton"
              id="<?= $webClass; ?>prevpat_<?= $page; ?><?= $t; ?>"><?= Lang::t('prev'); ?></span>
        <script type="text/javascript">
            $("#<?=$webClass;?>firstpagepat_<?=$page;?><?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
            $("#<?=$webClass;?>prevpat_<?=$page;?><?=$t;?>").click(function () {
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=($page-1);?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
        </script>
    <?
    }
        //handle next pages
        $showpagination = 2;
        if ($page > ($totalpage - $showpagination)) {

            $endpage = $totalpage;
        } else {
            $endpage = $page + $showpagination;
        }

        if ($page >= $showpagination) {
            $beginpage = $page - $showpagination;
        } else {
            $beginpage = 1;
        }
        if ($beginpage < 1) {
            $beginpage = 1;
        }
        if ($endpage > $totalpage) {
            $endpage = $totalpage;
        }
        for ($x = $beginpage; $x <= $endpage; $x++) {
            if ($x == $page) {
                $selected = "selpage";
            } else {
                $selected = "";
            }
            ?>
            <span class="CrudViewPagebutton <?= $selected; ?>"
                  id="<?= $webClass; ?>mppage_<?= $x; ?><?= $t; ?>"><?= $x; ?></span>
            <script type="text/javascript">
                $("#<?=$webClass;?>mppage_<?=$x;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=$x;?>&sort=<?=$sort;?>&clms=<?=$clms;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
            </script>
        <?
        }
        if (!($page >= $totalpage)) {
            ?><span class="CrudViewPagebutton"
                    id="<?= $webClass; ?>nextpat_<?= $page; ?><?= $t; ?>"><?= Lang::t('next'); ?></span>
            <span class="CrudViewPagebutton"
                  id="<?= $webClass; ?>lastpagepat_<?= $page; ?><?= $t; ?>"><?= Lang::t('last'); ?></span>
            <script type="text/javascript">
                $("#<?=$webClass;?>lastpagepat_<?=$page;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=$totalpage;?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
                $("#<?=$webClass;?>nextpat_<?=$page;?><?=$t;?>").click(function () {
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?page=<?=($page+1);?>&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
                });
            </script><?

        }
        ?></div><?

    }
    public static function savePic($data,$return = "nopath"){

        if($_GET['ios'] == "1") {
            $data = base64_decode(str_replace(" ", "+", $data));
        }else
        $data = base64_decode($data);

        $im = imagecreatefromstring($data);
        if ($im !== false) {
            $ff = md5(mt_rand()) . '.png';   
            $filename = _PHOTOPATH.$ff;

            //header('Content-Type: image/png');
            $succ = imagepng($im,$filename);
            //imagedestroy($im);
            if($succ){
                if($return == "nopath")
                    return $ff;
                else
                    return _PHOTOURL.$ff;
            }else{
                return 0;
            }

        }
        return 0;
    }

    public static function workWebService($obj, $webClass){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
        IMBAuth::checkOAuth();

        $mws = $_GET['mws'];
        if($mws == "getall"){
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            $arr = $obj->getAll();
            $json = array();
            $json['status_code'] = 1;
            //filter
            foreach($arr as $o){
               $sem = array();
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = stripslashes ($o->$attr);
               }
               $json["results"][] = $sem;
            }
            if(count($arr)<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        if($mws == "getByPage"){
            $page = addslashes($_GET['page']);
            if($page == ""||$page<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Page Found";
                echo json_encode($json);
                die();
            }
            $limit = addslashes($_GET['limit']);
            if($limit == ""||$limit<1||$limit>$obj->webservice_read_limit){
                $json['status_code'] = 0;
                $json['status_message'] = "Limit Error";
                echo json_encode($json);
                die();
            }
            
            $begin = ($page-1)*$limit;
            //begin
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            $arr = $obj->getWhere("$main_id != '' LIMIT $begin,$limit");
            $json = array();
            $json['status_code'] = 1;
            //filter
            foreach($arr as $o){
               $sem = array();
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = stripslashes ($o->$attr);
               }
               $json["results"][] = $sem;
            }
            if(count($arr)<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        //tambahan pakai tupel
        /*
         * tupel format : nama_colom,value,rule;nama_colom2,value2,rule2
         * rule ada : exact, anywhere, start, end
         */
        if($mws == "getPair"){
            //begin
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            
            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            $page = addslashes($_GET['page']);
            if($page == ""||$page<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Page Found";
                echo json_encode($json);
                die();
            }
            $limit = addslashes($_GET['limit']);
            if($limit == ""||$limit<1||$limit>$obj->webservice_read_limit){
                $json['status_code'] = 0;
                $json['status_message'] = "Limit Error";
                echo json_encode($json);
                die();
            }
            $orderby = addslashes($_GET['orderby']);
            if($orderby == ""){
                $orderby_text = " ORDER BY $main_id ASC";
            }
            else{
                $orderby_text = " ORDER BY $orderby ";
            }
            $search = addslashes($_GET['search']);
            if($search != ""){
                $exp2 = explode(";",$search);
                //pr($exp2);
                if(count($exp2)>0){
                    foreach($exp as $field){
                        //pr($field);
                        foreach($exp2 as $tupel){
                            //pr($tupel);
                            $exp3 = explode(",",$tupel);
                            //pecah jadi satuan
                            //pr($exp3);
                            $nama_colom = $exp3[0];
                            $value = $exp3[1];
                            $rule = $exp3[2];
                            if($nama_colom == $field){
                                if($rule == "anywhere")
                                    $snn[] = "($field LIKE '%$value%')";
                                elseif($rule=="exact")
                                    $snn[] = "($field LIKE '$value')";
                                elseif($rule=="start")
                                    $snn[] = "($field LIKE '$value%')";
                                elseif($rule=="end")
                                    $snn[] = "($field LIKE '%$value')";
                            }
                        }
                    }
                    //pr($snn);
                    $where_text = implode(" AND ",$snn);
                    //echo $where_text;
                }
                else{
                    //$where_text = "$main_id != ''";
                    $json['status_code'] = 0;
                    $json['status_message'] = "No Pair Details Found";
                    echo json_encode($json);
                    die();
                }
            }
            else{
                //$where_text = "$main_id != ''";
                $json['status_code'] = 0;
                $json['status_message'] = "No Search Details Found";
                echo json_encode($json);
                die();
            }
            
            $begin = ($page-1)*$limit;
            //echo "$where_text $orderby_text LIMIT $begin,$limit";
            $query = "$where_text $orderby_text  ";
            $arr = $obj->getWhere($query." LIMIT $begin,$limit");
            
            $json = array();
            $json['status_code'] = 1;
            $json['results_number'] = $obj->getJumlah($query);
            //filter
            foreach($arr as $o){
               $sem = array();
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = stripslashes ($o->$attr);
               }
               $json["results"][] = $sem;
            }
            if(count($arr)<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        
        
        
        if($mws == "getByPageWhere"){
            //begin
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            
            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            
            $page = addslashes($_GET['page']);
            if($page == ""||$page<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Page Found";
                echo json_encode($json);
                die();
            }
            $limit = addslashes($_GET['limit']);
            if($limit == ""||$limit<1||$limit>$obj->webservice_read_limit){
                $json['status_code'] = 0;
                $json['status_message'] = "Limit Error";
                echo json_encode($json);
                die();
            }
            $orderby = addslashes($_GET['orderby']);
            if($orderby == ""){
                $orderby_text = " ORDER BY $main_id ASC";
            }
            else{
                $orderby_text = " ORDER BY $orderby ";
            }
            $search = addslashes($_GET['search']);
            if($search != ""){
                foreach($exp as $field){
                    $snn[] = "($field LIKE '%$search%')";
                }
                $where_text = implode(" OR ",$snn);
            }
            else{
                $where_text = "$main_id != ''";
            }
            $begin = ($page-1)*$limit;
            //echo "$where_text $orderby_text LIMIT $begin,$limit";
            $query = "$where_text $orderby_text  ";
            $arr = $obj->getWhere($query." LIMIT $begin,$limit");
            
            $json = array();
            $json['status_code'] = 1;
            $json['results_number'] = $obj->getJumlah($query);
            //filter
            foreach($arr as $o){
               $sem = array();
               foreach($exp as $attr){
                   if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                   $sem[$attr] = stripslashes ($o->$attr);
               }
               $json["results"][] = $sem;
            }
            if(count($arr)<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        
        if($mws == "getbyid"){
            
            $id = addslashes($_GET['id']);
            if($id == ""||$id<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No ID Found";
                echo json_encode($json);
                die();
            }
            
            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            $obj->getById($id);
            $json = array();
            $json['status_code'] = 1;
            //filter
            $sem = array();
            foreach($exp as $attr){
                
                //if(updates)
                $updates = addslashes($_GET['updates']);
                if($updates){
                    if($_POST[$attr]!=""){
                        if(in_array($attr, $obj->crud_webservice_images)){
                            $picname = self::savePic($_POST[$attr]);
                            $_POST[$attr] = $picname;
//                            if($_GET['ios'] == "1") {
//                                $_POST[$attr] = $_POST[$attr];
//                            }
                        }
                        $obj->$attr = $_POST[$attr];
                    }
                }
                if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$obj->$attr;
                   }
                   else
                $sem[$attr] = stripslashes ($obj->$attr);
            }
            
            if($updates){
                $obj->load = 1;
                $succ = $obj->save();
                if($succ)
                    $json['status_code'] = 1;
                else 
                    $json['status_code'] = 0;
            }
            
            $json["results"] = $sem;
            
            if($obj->$main_id<1 || $obj->$main_id==""){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        if($mws == "addnew"){
            
            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
            
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            
            $json = array();
            $json['status_code'] = 1;
            //filter
            $sem = array();
            foreach($exp as $attr){
                
                //if(updates)
                $updates = addslashes($_GET['updates']);
                if($updates){
                    if($_POST[$attr]!=""){
                        if(in_array($attr, $obj->crud_webservice_images)){
                            $picname = self::savePic($_POST[$attr]);
                            $_POST[$attr] = $picname;
                        }
                        $obj->$attr = $_POST[$attr];
                    }
                }
                $sem[$attr] = $obj->$attr;
            }
            
            if($updates){
                //diberi constraints
                $json['err'] = $obj->constraints();

                if (count($json['err']) > 0) {
                    $json['status_code'] = 0;
                } else {
                    $id = $obj->save();
                    
                    if (!$id) {
                        $json['err'] = array ("all" => Lang::t('save failed'));
                    }
                }
                
            }
            //load             
            $obj->getById($id);
            //di isi ke sem
            foreach($exp as $attr){
                if(in_array($attr, $arrPicsToAddPhotoUrl)){
                       $sem[$attr] = _PHOTOURL.$o->$attr;
                   }
                   else
                $sem[$attr] = $obj->$attr;
            }
            
            //$sem[$main_id] = $id;
            $json["results"] = $sem;
            
            if($obj->$main_id<1 || $obj->$main_id==""){
                $json['status_code'] = 0;
                $json['status_message'] = "No Details Found";
            }
            
            echo json_encode($json);
            die();
        }
        if($mws == "dodelete"){
            
            $id = addslashes($_GET['id']);
            if($id == ""||$id<1){
                $json['status_code'] = 0;
                $json['status_message'] = "No ID Found";
                echo json_encode($json);
                die();
            }
            $updates = addslashes($_POST['updates']);
            if($updates){                 
                $succ = $obj->delete($id);
                if($succ){
                    $json['status_code'] = 1;
                    $json['status_message'] = "Success";
                }else{ 
                    $json['status_code'] = 0;
                    $json['status_message'] = "Delete Error";
                }
            }else{
               $json['status_code'] = 0;
               $json['status_message'] = "No Update Found"; 
            }
            echo json_encode($json);
            die();
        }
    }
    public static function clean2print($obj,$arr){

//        $this->default_read_coloms = $this->crud_webservice_allowed;
//        $main_id = $this->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);

        $res = array();

        foreach($arr as $o){
            $sem = array();
            foreach($exp as $attr){
                $sem[$attr] = stripslashes ($o->$attr);
            }
            $res[] = $sem;
        }
        return $res;

    }
    public static function clean2printEinzeln($obj){

//        $this->default_read_coloms = $this->crud_webservice_allowed;
//        $main_id = $this->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);


        $sem = array();

            foreach($exp as $attr){
                $sem[$attr] = stripslashes ($obj->$attr);
            }


        return $sem;

    }

    public static function clean2printEinzelnWithColoums($obj){

//        $this->default_read_coloms = $this->crud_webservice_allowed;
//        $main_id = $this->main_id;
        $exp = explode(",",$obj->coloumlist);


        $sem = array();

        foreach($exp as $attr){
            $sem[$attr] = stripslashes ($obj->$attr);
        }


        return $sem;

    }
}
