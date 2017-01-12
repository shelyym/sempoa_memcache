<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/27/16
 * Time: 7:44 PM
 */

class CrudCustom extends Crud{

    var $ar_add = 1;
    var $ar_edit = 1;
    var $ar_delete = 1;

    var $ar_add_url = "";
    var $ar_edit_url = "";
    var $ar_delete_url = "";
    var $ar_onDeleteSuccess_js = "";

    var $callClass = "";
    var $callFkt = "";

    public function run_custom($obj, $callClass, $callFkt){

        if ($obj instanceof Model) {

            $this->callClass = $callClass;
            $this->callFkt = $callFkt;

            $cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
            if ($cmd == "edit") {
                CrudCustom::createForm($obj, $callClass, $callFkt,$this);
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
                Crud::workWebService($obj, $callClass);
                die();
            }
            
            CrudCustom::read($obj, $callClass,$callFkt,$this);
           
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }

    }

    public static function read ($obj, $callClass, $callFkt, $crudObj)
    {
        if ($obj instanceof Model) {

            $mps = $obj->read();
            $mps['webClass'] = $callClass;
            $mps['callFkt'] = $callFkt;
            $mps['crudObj'] = $crudObj;
            $mps = $obj->overwriteRead($mps);
            $mps['activeObj'] = $obj;
            Mold::plugin("CrudCustom","read", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function searchBox ($return, $webClass, $callFkt)
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
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$callFkt;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                });
                $("#<?=$c;?>searchpat_text_<?=$t;?>").keyup(function (event) {
                    if (event.keyCode == 13) { //on enter
                        var slc = encodeURI($('#<?=$c;?>searchpat_text_<?=$t;?>').val());
                        openLw(selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$callFkt;?>?page=1&clms=<?=$clms;?>&sort=<?=$sort;?>&search=1&word=' + slc, 'fade');
                    }
                });
            </script>
        </div>
    <?
    }

    public static function viewAll ($return, $webClass, $callFkt)
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
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$callFkt;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>', 'fade');
            });
        </script>
    <?

    }

    public static function exportExcel ($return, $webClass,$callFkt)
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
                window.open('<?=_SPPATH;?><?=$webClass;?>/<?=$callFkt;?>?page=all&clms=<?=$clms;?>&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&export=1', "_blank ");
            });
        </script>
    <?
    }

    public static function importExcel ($return, $webClass,$callFkt)
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

    public static function AddButton ($return, $webClass,$callFkt)
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
        $crudObj = $return['crudObj'];

        if($crudObj->ar_add) {
            $url = _SPPATH.$webClass."/".$callFkt;
            if($crudObj->ar_add_url!=""){
                $url = $crudObj->ar_add_url; //jangan pakai tanda tanya
            }
            ?>

            <button class="btn btn-default" id="<?= $c; ?>addpat<?= $t; ?>"
                    type="button"><?= Lang::t('add'); ?></button>

            <script type="text/javascript">
                $("#<?=$c;?>addpat<?=$t;?>").click(function () {
                    openLw('<?=$c;?>AddPage', '<?=$url;?>?cmd=edit&t=' + $.now() + '&parent_page=' + window.selected_page, 'fade');
                });
            </script>

        <?
        }
    }

    public static function createForm ($obj, $webClass,$callFkt,$crudObj)
    {
        //pr($obj);
        if ($obj instanceof Model) {
            $mps = $obj->createForm();
            //pr($obj);
            $mps['webClass'] = $webClass;
            $mps['action'] = $webClass . "/" . $callFkt . "?cmd=add";
            $mps['formID'] = "editform_" . $mps['classname'] . "_" . time();
            $mps['obj'] = $obj;
            $mps['ajax'] = new Ajax($mps);
            $mps['crudObj'] = $crudObj;
            //pr($mps);
            //echo $webClass;
            Mold::plugin("CrudCustom","createForm", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }

    }

    public static function filter ($return, $webClass,$t,$callFkt)
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

    public static function filterButton ($return, $webClass,$t1,$callFkt,$activeObj)
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
                if(in_array($clm,$activeObj->hideColoums))continue;
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
                    openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=$callFkt;?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=' + $('#<?=$c;?>filterHide<?=$t;?>').val(), 'fade');
                });
            </script>
        </div>
    <?
    }

    public static function listWebService($return, $webClass,$callFkt)
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
                GetAll <a target="_blank" href="<?=_SPPATH.$webClass."/".$callFkt;?>?cmd=ws&mws=getall">Link</a>
            </div>
            <div class="ws">
                GetByPage <a target="_blank" href="<?=_SPPATH.$webClass."/".$callFkt;?>?cmd=ws&mws=getByPage&page=1&limit=20">Link</a>
            </div>
            <div class="ws">
                GetWhere <a target="_blank" href="<?=_SPPATH.$webClass."/".$callFkt;?>?cmd=ws&mws=getByPageWhere&page=1&limit=20&orderby=&search=">Link</a>
            </div>
            <div class="ws">
                GetByID <a target="_blank" href="<?=_SPPATH.$webClass."/".$callFkt;?>?cmd=ws&mws=getbyid&id=">Link</a>
            </div>
            <div class="ws">
                GetPair <a target="_blank" href="<?=_SPPATH.$webClass."/".$callFkt;?>?cmd=ws&mws=getPair&page=1&limit=20&orderby=&search=">Link</a> exact,anywhere,start,end
            </div>
        </div>

    <?
    }

    public static function sortBy ($return, $webClass,$callFkt, $divID, $clmID)
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
                openLw(window.selected_page, '<?=_SPPATH;?><?=$webClass;?>/<?=($callFkt);?>?page=1&sort=<?=$sort;?>&search=<?=$search;?>&word=<?=$w;?>&clms=<?=$clms;?>', 'fade');
            });
        </script>
    <?

    }

    public static function pagination ($return, $webClass, $callFkt)
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

        <? $c = $callFkt;?>
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
} 