<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/30/17
 * Time: 10:13 AM
 */
class FunctionBackup
{
    public function create_stok_buku_dan_barang_kpo()
    {
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
                <select class="form-control" id="buku_<?= $t; ?>">
                    <?
                    foreach ($arrBarang as $barang) {
                        ?>
                        <option id='<?= $barang->nama_barang . "_" . $t; ?>'
                                value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>
                        <?
                    }
                    ?>
                </select>
                <label for="Penginput">Penginput:</label>
                <input type="text" class="form-control" id="id_nama_<?= $t; ?>" value="<?= $acc->getMyName(); ?>"
                       readonly>

                <label for="NamaOrganisasi">Nama Organisasi:</label>
                <input type="text" class="form-control" id="id_pemilik_barang_<?= $t; ?>" placeholder="Organisasi"
                       value="<?= Generic::getTCNamebyID(AccessRight::getMyOrgID()); ?>" readonly>

                <label for="tanggal">Tanggal:</label>
                <input type="datetime" class="form-control" id="tanggal_<?= $t; ?>" value="<?= leap_mysqldate(); ?>"
                       readonly>
                <label for="stockMasuk">Stock Masuk:</label>
                <input type="text" class="form-control" id="stockMasuk_<?= $t; ?>" placeholder="Stock masuk">

                <label for="keterangan">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan_<?= $t; ?>" placeholder="Keterangan">

                <div class="err_text" id="biaya_"></div>
            </div>
            <button class="btn btn-default" id="btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>" type="button">Submit
            </button>
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

            $( document ).ready(function() {
                alert("Mulai");
            });
            $("#buku_<?= $t; ?>").change(function(){

            });

            $('#btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>').click(function () {
                if (confirm("Anda yakin?")) {
                    var stk_masuk = $('#stockMasuk_<?= $t; ?>').val();
                    var id_barang = $('#buku_<?= $t; ?> option:selected').val();
                    var name = $('#id_nama_<?= $t; ?>').val();
                    var id_pemilik_barang = '<?=AccessRight::getMyOrgID();?>';
//                    alert(id_pemilik_barang);
                    var tanggal = $('#tanggal_<?= $t; ?>').val();
                    var keterangan = $('#keterangan_<?= $t; ?>').val();
                    var name_barang = $('#buku_<?= $t; ?> option:selected').text();
                    $.get("<?= _SPPATH; ?>StockWebHelper/insertKartuStock?id_barang=" + id_barang + "&stk_masuk=" + stk_masuk + "&tanggal=" + tanggal + "&pemilik=" + id_pemilik_barang + "&id_nama=" + name + "&keterangan=" + keterangan +"&name_barang="+name_barang, function (data) {
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
}