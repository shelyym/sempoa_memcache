<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BarangWeb
 *
 * @author efindiongso
 */
class BarangWeb extends WebService {

//                            [0] => read_jenis_dan_harga_barang
//                            [1] => update_jenis_dan harga_barang
//                            [2] => delete_jenis_dan harga_barang
//                            [3] => create_jenis_dan_harga_barang

    public function read_jenis_dan_harga_barang() {
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new BarangWebModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_jenis_dan_harga_barang");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_dan_harga_barang");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_dan_harga_barang");
        $crud->run_custom($obj, "BarangWeb", "read_jenis_dan_harga_barang", " kpo_id LIKE '%$myOrgID%' ");
    }

    public function create_jenis_dan_harga_barang() {
        $_GET['cmd'] = 'edit';
        $this->read_jenis_dan_harga_barang();
    }

    public function update_jenis_dan_harga_barang() {
        
    }

    public function delete_jenis_dan_harga_barang() {
        
    }

    // IBO
    public function get_jenis_dan_harga_barang_my_ibo() {
        SettingWeb2Helper::table_harga_Buku_anak2();
        
        die();
        $myOrgID = (AccessRight::getMyOrgID());
        $myParentID = Generic::getMyParentID($myOrgID);
        $obj = new BarangWebModel();
        $crud = new CrudCustomSempoa();
        $like_1 = "( ibo_id LIKE '%, " . $myOrgID . "' OR " . " ibo_id LIKE '" . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '" . $myOrgID . "')";
        $crud->run_custom($obj, "BarangWeb", "get_jenis_dan_harga_barang_my_ibo", " kpo_id='$myParentID' ");
    }

    // TC
//       [BarangWeb] => Array
//                        (
//                            [0] => get_jenis_dan_harga_barang_my_tc
//                            [1] => create_pemesanan_barang_tc
//                            [2] => read_pemesanan_barang_tc
//                            [3] => update_pemesanan_barang_tc
//                            [4] => delete_pemesanan_barang_tc
//                        )
    public function create_pemesanan_barang_tc() {
        $ibo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        BarangWebHelper::form_pemesanan($ibo_id);

        die();
        Generic::getMyRoot();
        $myOrgID = AccessRight::getMyOrgID();
        $kpo_id = Generic::getMyParentID($myOrgID);
        //sempoa__barang_harga
        $objBarang = new BarangWebModel();
        $objStockBarangMyParent = new StockModel();
        global $db;
        $q = "SELECT b.*, s.jumlah_stock, s.jumlah_stock_hold, s.org_id FROM {$objBarang->table_name} b INNER JOIN {$objStockBarangMyParent->table_name} s ON  b.id_barang_harga = s.id_barang WHERE s.org_id='$kpo_id'";
//pr($q);
        $arrStockBarangMyParent = $db->query($q, 2);
//        pr($arrStockBarangMyParent);
        $arrCart = $_SESSION['cart'];
        if (count($arrCart) > 0) {
            foreach ($arrCart as $val) {
                $jumlah = $jumlah + $val['qty'];
            }
        }
        $t = time();
        ?>
        <button type="button" class="pull-right btn btn-danger" id="btn_cart_<?= $t; ?>" >
            <span class="glyphicon glyphicon-shopping-cart" ></span>
            <span class="badge badge-notify my-cart-badge" id='jumlah'><?= $jumlah; ?></span>
        </button>

        <div class="clearfix"></div>
        <style>
            .icon-shopping-cart:before {
                content: "\f07a";
            }
            .prod-info-main {
                border: 1px solid #f39c12;
                margin-bottom: 20px;
                margin-top: 10px;
                background: #fff;
                padding: 6px;
                -webkit-box-shadow: 0 1px 4px 0 rgba(21,180,255,0.5);
                box-shadow: 0 1px 1px 0 rgba(21,180,255,0.5);
            }
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            user agent stylesheet
            div {
                display: block;
            }
            .price-container {
                font-size: 24px;
                margin: 0;
                font-weight: 300;
            }
            .product-deatil {
                /*border-bottom: 1px solid #dfe5e9;*/
                padding-bottom: 17px;
                padding-left: 16px;
                padding-top: 16px;
                position: relative;
                background: #fff;
            }
            .product-deatil .name a {
                margin-left: 0;
            }
            a {
                color: #337ab7;
                text-decoration: none;
            }
            a {
                background-color: transparent;
            }
            .product-block .product-deatil p.price-container span, .prod-info-main .product-deatil p.price-container span, .shipping table tbody tr td p.price-container span, .shopping-items table tbody tr td p.price-container span {
                color: #21c2f8;
                font-family: Lato, sans-serif;
                font-size: 24px;
                line-height: 20px;
            }

            .prod-wrap .product-image span.tag2 {

                position: absolute;

                top: 10px;

                right: 10px;

                width: 36px;

                height: 36px;

                border-radius: 50%;

                padding: 10px 0;

                color: #fff;

                font-size: 11px;

                text-align: center

            }
            .prod-wrap .product-image span.tag3 {

                position: absolute;

                top: 10px;

                right: 20px;

                width: 60px;

                height: 36px;

                border-radius: 50%;

                padding: 10px 0;

                color: #fff;

                font-size: 11px;

                text-align: center

            }
            .prod-wrap .product-image span.sale {

                background-color: #57889c;

            }



            .prod-wrap .product-image span.hot {

                background-color: #a90329;

            }



            .prod-wrap .product-image span.special {

                background-color: #3B6764;

            }
            .product-deatil .name a {
                margin-left: 0;
            }


        </style>
        <?
        foreach ($arrStockBarangMyParent as $barang) {
            ?>
            <div class="col-xs-12 col-md-6">
                <div class="prod-info-main prod-wrap clearfix" id="<?= $barang->id_barang_harga; ?>">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image"> 
                                <?
                                if ($barang->foto_barang === "") {
                                    ?>
                                    <img src="<?= _BPATH . _PHOTOURL . "noimage.jpg"; ?>" class="img-responsive">
                                    <?
                                } else {
                                    ?>
                                    <img src="<?= _BPATH . _PHOTOURL . $barang->foto_barang; ?>" class="img-responsive">
                                    <?
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="product-deatil">
                                <h4 class="name"><b>
                                        <?= $barang->nama_barang; ?>
                                    </B></h4>
                                <p >
                                    <b><span>Stock: <?= Generic::number($barang->jumlah_stock - $barang->jumlah_stock_hold);
                                        ?></span></b>
                                </p>

                                <p class="price-container">
                                    <span><b>IDR <?= idr(Generic::getHargaBarang($barang->id_barang_harga, $kpo_id)); ?></b></span>
                                </p>
                                <span class="tag1"></span> 
                            </div>

                            <div class="product-info smart-form">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <?
                                        if (Generic::number($barang->jumlah_stock - $barang->jumlah_stock_hold) <= 0) {
                                            ?>
                                            <button class="pull-right btn btn-danger" style ="display: none;"id="add_cart_<?= $barang->id_barang_harga; ?>" >Add to cart</button>

                                            <?
                                        } else {
                                            ?>
                                            <button class="pull-right btn btn-danger" id="add_cart_<?= $barang->id_barang_harga . "_" . $t; ?>" >Add to cart</button>

                                            <?
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end product -->
            </div>
            <script>
                // Add to chart, lalu masukin ke session
                var cartObj = {};
                var check = false;
                $('#add_cart_<?= $barang->id_barang_harga . "_" . $t; ?>').click(function () {
                    cartObj.id_barang = parseInt('<?= $barang->id_barang_harga; ?>');
                    cartObj.nama_barang = ('<?= $barang->nama_barang; ?>');
                    cartObj.qty = 1;
                    cartObj.harga_barang = parseInt('<?= Generic::getHargaBarang($barang->id_barang_harga, $kpo_id); ?>');
                    cartObj.stock = '<?= Generic::number($barang->jumlah_stock); ?>';
                    if ('<?= $barang->foto_barang; ?>' == "") {
                        cartObj.pic = '<?= _BPATH . _PHOTOURL . "noimage.jpg"; ?>';
                    } else {
                        cartObj.pic = '<?= _BPATH . _PHOTOURL . "$barang->foto_barang"; ?>';
                    }
                    // Add ke session
                    $.post("<?= _SPPATH; ?>BarangWebHelper/add_cart", cartObj, function (data) {
                        if (data.status_code) {
                            lwrefresh(selected_page);
                            $('#cart_body').load("<?= _SPPATH; ?>BarangWebHelper/cart_modal");

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
                });
                $('#btn_cart_<?= $t; ?>').click(function () {
            <?
            if ($_SESSION['cart'] != null) {
                ?>
                        check = true;
                <?
            }
            ?>
                    if (check) {
                        $('#my-cart-modal').modal("show");
                    }
                    //                   

                });
            </script>
            <?
        }
        ?>
        <script>


        </script>
        <?
    }

    public function read_pemesanan_barang_tc() {
        
        BarangWebHelper::lihat_pesanan_TC();
    }

    public function update_pemesanan_barang_tc() {
        
    }

    public function delete_pemesanan_barang_tc() {
        
    }

    public function get_jenis_dan_harga_barang_my_tc() {

        BukuWebHelper::formBiaya();

//        $obj = new BarangWebModel();
//        $myOrgID = AccessRight::getMyOrgID();
//        $myParentID = Generic::getMyParentID($myOrgID);
//        $mygrandParentID = Generic::getMyParentID($myParentID);
//        $crud = new CrudCustomSempoa();
//        $crud->ar_add = 0;
//        $crud->ar_edit = 0;
//        $crud->ar_delete = 0;
//
//
//        $crud->run_custom($obj, "BarangWeb", "get_jenis_dan_harga_barang_my_tc", "  kpo_id='$mygrandParentID' ");
    }

}
