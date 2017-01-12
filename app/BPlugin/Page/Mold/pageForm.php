<? $t = time();
$id = (isset($_GET['id'])?addslashes($_GET['id']):0);
if($id){            

    $load = 1;
}
else $load = 0;

//pr($obj);

if($obj->post_author == "")
    $aut = Account::getMyID();
else {
    $aut = $obj->post_author;
}
?>
<div id="PageAddPage_content" class="row">
    <div id="PageAddPage_contentdlm" class="col-md-12">    
     <div id="resultme"></div>
     <!--
     <div id="formgroup_post_title" class="form-group">
        <label for="post_feat_image" class="col-sm-2 control-label"><?=Lang::t('post_featured_image');?></label>
        <div class="col-sm-10">
        <input id="fileupload_post_feat_image" type="file" name="files[]" data-url="<?=_SPPATH;?>plugins/jQuery_File_Upload/server/php/index.php" multiple>
        <span class="help-block" id="warning_post_feat_image"></span>    
        </div>
    </div>-->
<form role="form" method="post" action="<?=_SPPATH;?>PageWeb/Page?cmd=add" id="editform_Page_<?=$t;?>">
    <?
    if($load){?>
    <input type="hidden" name="ID" value="<?=$obj->ID;?>" id="ID" class="form-control">
    <? } ?>
    <input type="hidden" name="post_author" value="<?=$aut;?>" id="post_author" class="form-control"> 
    <input type="hidden" name="post_date" value="<?=$obj->post_date;?>" id="post_date" class="form-control">   
    <input type="hidden" name="post_modified" value="<?=$obj->post_modified;?>" id="post_modified" class="form-control">  
    <div class="form-group">
       <label for="post_image" class="col-sm-2 control-label"><?=Lang::t('post_image');?></label>
        <div class="col-sm-10">
    <?
    $if = new \Leap\View\InputFoto("foto", "post_image", $obj->post_image);
    $if->p();
    ?>
        </div>
       <span class="help-block" id="warning_post_image"></span>  
    </div> 
    <div id="formgroup_post_title" class="form-group">
        <label for="post_title" class="col-sm-2 control-label"><?=Lang::t('post_title');?></label>
        <div class="col-sm-10">
        <input type="text" name="post_title" value="<?=$obj->post_title;?>" id="post_title" class="form-control">
        <span class="help-block" id="warning_post_title"></span>    
        </div>
    </div>
       
    <div id="formgroup_post_content" class="form-group">
        <label for="post_content" class="col-sm-2 control-label"><?=Lang::t('post_content');?></label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="10" name="post_content" id="post_content<?=$t;?>"><?=stripslashes($obj->post_content);?></textarea>
            <span class="help-block" id="warning_post_content"></span>    
        </div>
    </div>
   <script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'post_content<?=$t;?>' );
  </script>    
    
       
    
       
    <div id="formgroup_post_status" class="form-group">
        <label for="post_status" class="col-sm-2 control-label"><?=Lang::t('post_status');?></label>
        <div class="col-sm-10">
            <select name="post_status"  id="post_status" class="form-control">
                <option value="draft" ><?=Lang::t('draft');?></option>
                <option value="publish" <? if($obj->post_status == "publish")echo "selected";?>><?=Lang::t('publish');?></option>
                
             </select>
                   
            <span class="help-block" id="warning_post_status"></span>    
        </div>
    </div>
    
  <div id="formgroup_post_gallery_id" class="form-group">
        <label for="post_gallery_id" class="col-sm-2 control-label"><?=Lang::t('post_container_id');?></label>
        <div class="col-sm-10">
            <?
            $gal2 = new PageContainer();
            $arrGal = $gal2->getWhere("container_active =1 ORDER BY container_name ASC");
            $cid = $_SESSION['pageConID'];
            ?>
            <select <? if($cid != ""){?>disabled="true"<?}?> class="form-control" name="post_gallery_id" id="post_gallery_id">
                <option value="0"><?=Lang::t('No connecting container');?></option>
                <?
                foreach($arrGal as $gal){
                    
                    ?>
                <option <? if($gal->container_id == $obj->post_gallery_id || $gal->container_id == $cid)echo "selected";?> value="<?=$gal->container_id;?>"><?=$gal->container_name;?></option>
                <? } ?>
            </select>
        <span class="help-block" id="warning_post_gallery_id"></span>    
        </div>
    </div>
  <div id="formgroup_post_subcon_id" class="form-group">
        <label for="post_subcon_id" class="col-sm-2 control-label"><?=Lang::t('post_subcon_id');?></label>
        <div class="col-sm-10">
            <?
            $gal2 = new PageContainer();
            if($cid != ""){
                $parenttext = "AND container_parent_id = '$cid'";
            }else{
                $parenttext = "AND container_parent_id != '0'";
            }
            $arrGal = $gal2->getWhere("container_active =1 $parenttext ORDER BY container_name ASC");
            
            ?>
            <select class="form-control" name="post_subcon_id" id="post_subcon_id">
                <option value="0"><?=Lang::t('No Subcontainer');?></option>
                <?
                foreach($arrGal as $gal){
                    
                    ?>
                <option <? if($gal->container_id == $obj->post_subcon_id)echo "selected";?> value="<?=$gal->container_id;?>"><?=$gal->container_name;?></option>
                <? } ?>
            </select>
        <span class="help-block" id="warning_post_subcon_id"></span>    
        </div>
    </div>
  <div id="formgroup_comment_allowed" class="form-group">
        <label for="comment_allowed" class="col-sm-2 control-label"><?=Lang::t('comment_allowed');?></label>
        <div class="col-sm-10">
            <?
           // $gal2 = new Event();
           // $arrGal = $gal2->getWhere("cal_name !='' ORDER BY cal_name ASC");
            $m = new Model();
            $arrGal = $m->arrayYesNO;
            ?>
            <select class="form-control" name="comment_allowed" id="comment_allowed">
                
                <?
                foreach($arrGal as $num=>$gal){?>
                <option <? if($obj->comment_allowed == $num)echo "selected";?> value="<?=$num;?>"><?=$gal;?></option>
                <? } ?>
            </select>
        <span class="help-block" id="warning_comment_allowed"></span>    
        </div>
    </div>
  <div id="formgroup_post_files" class="form-group">
    <label for="post_files" class="col-sm-2 control-label"><?=Lang::t('post_files');?></label>

    <div class="col-sm-10">
<? 
          $c =  new \Leap\View\InputFileMultiple("post_files", "post_files", $obj->post_files);
          $c->p();
  ?>
                <span class="help-block" id="warning_post_files"></span>
    </div>
</div>
  
  
  <!-- channel tambahan -->
  <div id="formgroup_page_channel_id" class="form-group">
        <label for="page_channel_id" class="col-sm-2 control-label"><?=Lang::t('page_channel_id');?></label>
        <div class="col-sm-10">
            <?
            $gal2 = new NewsChannel();
            $arrGal = $gal2->getWhere("channel_active =1 AND channel_type = 'content' ORDER BY channel_name ASC");
            
            ?>
            <select class="form-control" name="page_channel_id" id="page_channel_id">
                
                <?
                if(!isset($obj->page_channel_id) || $obj->page_channel_id<1)$obj->page_channel_id = 1;
                foreach($arrGal as $gal){
                    
                    ?>
                <option <? if($gal->channel_id == $obj->page_channel_id)echo "selected";?> value="<?=$gal->channel_id;?>"><?=$gal->channel_name;?></option>
                <? } ?>
            </select>
        <span class="help-block" id="warning_page_channel_id"></span>    
        </div>
    </div>
  
  
  <div style="display:none;">
      
    <div id="formgroup_post_webtitle" class="form-group">
        <label for="post_webtitle" class="col-sm-2 control-label"><?=Lang::t('post_webtitle');?></label>
        <div class="col-sm-10">
        <input type="text" name="post_webtitle" value="<?=$obj->post_webtitle;?>" id="post_webtitle" class="form-control">
        <span class="help-block" id="warning_post_webtitle"></span>    
        </div>
    </div>
  
  <div id="formgroup_post_webmetakey" class="form-group">
        <label for="post_webmetakey" class="col-sm-2 control-label"><?=Lang::t('post_webmetakey');?></label>
        <div class="col-sm-10">
        <input type="text" name="post_webmetakey" value="<?=$obj->post_webmetakey;?>" id="post_webmetakey" class="form-control">
        <span class="help-block" id="warning_post_webmetakey"></span>    
        </div>
    </div>
  
  <div id="formgroup_post_metadesc" class="form-group">
        <label for="post_metadesc" class="col-sm-2 control-label"><?=Lang::t('post_metadesc');?></label>
        <div class="col-sm-10">
        <input type="text" name="post_metadesc" value="<?=$obj->post_metadesc;?>" id="post_metadesc" class="form-control">
        <span class="help-block" id="warning_post_metadesc"></span>    
        </div>
    </div>
  
  </div>
    <input type="hidden" name="load" value="<?=$load;?>" id="load" class="form-control">  
    
    <div class="form-group">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-default"><?=Lang::t('submit');?></button>
        <button  id="close_button_<?= $formID; ?>" class="btn btn-default"><?=Lang::t('cancel');?></button>
        <script>
         $( "#close_button_<?= $formID; ?>" ).click(function( event ) {
            event.preventDefault();
            lwclose(window.selected_page);
          });   
        </script>
        <? if ($load) { ?>
        <button type="button" id="delete_button_<?= $formID; ?>"
                            class="btn btn-default"><?= Lang::t('delete'); ?></button>
        <?
        $url = _SPPATH . "PageWeb/Page?cmd=delete";
        ?>
        <script type="text/javascript">
            $('#delete_button_<?= $formID; ?>').click(function () {
                if (confirm("<?=Lang::t('Are you sure, you want to delete this object?');?>")) {
                    var url = '<?=$url;?>';
                    //alert(url);
                    var posting = $.post(url, {id: '<?=$id;?>'}, function (data) {
                        //console.log( data );
                        //alert(data);
                        if (data.bool) {
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);
                        }
                        else {
                            alert("<?=Lang::t('Error, Cannot Delete');?>");
                        }

                    }, 'json');
                }
            });
        </script>
        <? } ?>
        </div>
    </div>
    
</form>
<div class="clearfix visible-xs-block"></div>
<script type="text/javascript">
$( "#editform_Page_<?=$t;?>" ).submit(function( event ) {
  //alert( "Handler for .submit() called." );
   // Stop form from submitting normally
  event.preventDefault();
 
    //
    var stop = 0;
 
  // Get some values from elements on the page:
  var $form = $( this ),
  url = $form.attr( "action" );
  
  var tb = 'post_content<?=$t;?>';
  //get data
  var data = CKEDITOR.instances;
    //console.log(data);
    var data2 = data[tb];
    //console.log(data2);
    var data1 = data2.getData();
    //console.log(data1);
        
  if ( data1 == '' ){
    alert( '<?=Lang::t('Content must be filled');?>' );
    stop = 1;
  }
    
  var title = $('#editform_Page_<?=$t;?> #post_title').val();
  if(title == ''){
      alert( '<?=Lang::t('Title must be filled');?>' );
      stop = 1;
  }
  
  var status = $('#editform_Page_<?=$t;?> #post_status').val();
  var img = $('#editform_Page_<?=$t;?> #foto').val();
  
  var post_webtitle = $('#editform_Page_<?=$t;?> #post_webtitle').val();
  var post_webmetakey = $('#editform_Page_<?=$t;?> #post_webmetakey').val();
  var post_metadesc = $('#editform_Page_<?=$t;?> #post_metadesc').val();
  
  var post_gallery_id = $('#editform_Page_<?=$t;?> #post_gallery_id').val();
  var comment_allowed = $('#editform_Page_<?=$t;?> #comment_allowed').val();
  var post_subcon_id  = $('#editform_Page_<?=$t;?> #post_subcon_id').val();
  var post_files = $("#editform_Page_<?=$t;?> input[name='post_files']").val();
  var page_channel_id =  $('#editform_Page_<?=$t;?> #page_channel_id').val();
  //load the dates
  var load = <?=$load;?>;
  var post_date = js_yyyy_mm_dd_hh_mm_ss();
  var post_modified = js_yyyy_mm_dd_hh_mm_ss();
  if(load){
       post_date = $('#editform_Page_<?=$t;?> #post_date').val();
       //post_modified = js_yyyy_mm_dd_hh_mm_ss(); 
      
  }
  
  if(!stop){
  // Send the data using post
  var posting = $.post( url,{page_channel_id:page_channel_id,post_subcon_id:post_subcon_id,post_files:post_files,comment_allowed:comment_allowed,post_gallery_id:post_gallery_id,post_webtitle:post_webtitle,post_webmetakey:post_webmetakey,post_metadesc:post_metadesc,load:load, ID : $('#editform_Page_<?=$t;?> #ID').val(), post_title: title, post_content: data1,post_status : status, post_author : $('#editform_Page_<?=$t;?> #post_author').val(), post_date : post_date,post_modified:post_modified,post_image:img }, function( data ) {
      //alert(data);
  //console.log( data ); // John
  //console.log( data.bool ); // 2pm
  $( "#editform_Page_<?=$t;?> .form-group" ).removeClass('has-error');
  $( "#editform_Page_<?=$t;?> .help-block" ).hide();
  $('#resultme').empty().hide();
  
  if(data.bool){
      lwclose(window.selected_page);
      lwrefresh(window.beforepage);
  }
  else{
      var obj = data.err;
      var tim = data.timeId;
      //console.log( obj ); 
      for (var property in obj) {
        if (obj.hasOwnProperty(property)) {
            if(property!='all'){
                $('#editform_Page_<?=$t;?> #formgroup_'+property).addClass('has-error');
                $('#editform_Page_<?=$t;?> #warning_'+property).empty().append(obj[property]).fadeIn('slow');
            }
            else{
                $('#editform_Page_<?=$t;?> #resultme').empty().append(obj[property]).fadeIn('slow');
            }
        }
     }
  }
},'json');
 
 
 } //end stop
  
});
</script>    
        </div></div>