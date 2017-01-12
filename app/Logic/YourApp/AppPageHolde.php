<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/14/16
 * Time: 2:40 PM
 */

class AppPageHolde {

    public static function pageholder(){

        $id = addslashes($_GET['id']);

        $appAcc = new AppAccount();
        $appAcc->getByID($id);

        global $template;
        $template->pagetitle = substr($appAcc->app_name,0,30);

        ?>

        <div id="pageholder">
        </div>

        <script>
            var app_id = <?=$id;?>;
            $( document ).ready(function() {
                addPage("app_id","<?=_SPPATH;?>AppAPIPrinter/app_getByID?app_id="+app_id,"<?=$appAcc->app_name;?>","");
//                $('#pageholder').load();
            });

            var list_of_pages = [];
            var data_of_pages = {};
            var back_page_id;
            var active_page_id;
            function addPage(id,url,pagetitle,back_id){
//                console.log(id);console.log(url);
                var bool = jQuery.inArray( id, list_of_pages);
//                console.log(bool);

                $(".pagetitle").html(pagetitle);

                data_of_pages[id] = {url:url,pagetitle:pagetitle,back_id:back_id};

                active_page_id = id;
                back_page_id = back_id;

                //manage backbutton
                console.log("back id "+back_id);
                if(back_id!="" && back_id !== undefined){
                    sethistoryback(back_id);
                }else{
                    hidebackbutton();
                }

                if(bool !== -1){
                    $(".dalampage").hide();
                    $("#"+id).show();

//                    console.log("atas");
//                    console.log(list_of_pages);

                }
                else {
//                    console.log("bawah");
//                    console.log(url);
                    $.get(url, function (data) {
                        var wadah = "<div class='dalampage' id='" + id + "'><div class='refresher' onclick=\"page_refresher('"+id+"');\">refresh</div><div class='isidalam'> ";
                        wadah += data;
                        wadah += "</div></div>";

                        list_of_pages.push(id);



                        $('#pageholder').append(wadah);

                        $(".dalampage").hide();
                        $("#"+id).show();

//                        console.log("edn");
//                        console.log(wadah);

                        // modify history
                        var obj = {'lid': id, 'url': url, 'pagetitle':pagetitle,'back_id':back_id};
                        var title = id;
                        var url = '?st=' + id+ '&id='+app_id;
                        history.pushState(obj, title, url);

                        console.log(history);
                        console.log(list_of_pages);
                    });
                }


            }
            window.addEventListener("popstate", function (e) {
                var state = e.state;
                addPage(state.lid, state.url,state.pagetitle,state.back_id);

            });

            function page_refresher(id){
                console.log(data_of_pages);
                var url = data_of_pages[id].url;
                $('#'+id +" .isidalam").load(url);
            }

            function active_page_refresher(){
                var id = active_page_id;
                var url = data_of_pages[id].url;
                $('#'+id +" .isidalam").load(url);
            }

            function back_page_refresher(){
                var id = back_page_id;
                var url = data_of_pages[id].url;
                $('#'+id +" .isidalam").load(url);
            }

            function goto_back_page(){
                var id = back_page_id;
                var url = data_of_pages[id].url;
                var pagetitle = data_of_pages[id].pagetitle;
                var back_id = data_of_pages[id].back_id;
                addPage(id, url,pagetitle,back_id);
            }

        </script>


        <style>
            #pageholder{
                color: #555555;
            }
            .refresher{
                text-align: right;
            }
            a{color: #001f3f;}
        </style>
        <?
    }
} 