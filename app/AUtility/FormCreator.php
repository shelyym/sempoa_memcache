<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/27/16
 * Time: 9:03 AM
 */
class FormCreator {

    public static function createFormSempoa($title, $arrDetails, $kemana, $onSuccess = '', $addPostValue = '', $onFailed = '', $load = 0) {
        $t = time() . rand(0, 100);
//        pr($arrDetails);
        ?>
        <div class="content-wrapper2">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="form_title"><?= Lang::t($title); ?></h1>
            </section>

            <!-- Main content -->
            <section class="content">


                <form method="post" id="formcreator_<?= $t; ?>">

                    <div class="alert alert-danger resultme" style="display: none;">
                    </div>
                    <?
                    foreach ($arrDetails as $name => $obj) {
                        if ($obj instanceof \Leap\View\InputText) {
                            if ($obj->type == "hidden") {
                                $obj->p();
                                continue;
                            }
                        }
                        $inputID = $obj->id;
                        ?>
                        <div id="formgroup_<?= $name; ?>" class="form-group">
                            <label for="<?= $name; ?>" class="control-label"><?= Lang::t($name); ?></label>
                            <?= $obj->p(); ?>
                            <span class="help-block" id="warning_<?= $name; ?>" style="display: none;"></span>
                            <div class="clearfix"></div>
                        </div>
                    <? } ?>
                    <input type="hidden" name="load" value="<?= $load; ?>">
                    <input type="hidden" name="jalankan" value="add">
                    <button type="button" onclick="lwclose(window.selected_page);" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-default">Submit</button>

                </form>

                <script>
                    $('#formcreator_<?= $t; ?>').submit(function (event) {
                        event.preventDefault();


                        // console.log(array_rte);
                        for (key in array_rte) {
                            var tb = array_rte[key];
                            // console.log(tb);
                            //get data
                            var data = CKEDITOR.instances;
                            //console.log(data);
                            var data2 = data[tb];
                            //console.log(data2);
                            var data1 = data2.getData();
                            // console.log(data1);
                            $("#hidden_" + tb).val(data1);
                        }

        <?= $addPostValue; ?>

                        var $form = $(this),
                                url = $form.attr("action");

                        $.post("<?= $kemana; ?>", $form.serialize(), function (data) {
                            console.log(data);
                            $("#formcreator_<?= $t; ?> .form-group").removeClass('has-error');
                            $("#formcreator_<?= $t; ?> .help-block").hide();
                            $('#formcreator_<?= $t; ?> .resultme').empty().hide();

                            if (data.status_code) {
                                //open account registration
        <?= $onSuccess; ?>
        //                        lwclose(window.selected_page);
        //                        lwrefresh(window.beforepage);
                            } else {
                                var obj = data.err;
                                var tim = data.timeId;
                                console.log(obj);
                                for (var property in obj) {
                                    if (obj.hasOwnProperty(property)) {
                                        if (property != 'all') {
                                            $('#formcreator_<?= $t; ?> #formgroup_' + property).addClass('has-error');
                                            $('#formcreator_<?= $t; ?> #warning_' + property).empty().append(obj[property]).fadeIn('slow');
                                        } else {
                                            $('#formcreator_<?= $t; ?> .resultme').empty().append(obj[property]).fadeIn('slow');
                                        }
                                    }
                                }

        <?= $onFailed; ?>
        //                        alert(data.status_message);
                            }
                        }, 'json');
                    });
                </script>

            </section>
        </div>
        <?
    }

    public static function createForm($title, $arrDetails, $kemana, $onSuccess = '', $addPostValue = '', $onFailed = '', $load = 0) {
        $t = time() . rand(0, 100);
        ?>
        <div class="content-wrapper2">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="form_title"><?= Lang::t($title); ?></h1>
            </section>

            <!-- Main content -->
            <section class="content">


                <form method="post" id="formcreator_<?= $t; ?>">

                    <div class="alert alert-danger resultme" style="display: none;">
                    </div>
        <?
        foreach ($arrDetails as $name => $obj) {
            if ($obj instanceof \Leap\View\InputText) {
                if ($obj->type == "hidden") {
                    $obj->p();
                    continue;
                }
            }
            $inputID = $obj->id;
            ?>
                        <div id="formgroup_<?= $name; ?>" class="form-group">
                            <label for="<?= $name; ?>" class="control-label"><?= Lang::t($name); ?></label>
                        <?= $obj->p(); ?>
                            <span class="help-block" id="warning_<?= $name; ?>" style="display: none;"></span>
                            <div class="clearfix"></div>
                        </div>
                        <? } ?>
                    <input type="hidden" name="load" value="<?= $load; ?>">
                    <input type="hidden" name="jalankan" value="add">
                    <button type="button" onclick="lwclose(window.selected_page);" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-default">Submit</button>

                </form>

                <script>
                    $('#formcreator_<?= $t; ?>').submit(function (event) {
                        event.preventDefault();


                        // console.log(array_rte);
                        for (key in array_rte) {
                            var tb = array_rte[key];
                            // console.log(tb);
                            //get data
                            var data = CKEDITOR.instances;
                            //console.log(data);
                            var data2 = data[tb];
                            //console.log(data2);
                            var data1 = data2.getData();
                            // console.log(data1);
                            $("#hidden_" + tb).val(data1);
                        }

        <?= $addPostValue; ?>
                        var $form = $(this),
                                url = $form.attr("action");
                        
                        $.post("<?= $kemana; ?>", $form.serialize(), function (data) {
                            console.log(data);
                            $("#formcreator_<?= $t; ?> .form-group").removeClass('has-error');
                            $("#formcreator_<?= $t; ?> .help-block").hide();
                            $('#formcreator_<?= $t; ?> .resultme').empty().hide();

                            if (data.status_code) {
                                //open account registration
        <?= $onSuccess; ?>
        //                        lwclose(window.selected_page);
        //                        lwrefresh(window.beforepage);
                            } else {
                                var obj = data.err;
                                var tim = data.timeId;
                                console.log(obj);
                                for (var property in obj) {
                                    if (obj.hasOwnProperty(property)) {
                                        if (property != 'all') {
                                            $('#formcreator_<?= $t; ?> #formgroup_' + property).addClass('has-error');
                                            $('#formcreator_<?= $t; ?> #warning_' + property).empty().append(obj[property]).fadeIn('slow');
                                        } else {
                                            $('#formcreator_<?= $t; ?> .resultme').empty().append(obj[property]).fadeIn('slow');
                                        }
                                    }
                                }

        <?= $onFailed; ?>
        //                        alert(data.status_message);
                            }
                        }, 'json');
                    });
                </script>

            </section>
        </div>
        <?
    }

    public static function receive($contraintslocation, $allowEmpty = array()) {

        if ($_POST['jalankan'] == "add") {

            list($cname, $fktname) = $contraintslocation;
            $new = new $cname();

            foreach ($_POST as $name => $value) {
                $new->$name = $value;
            }

            $mainid = $new->main_id;
            if ($new->$mainid != "" && isset($new->$mainid)) {
                $new->getById($new->$mainid);
                foreach ($_POST as $name => $value) {
                    if (in_array($name, $allowEmpty)) {
                        if ($value != "")
                            $new->$name = $value;
                    } else
                        $new->$name = $value;
                }
            }

            $err = $new->$fktname();
//            pr($err);
            $json['obj'] = $new;
            $json['post'] = $_POST;

            $json['status_code'] = 1;
            $json['status_message'] = "success";

            $json['err'] = $err;

            if (count($err) > 0) {
                $json['status_code'] = 0;
            } else {
                $mainid = $new->main_id;
                if ($new->$mainid != "" && isset($new->$mainid)) {
                    $json['status_code'] = $new->save(1);
                    $json['id'] = $new->$mainid;
                    $json['new'] = $new;
                } else {
                    $json['id'] = $new->save();

                    if ($json['id'])
                        $json['status_code'] = 1;
                    else {
                        $json['status_code'] = 0;
                        $json['err']['all'] = "Save Failed. Make sure all ID data do not duplicate.";
                    }
                }
            }


            echo json_encode($json);
            die();
        }
    }

    public static function receiveSempoa($contraintslocation, $allowEmpty = array()) {

//        pr($contraintslocation);
        if ($_POST['jalankan'] == "add") {

            list($cname, $fktname) = $contraintslocation;
            $new = new $cname();

            foreach ($_POST as $name => $value) {
                $new->$name = $value;
            }

            $mainid = $new->main_id;
            if ($new->$mainid != "" && isset($new->$mainid)) {
                $new->getById($new->$mainid);
                foreach ($_POST as $name => $value) {
                    if (in_array($name, $allowEmpty)) {
                        if ($value != "")
                            $new->$name = $value;
                    } else
                        $new->$name = $value;
                }
            }
//pr($new);
            $err = $new->$fktname();
//            pr($err);
            $json['obj'] = $new;
            $json['post'] = $_POST;

            $json['status_code'] = 1;
            $json['status_message'] = "success";

            $json['err'] = $err;

            if (count($err) > 0) {
                $json['status_code'] = 0;
            } else {
                $mainid = $new->main_id;
                if ($new->$mainid != "" && isset($new->$mainid)) {
                    $json['status_code'] = $new->save(1);
                    $json['id'] = $new->$mainid;
                    $json['new'] = $new;
                } else {
                    $json['id'] = $new->save();

                    if ($json['id'])
                        $json['status_code'] = 1;
                    else {
                        $json['status_code'] = 0;
                        $json['err']['all'] = "Save Failed. Make sure all ID data do not duplicate.";
                    }
                }
            }


            echo json_encode($json);
            die();
        }
    }

    public static function read($obj, $arr, $webClass, $webFunction, $addAccess = 1, $addURL = "", $editAccess = 1, $deleteAccess = 1) {

        if (count($arr) > 0) {
            extract($arr);
        }
        $activeObj = $obj;
        $t = time() . rand(0, 10);

        $sort = urlencode($sort);
        $c = $webFunction;
        ?>
        <div class="row hidden-print" style="margin-bottom: 10px;">
        <? if ($obj->crud_setting['search']) Crud::searchBox($arr, $webClass); ?>
            <div class="col-md-8 col-xs-12">
                <div class="btn-group">
                    <button class="btn btn-default" id="<?= $webFunction; ?>viewall<?= $t; ?>"
                            type="button"><?= Lang::t('viewall'); ?></button>

                    <script type="text/javascript">
                        $("#<?= $webFunction; ?>viewall<?= $t; ?>").click(function () {
                            openLw(window.selected_page, '<?= _SPPATH; ?><?= $webClass; ?>/<?= $webFunction; ?>?page=all&clms=<?= $coloms; ?>&sort=<?= $sort; ?>&search=<?= $search; ?>&word=<?= $w; ?>', 'fade');
                                });
                    </script>


        <? if ($addAccess) { ?>
                        <button class="btn btn-default" id="<?= $c; ?>addpat<?= $t; ?>" type="button"><?= Lang::t('add'); ?></button>
                        <script type="text/javascript">
                            $("#<?= $c; ?>addpat<?= $t; ?>").click(function () {
                                openLw('<?= $c; ?>AddPage', '<?= $addURL; ?>', 'fade');
                            });
                        </script>
        <? } ?>

        <? if ($obj->crud_setting['toggle']) Crud::filter($arr, $webClass, $t); ?>
                    <? if ($obj->crud_setting['webservice']) Crud::listWebService($arr, $webClass); ?>
                </div>
            </div>
                    <? if ($obj->crud_setting['toggle']) Crud::filterButton($arr, $webClass, $t); ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover crud-table" style="background-color: white;">

                <tr>
        <?
        if (isset($objs[0]))
            foreach ($objs[0] as $colom => $isi) {
                if ($colom == "removeAutoCrudClick")
                    continue;
                if (in_array($colom, $activeObj->hideColoums))
                    continue;
                ?>
                            <th id="sort_<?= $colom; ?><?= $t; ?>"><?= Lang::t($colom); ?></th>

                <?
                Crud::sortBy($arr, $webClass, "sort_" . $colom . $t, $colom);
            }
        ?>
                </tr>

        <? foreach ($objs as $num => $obj) { ?>
                    <tr id="<?= $c; ?>_<?= $obj->{$main_id}; ?>">

            <?
            foreach ($obj as $colom => $isi) {
                if ($colom == "removeAutoCrudClick")
                    continue;
                if (in_array($colom, $activeObj->hideColoums))
                    continue;
                ?>
                            <td id="<?= $colom; ?>_<?= $obj->{$main_id}; ?>">
                            <?= stripslashes($isi); ?>
                            </td>
                <? if (!in_array($colom, $obj->removeAutoCrudClick)) { ?>
                            <script type="text/javascript">
                                $("#<?= $colom; ?>_<?= $obj->{$main_id}; ?>").click(function () {
                                    openLw('<?= $webClass; ?>View', '<?= _SPPATH; ?><?= $webClass; ?>/<?= $c; ?>?cmd=edit&id=<?= $obj->{$main_id}; ?>&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');
                                });
                            </script>
                        <? } ?>
            <? } ?>
                    </tr>


        <? } ?>

            </table>
        </div>
        <div class="row hidden-print">
            <div class="col-md-12">
        <? Crud::pagination($arr, $webClass); ?>
            </div>
        </div>

        <?
    }

}
