<div style="padding: 10px;"></div>
<?// pr($roleObj);?>
<div class="col-md-4" style="padding-top: 10px; padding-bottom: 10px;">
    <div id="profilepic" onclick="openFileOption()">
    <? 
    $t = time();
    $src = _SPPATH.Leap\View\InputFoto::getFoto($roleObj->admin_foto);
    $id = "holder_foto_old_" . $t;
    
    ?>
        <img src="<?=$src;?>" id="<?=$id;?>" style="width: 100%;">
        <input type="file" id="upload" name="upload" style="visibility: hidden; width: 1px; height: 1px"  />
    </div>
<script>
function openFileOption()
{
    document.getElementById('upload').click(); return false;
  
}


            document.querySelector('#profilepic input[type=file]').addEventListener('change', function (event) {
                // Read files
                var files = event.target.files;
                //alert('in');
                //console.log(files);
                // Iterate through files
                for (var i = 0; i < files.length; i++) {
                    // alert('in2');
                    // Ensure it's an image
                    if (files[i].type.match(/image.*/)) {
                        var reader = new FileReader();
                        //alert('in3');
                        //console.log(reader);
                        reader.onload = function (readerEvent) {
                            // alert('in3b');
                            var image = new Image();
                            //alert('in4');
                            //console.log(image);
                            image.onload = function (imageEvent) {
                                // Resize image
                                var canvas = document.createElement('canvas'),
                                    max_size = 1200,
                                    width = image.width,
                                    height = image.height;
                                if (width > height) {
                                    if (width > max_size) {
                                        height *= max_size / width;
                                        width = max_size;
                                    }
                                } else {
                                    if (height > max_size) {
                                        width *= max_size / height;
                                        height = max_size;
                                    }
                                }
                                canvas.width = width;
                                canvas.height = height;
                                canvas.getContext('2d').drawImage(image, 0, 0, width, height);

                                //alert('in');

                                // Upload image
                                var xhr = new XMLHttpRequest();
                                if (xhr.upload) {

                                    // Update progress
                                    xhr.upload.addEventListener('progress', function (event) {
                                        var percent = parseInt(event.loaded / event.total * 100);
                                        //progressElement.style.width = percent+'%';
                                    }, false);

                                    // File uploaded / failed
                                    xhr.onreadystatechange = function (event) {
                                        if (xhr.readyState == 4) {
                                            if (xhr.status == 200) {

                                                //imageElement.classList.remove('uploading');
                                                //imageElement.classList.add('uploaded');
                                                var imageHtml = document.getElementById("holder_foto_old_<?=$t;?>");

//                                                imageHtml.removeAttribute("style");
//                                                imageHtml.removeAttribute("width");
//                                                imageHtml.removeAttribute("height");
                                                imageHtml.src = '<?=_SPPATH._PHOTOURL;?>' + xhr.responseText;
                                                //$('#upload').val(xhr.responseText);
                                                //imageHtml.onload(function(){resizeAndJustify("holder_foto_old_<?=$t;?>",100);});
                                                //document.getElementById('progress_fotodatamurid_<?=$t;?>').style.display = 'none';
                                                //$('loadingtop').fade();
                                                //$('oktop').fade().fade();
                                                console.log('Image uploaded: ' + xhr.responseText);

                                                $("#leftMainPicMenu").attr("src","<?=_SPPATH._PHOTOURL;?>"+xhr.responseText);
                                                $("#PPimage2").attr("src","<?=_SPPATH._PHOTOURL;?>"+xhr.responseText);
                                                $("#PPimage1").attr("src","<?=_SPPATH._PHOTOURL;?>"+xhr.responseText);

                                                /*$('close_button_pop1').onClick(function(){
                                                 $('content_utama').load('
                                                <?=_SPPATH;?>datamurid/harmonica_widget?aj=1',{spinner:"loadingtop"});
                                                 $('pop1').hide();
                                                 });*/
                                                 $.get("<?=_SPPATH;?>Account/changePic?uid=<?=Account::getMyID();?>&file="+xhr.responseText);   
                                            } else {
                                                //imageElement.parentNode.removeChild(imageElement);
                                            }
                                        }
                                    }

                                    // Start upload
                                    xhr.open('post', '<?=_SPPATH;?>uploader/uploadres?adafile=<?=$roleObj->admin_foto; ?>', true);
                                    xhr.send(canvas.toDataURL('image/jpeg'));

                                }
                            }
                            image.src = readerEvent.target.result;

                        }
                        reader.readAsDataURL(files[i]);

                    }
                }

            });
        
</script>

</div>
<div class="col-md-8">
    <? //pr($arr);?>
    <div style="padding-left: 20px;">
        
    <div class="table-responsive">
        <h3 style="padding-left: 10px; padding-top: 0px; margin-top: 0;"><?= $roleObj->getName(); ?></h3>
        <table class="table table-striped">
            
<!--            <tr>-->
<!--                <td>-->
<!--                    --><?//= Lang::t('Department'); ?><!-- :-->
<!--                </td>-->
<!--                <td>-->
<!--                    --><?//= RoleOrganization::getMy()->organization_name; ?>
<!--                </td>-->
<!--                -->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>-->
<!--                    --><?//= Lang::t('Level'); ?><!-- :-->
<!--                </td>-->
<!--                -->
<!--                <td>-->
<!--                    --><?//= RoleLevel::getMy()->level_name; ?>
<!--                </td>-->
<!--            </tr>-->
            <tr>
                <td>
                    <?= Lang::t('Administrator Role'); ?> :
                </td>
                
                <td>
                    <?= Account::getMyRole();?>
                </td>
            </tr>
        </table>
        <h3 style="padding-left: 10px;"><?= Lang::t('Account Details'); ?></h3>
        <table class="table table-striped">
            <tr>
                <td>
                    <?= Lang::t('Username'); ?> :
                </td>
                <td>
                    <?= Account::getMyUsername(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Password'); ?> :
                </td>
                <td>
                    <? $xx = strlen(Account::getMyPassword()); for($x=0;$x<$xx;$x++)echo "*"; ?>
                </td>
            </tr>
        </table>
    </div>
    </div>
</div>
<div style="padding-bottom: 50px; clear: both;"></div>    
    <?php



