<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StokWeb
 *
 * @author efindiongso
 */
class StokWeb extends WebService {

    // KPO
    public function create_stok_buku_dan_barang_kpo() {
        $kpo_id = AccessRight::getMyOrgID();
        $barang = new BarangWebModel();
        $arrBarang = $barang->getWhere("kpo_id='$kpo_id'");
        $org = new SempoaOrg();
        $acc = new SempoaAccount();
        $t = time();
        ?>
        <h1>Kartu Stock</h1>
        <form id="kartuStock_<?= $kpo_id . $acc->getMyID(); ?>">
            <div class="form-group">
                <label for="namaBarang">Nama Barang:</label>
                <select class = "form-control" id = "buku_<?= $t; ?>">
                    <?
                    foreach ($arrBarang as $barang) {
                        ?>
                        <option id='<?= $barang->nama_barang . "_" . $t; ?>' value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>
                        <?
                    }
                    ?>
                </select>
                <label for="Penginput">Penginput:</label>
                <input type="text" class="form-control" id ="id_nama_<?= $t; ?>" value="<?= $acc->getMyName(); ?>" readonly>

                <label for="NamaOrganisasi" >Nama Organisasi:</label>
                <input type="text" class="form-control" id ="id_pemilik_barang_<?= $t; ?>" placeholder="Organisasi" value="<?=  Generic::getTCNamebyID(AccessRight::getMyOrgID());?>" readonly>

                <label for="tanggal">Tanggal:</label>
                <input type="datetime" class="form-control" id="tanggal_<?= $t; ?>" value="<?= leap_mysqldate(); ?>" readonly >
                <label for="stockMasuk">Stock Masuk:</label>
                <input type="text" class="form-control" id="stockMasuk_<?= $t; ?>" placeholder="Stock masuk">

                <label for="keterangan">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan_<?= $t; ?>" placeholder="Keterangan" >

                <div class="err_text" id="biaya_"></div>
            </div>
            <button class="btn btn-default" id="btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>" type="button" >Submit</button>
        </form>

        <style>
            .err_text {
                padding: 5px;
                margin: 5px;
                background-color: #dedede;
                display: none;
            }

            .input_bordered {
                border-color: #ff0000;
            }
        </style>
        <script>

            $('#btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>').click(function () {
                if (confirm("Anda yakin?")) {
                    var stk_masuk = $('#stockMasuk_<?= $t; ?>').val();
                    var id_barang = $('#buku_<?= $t; ?> option:selected').val();
                    var name = $('#id_nama_<?= $t; ?>').val();
                    var id_pemilik_barang = '<?=AccessRight::getMyOrgID();?>';
//                    alert(id_pemilik_barang);
                    var tanggal = $('#tanggal_<?= $t; ?>').val();
                    var keterangan = $('#keterangan_<?= $t; ?>').val();
                    //                    var post = $("#barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>").serialize();
                    $.get("<?= _SPPATH; ?>StockWebHelper/insertKartuStock?id_barang=" + id_barang + "&stk_masuk=" + stk_masuk + "&tanggal=" + tanggal +"&pemilik=" + id_pemilik_barang + "&id_nama=" + name + "&keterangan=" + keterangan, function (data) {
                        console.log(data);
                        if (data.status_code) {
                           console.log(data.id_pemilik_barang);
                            alert("Success!");
                            //                            lwrefresh("read_stok_buku_dan_barang_kpo");
                            //                            lwrefresh("read_kartu_stok_kpo");
                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
                }

            });

        </script>
        <?
    }

    public function read_stok_buku_dan_barang_kpo_tmp() {
        $myID = AccessRight::getMyOrgID();
        $arrMyIBO = (Generic::getAllsMyIBO($myID));
        $myStock = new StockModel();
        $arrMyStocks = $myStock->getWhere("org_id='$myID'");
//        pr($arrMyStocks);
        $objStock = new StockModel();
        ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr> <th>Nama\Jumlah</th>

                    <?
                    foreach ($arrMyStocks as $myStock) {
                        $reihenFolge[] = $myStock->id_barang;
                        ?>
                        <th id='<?= $myStock->id_barang; ?>'><b><?= Generic::getNamaBarangByIDKPOID($myStock->id_barang, $myID); ?></b></th>
                        <?
                    }
                    ?>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td id='<?= $key . "_" . $ibo; ?>'>
                        Stock
                    </td>
                    <?
                    foreach ($reihenFolge as $keyreihen => $reihen) {
                        $arrStok = $objStock->getWhere("org_id='$myID' AND id_barang='$reihen'");
                        ?>
                        <td id='<?= $key . "_" . $reihen; ?>'><?= $arrStok[0]->jumlah_stock; ?></td>
                        <?
                    }
                    ?>

                </tr>

                <tr>
                    <td id='<?= $key . "_" . $ibo; ?>'>
                        Stock Hold
                    </td>
                    <?
                    foreach ($reihenFolge as $keyreihen => $reihen) {
                        $arrStok = $objStock->getWhere("org_id='$myID' AND id_barang='$reihen'");
                        ?>
                        <td id='<?= $key . "_" . $reihen; ?>'><?= $arrStok[0]->jumlah_stock_hold; ?></td>
                        <?
                    }
                    ?>

                </tr>
            </tbody>
        </table>
        <center>
            <button id = "refresh_stock_<?= time(); ?>" class="btn btn-success text-center">Update Stock</button>
        </center>
        <script>
            $('#refresh_stock_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>

        <?
    }

    public function read_stok_buku_dan_barang_kpo() {
//        pr("asasas");
        $myID = AccessRight::getMyOrgID();
//        $arrMyIBO = (Generic::getAllsMyIBO($myID));
        $myStock = new StockModel();
        $arrMyStocks = $myStock->getWhere("org_id='$myID'");
//        pr($arrMyStocks);
        $objStock = new StockModel();
        ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr> <th>Nama</th>
                    <th>Jumlah Stock</th>
                    <th>Jumlah Stock Hold</th>
                </tr>
            </thead>
            <tbody>
                <?
                $arrStok = $objStock->getWhere("org_id='$myID'");
                $arrNamaBarang = Generic::getNamaBarang();
                foreach ($arrStok as $keyreihen => $reihen) {
                    ?>
                    <tr>
                        <td>
                            <?= $arrNamaBarang[$reihen->id_barang]; ?>
                        </td>
                        <td style="text-align: left;">
                            <?= $reihen->jumlah_stock; ?>
                        </td>
                        <td style="text-align: left;">
                            <?= $reihen->jumlah_stock_hold; ?>
                        </td>
                    </tr>
                    <?
                }
                ?>


                </tr>
            </tbody>
        </table>
        <center>
            <button id = "refresh_stock_<?= time(); ?>" class="btn btn-success text-center">Update Stock</button>
        </center>
        <script>
            $('#refresh_stock_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>

        <?
    }

    public static function formBarang() {
        $kpo_id = AccessRight::getMyOrgID();
        $barang = new BarangWebModel();
        $arrBarang = $barang->getWhere("kpo_id='$kpo_id'");
        $org = new SempoaOrg();
        $acc = new SempoaAccount();
        $t = time();
        ?>
        <h1>Kartu Stock</h1>
        <form id="kartuStock_<?= $kpo_id . $acc->getMyID(); ?>">
            <div class="form-group">
                <label for="namaBarang">Nama Barang:</label>
                <select class = "form-control" id = "buku_<?= $t; ?>">
                    <?
                    foreach ($arrBarang as $barang) {
                        ?>
                        <option id='<?= $barang->nama_barang . "_" . $t; ?>' value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>
                        <?
                    }
                    ?>
                </select>
                <label for="Penginput">Penginput:</label>
                <input type="text" class="form-control" id ="id_nama_<?= $t; ?>" value="<?= $acc->getMyName(); ?>" readonly>

                <label for="NamaOrganisasi" >Nama Organisasi:</label>
                <input type="text" class="form-control" id ="id_pemilik_barang_<?= $t; ?>" placeholder="Organisasi" value="<?= AccessRight::getMyOrgID(); ?>" readonly>

                <label for="tanggal">Tanggal:</label>
                <input type="datetime" class="form-control" id="tanggal_<?= $t; ?>" value="<?= leap_mysqldate(); ?>" readonly >
                <label for="stockMasuk">Stock Masuk:</label>
                <input type="text" class="form-control" id="stockMasuk_<?= $t; ?>" placeholder="Stock masuk" readonly>

                <label for="keterangan">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan_<?= $t; ?>" placeholder="Keterangan" >

                <div class="err_text" id="biaya_"></div>
            </div>
            <button class="btn btn-default" id="btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>" type="submit" >Submit</button>
        </form>

        <style>
            .err_text {
                padding: 5px;
                margin: 5px;
                background-color: #dedede;
                display: none;
            }

            .input_bordered {
                border-color: #ff0000;
            }
        </style>
        <script>

            $('#btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>').click(function () {
                if (confirm("Anda yakin?")) {
                    //                    var post = {};
                    var stk_masuk = $('#stockMasuk_<?= $t; ?>').val();
                    var stk_keluar = $('#stockKeluar_<?= $t; ?>').val();
                    var id_barang = $('#buku_<?= $t; ?> option:selected').val();
                    var name = $('#id_nama_<?= $t; ?>').val();
                    var id_pemilik_barang = $('#id_pemilik_barang_<?= $t; ?>').val();
                    var tanggal = $('#tanggal_<?= $t; ?>').val();
                    var keterangan = $('#keterangan_<?= $t; ?>').val();
                    //                    var post = $("#barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>").serialize();
                    $.get("<?= _SPPATH; ?>StockWebHelper/insertKartuStock?id_barang=" + id_barang + "&stk_masuk=" + stk_masuk + "&tanggal=<?=  leap_mysqldate();?>&pemilik=" + id_pemilik_barang + "&id_nama=" + name + "&keterangan=" + keterangan, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            //success
                            alert(data.status_message);
                            openLw("Stock", "<?= _SPPATH; ?>StokWeb/read_stok_buku_dan_barang_kpo", fade);
                        } else {
                            alert(data.status_message);
                        }
                    }, 'json');
                }

            });

        </script>
        <?
    }

    public function get_my_stok_barang_dan_buku_ibo() {
        $myID = AccessRight::getMyOrgID();
        $arrMyStocks = Generic::getMyStock($myID);
        $arrNamaBarang = Generic::getNamaBarang();
        ?>
        <h1>Jumlah Stock <?= Account::getMyName(); ?></h1>
        <table class="table table-bordered table-striped table-responsivet">
            <thead>
                <tr> <th>Nama</th>
                    <th>Jumlah Stock</th>
                    <th>Jumlah Stock Hold</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach ($arrMyStocks as $val) {
                    ?>
                    <tr>
                        <td><?= $arrNamaBarang[$val->id_barang]; ?></td>
                        <td><?= $val->jumlah_stock; ?></td>
                        <td><?= $val->jumlah_stock_hold; ?></td>
                    </tr>
                    <?
                }
                ?>

            </tbody>
        </table>

        <center>
            <button id = "update_stock_ibo_<?= time(); ?>" class="btn btn-success text-center">Update</button>
        </center>
        <script>
            $('#update_stock_ibo_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>
        <?
    }

    // KPO
    public function read_kartu_stok_kpo() {
        $myOrgID = AccessRight::getMyOrgID();
        $objStocks = new KartuStockModel();
        $arrStocks = $objStocks->getWhere("id_pemilik_barang=$myOrgID ORDER BY 	tanggal_input DESC");
        ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>ID</b></th>
                    <th><b>Barang</b></th>
                    <th><b>Tanggal</b></th>
                    <th><b>stock Masuk</b></th>
                    <th><b>keterangan</b></th>
                    <th><b>Penanggung Jawab</b></th>
                </tr>    
            </thead>
            <tbody>
                <?
                foreach ($arrStocks as $val) {
                    ?>
                    <tr class="<?= $val->kartu_id; ?>">
                        <td class="<?= $val->kartu_id; ?>">
                            <?= $val->kartu_id; ?>
                        </td>
                        <td>
                            <?= Generic::getNamaBarangByIDKPOID($val->id_barang, $myOrgID); ?>
                        </td>
                        <td>
                            <?= $val->tanggal_input; ?>
                        </td>
                        <td>
                            <?= $val->stock_masuk; ?>
                        </td>
                        <td>
                            <?= $val->keterangan; ?>
                        </td>
                        
                        <td>
                            <?= $val->nama_penerima_barang; ?>
                        </td>
                    </tr>

                    <?
                }
                ?>
            </tbody>
        </table>
        <center>
            <button id = "refresh_stock_<?= time(); ?>" class="btn btn-success text-center">Update</button>
        </center>
        <script>
            $('#refresh_stock_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>
        <?
    }

    // TC

    public function get_my_stok_barang_dan_buku_tc() {
        $myID = AccessRight::getMyOrgID();
        $arrMyStocks = Generic::getMyStock($myID);
//        pr($arrMyStocks);
        ?>
        <h1>Jumlah Stock <?= Account::getMyName(); ?></h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th>Nama Barang</th>
                    <th>Jumlah Stock</th>
                </tr>
            </thead>
            <thead>


                <?
                foreach ($arrMyStocks as $key => $myStock) {
                    ?>
                    <tr>
                        <td><?= Generic::getNamaBarangByIDBarang($myStock->id_barang); ?></td>
                        <td><?= $myStock->jumlah_stock; ?></td>
                    </tr>

                    <?
                }
                ?>


            </thead>
        </table>
        <center>
            <button id = "refresh_stock_<?= time(); ?>" class="btn btn-success text-center">Update</button>
        </center>
        <script>
            $('#refresh_stock_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>
        <?
    }

}
