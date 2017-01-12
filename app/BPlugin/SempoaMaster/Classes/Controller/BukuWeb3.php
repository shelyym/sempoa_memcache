<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BukuWeb3
 *
 * @author efindiongso
 */
class BukuWeb3 extends WebService {

    //p$('#my-cart-modal').modal("show");ut your code here
    function create_pemesanan_buku() {
        $kpo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        BarangWebHelper::form_pemesanan($kpo_id);
    }

    function create_pemesanan_buku_lama() {
        // buat form seperti ecom
        // buat PO
        $myOrgID = AccessRight::getMyOrgID();
        $kpo_id = Generic::getMyParentID($myOrgID);
//        pr($myOrgID);
//        pr($kpo_id);
        //sempoa__barang_harga
        $objBarang = new BarangWebModel();
        $objStockBarangMyParent = new StockModel();
        global $db;
        $q = "SELECT b.*, s.jumlah_stock, s.jumlah_stock_hold FROM {$objBarang->table_name} b INNER JOIN {$objStockBarangMyParent->table_name} s ON  b.id_barang_harga = s.id_barang WHERE s.org_id='$kpo_id'";
//pr($q);
        $arrStockBarangMyParent = $db->query($q, 2);
//        pr($arrStockBarangMyParent);
        $arrCart = $_SESSION['cart'];
        $jumlah = 0;
        if (count($arrCart) > 0) {
            foreach ($arrCart as $val) {
                $jumlah = $jumlah + $val['qty'];
            }
        }
        $t = time();
        ?>
        <button type="button" class="pull-right btn btn-danger" id="btn_cart_barang_total" <? if ($jumlah < 1) echo "style='display:none;'"; ?> >
            <span class="glyphicon glyphicon-shopping-cart" ></span>
            <span class="badge badge-notify my-cart-badge" id='jumlah_cart_barang_total'><?= $jumlah; ?></span>
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
                            $('#jumlah_cart_barang_total').html(data.qty);
            //                            lwrefresh(selected_page);
                            if (data.qty > 0) {
                                $('#btn_cart_barang_total').show();
                            }

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
                });

            </script>
            <?
        }
        ?>
        <script>
            $('#btn_cart_barang_total').click(function () {

                $('#cart_body').load("<?= _SPPATH; ?>BarangWebHelper/cart_modal");
                $('#my-cart-modal').modal("show");


            });

        </script>
        <?
    }

    function create_pemesanan_buku_tmp() {
        // buat form seperti ecom
        // buat PO
        $myOrgID = AccessRight::getMyOrgID();
        $kpo_id = Generic::getMyParentID($myOrgID);
        //sempoa__barang_harga
        $objBarang = new BarangWebModel();
        $objStockBarangMyParent = new StockModel();
        global $db;
        $q = "SELECT b.*, s.jumlah_stock FROM {$objBarang->table_name} b INNER JOIN {$objStockBarangMyParent->table_name} s ON  b.id_barang_harga = s.id_barang WHERE org_id='$kpo_id'";

        $arrStockBarangMyParent = $db->query($q, 2);
        $t = time();
        $poItem = new POItemModel();
        $po = $_SESSION['po_id'];
        $jumlah = 0;
        $arrPO = $poItem->getWhere("po_id='$po'");
        if (count($arrPO) > 0) {
            foreach ($arrPO as $val) {
                $jumlah = $jumlah + $val->qty;
            }
        }
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
//        pr($arrStockBarangMyParent);
        foreach ($arrStockBarangMyParent as $barang) {
            ?>


            <div class="col-xs-12 col-md-6">
                <!-- First product box start here-->
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
                                    <b><span>Stock: <?= Generic::number($barang->jumlah_stock);
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
                                        <button class="pull-right btn btn-danger" id="add_cart_<?= $barang->id_barang_harga; ?>">Add to cart</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end product -->
            </div>
            <script>
                var po_id = "";
                var item_id = "";
                $('#add_cart_<?= $barang->id_barang_harga; ?>').click(function () {
                    var harga_barang = '<?= Generic::getHargaBarang($barang->id_barang_harga, $kpo_id); ?>';
                    $.get("<?= _SPPATH; ?>BarangWebHelper/add_cart?po_id=" + po_id + "&item_id=" + item_id + "&harga_barang=" + harga_barang + "&id_barang=<?= $barang->id_barang_harga; ?>", function (data) {
                        if (data.status_code) {
                            //success
                            alert(data.status_message);
                            po_id = data.po_id;
                            item_id = data.item_id;
                            console.log(data);
                            lwrefresh(selected_page);

                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
                });

            </script>
            <?
        }
        ?>
        <script>
            $('#btn_cart_<?= $t; ?>').click(function () {
                $('#my-cart-modal').modal("show");
                //                openLw("page_cart", "<?= _SPPATH; ?>StockWebHelper/page_cart", "fade");
                //                 openLw("read_status_guru_ibo", "<?= _SPPATH; ?>GuruWeb4/read_status_guru_ibo?tc_id=" + tc_id, "fade");
            });
        </script>
        <?
    }

    function read_pemesanan_buku() {
//        BarangWebHelper::lihat_pesanan();
//        die();
        $myOrgID = AccessRight::getMyOrgID();
        $kpo_id = Generic::getMyParentID($myOrgID);
        $objPO = new POModel();
        $objPOItems = new POItemModel();
        $page = isset($_GET['page']) ? addslashes($_GET['page']) : 1;
        $limit = KEY::$LIMIT_PO;
        $begin = ($page - 1) * $limit;
        $arrPO = $objPO->getWhere("po_penerima='$kpo_id' AND po_pengirim='$myOrgID' ORDER BY po_tanggal DESC LIMIT $begin,$limit");
        $jumlahTotal = $objPO->getJumlah("po_penerima='$kpo_id' AND po_pengirim='$myOrgID'");
        $jumlahHalamanTotal = ceil($jumlahTotal / $limit);
        $t = time();
        ?>
        <style>
            .caret {
                display: inline-block;
                width: 0;
                height: 0;
                margin-left: 2px;
                vertical-align: middle;
                border-top: 4px solid;
                border-right: 4px solid transparent;
                border-left: 4px solid transparent;
            }
        </style>
        <section class="content-header">
            <h1>History pemesanan Barang <?=  Generic::getTCNamebyID(AccessRight::getMyOrgID());?> ke KPO</h1>
        </section>
        <section class="content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="background-color: #FFFFFF;">
                    <thead>
                        <tr>
                            <th><b>No. PO</b></th>
                            <th><b>Tanggal</b></th>
                            <th><b>Pengirim PO</b></th>
                            <th><b>Penerima PO</b></th>
                            <th><b>Status</b></th>
                            <th class="palingdalam_<?= $t; ?>" style="visibility:hidden;display: none"><b>Barang</b></th>
                            <th class="palingdalam_<?= $t; ?>" style="visibility:hidden;display: none"><b>Qty</b></th>
                            <th class="palingdalam_<?= $t; ?>" style="visibility:hidden;display: none"><b>Harga</b></th>
                            <th><b>Total Harga</b></th>
                        <tr>
                    </thead>
                    <tbody id="body_<?= $t; ?>">
                        <?
                        foreach ($arrPO as $po) {
                            $arrPOItems = $objPOItems->getWhere("po_id = $po->po_id");
//                    pr($arrPOItems);
                            if ($po->po_status == KEY::$STATUS_NEW)
                                $warna = KEY::$WARNA_BIRU;
                            elseif ($po->po_status == KEY::$STATUS_PAID)
                                $warna = KEY::$WARNA_HIJAU;
                            elseif ($po->po_status == KEY::$STATUS_CANCEL)
                                $warna = KEY::$WARNA_MERAH;
                            $acc = new Account();
                            $arrname = $acc->getWhere("admin_org_id = '$po->po_pengirim'");
                            //hitung total hrg manually roy 14 sep 2016
                            $total_satu_po = 0;

                            foreach ($arrPOItems as $items) {
                                $total_satu_po += $items->harga * $items->qty;
                            }
                            ?>
                            <tr class='<?= $po->po_id ?> atas_<?= $t; ?><?= $po->po_id ?>' style="background-color: <?= $warna; ?>;">

                                <td id='open_<?= $t; ?><?= $po->po_id ?>' onclick="bukaPO2('<?= $po->po_id ?>', '<?= $po->po_status; ?>');">
                                    <?= $po->po_id ?>

                                    <span class="caret" style="cursor: pointer;"></span>
                                </td>
                                <td><?= $po->po_tanggal ?></td>
                                <td><?= $acc->getMyName(); ?></td>
                                <td><?= Generic::getTCNamebyID($po->po_penerima); ?></td>


                                <td id='status_po_<?= $po->po_id; ?>'><?
                                    if ($po->po_status == 0) {
                                        echo "New";
                                    } elseif ($po->po_status == 1) {
                                        echo "Paid";
                                    } elseif ($po->po_status == 99) {
                                        echo "Cancel";
                                    }
                                    ?></td>

                                <td class='<?= $po->po_id; ?> palingdalam_<?= $t; ?>'  style="visibility:hidden;display: none"></td>
                                <td class='<?= $po->po_id ?> palingdalam_<?= $t; ?>'  style="visibility:hidden;display: none"></td>
                                <td class='<?= $po->po_id ?> palingdalam_<?= $t; ?>' style="visibility:hidden;display: none"></td>
                                <td><?= "IDR " . idr($total_satu_po); ?></td>

                            </tr>
                            <?
                            foreach ($arrPOItems as $items) {
                                ?>
                                <tr class='<?= $po->po_id ?>'   style="visibility:hidden;display: none">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class='<?= $po->po_id ?>' ><?= $items->qty ?></td>
                                    <td class='<?= $po->po_id ?> ' ><?= Generic::getNamaBarangByIDBarang($items->id_barang); ?></td>

                                    <td class='<?= $po->po_id ?>' ><?= "IDR " . idr($items->harga); ?></td>
                                    <td class='<?= $po->po_id ?>' ><?= "IDR " . idr($items->harga * $items->qty) ?></td>

                                </tr>
                                <?
                            }
                            ?>
                        <script>
                            var openPO_id = 0;
                            var listOpenPOID = [];
                            function bukaPO2(po_id, id_status) {

                                var pos = jQuery.inArray(po_id, listOpenPOID);
                                console.log(pos);
                                if (pos == -1) {
                                    $("#body_<?= $t; ?> tr." + po_id).removeAttr("style");
                                    $("#body_<?= $t; ?> td." + po_id).removeAttr("style");
                                    if (id_status == '<?= KEY::$STATUS_NEW ?>') {
                                        warna = '<?= KEY::$WARNA_BIRU ?>';
                                    } else if (id_status == '<?= KEY::$STATUS_PAID ?>') {
                                        warna = '<?= KEY::$WARNA_HIJAU ?>';
                                    } else if (id_status == '<?= KEY::$STATUS_CANCEL ?>') {
                                        warna = '<?= KEY::$WARNA_MERAH ?>';
                                    }
                                    $("#body_<?= $t; ?> tr." + po_id).css("background-color", warna);
                                    $("#body_<?= $t; ?> td." + po_id).css("background-color", warna);
                                    listOpenPOID.push(po_id);
                                } else {
                                    console.log("masuk");
                                    $("#body_<?= $t; ?> tr." + po_id).css("visibility", "hidden");
                                    $("#body_<?= $t; ?> td." + po_id).css("visibility", "hidden");
                                    $("#body_<?= $t; ?> tr." + po_id).css("display", "none");
                                    $("#body_<?= $t; ?> td." + po_id).css("display", "none");
                                    $(".atas_<?= $t; ?>" + po_id).removeAttr("style");
                                    if (id_status == <?= KEY::$STATUS_NEW ?>) {
                                        warna = '<?= KEY::$WARNA_BIRU ?>';
                                    } else if (id_status == <?= KEY::$STATUS_PAID ?>) {
                                        warna = '<?= KEY::$WARNA_HIJAU ?>';
                                    } else if (id_status == <?= KEY::$STATUS_CANCEL ?>) {
                                        warna = '<?= KEY::$WARNA_MERAH ?>';
                                    }
                                    $("#body_<?= $t; ?> tr." + po_id).css("background-color", warna);
                                    $("#body_<?= $t; ?> td." + po_id).css("background-color", warna);
                                    listOpenPOID.pop(po_id);
                                    //
                                }
                                if (listOpenPOID.length != 0) {
                                    $(".palingdalam_<?= $t; ?>").removeAttr("style");
                                } else {
                                    $(".palingdalam_<?= $t; ?>").css("visibility", "display");
                                    $(".palingdalam_<?= $t; ?>").css("display", "none");
                                }
                            }
                        </script>
                        <?
                    }
                    die();
                    $acc = new Account();
//                pr($arrPO);
                    foreach ($arrPO as $key => $val) {
                        if ($val->po_status == KEY::$STATUS_NEW)
                            $warna = KEY::$WARNA_BIRU;
                        elseif ($val->po_status == KEY::$STATUS_PAID)
                            $warna = KEY::$WARNA_HIJAU;
                        elseif ($val->po_status == KEY::$STATUS_CANCEL)
                            $warna = KEY::$WARNA_MERAH;
                        ?>
                        <tr style="background-color: <?= $warna; ?>;">


                            <td ><?= $val->po_id; ?>
                                <span class="caret" style="cursor: pointer;"></span></td>
                            <td><?= $val->po_tanggal; ?></td>
                            <td><?= $acc->getMyName(); ?></td>
                            <td><?= Generic::getTCNamebyID($val->po_penerima); ?></td>
                            <td id = '<?= $val->po_id; ?>'><?
                                if ($val->po_status == KEY::$STATUS_NEW)
                                    echo KEY::$NEW;
                                elseif ($val->po_status == KEY::$STATUS_PAID)
                                    echo KEY::$Paid;
                                elseif ($val->po_status == KEY::$STATUS_CANCEL)
                                    echo KEY::$Cancel;
                                ?></td>
                            <td class='<?= $val->po_id; ?> palingdalam'  style="visibility:hidden;display: none"><?= Generic::getNamaBarangByIDKPOID($val->id_barang, $kpo_id); ?></td>
                            <td class='<?= $val->po_id; ?> palingdalam'  style="visibility:hidden;display: none"><?= $val->qty; ?></td>
                            <td class='<?= $val->po_id; ?> palingdalam'  style="visibility:hidden;display: none"><?= idr($val->harga); ?></td>
                            <td><?= idr($val->qty * $val->harga); ?></td>

                        </tr>
                        <?
                    }
                    ?>


                    </tbody>
                </table>

                <div class="text-center">
                    <button class="btn btn-default" id="loadmore_read_buku_<?= $t; ?>">Load more</button>
                </div>
            </div>
        </section>
        <script>
            var page_read_buku = <?= $page; ?>;
            var total_page_read_buku = <?= $jumlahHalamanTotal; ?>;
            $('#loadmore_read_buku_<?= $t; ?>').click(function () {
                if (page_read_buku < total_page_read_buku) {
                    page_read_buku++;
                    $.get("<?= _SPPATH; ?>BarangWebHelper/read_buku_load?page=" + page_read_buku, function (data) {
                        $("#body_read_buku_<?= $t; ?>").append(data);
                    });
                    if (page_read_buku > total_page_read_buku)
                        $('#loadmore_read_buku_<?= $t; ?>').hide();
                } else {
                    $('#loadmore_read_buku_<?= $t; ?>').hide();
                }
            });
        </script>
        <?
    }

    function delete_pemesanan_buku() {
        
    }

    function update_pemesanan_buku() {
        
    }

    function get_pesanan_buku_tc() {
        BarangWebHelper::lihat_pesanan();
    }

    // KPO

    function get_pesanan_buku_ibo() {
        BarangWebHelper::lihat_pesanan();
    }

}
