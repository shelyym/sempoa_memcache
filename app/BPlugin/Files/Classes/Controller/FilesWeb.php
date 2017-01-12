<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FilesWeb
 *
 * @author User
 */
class FilesWeb extends WebService {
    var $access_filesDelete = "download_admin";

    function files ()
    {
        $gw = new GalleryWeb();
        ?>
        <h1><?= Lang::t("Files"); ?></h1>
        <div class="howto">
            <?= Lang::t("Please upload your files here"); ?>
        </div>
        <div id="progressfiles">
            <div class="bar" style="width: 0%;"></div>
        </div>
        <input id="fileupload" type="file" name="files[]" data-url="<?= _SPPATH; ?><?= $gw->imageProcURL; ?>" multiple>
        <div style="padding-top: 10px;">
            <button type="button" onclick="document.location='<?= _SPPATH; ?>';"
                    class="btn btn-default"><?= Lang::t('View Site'); ?></button>
        </div>
        <div id="hasilfiles"></div>

        <style>
            .bar {
                height: 18px;
                background: green;
            }

            .file_thumb {
                text-align: center;
                min-height: 100px;
            }

            #hasilfiles {
                padding-top: 20px;
            }

            .file_menu {
                padding: 5px;
            }
        </style>
        <script>
            $.get("<?=_SPPATH;?>FilesWeb/fileInsert?img=0", function (data) {
                $("#hasilfiles").html(data);
                //alert( "Load was performed." );
            });
            $(function () {
                $('#fileupload').fileupload({
                    dataType: 'json',
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            $('<p/>').text(file.name).appendTo($('#hasilfiles'));
                            //update the database
                            $.get("<?=_SPPATH;?>FilesWeb/fileInsert?img=" + file.name, function (data) {
                                $("#hasilfiles").html(data);
                                //alert( "Load was performed." );
                            });
                        });
                        $('#progressfiles .bar').hide();
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progressfiles .bar').show().css(
                            'width',
                            progress + '%'
                        );
                    }
                });
            });
        </script>

    <?

    }

    function fileInsert ()
    {
        $car = new DocFile();
        $img = (isset($_GET['img']) ? addslashes($_GET['img']) : 0);

        if ($img) {
            $car->file_filename = $img;
            $car->file_date = leap_mysqldate();
            $car->file_owner_id = Account::getMyID();
            $car->save();
        }

        $arrCar = $car->getWhere("file_filename !='' ORDER BY file_id DESC ");
        //pr($arrCar);
        $gw = new GalleryWeb();
        foreach ($arrCar as $num => $pic) {

            ?>
            <div class="file_thumb thumbnail col-md-2">
                <div class="file_filename">
                    <a target="_blank"
                       href="<?= _SPPATH . $gw->uploadURL . $pic->file_filename; ?>"><?= $pic->file_filename; ?></a>
                </div>

                <div class="file_menu">
                    <button type="button"
                            onclick="if(confirm('<?= Lang::t("Are You Sure?"); ?>'))files_delete(<?= $pic->file_id; ?>);"
                            class="btn btn-default"><?= Lang::t('delete'); ?></button>
                </div>
            </div>

        <?

        }
    }

    function filesDelete ()
    {
        $pid = (isset($_GET['pid']) ? addslashes($_GET['pid']) : 0);
        if ($pid == 0) {
            die('No ID');
        }
        $car = new DocFile();
        $car->delete($pid);

        $gw = new GalleryWeb();
        //delete di server
        unlink($gw->uploadDir . $car->file_filename);
        //unlink($gw->uploadDirThumb.$car->file_filename);
    }
}
