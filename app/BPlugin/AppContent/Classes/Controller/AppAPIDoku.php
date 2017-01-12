<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/27/16
 * Time: 11:13 AM
 */

class AppAPIDoku {
    /*
    * DEVICES
    */



    /*
     * ACCOUNTS
     */

    function login_me($return = 0){

        /*
         * PARAMS POS
         * usrname
         * pswd
         */

    }

    function register_me(){

        /*
         * PARAMS POST
         *
         * email
         * pwd
         * pwd2
         * name
         * phone
         *
         * uname if any *ignore on not web
         * marketer if any
         */
    }

    function forgot_password(){

        /*
         * PARAMS POST
         *
         * email
         */

    }

    function edit_account()
    {



        $acc_id = addslashes($_POST['acc_id']);
        $password = addslashes($_POST['pswd']); //harus isi password lama untuk verifikasi update account

        $email = addslashes($_POST['email']);

        $webpasswd = addslashes($_POST['webpasswd']);
        $webpasswd2 = addslashes($_POST['webpasswd2']);

        $newpass = addslashes($_POST['newpasswd']);
        $newpass2 = addslashes($_POST['newpasswd2']);
    }
    /*
     * TENTANG APP
     */

    //add hide or not flag for content and content type
    function app_draft(){
        /*
         * PARAMS
         * GET id
         */


    }

    //utk load semua apps dr user id x, if needed
    function get_user_apps()
    {

// POST acc_id
        $acc_id = addslashes($_POST['acc_id']);
    }
    function get_app(){

        /*
         * PARAMS
         * POST app_id
         */


    }

    function add_app(){

        /*
         * PARAMS
         * POST apptitle
         * app_acc
         */

    }

    function edit_app_descr(){

        //POST
        //app_id
        //app_acc
        //apptitle
        //appshort
        //appfull
        //appkey
        //appicon
        //appfeat
        //apppaket


    }

    function change_selected_theme(){

        //POST
        //app_id
        //theme_id
        //acc_id

    }

    function get_themes(){

        //POST
        //app_id
        //acc_id




    }

    function set_home_header(){

//        POST
        //app_id
        //acc_id
        //header_style  //carousel_update,carousel_custom,none
        //carousel_order, only if carousel_custom
        //POST carousel_x, dimana x, explode dari carousel_order


    }


    function set_home_menu_style(){
//        POST
        //app_id
        //acc_id
        //menu_style  //list,grid_1,grid_2,grid_3


    }


    function publish_from_draft(){
        //POST app_id
        //acc_id

    }

    /*
     * TENTANG CONTENT
     */

    //fungsi get content
    function get_content(){
        //POST
        //app_id


    }

    //fungsi add content
    function add_content(){

        //POST
        //app_id
        //content_type
        //articlename //optional


    }

    //fungsi save urutan
    function save_urutan(){

        //POST
        //app_id
        //order //content_id1,content_id2,...


    }

    //fungsi delete content
    function del_content(){

        //POST
        //app_id
        //content_id


    }


    function get_content_byid(){

        //POST
        //content_id



    }

    function edit_default_content($echo = 1){
        //POST
        //content_id
        //articlename
        //content_icon

    }

    function hide_content(){
        //POST
        //app_id
        //content_id
    }

    function unhide_content(){
        //POST
        //app_id
        //content_id
    }
    /*
     * CONTENT TYPE A, B , C versi 2
     */

    //TYPE A
    function get_content_typeA(){

        //POST
        //content_id || a_id (please use a_id if not from home) *prioritas pakai a_id
        //return content, dan typeA object


    }
    function set_content_typeA(){

        /*
         *  PARAMETERS all using POST
         *
         *  1.content_id
         *  2.a_id //bisa = '' atau = 0 kalau tidak ada
         *  3.articlename =  nama typeA nya, e.g about us
         *  4.tabsdata = //ini cuman id1,id2,id3,usw , id = local id
         *
         *  5.Masing2 tabs akan mempunyai
         *  'tabtitle-'+idx
         *  'contenttitle-'+idx
         *  'contenttext-'+idx
         *
         *  6.carouseldata //ini cuman id1,id2,id3
         *
         *  7.masing2 carousel akan mempunyai
         *  'carousel-'+idx
         *
         *  8.callbutton_active
         *  9.callbutton_text
         *  10.callbutton_number
         *
         *  11.emailbutton_active
         *  12.emailbutton_text
         *  13.emailbutton_mail
         *
         *  14.sharebutton_active
         *  15.sharebutton_text
         *   sharebutton_url //new ..roy add 18 july 2016
         *
         *  16.price_active
         *  17.price
         *
         *  18.cat //kalau dia type C
         *
         *
         *
         *   19 . header_type // ada map,video,carousel
         *   if(header_type == video) hrs ada POST video  (dimana video adlh string, e.g url nya)
         *   if(header_type == map ) hrs ada POST map (dimana map adlh string e.g lat,long)
         *   if(header_type == carousel) hrs ada POST carousel,dimana ini adlh order nya, yg didapat dari attribute carousel_asli
         *
         * untuk menghapus carousel, hanya hilangkan dari carousel_ordernya saja...
         *
         *
         * NEW 13 july 2016
         *  20.urlbutton_active
         *  21.urlbutton_text
         *  22.urlbutton_url
         *
         * NEW 18 july
         *  23.tabsdata_active
         */
    }
    function delete_content_typeA(){

        //delete typeA dipakai dari B
        //POST a_id


    }

    //TYPE B
    function get_content_typeB(){

        //POST
        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //return content, dan array of typeA object



    }
    function set_content_typeB(){

        //POST
        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //articlename
        //content_icon
        //typeA_order
        //category_name \\if using category_id
        //typeA_hidden



    }
    function save_carousel_typeA(){
        /*
         * PARAMS POST
         * a_id
         * carouseldata //base64 dari file image
         * return adalah new order dari carousel
         *
         */
    }
    function remove_carousel_typeA()
    {
        //see hapus lewat order di set type a
        //bisa juga hapus satuan
        $a_id = addslashes($_POST['a_id']);
        $carousel_id = addslashes($_POST['carousel_id']);
        $carousel_order = addslashes($_POST['carousel_order']);
    }


    function delete_content_typeB(){

        //dipakai dari TypeC
        //ini adalah delete category atau delete content

        //PARAMS POST
        //content_id || category_id
        //app_id


    }
    function add_content_typeA(){

        //dipakai dari TypeB

        //POST
        //a_id
        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id

        //dipakai kalau dari luar saja yaa... typeB saja dan TypeB nya TypeC


    }


    //TYPE C
    function get_content_typeC(){

        //POST
        //content_id
        //return content, dan array of category with array typeA object



    }
    function set_content_typeC(){

        //POST
        //articlename
        //content_icon
        //typeB_order ==> use updateTypeCCatOrder
        //typeB_hidden


    }
    function delete_content_typeC(){

        //POST
        //app_id
        //content_id

    }
    function add_content_typeB(){

        //dipakai dari TypeC

        //POST
        //cat_name
        //app_id
        //content_id

    }


    /*
     *  STORE
     */

    function addStore(){

        /*
         * PARAMS
         * POST
         *
         * store_id //for edit
         * store_name
         * store_descr
         * store_phone
         * store_email
         * opening_hour
         * store_address
         * lat
         * lng
         * app_id
         * content_id
         *
         */

    }

    function reloadStore(){

        /*
         * PARAMS
         * POST
         * content_id
         */

    }

    function openStore(){

        /*
        * PARAMS
        * POST
        * store_id
        */


    }
    function deleteStore(){
        /*
        * PARAMS
        * POST
        * store_id
        * content_id
        */

    }
    function editStore(){

        //same as add store
        //add store_id

    }


    /*
     *  CONNECT WITH US
     */

    function save_socmed(){

        /*
        * PARAMS
        * POST
        * fb_id
        * instagram_id
         * youtube_id
         * twitter_id
         * content_id
        */



    }





    /*
     *  COntact
     */

    function editContact(){
        /*
       * PARAMS
       * POST
       * telp
       * email
        * address
        * additional
        * lat
         * lng
         * content_id
       */



    }

    /*
     * FAQ
     */

    function editFAQ(){
        /*
         * PARAMS POST
         * judul
         * text
         * content_id
         */


    }

    /*
     * edit Pricelist()
     */

    function editPricelist(){
        /*
         * PARAMS POST
         * judul
         * text
         * table
         * content_id
         */


    }

    function get_transactions()
    {

        $acc_id = addslashes($_POST['acc_id']);

    }



    //NEW 4 July 2016
    function register_device_bridge(){
        /*
         * Params
         * device_id
         * type
         * lng
         * lat
         *

         */

    }

    function register_device(){
        /*
         * Params
         * device_id
         * type
         * lng
         * lat
         * app_id
         * app_token
         * acc_id

         */

    }

    // max user 1000
    //max jark 1000 km
    function get_nearby(){
        //limit 1000
        $app_id = addslashes($_POST['app_id']);
        $lat_awal = addslashes($_POST['lat_awal']);
        $lng_awal = addslashes($_POST['lng_awal']);

    }

    /*
     * PUSH Notif
     */

    function register_push_notif(){



        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);



        $now = addslashes($_POST['push_now']); //not active utk sementara
        $date = addslashes($_POST['push_date']);
        $time = addslashes($_POST['push_time']);
        $title = addslashes($_POST['push_title']);
        $content = addslashes($_POST['push_content']);
        $pic = addslashes($_POST['push_pic']);

        $dev_mode_ids = addslashes($_POST['dev_mode_ids']); //lastlogged, notloggedlama, mapselector
        $dev_ids = addslashes($_POST['dev_ids']);
        //if push_date == now, maka beda approach..diregister trus langsung di push //not active


        //process action
        $action = array();
        //call
        if($_POST['callbutton_active']){
            $action['call']['callbutton_text'] = addslashes($_POST['callbutton_text']);
            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
            $action['call']['callbutton_active']= addslashes($_POST['callbutton_active']);
        }

        //email
        if($_POST['emailbutton_active']){
            $action['email']['emailbutton_text'] = addslashes($_POST['emailbutton_text']);
            $action['email']['emailbutton_mail'] = addslashes($_POST['emailbutton_mail']);
            $action['email']['emailbutton_active'] = addslashes($_POST['emailbutton_active']);
        }

        //call
        if($_POST['sharebutton_active']){
            $action['share']['value'] = 1;
            $action['share']['sharebutton_active'] = addslashes($_POST['sharebutton_active']);
            $action['share']['sharebutton_text'] = addslashes($_POST['sharebutton_text']); //new..blom di frontend 13 june
        }



    }


    function edit_push_notif(){



        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);


        $now = addslashes($_POST['push_now']);
        $date = addslashes($_POST['push_date']);
        $time = addslashes($_POST['push_time']);
        $title = addslashes($_POST['push_title']);
        $content = addslashes($_POST['push_content']);
        $pic = addslashes($_POST['push_pic']);

        $dev_mode_ids = addslashes($_POST['dev_mode_ids']); //lastlogged, notloggedlama, mapselector
        $dev_ids = addslashes($_POST['dev_ids']);
        //if push_date == now, maka beda approach..diregister trus langsung di push


        //process action
        $action = array();
        //call
        if($_POST['callbutton_active']){
            $action['call']['callbutton_text'] = addslashes($_POST['callbutton_text']);
            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
            $action['call']['callbutton_active']= addslashes($_POST['callbutton_active']);
        }

        //email
        if($_POST['emailbutton_active']){
            $action['email']['emailbutton_text'] = addslashes($_POST['emailbutton_text']);
            $action['email']['emailbutton_mail'] = addslashes($_POST['emailbutton_mail']);
            $action['email']['emailbutton_active'] = addslashes($_POST['emailbutton_active']);
        }

        //call
        if($_POST['sharebutton_active']){
            $action['share']['value'] = 1;
            $action['share']['sharebutton_active'] = addslashes($_POST['sharebutton_active']);
            $action['share']['sharebutton_text'] = addslashes($_POST['sharebutton_text']); //new..blom di frontend 13 june
        }




    }


    function get_push_results(){



        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);

        //implementasi blom selesai tunggu Pusher

    }

    function test_push(){
        //ke bridge loh sampainya
        //pakai yang capsule //access_key harus diisi
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);
    }

    function delete_push(){
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);


    }

    function get_push(){



        //pakai yang capsule //blom ada pagination !!!
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);


    }

    function get_push_byid(){


        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);



    }

    /*
     * Home carousel
     */

    function save_home_carousel()
    {


        $carousel = addslashes($_POST['carouseldata']); //base64 image
        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        //app_id
        $app_id = addslashes($_POST['app_id']);

        /*
         * return adalah carousel_asli = order dan carousel = array of img urls
         * delete tinggal waktu set_home_header hilangkan dari order.. atau pakai fungsi delete_home_carousel
         */
    }
    function delete_home_carousel()
    {

        //acc_id
        $acc_id = addslashes($_POST['acc_id']);

        //app_id
        $app_id = addslashes($_POST['app_id']);

        $carousel_id = addslashes($_POST['carousel_id']); //nama filenya
        $carousel_order = addslashes($_POST['carousel_order']); //order terbaru, kalau user sudah ganti order, kalatu tidak diisi order tetap yang lama yang di return
    }

    //agent
    function got_agent(){
        //cust_id
        //product_id
        //merchant_id

        //dipanggil dari login_me



    }

    function agent_dapat_customer(){
        //agent_uname
        //id //acc_id
        //merchant_id //hardcoded in systems, no need to fill


    }

    function agent_convert_product(){
        //agent_uname
        //id //acc_id
        //merchant_id //hardcoded in systems, no need to fill
        //product_id //hitung komisi //hardcoded in systems, no need to fill
        //transaction_id
    }
    function agent_list(){
        //id //acc_id
        //merchant_id //hardcoded in systems, no need to fill
    }
    function get_product_byCodeName(){
        //product_code_name
        //merchant_id
        //call got_agent webservice disana


    }
    function agent_rating(){
        //agent_uname
        //id //acc_id
        //rating_star //confirm budi bentuknya apa...
        //rating_sifat
        //transaction_id
    }
    function agent_send_help(){
        //agent_uname
        //id //acc_id
        //help_id
        //help_text
    }
    function agent_help_list(){
        //agent_uname
        //id //acc_id

    }

    /*
     * PUBLISHED
     */
    function get_content_typeB_published()
    {

        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //return content, dan array of typeA object
    }
    /*
     * LOG Perubahan API
     *
     * 11 July 2016 : add agent functions
     * 13 July 2016 : add urlbutton di set_content_typeA dan register_push_notif dan edit_push_notif
     *                get_content_typeB_published, pagination using get_content_typeB
     *                get_user_apps //utk load user apps misalnya kalau nambah app baru...atau for simple reload
     *                edit_account
     * 18 july 2016  : set_Content_type_A tabsdata_active dan bbrp lainnya share url dan url
     */
} 