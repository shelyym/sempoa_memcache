<?php

/**
 * Description of TreeStructure
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class TreeStructure {

    public static function run ($obj, $webClass, $fktname)
    {
        if ($obj instanceof Model) {

            $cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
            if ($cmd == "savetree") {
                $t = new TreeStructure();
                $t->saveTree($obj,$webClass);
                //Crud::createForm($obj, $webClass);
                die();
            }
            if ($cmd == "add") {
                $t = new TreeStructure();
                $t->editMenu($obj,$webClass);
                die();
            }
            TreeStructure::printTree($obj, $webClass,$fktname);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }
    //put your code here
    public static function printTree($object, $webClass,$fktname){

        $classname = get_class($object);
        $t = time();
        if(!is_subclass_of($object,"Model"))
            die("Object must be subclass object of Model");

        //cek apakah sudah punya parent ID
        $par = $object->parentID;
        if($par == "")die("Please define parentID attribute");
        ?>
        <style type="text/css">
            button{
                background: #fff;
                border: solid 1px #000;
                color: #000;
            }

            .tree_hover{
                background: #fdd;
            }

            .tree_item{
                padding: 2px;
                list-style: none;
            }

            .tree_item span:hover{
                background: #ddd;
                cursor: pointer;
            }

            .tree_item span{
                border-bottom: solid 1px #aaa;
            }
        </style>

        <div id="printOut_<?=$t;?>" ></div>
        <div class="col-md-12">
            <?
            $menu_id = $object->main_id;
            ?>
            <h1><?=Lang::t($classname);?></h1>
            <small>To create a new object, just fill in the needed data, to edit an object just double click on the object name</small>
            <div style="padding: 10px; border: 1px solid #cccccc;background-color: white; margin-top: 10px;">
                <form id="treeform_<?=$t;?>" role="form" onsubmit="return false;">
                    <?
                    $editboxarr = $object->printToEditBox;
                    //  pr($editboxarr);
                    foreach($editboxarr as $key=>$arrVals){
                        ?>
                        <div class="form-group">
                            <label for="<?=$key;?>_<?=$t;?>"><?=Lang::t($key);?></label>
                            <input id="<?=$key;?>_<?=$t;?>" type="<?=$arrVals[0];?>" class="form-control" placeholder="<?=Lang::t($key);?>">
                        </div>
                    <? } ?>


                <input type="hidden" id="<?=$menu_id;?>_<?=$t;?>">



                <div class="form-group">
                    <button id="saveButton_<?=$t;?>" onclick="saveMenu_<?=$t;?>();" class="btn btn-default"><?=Lang::t('Save');?></button>

                    <button style="display: none;" id="editButton_<?=$t;?>" onclick="editMenu_<?=$t;?>();" class="btn btn-default"><?=Lang::t('Edit');?></button>

                        <button style="display: none;" id="deleteButton_<?=$t;?>" onclick="delMenu_<?=$t;?>();" class="btn btn-default"><?=Lang::t('Delete');?></button>
                    <button style="display: none;" id="clearButton_<?=$t;?>" onclick="clearMenu_<?=$t;?>();" class="btn btn-default"><?=Lang::t('Clear');?></button>

                    </div>
                </form>

            </div>



        </div>
        <div class="clearfix"></div>
        <div class="row" style="margin-top: 30px;">
            <!--<div style="padding: 10px; padding-bottom: 20px; padding-left: 0px;">
                <button id="save_<?=$t;?>" class="btn btn-default"><?=Lang::t('Save');?></button>
            </div>-->
            <ul id="tag_tree_<?=$t;?>">
                <?
                //$menu = new Menu();
                if(count($object->tree_multi_user_constraint)>0){
                    $where = array();
                    foreach($object->tree_multi_user_constraint as $attr=>$val){
                        $where[] = $attr." = '".$val."'";
                    }
                    $impWhere = implode(" AND ",$where);
                    $arr = $object->getWhere($impWhere);
                }else {
                    $arr = $object->getAll();
                }
                // pr($arr);
                foreach($arr as $n=>$obj){
                    $anak2[$obj->$par][] = $obj;
                }
                //pr($anak2);
                ?>

                <li id="active-menu" class="tree_item"><span><?=Lang::t('Active');?></span>
                    <? TreeStructure::printTreeRecursive(0, $anak2,$object,$t); ?>
                </li>
                <li id="non-active-menu" class="tree_item"><span><?=Lang::t('Non-Active');?></span>
                    <? TreeStructure::printTreeRecursive(-1, $anak2,$object,$t); ?>
                </li>


            </ul>
        </div>


        <script>

        $('#treeform_<?=$t;?>').keypress(function (e) {
            if (e.which == 13) {
                var vis = $("#saveButton_<?=$t;?>").is(":visible");
                if(vis){
                    saveMenu_<?=$t;?>();
                }else{
                    editMenu_<?=$t;?>();
                }
//                $('form#login').submit();
                return false;    //<---- Add this line
            }
        });

        function saveMenu_<?=$t;?>(){
            var err = 0;
            var errmsg = '';
            var postObj = {};
            <?
            foreach($editboxarr as $key=>$arrVals){ ?>
            var <?=$key;?> = $("#<?=$key;?>_<?=$t;?>").val();
            postObj.<?=$key;?> = <?=$key;?>;
            <?
            if($arrVals[1] == "not_empty"){?>
            if(<?=$key;?> == ""){
                errmsg += "<?=Lang::t('Please Insert');?> <?=Lang::t($key);?>\n";
                err = 1;
            }
            <?
            } }
            ?>

            var mid = $("#<?=$menu_id;?>_<?=$t;?>").val();
            postObj.mid = mid;



            if(!err)
                $.post("<?=_LANGPATH.$webClass;?>/<?=$fktname;?>?cmd=add&mode=add",postObj,function(data){
                    console.log(data);
                    if(data.bool){
                        lwrefresh(selected_page);
                    }
                },'json');
            else
                alert(errmsg);
        }
        function delMenu_<?=$t;?>(){
            if(confirm("<?=Lang::t('This will delete the selected object, are you sure?');?>")){
                var postObj = {};
                var mid = $("#<?=$menu_id;?>_<?=$t;?>").val();
                postObj.mid = mid;
                var err = 0;
                var errmsg = '';

                if(mid == ""){
                    errmsg += "<?=Lang::t('Please Insert ID');?>";
                    err = 1;
                }

                if(!err)
                    $.post("<?=_LANGPATH.$webClass;?>/<?=$fktname;?>?cmd=add&mode=del",postObj,function(data){
                        console.log(data);
                        if(data.bool){
                            lwrefresh(selected_page);
                        }
                    },'json');
                else
                    alert(errmsg);
            }
        }
        function editMenu_<?=$t;?>(){

            var err = 0;
            var errmsg = '';
            var postObj = {};
            <?
            foreach($editboxarr as $key=>$arrVals){?>
            var <?=$key;?> = $("#<?=$key;?>_<?=$t;?>").val();
            postObj.<?=$key;?> = <?=$key;?>;
            <?
            if($arrVals[1] == "not_empty"){?>
            if(<?=$key;?> == ""){
                errmsg += "<?=Lang::t('Please Insert');?> <?=Lang::t($key);?>\n";
                err = 1;
            }
            <?
            } }
            ?>

            var mid = $("#<?=$menu_id;?>_<?=$t;?>").val();
            postObj.mid = mid;

            if(mid == ""){
                errmsg += "<?=Lang::t('Please Insert ID');?>";
                err = 1;
            }

            if(!err)
                $.post("<?=_LANGPATH.$webClass;?>/<?=$fktname;?>?cmd=add&mode=edit",postObj,function(data){
                    console.log(data);
                    if(data.bool){
                        lwrefresh(selected_page);
                    }
                },'json');
            else
                alert(errmsg);
        }
        function printToEditBox_<?=$t;?>(json,mid){

            console.log(json);
            console.log(mid);
            var obj = JSON.parse(atob(json));
            console.log(obj);
            <?
            foreach($editboxarr as $key=>$arrVals){?>
            $("#<?=$key;?>_<?=$t;?>").val(obj.<?=$key;?>);
            <? } ?>

            $("#<?=$menu_id;?>_<?=$t;?>").val(mid);


            $("#editButton_<?=$t;?>").show();
            $("#deleteButton_<?=$t;?>").show();
            $("#clearButton_<?=$t;?>").show();
            $("#saveButton_<?=$t;?>").hide();
        }

        function clearMenu_<?=$t;?>(){
            $("#editButton_<?=$t;?>").hide();
            $("#deleteButton_<?=$t;?>").hide();
            $("#clearButton_<?=$t;?>").hide();
            $("#saveButton_<?=$t;?>").show();

            <?
            foreach($editboxarr as $key=>$arrVals){?>
            $("#<?=$key;?>_<?=$t;?>").val('');
            <? } ?>

            $("#<?=$menu_id;?>_<?=$t;?>").val('');
        }

        function parseTree(ul){
            var tags = [];
            ul.children("li").each(function(){
                var subtree =	$(this).children("ul");
                if(subtree.size() > 0)
                    tags.push([$(this).attr("id"), parseTree(subtree)]);
                else
                    tags.push($(this).attr("id"));
            });
            return tags;
        }

        $(document).ready(function(){

            $("li.tree_item span").droppable({
                tolerance		: "pointer",
                hoverClass		: "tree_hover",
                drop			: function(event, ui){
                    var dropped = ui.draggable;
                    dropped.css({top: 0, left: 0});
                    var me = $(this).parent();
                    if(me == dropped)
                        return;
                    var subbranch = $(me).children("ul");
                    if(subbranch.size() == 0) {
                        me.find("span").after("<ul></ul>");
                        subbranch = me.find("ul");
                    }
                    var oldParent = dropped.parent();
                    subbranch.eq(0).append(dropped);
                    var oldBranches = $("li", oldParent);
                    if (oldBranches.size() == 0) { $(oldParent).remove(); }

                    ///save tree
                    var tree = parseTree($("#tag_tree_<?=$t;?>"));
                    var n = JSON.stringify(tree);
                    console.log(n);

                    //var tree = $.toJSON(tree));
                    $.post("<?=_LANGPATH.$webClass;?>/<?=$fktname;?>?cmd=savetree", {tags: n}, function(data){
                        $("#printOut_<?=$t;?>").hide();
                        if(data.bool){
                            asuccess(data.err);
                            clear_permanent();
                        }else{

                            lwrefresh(selected_page);
                            perror(data.err);
//                            $("#printOut_<?//=$t;?>//").show();
//                            $("#printOut_<?//=$t;?>//").html(data.err);
                        }
                    },'json');
                }
            });

            $("li.tree_item_drag").draggable({
                opacity: 0.5,
                revert: true
            });

            $("#save_<?=$t;?>").click(function(){
                var tree = parseTree($("#tag_tree_<?=$t;?>"));
                var n = JSON.stringify(tree);
                console.log(n);

                //var tree = $.toJSON(tree));
                $.post("<?=_LANGPATH.$webClass;?>/<?=$fktname;?>?cmd=savetree", {tags: n}, function(data){
                    $("#printOut_<?=$t;?>").hide();
                    if(data.bool){
                        asuccess(data.err);
                        clear_permanent();
                    }else{
//                        $("#printOut_<?//=$t;?>//").show();
//                        $("#printOut_<?//=$t;?>//").html(data.err);
                        lwrefresh(selected_page);
                        perror(data.err);
                    }
                },'json');

                //$.debug.print_r(parseTree($("#tag_tree")), "printOut", false);
            });



        });

        function encHTML(str){
            return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }

        (function($){
            $.debug = {
                dump: function(arr, level, enc) {
                    var dumped_text = "";
                    if(!level) level = 0;
                    var level_padding = "";
                    for(var j=0;j<level+1;j++) level_padding += "    ";
                    if(typeof(arr) == 'object') { //Array/Hashes/Objects
                        for(var item in arr) {
                            var value = arr[item];

                            if(typeof(value) == 'object') { //If it is an array,
                                dumped_text += level_padding + "'" + item + "' ...\n";
                                dumped_text += $.debug.dump(value, level+1);
                            }else if(typeof(value) == 'string'){
                                value = enc == true ? encHTML(value) : value;
                                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                            } else {
                                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                            }
                        }
                    } else { //Stings/Chars/Numbers etc.
                        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
                    }
                    return dumped_text;
                },
                print_r: function(obj, contId){
                    $("#"+contId).removeClass().css({
                        display: "block",
                        position: "absolute",
                        top: "0px",
                        right: "0px",
                        padding: "10px",
                        width: "700px",
                        height: "auto",
                        background: "#ddd",
                        color: "black",
                        border: "solid 1px black",
                        zIndex: 1000
                    }).html("<pre>"+$.debug.dump(obj)+"</pre><div id='close-debug'>Close</div>");

                    $("#close-debug").css({cursor: "pointer"}).click(function(){
                        $("#"+contId).remove();
                    });
                }
            };
        })(jQuery);


        </script>
    <?
    }
    public static function printTreeRecursive($startNode,$anak2,$object,$t){
        $arr = $object->printToEditBox;

        $namaID = $object->nameID;
        //$t = time().rand(0,10);
        if(count($anak2[$startNode])>0){
            ?>
            <ul>
                <?
                foreach($anak2[$startNode] as $n=>$o){
                    //get the main id
                    $menu_id = $o->main_id;
                    $arrDikirim = array();
                    foreach($arr as $n1=>$v){
                        $arrDikirim[$n1] = $o->$n1;
                    }
                    $str = base64_encode(json_encode($arrDikirim));
                    ?>
                    <li id="<?=$t."_".$o->$menu_id;?>" class="tree_item tree_item_drag">
                        <span ondblclick='printToEditBox_<?=$t;?>("<?=$str;?>","<?=$o->$menu_id;?>");'><?=$o->$namaID;?> </span>
                        <? TreeStructure::printTreeRecursive($o->$menu_id, $anak2,$object,$t); ?>
                    </li>
                <?
                }
                ?>
            </ul>
        <?
        }

    }

    function hitungAnakActive($arr){
//        pr($arr);
//        $active = $arr[0];
        $cnt = 0;
        foreach($arr as $obj) {
            if (is_array($obj)) {
                //if yes
                //get the first col as name and the res as children
//                $arrlanjutan = $obj[1];

                $cnt += $this->hitungAnakActive($obj);
            } else {
                $cnt++;
            }
        }
//        echo $cnt;
        return $cnt;
    }


    function saveTree($object,$webClass){
        $tree = $_POST['tags'];
        $arr = json_decode($tree);


        $json = array();

        //get active knoten
        $nrActive = $this->hitungAnakActive($arr[0][1]);

//        echo "<h1>".$nrActive."</h1>";
//        pr($arr);

        //cek apakah paket sesuai dengan yg diperbolehkan
        $app = AppAccount::getActiveAppObject();

        //category 1_7
        $cat_id = $app->app_paket_id."_7";
//
        $mm = new PaketMatrix();
        $mm->getByID($cat_id);
//
        $limit = (int)$mm->ps_isi;
//
//        //get all campaign dengan app_id dan type yg diperbolehkan
//        $nr = $object->getJumlah("cat_parent_id != '-1' AND cat_app_id = '".$app->app_id."'");
//
//
//        echo "nr = ".$nr." limit : ".$limit;

        if($nrActive>$limit){
            $json['bool'] = 0;
            $json['err'] = "<h1>Too Many Categories!! Limit is $limit </h1>";
            echo json_encode($json);
            die();
        }



        //pr($arr);
        foreach($arr as $n=>$obj){
            //cek apakah array
            if(is_array($obj)){
                //if yes
                //get the first col as name and the res as children
                $id = $obj[0];
                //echo "adalah array dengan element pertama adalah $id <br>";

                //pr($obj);
                $this->saveTreeRecursive($obj[1],$id,$object,$webClass);
            }else{
                $id = $obj;
                //di skip aja krn tidak disave juga
            }


        }
        $json['bool']=1;
        $json['err'] = "<h1>Success</h1>";
        echo json_encode($json);
        die();
//        exit();
    }
    function saveTreeRecursive($arr,$parent_id,$object,$webClass){
        // echo "masuk save tree recursive <br> ";
        //echo "parent id : ".$parent_id."<br>";
        //echo "obj id : ".$obj;
        //pr($obj);
        /*if($parent_id == "non-active-menu" ||$parent_id == "active-menu" )
            return "";
        */
        foreach($arr as $n=>$obj){
            //cek apakah array
            if(is_array($obj)){
                //if yes
                //get the first col as name and the res as children
                $id = $obj[0];
                $this->saveToObj($id,$parent_id,$object,$webClass);
                $this->saveTreeRecursive($obj[1],$id,$object,$webClass);
            }else{
                $id = $obj;
                //kalo bukan array di save
                $this->saveToObj($id,$parent_id,$object,$webClass);

            }
        }

    }
    function saveToObj($id,$parent_id,$object,$webClass){
        $exp = explode("_",$id);
        $m = $object;
        $m->getByID($exp[1]);
        $par = $object->parentID;
        // echo $parent_id;
        if($parent_id === "active-menu")$parent_id = 0;
        if($parent_id === "non-active-menu")$parent_id = -1;
        if($parent_id !== 0 && $parent_id !== -1){
            $exp2 = explode("_",$parent_id);
            $parent_id = $exp2[1];
        }
        $m->$par = $parent_id;
        $m->load = 1;
        //pr($m);
        if($id == "non-active-menu" ||$id == "active-menu" ){
            //echo " <h3>not save krn id $id </h3><br><br>";
            return "";
        }

        //sebelum disave pastikan app yang active yang bisa save
        foreach($m->tree_multi_user_constraint as $attr=>$val){
            $m->$attr = $val;
        }

        //echo "<br><h2> saving the object". $id." with parent ".$parent_id."</h2><br><br>";
        $m->save();
    }

    function editMenu($obj,$webClass){
        $arr = $obj->printToEditBox;
        $par = $obj->parentID;
        /*foreach($arr as $key=>$arrVal){
            $$key = $_POST[$key]?addslashes($_POST[$key]):"New $key";
        }*/

        $mid = $_POST['mid']?addslashes($_POST['mid']):0;
        $mode = addslashes($_GET['mode']);
        $json = array();
        //$menu = new Menu(); 
        $menu = $obj;

        if($mode == "add"){
            foreach($arr as $key=>$arrVal){
                $menu->$key = addslashes($_POST[$key]);
            }
            foreach($menu->tree_multi_user_constraint as $attr=>$val){
                $menu->$attr = $val;
            }
            $json['par'] = $par;
            $menu->$par = -1;
            $json['menupar'] = $menu->$par;
            $json['menu'] = $menu;
            $json['bool'] = $menu->save();
        }
        elseif($mode == "del"){

            $json['bool'] = $menu->delete($mid);
        }
        else{

            $menu->getByID($mid);
            $json['mid'] = $mid;
            foreach($arr as $key=>$arrVal){
                $menu->$key = addslashes($_POST[$key]);
            }
            foreach($menu->tree_multi_user_constraint as $attr=>$val){
                $menu->$attr = $val;
            }
            $json['menu'] = $menu;
            $menu->load = 1;
            $json['bool'] = $menu->save();
        }
        echo json_encode($json);

    }
}
