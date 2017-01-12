<?php
namespace Leap\View;

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of InputFoto
 *
 * @author User
 */
class InputPageAttachment extends Html {

    public $arrImgExt   = array ("jpg", "png", "gif", "jpeg", "bmp");
    public $arrVideoExt = array ("mp4", "mkv", "flv");

    public function __construct ($id, $name, $value, $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
//        $this->value = $value;
        $this->value = htmlentities(stripslashes($value));
    }



    public function p(){
        $pa = \Efiwebsetting::getData('PageAttachment');
        $t = time();
        $id = $this->id."_".$t;
        echo $pa;
//        echo $this->value;
        ?>
        <input class="form-control" type="text" name="<?= $this->name; ?>" id="<?= $id; ?>" value='<?=stripslashes($this->value); ?>'>
        <?
        $exp = explode(",",$pa);

        foreach($exp as $p){
            if($p == "Page")continue;
            $n = new $p();
            ?>
            <div class="pageAttachmentItem">
            <?
            $n->attachmentDialog($id,$this->value);
            ?>
            </div>
            <?
        }
    }

    public function p2 ()
    {
        $t = time()+rand(0,100);
        $if = new \InputFileModel();
        ?>
        <div id="input_file_img_<?= $t; ?>"
             <? if (!self::isImage($this->value) && !self::isVideo($this->value)){ ?>style="display: none;"<? } ?> >
            <?
            //if(self::isImage($this->value)){
            $src = InputFile::getFoto($this->value);
            //echo $src;
            //echo $this->value;
            $id = "holder_file_old_" . $t;
            //echo $id;
            echo InputFile::makeFoto($src, $id);
            //}
            ?>
        </div>


        <div class="input-group">
            <input class="form-control" type="text" name="<?= $this->name; ?>" id="<?= $this->id; ?>_<?= $t; ?>" value="<?= $this->value; ?>">



            <div id="hidupload_<?= $t; ?>">
                <input class="form-control" type="file"
                       id="uploadfolder_<?= $t; ?>"
                       name="upload" />
                <i class="glyphicon glyphicon-ok"
                   id="file_ok_<?= $this->id; ?>_<?= $t; ?>"
                   style="display: none;"></i>
                <i class="glyphicon glyphicon-repeat"
                   id="file_repeat_<?= $this->id; ?>_<?= $t; ?>"
                   style="display: none;"></i>
            </div>
        </div>
        <script type="text/javascript">

            // Variable to store your files
            var files;

            // Add events
            $('#hidupload_<?= $t; ?> input[type=file]').on('change', inputFiles_<?=$t;?>);

            // Grab the files and set them to our variable
            /*function prepareUpload(event)
             {
             files = event.target.files;
             } */
            // Catch the form submit and upload the files
            function inputFiles_<?=$t;?>(event) {
                files = event.target.files;
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening

                // START A LOADING SPINNER HERE

                // Create a formdata object and add the files
                var data = new FormData();
                $.each(files, function (key, value) {
                    data.append(key, value);
                });
                //console.log(data);
                $.ajax({
                    url: '<?=_LANGPATH;?>Uploader/uploadfiles?t=<?=$t;?>&files=1&adafile=<?= $this->value; ?>',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data, textStatus, jqXHR) {
                        // console.log(data);

                        if (data.bool) {
                            // Success so call function to process the form
                            //submitForm(event, data);
                            console.log("success");
                            // loadfolder_<?=$t;?>(activeTID_<?=$t;?>);
                            $("#file_ok_<?= $this->id; ?>_<?= $t; ?>").show();
                            //var slc = $('#uploadfolder_<?=$t;?>').val();
                            console.log(data.filename);
                            $("#<?= $this->id; ?>_<?=$t;?>").val(data.filename);
                            console.log("yey "+$("#<?= $this->id; ?>_<?=$t;?>").val());
                            if (data.isImage) {
                                var imageHtml = document.getElementById("<?=$id;?>");
                                imageHtml.removeAttribute("style");
                                imageHtml.removeAttribute("width");
                                imageHtml.removeAttribute("height");
                                imageHtml.src = '<?=_SPPATH;?><?=$if->upload_url;?>' + data.filename;
                                $("#input_file_img_<?=$t;?>").show();
                            }else if (data.isVideo) {
                                generateThumbnail(data.filename);
                            }else {
                                console.log("not video");
                            }
                        }
                        else {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                            $("#file_repeat_<?= $this->id; ?>_<?= $t; ?>").show();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
            }

            function generateThumbnail(filename) {
                $.get("<?=_LANGPATH;?>Video/generateThumbnail?filename=" + filename,
                    function (dataReturn) {
                        console.log(dataReturn);

                        var imageHtml = document.getElementById("<?=$id;?>");
                        imageHtml.removeAttribute("style");
                        imageHtml.removeAttribute("width");
                        imageHtml.removeAttribute("height");
                        imageHtml.src = '<?=_SPPATH;?><?=$if->upload_url;?>' + dataReturn;
                        $("#input_file_img_<?=$t;?>").show();
                        $("#video_upload_preview").val(dataReturn);
                    });
            }
        </script>
    <?
    }
}
