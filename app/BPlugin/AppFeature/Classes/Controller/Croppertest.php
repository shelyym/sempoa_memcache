<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/19/16
 * Time: 10:55 PM
 */

class Croppertest extends WebApps{


    function testRegex(){
        $isi = "http://localhost:8888/appear/uploads/219.jpg";

        ?>
        <br><br><br><br><br><br><br><br>
        <?
        echo $isi."<br>";

        if (preg_match("([^\s]+(\.(?i)(jpe?g|png|gif|bmp))$)", $isi)) {
            $exp = explode(_PHOTOURL,$isi);
            pr($exp);
            echo unlink(_PHOTOPATH.$exp[1]);
            echo "in";
        }
    echo "ends";

    }
    function index(){

        $t = time();
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
    <div class="attop">
        <!-- Current avatar -->
        <div class="avatar-view" title="Change the avatar" data-toggle="modal" data-target="#avatar-modal">
            <img id="gambarAsli" src="<?=_SPPATH;?>images/blur.jpg" alt="Avatar">
        </div>

        <!-- Cropping modal -->
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="avatar-form" action="<?=_SPPATH;?>Croppertest/uploadcrop" enctype="multipart/form-data" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                        </div>
                        <div class="modal-body">
                            <div class="avatar-body">

                                <!-- Upload image and data -->
                                <div class="avatar-upload" id="avatarUpload">
                                    <input type="hidden" class="avatar-src" id="imgAsli" name="avatar_src">
                                    <input type="hidden" class="avatar-data" id="imgCropped" name="avatar_data">
                                    <label for="avatarInput">Upload</label>
                                    <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                </div>

                                <!-- Crop and preview -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="avatar-wrapper cropTool"><img id="image2crop" /></div>
                                    </div>

                                </div>

                                <div class="row avatar-btns">

                                    <div class="col-md-12">
                                        <button onclick="ups(event);" type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
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

    </div>
        <script type="text/javascript">
            var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];  //acceptable file types

            document.querySelector('#avatarUpload input[type=file]').addEventListener('change', function (event) {

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

                            inputFotoFilesCropper(event);




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
            function inputFotoFilesCropper(event) {
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
                    url: '<?=_LANGPATH;?>Uploader/uploadres_ext?t=<?=$t;?>&files=1',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);

                        if (data.bool) {

//                            var imageHtml = $("#<?//=$id;?>//");
//                            imageHtml.attr('src', '<?//=_SPPATH;?>//'+'<?//=_PHOTOURL;?>//' + data.filename);
                            /*imageHtml.removeAttribute("style");
                             imageHtml.removeAttribute("width");
                             imageHtml.removeAttribute("height");
                             imageHtml.src = '<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + data.filename;*/
//                            $('#a_<?//=$id;?>//').attr("href",'<?//=_SPPATH;?>//'+'<?//=_PHOTOURL;?>//' + data.filename);
                            $('#imgAsli').val(data.filename);
                            //imageHtml.src = '<?=_SPPATH;?><?=_PHOTOURL;?>' + data.filename;
                            console.log('Image uploaded: ' + data.filename);

                            $('#image2crop').attr("src",'<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + data.filename);

                            $('#image2crop').cropper("destroy");
                            $('#image2crop').cropper({
                                    aspectRatio: 16 / 9,
                                autoCropArea: 1,
                                crop: function(e) {
                                // Output the result data for cropping image.
//                                    console.log(e.x);
//                                    console.log(e.y);
//                                    console.log(e.width);
//                                    console.log(e.height);
//                                    console.log(e.rotate);
//                                    console.log(e.scaleX);
//                                    console.log(e.scaleY);


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


            function ups(event){
                event.preventDefault();
                // Upload cropped image to server
                var canvas = $('#image2crop').cropper('getCroppedCanvas');

                var fullQuality = canvas.toDataURL("image/jpeg", 1.0);
                console.log(fullQuality);

//                $('.cropper-example-3 > img').cropper('getCroppedCanvas').toBlob(function (blob) {
                var formData = new FormData();

                var old_filename = $('#imgAsli').val();

//                    alert(old_filename);

                formData.append('croppedImage', fullQuality);

                $.ajax('<?=_LANGPATH;?>UploaderCrop/upload?ext=jpg&fname='+old_filename, {
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);

                        var imageHtml = $("#gambarAsli");
                        imageHtml.attr('src', '<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + data+'?t='+$.now());

                        if(data != old_filename){

//                            $('#a_<?//=$id;?>//').attr("href",'<?//=_SPPATH;?>//'+'<?//=_PHOTOURL;?>//' + data);
//                            $('#<?//=$this->id;?>//_<?//=$t;?>// #<?//=$this->id;?>//').val(data);
                        }
                        console.log('Upload success');
//                            alert("Success");
//                        asuccess("Image Cropped Successfully");
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


    function uploadcrop(){
        $crop = new CropAvatar(
            isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
            isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
            isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null
        );

        $response = array(
            'state'  => 200,
            'message' => $crop -> getMsg(),
            'result' => $crop -> getResult()
        );

        echo json_encode($response);
        die();
    }

} 