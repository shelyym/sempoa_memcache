<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/2/16
 * Time: 5:01 PM
 */

namespace Leap\View;


class InputGallerySortable extends InputGallery{

    public function p(){


        $t = time() + rand(0,1000);
        $startTID = rand(0,10);
        $this->id = $this->id."_".$t;
        // get asli
        $text = '';
        $exp = explode(",",trim(rtrim($this->value)));
        $arrNames = array();
        $sudah = array();
        foreach ($exp as $fil){
            if(in_array($fil, $sudah))
                continue;
            $sudah[] = $fil;
            $fil=trim(rtrim($fil));
            // echo $fil."<br>";
            if($fil=="")continue;
            $exp2 = explode(".",$fil);
            $if = new \InputFileModel();
            // echo $exp2[0]."<br>";
            $if->getByID($exp2[0]);
            $fil2 = explode(".",$fil);
            $fil3 = $fil2[0];
            $arrNames[] = $if;
            //  $text .= "<div id='file_".$exp2[0]."_{$t}' class='mlt_item'>".$if->file_url." <i onclick=\"deleteFromList_{$t}('".$fil."');\" class='glyphicon glyphicon-remove'></i></div>";
            $text .= "<div id='file_".$exp2[0]."_{$t}' class='mlt_item_gal'>";
            $text .= "<div id='gal_$fil3' class='foto100gal'><span class='helper'></span>";
            $text .= "<img ondblclick='makeasmainpic_".$t."(\"$fil\");' src='"._SPPATH.$if->upload_url.$if->file_filename."'></div>";
//            $text .=$if->file_url;
            $text .= "<i onclick=\"deleteFromList_{$t}('".$if->file_filename."');\" class='glyphicon glyphicon-remove'></i></div>";

        }
        ?>
        <input type="text" name="<?=$this->name;?>"  value="<?=$this->value;?>" id="<?=$this->id;?>" class="form-control">

        <div id="hidupload_<?=$t;?>" style="padding-top: 10px;clear:both;">
            <input class="form-control" type="file" id="uploadfolder_<?=$t;?>" name="upl_<?=$this->name;?>" value="<?=$this->value;?>"  multiple  />
        </div>

        <style>

            .helper {
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }

            .mlt_item_gal{
                float:left;
                width: 100px;

            }
            .foto100gal{
                mwidth: 100px;
                height: 100px;
                overflow: hidden;
                border: 1px solid #efefef;
                white-space: nowrap;
                text-align: center;
                margin: 1em 0;
            }
            .foto100gal img{
                max-width: 100px;
                vertical-align: middle;
                cursor: pointer;
            }
            .gal_mainpic{
                border:1px solid red;
            }
        </style>

        <style>
            #sortable_<?=$this->id;?> { list-style-type: none; margin: 0; padding: 0; width: 100%; }
            #sortable_<?=$this->id;?> li {
                cursor: pointer; margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 100px; font-size: 15px; text-align: center; }
        </style>
        <style>
            img.gallerysortable{

                display: block;
                max-width:100px;
                max-height:100px;
                width: auto;
                height: auto;
                cursor: pointer;
            }
        </style>
        <ul id="sortable_<?=$this->id;?>">
            <?

            $sudah = array();
            foreach ($exp as $fil){
                if(in_array($fil, $sudah))
                    continue;
                $sudah[] = $fil;
                $fil=trim(rtrim($fil));
                // echo $fil."<br>";
                if($fil=="")continue;
                $exp2 = explode(".",$fil);
                $if = new \InputFileModel();
                // echo $exp2[0]."<br>";
                $if->getByID($exp2[0]);
                $fil2 = explode(".",$fil);
                $fil3 = $fil2[0];
                $arrNames[] = $if;

                $text = "<i onclick=\"deleteFromList_{$t}('".$if->file_filename."');\" class='glyphicon glyphicon-remove'></i>";

                ?>
                <li id="<?=str_replace(".","_",$if->file_filename);?>" class="ui-state-default">
                    <div style="position: absolute; width: 20px; height: 20px; text-align: center; background-color: #dedede;"><?=$text;?></div>
                    <img class="gallerysortable" src="<?=_SPPATH.$if->upload_url.$if->file_filename;?>">
                </li>
                <?
            }

            ?>

<!--            <li class="ui-state-default">2</li>-->
<!--            <li class="ui-state-default">3</li>-->
<!--            <li class="ui-state-default">4</li>-->
<!--            <li class="ui-state-default">5</li>-->
<!--            <li class="ui-state-default">6</li>-->
<!--            <li class="ui-state-default">7</li>-->
<!--            <li class="ui-state-default">8</li>-->
<!--            <li class="ui-state-default">9</li>-->
<!--            <li class="ui-state-default">10</li>-->
<!--            <li class="ui-state-default">11</li>-->
<!--            <li class="ui-state-default">12</li>-->
        </ul>
        <script>

            $(function() {
                $( "#sortable_<?=$this->id;?>" ).sortable({
                    stop: function(event, ui) {

                        var idsInOrder = $("#sortable_<?=$this->id;?>").sortable("toArray");
                        console.log(idsInOrder);
                        var newarr = [];
                        for(var  key in idsInOrder ){
                            newarr.push(idsInOrder[key].replace("_","."));
                        }

                        $('#<?=$this->id;?>').val(newarr.join());



                    }
                });
                $( "#sortable_<?=$this->id;?>" ).disableSelection();
            });


            // Variable to store your files
            var files;
            $(document).ready(function(){
//                setMainPic_<?//=$t;?>//();
            });
            // Add events
            $('#hidupload_<?=$t;?> input[type=file]').on('change', uploadFiles_<?=$t;?>);

            <?
            $if = new \InputFileModel();
            ?>
            function refreshView_<?=$this->id;?>(){
                if($('#<?=$this->id;?>').val()=='')$( "#sortable_<?=$this->id;?>" ).html('');
                var res = $('#<?=$this->id;?>').val().split(",");
                console.log($('#<?=$this->id;?>').val());

                if(res.length <1)$( "#sortable_<?=$this->id;?>" ).html('');
                console.log(res);
                //refresh views
                var txt = '';
                for(var key in res){
                    if(res[key] == '')continue;
                    txt += '<li id="'+res[key].replace(".", "_")+'" class="ui-state-default">';
                    txt += '<div style="position: absolute; width: 20px; height: 20px; text-align: center; background-color: #dedede;">';
                    txt += '<i onclick="deleteFromList_<?=$t;?>(\''+res[key]+'\');" class="glyphicon glyphicon-remove"></i>';
                    txt += '</div>';
                    txt += '<img class="gallerysortable" src="<?=_SPPATH.$if->upload_url;?>'+res[key]+'">';
                    txt += '</li>';

                }
                $( "#sortable_<?=$this->id;?>" ).html(txt);
            }


            // Grab the files and set them to our variable
            function deleteFromList_<?=$t;?>(id)
            {
                //alert('in'+id);
                var bagi = id.split(".");
                var id_asli = bagi[0];
                var id_ext = bagi[1];
                //kalau yang dihapus mainpic

                if(confirm('<?=Lang::t('Are You Sure? This will delete the file');?>')){

                    var str = $('#<?=$this->id;?>').val();
                    var res = str.split(",");
                    for(var key in res){
                        if(res[key] == id){
                            res.splice(key,1);
                        }
                    }
                    if(res.length>0)
                    $('#<?=$this->id;?>').val(res.join());
                    else
                        $('#<?=$this->id;?>').val("");

                    refreshView_<?=$this->id;?>();
                    //delete on server .. later
                    $.post("<?=_LANGPATH;?>UploaderMultiples/del",{id:id});
                }
            }
            // Catch the form submit and upload the files
            function uploadFiles_<?=$t;?>(event)
            {
                files = event.target.files;
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening

                // START A LOADING SPINNER HERE

                // Create a formdata object and add the files
                var data = new FormData();
                $.each(files, function(key, value)
                {
                    data.append(key, value);
                });

                $.ajax({
                    url: '<?=_LANGPATH;?>UploaderMultiples/uploadfiles_gallery_sortable?t=<?=$t;?>&files=1',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {
                        console.log("ini masuk balikan");
                        console.log(data);
                        console.log(textStatus);

                        if(typeof data.error === 'undefined')
                        {
                            // Success so call function to process the form
                            //submitForm(event, data);
                            console.log("success");
                            //loadfolder_<?=$t;?>(activeTID_<?=$t;?>);
                            /* var fs = data.files;
                             var fstext = fs.split();
                             $('#<?=$this->id;?>').val(fstext);
                         */
                            var dulunya = $('#<?=$this->id;?>').val();
                            if(dulunya != "")
                                $('#<?=$this->id;?>').val(dulunya+","+data.ftext);
                            else
                                $('#<?=$this->id;?>').val(data.ftext);

                            refreshView_<?=$this->id;?>();

                            /*
                            var dulunya2 = $('#sortable_<?=$this->id;?>').html();
                            if(dulunya2 != "")
                                $('#sortable_<?=$this->id;?>').html(dulunya2+" "+data.ftextAsli);
                            else
                                $('#sortable_<?=$this->id;?>').html(data.ftextAsli);
*/
                        }
                        else
                        {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
            }
        </script>
    <?
    }

    public static function printMainPic($src,$id){

//        echo "halo";
//        echo $src;
        if($src == ""){
            $sel = "";
        }else{

            //explode
            $exp = explode(",",$src);

            $arr = array();
            foreach($exp as $e){
                $arr[$e]++;
            }

            $sels = array_keys($arr, max($arr));
            $sel = $sels[0];
//            pr($arr);
//            asort($arr);
//            pr($arr);
//            $sel = array_pop($arr);
//
//            pr($sel);
        }
        $foto = self::getFoto($sel);
        return self::makeFoto($foto,$id);

    }
} 