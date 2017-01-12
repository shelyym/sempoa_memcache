<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 12:54 PM
 */

class Cropper{

    var $id;
    var $modal_title;
    var $InputToUpdate;
    var $value;
    var $ratio = "0:0";
    var $imgIDToBeUpdated = array();
    var $onSuccessJS = '';

    public function __construct($id,$modal_title,$InputToUpdate,$value = '',$ratio = "0:0",$imgIDToBeUpdated = array(),$onSuccessJS = '' ) {

        $this->id = $id;
        $this->modal_title = $modal_title;
        $this->InputToUpdate = $InputToUpdate;
        $this->ratio = $ratio;
        $this->imgIDToBeUpdated = $imgIDToBeUpdated;
        $this->value = $value;
        $this->onSuccessJS = $onSuccessJS;

    }

    public static function createModal($id,$modal_title,$InputToUpdate,$value= '',$ratio = "0:0",$imgIDToBeUpdated = array(),$onSuccessJS = '',$isRaw = 0 ){

        /*
         * Use
         * <div class="avatar-view" title="Change the avatar" data-toggle="modal" data-target="#avatar-modal">
            <img id="gambarAsli" src="<?=_SPPATH;?>images/blur.jpg" alt="Avatar">
            </div>

        data-toggle and data target to call this function
         */
        $t = time();

        $needratio = 1;
        if($ratio == "0:0"){
            $needratio = 0;
        }

        list($ratioWidth,$ratioHeight) = explode(":",$ratio);
        if($ratioWidth == "" || $ratioHeight == "") $needratio = 0;
        ?>
        <style>

            .avatar-view {
                display: block;
                margin: 15% auto 5%;
                height: 220px;
                width: 220px;
                border: 3px solid #fff;
                border-radius: 5px;
                box-shadow: 0 0 5px rgba(0,0,0,.15);
                cursor: pointer;
                overflow: hidden;
            }

            .avatar-view img {
                width: 100%;
            }

            .avatar-body {
                padding-right: 15px;
                padding-left: 15px;
            }

            .avatar-upload {
                overflow: hidden;
            }

            .avatar-upload label {
                display: block;
                float: left;
                clear: left;
                width: 100px;
            }

            .avatar-upload input {
                display: block;
                margin-left: 110px;
            }

            .avatar-alert {
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .avatar-wrapper {
                height: 364px;
                width: 100%;
                margin-top: 15px;
                box-shadow: inset 0 0 5px rgba(0,0,0,.25);
                background-color: #fcfcfc;
                overflow: hidden;
            }

            .avatar-wrapper img {
                display: block;
                height: auto;
                max-width: 100%;
            }

            .avatar-preview {
                float: left;
                margin-top: 15px;
                margin-right: 15px;
                border: 1px solid #eee;
                border-radius: 4px;
                background-color: #fff;
                overflow: hidden;
            }

            .avatar-preview:hover {
                border-color: #ccf;
                box-shadow: 0 0 5px rgba(0,0,0,.15);
            }

            .avatar-preview img {
                width: 100%;
            }

            .preview-lg {
                height: 184px;
                width: 184px;
                margin-top: 15px;
            }

            .preview-md {
                height: 100px;
                width: 100px;
            }

            .preview-sm {
                height: 50px;
                width: 50px;
            }

            @media (min-width: 992px) {
                .avatar-preview {
                    float: none;
                }
            }

            .avatar-btns {
                margin-top: 30px;
                margin-bottom: 15px;
            }

            .avatar-btns .btn-group {
                margin-right: 5px;
            }

            .loading {
                display: none;
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: #fff url("<?=_SPPATH;?>images/leaploader.gif") no-repeat center center;
                opacity: .75;
                filter: alpha(opacity=75);
                z-index: 20140628;
            }
        </style>
        <div class="modal fade" id="<?=$id;?>" aria-hidden="true" aria-labelledby="avatar-modal-label-<?=$id;?>" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="avatar-form" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="avatar-modal-label-<?=$id;?>"><?=$modal_title;?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="avatar-body">

                                <!-- Upload image and data -->
                                <div class="avatar-upload" id="avatarUpload-<?=$id;?>">
                                    <input type="hidden" class="avatar-src" id="imgAsli<?=$id;?>" name="avatar_src">
                                    <input type="hidden" class="avatar-data" id="imgCropped<?=$id;?>" name="avatar_data">
                                    <label for="avatarInput<?=$id;?>">Upload</label>
                                    <input type="file" class="avatar-input" id="avatarInput<?=$id;?>" name="avatar_file">
                                </div>

                                <!-- Crop and preview -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="avatar-wrapper cropTool"><img id="image2crop<?=$id;?>" src="<?=$value;?>"  /></div>
                                    </div>

                                </div>

                                <div class="row avatar-btns">

                                    <div class="col-md-12">
                                        <button onclick="ups<?=$id;?>(event);" type="button" class="btn btn-primary btn-block avatar-save">Done</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div> -->
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->

        <script type="text/javascript">

<? if($value != ''){ ?>
$('#<?=$id;?>').on('shown.bs.modal', function() {
//    $('#image2crop<?//=$id;?>//').attr("src",'<?//=$value;?>//');
    $('#image2crop<?=$id;?>').cropper("destroy");
    $('#image2crop<?=$id;?>').cropper({
        <? if($needratio){?>
        aspectRatio: <?=$ratioWidth;?> / <?=$ratioHeight;?>
    <? }?>

});
//    console.log("show");
});

<? }?>



            var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];  //acceptable file types

            document.querySelector('#avatarUpload-<?=$id;?> input[type=file]').addEventListener('change', function (event) {

                var files = event.target.files;

                // Iterate through files
                for (var i = 0; i < files.length; i++) {

                    var mywidth = 0;
                    var myheight = 0;

                    // alert('in2');
                    // Ensure it's an image
                    if (files[i].type.match(/image.*/)) {
                        var reader = new FileReader();
                        //alert('in3');
                        var extension = files[i].name.split('.').pop().toLowerCase();
                        var isSuccess = fileTypes.indexOf(extension) > -1;
                        console.log(extension);
                        console.log(reader);
                        console.log(isSuccess);
                        if (isSuccess) {

                            //kalau png atau gif, tidak di resize, krn we want to preserve the transparency and animations
                            if (typeof FileReader !== "undefined") {
                                var sizess = files[i].size;
                                // check file size
                                console.log("sizes");
                                console.log(sizess);
                                var _URL = window.URL || window.webkitURL;
                                var file, img;
                                if ((file = this.files[i])) {
                                    img = new Image();
                                    img.onload = function () {
                                        console.log(this.width + " " + this.height);
                                        mywidth = this.width;
                                        myheight = this.height;

                                    };
                                    img.src = _URL.createObjectURL(file);
                                }
                            }

                            inputFotoFilesCropper<?=$id;?>(event);




                        }//success
                        else{
                            alert("<?=Lang::t('Please only upload image files');?>");
                            console.log("err type");
                        }
                    }else{
                        alert("<?=Lang::t('Please only upload image files');?>");
                        console.log("err type");
                    }
                }

            });

            // Catch the form submit and upload the files
            function inputFotoFilesCropper<?=$id;?>(event) {
                files = event.target.files;
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening


                //load Old Files
                var gambarLama = $('#image2crop<?=$id;?>').attr('src');
//                alert(gambarLama);
                var barunya = gambarLama.split(/(\\|\/)/g).pop();
//                alert(barunya);
                //cuman harus dipisah diambil belakangnya saja


                // START A LOADING SPINNER HERE

                // Create a formdata object and add the files
                var data = new FormData();
                $.each(files, function (key, value) {
                    data.append(key, value);
                });
                //console.log(data);
                $.ajax({
                    url: '<?=_LANGPATH;?>Uploader/uploadres_ext?t=<?=$t;?>&files=1&adafile='+barunya,
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);

                        if (data.bool) {

                            //remove old data

                            $('#imgAsli<?=$id;?>').val(data.filename);

                            console.log('Image uploaded: ' + data.filename);

                            $('#image2crop<?=$id;?>').attr("src",'<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + data.filename);

                            $('#image2crop<?=$id;?>').cropper("destroy");
                            $('#image2crop<?=$id;?>').cropper({
                                <? if($needratio){?>
                                aspectRatio: <?=$ratioWidth;?> / <?=$ratioHeight;?>,<? }?>
                                autoCropArea: 1,
                                crop: function(e) {


                                }
                            });


                            $(".cropTool").show();

                        }
                        else {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
//                $("#file_repeat_<?//= $this->id; ?>//_<?//= $t; ?>//").show();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
            }


            function ups<?=$id;?>(event){
                event.preventDefault();
                // Upload cropped image to server
                var canvas = $('#image2crop<?=$id;?>').cropper('getCroppedCanvas');

                var aslinya = $('#image2crop<?=$id;?>').attr("src");
                var extension = aslinya.split('.').pop();
                var tipe_ext = extension;

                if(extension == "jpeg"){
                    extension = "jpg";
                }

                if(extension == "jpg"){
                    tipe_ext = "jpeg";
                }


                var fullQuality = canvas.toDataURL("image/"+tipe_ext, 1.0);
                console.log(fullQuality);

//                $('.cropper-example-3 > img').cropper('getCroppedCanvas').toBlob(function (blob) {
                var formData = new FormData();

                var old_filename = $('#imgAsli<?=$id;?>').val();

//                    alert(old_filename);

                formData.append('croppedImage', fullQuality);

                $.ajax('<?=_LANGPATH;?>UploaderCrop/upload?ext='+extension+'&fname='+old_filename, {
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        <? if($isRaw){
                        ?>
                        $('#<?=$InputToUpdate;?>').val(data);
                        <?
                        }else{?>
                        $('#<?=$InputToUpdate;?>').val('<?=_BPATH._PHOTOURL;?>'+data);
                        <? } ?>
                        <?
                        foreach($imgIDToBeUpdated as $imgID){
 ?>
                        var imageHtml = $("#<?=$imgID;?>");
                        imageHtml.attr('src', '<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + data+'?t='+$.now());
                        <? } ?>

                        if(data != old_filename){

//                            $('#a_<?//=$id;?>//').attr("href",'<?//=_SPPATH;?>//'+'<?//=_PHOTOURL;?>//' + data);
//                            $('#<?//=$this->id;?>//_<?//=$t;?>// #<?//=$this->id;?>//').val(data);
                        }
                        console.log('Upload success');
//                            alert("Success");
//                        asuccess("Image Cropped Successfully");

                        $('#<?=$id;?>').modal('hide');

                        <?=$onSuccessJS;?>
                    },
                    error: function () {
                        alert("Upload Failed");
                        console.log('Upload error');
                    }
                });
//                });
            }
        </script>
        <?
    }
} 