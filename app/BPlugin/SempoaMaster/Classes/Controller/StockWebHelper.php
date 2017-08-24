<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockWebHelpger
 *
 * @author efindiongso
 */
class StockWebHelper extends WebService
{

    //put your code here

    public function insertKartuStock()
    {


        $stk_masuk = (int)addslashes($_GET['stk_masuk']);
        $id_barang = addslashes($_GET['id_barang']);
        $id_pemilik_barang = addslashes($_GET['pemilik']);
        $tanggal = addslashes($_GET['tanggal']);
        $keterangan = addslashes($_GET['keterangan']);
        $id_nama = addslashes($_GET['id_nama']);
        $name_barang = addslashes($_GET['name_barang']);

        $json['pemilik'] = $id_pemilik_barang;
        $json['tanggal'] = $tanggal;
        $json['keterangan'] = $keterangan;
        $json['id_nama'] = $id_nama;
        if (!is_int($stk_masuk) || $stk_masuk == 0) {
            $json['status_code'] = 0;
            $json['status_message'] = "Jumlah tidak boleh 0 atau kosong!";
            echo json_encode($json);
            die();
        }

        $obj = new KartuStockModel();
        $obj->id_barang = $id_barang;
        $obj->tanggal_input = $tanggal;
        $obj->id_pemilik_barang = $id_pemilik_barang;
        $obj->nama_penerima_barang = $id_nama;
        $obj->stock_masuk = $stk_masuk;
        $obj->keterangan = $keterangan;
        $succ = $obj->save();

        if ($succ) {
            // Stock KPO
            $stock_barang = new StockModel();
            $arrStockBarang = $stock_barang->getWhere("id_barang='$id_barang'");
//            pr($arrStockBarang);
            if (count($arrStockBarang) == 0) {
                $stock_barang->id_barang = $id_barang;
                $stock_barang->org_id = $id_pemilik_barang;
                $stock_barang->jumlah_stock = $stk_masuk;
                $id = $stock_barang->save();
            } else {
                $arrStockBarang[0]->jumlah_stock = $arrStockBarang[0]->jumlah_stock + $stk_masuk;
                $id = $arrStockBarang[0]->save(1);
            }
        }
        if ($id) {
            $json['id_pemilik_barang'] = $id_pemilik_barang;
            $json['status_code'] = 1;
            $json['status_message'] = "Data berhasil di simpan!";

            // isi stock buku dgn penomoran
            // id barang, cari nomor buku sampai mana
            // jika belum ketemu, mulai dari 00001
            // jika ketemu, lanjutkan
            // set status kpo ke avail
            // set tanggal masuk kpo
            // set id kpo

            $i = 0;
            for ($i = 0; $i < $stk_masuk; $i++) {
                $stockBuku = new StockBuku();
                $no = $stockBuku->getMyLastNummer($id_barang);
                if ($no == "0") {
//                    $json['status_code'] = 0;
//                    $json['status_message'] = "Jumlah tidak boleh 0 atau kosong!";
//                    echo json_encode($json);
//                    die();
                } else {
                    $stockBuku->createNoBuku($id_barang, $no, AccessRight::getMyOrgID(),$name_barang);
                }

            }


//            $levKur = Generic::getLevelAndKurByIdBarang($id_barang);
//            $json[KEY::$TEXT_KURIKULUM] = $levKur[KEY::$TEXT_KURIKULUM];
//            $json[KEY::$TEXT_LEVEL] = $levKur[KEY::$TEXT_LEVEL];
        }
        echo json_encode($json);
        die();
    }

    public function updateKartuStock()
    {


        $id = (int)addslashes($_POST['id']);
        $stk_masuk = (int)addslashes($_POST['stk_masuk']);
        $stk_keluar = (int)addslashes($_POST['stk_keluar']);
        $id_barang = addslashes($_POST['id_barang']);
        $id_pemilik_barang = addslashes($_POST['id_pemilik_barang']);
        $tanggal = addslashes($_POST['tanggal']);
        $keterangan = ($_POST['keterangan']);
        $id_nama = addslashes($_POST['id_nama']);

        $json['pemilik'] = $id_pemilik_barang;
        $json['tanggal'] = $tanggal;
        $json['keterangan'] = $keterangan;
        $json['id_nama'] = $id_nama;
        if (!is_int($stk_masuk) || $stk_masuk == 0) {
            $json['status_code'] = 0;
            $json['status_message'] = "Jumlah tidak boleh 0 atau kosong!";
            echo json_encode($json);
            die();
        }

        $obj = new KartuStockModel();
        $obj->getByID($id);
        $obj->id_barang = $id_barang;
        $obj->tanggal = leap_mysqldate_isi($tanggal);
        $obj->id_pemilik_barang = $id_pemilik_barang;
        $obj->nama_penerima_barang = $id_nama;
        $obj->stock_masuk = $stk_masuk;
//        $obj->stock_keluar = $stk_keluar;
        $obj->keterangan = $keterangan;
        $succ = $obj->save(1);

        if ($succ) {
            // Stock KPO
            $stock_barang = new StockModel();
            $arrStockBarang = $stock_barang->getWhere("id_barang='$id_barang'");
            if (count($arrStockBarang) == 0) {
                $stock_barang->id_barang = $id_barang;
                $stock_barang->org_id = $id_pemilik_barang;
                $stock_barang->jumlah_stock = $stk_masuk;
                $id = $stock_barang->save();
            } else {
                $arrStockBarang[0]->jumlah_stock = $arrStockBarang[0]->jumlah_stock + $stk_masuk;
                $id = $arrStockBarang[0]->save(1);
            }
        }
        if ($id) {
            $json['status_code'] = 1;
            $json['status_message'] = "Data berhasil di simpan!";
        }
        echo json_encode($json);
        die();
    }

    function isiFormStockKartu()
    {
        $id = addslashes($_GET['id']);
//        echo $id;
        if ($id == "") {
            $json['status_code'] = 0;
            $json['status_message'] = "id kosong!";
            echo json_encode($json);
            die();
        } else {
            $objKartu = new KartuStockModel();
            $arrObj = $objKartu->getWhere("kartu_id='$id'");
            if (count($arrObj) == 0) {
                $json['status_code'] = 0;
                $json['status_message'] = "Kartu Stock tidak ditermukan!";
                echo json_encode($json);
                die();
            }
            $kpo_id = AccessRight::getMyOrgID();
            $barang = new BarangWebModel();
            $arrBarang = $barang->getWhere("kpo_id='$kpo_id'");
            $org = new SempoaOrg();
            $acc = new SempoaAccount();
            $t = time();
//            pr($arrBarang);
//            pr($arrObj);
            ?>
            <? foreach ($arrObj as $val) {
                ?>
                <h1>Kartu Stock</h1>
                <form id="kartuStock_<?= $kpo_id . $acc->getMyID(); ?>">
                    <div class="form-group">
                        <label for="namaBarang">Nama Barang:</label>
                        <select class="form-control" id="buku_<?= $t; ?>">
                            <?
                            foreach ($arrBarang as $barang) {
                                if ($val->id_barang == $barang->id_barang_harga) {
                                    ?>
                                    ?>
                                    <option id='<?= $barang->nama_barang . "_" . $t; ?>'
                                            value="<?= $barang->id_barang_harga; ?>"
                                            selected><?= $barang->nama_barang; ?></option>
                                    <?
                                } else {
                                    ?>
                                    <option id='<?= $barang->nama_barang . "_" . $t; ?>'
                                            value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>
                                    <?
                                }
                            }
                            ?>
                        </select>
                        <label for="Penginput">Penginput:</label>
                        <input type="text" class="form-control" id="id_nama_<?= $t; ?>"
                               value="<?= $acc->getMyName(); ?>" readonly>

                        <label for="NamaOrganisasi">Nama Organisasi:</label>
                        <input type="text" class="form-control" id="id_pemilik_barang_<?= $t; ?>"
                               placeholder="Organisasi" value="<?= AccessRight::getMyOrgID(); ?>" readonly>

                        <label for="tanggal">Tanggal:</label>
                        <input type="datetime" class="form-control" id="tanggal_<?= $t; ?>"
                               value="<?= $barang->tanggal; ?>" readonly>
                        <label for="stockMasuk">Stock Masuk:</label>
                        <input type="text" class="form-control" id="stockMasuk_<?= $t; ?>" placeholder="Stock masuk"
                               value=<?= $val->stock_masuk; ?>>

                        <label for="keterangan">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan_<?= $t; ?>" placeholder="Keterangan"
                               value=<?= addslashes($val->keterangan); ?>>

                        <div class="err_text" id="biaya_"></div>
                    </div>
                    <button class="btn btn-default" id="btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>" type="submit">
                        Submit
                    </button>
                </form>
                <script>

                    $('#btn_kartuStock_<?= $kpo_id . $acc->getMyID(); ?>').click(function () {
                            if (confirm("Anda yakin?")) {
                                var post = {};

                                post.id = parseInt(<?= $id; ?>);
                                post.stk_masuk = $('#stockMasuk_<?= $t; ?>').val();
                                post.stk_keluar = $('#stockKeluar_<?= $t; ?>').val();
                                post.id_barang = $('#buku_<?= $t; ?> option:selected').val();
                                post.pemilik = $('#id_nama_<?= $t; ?>').val();
                                post.id_pemilik_barang = $('#id_pemilik_barang_<?= $t; ?>').val();
                                post.tanggal = '<?= leap_mysqldate(); ?>';
                                post.keterangan = $('#keterangan_<?= $t; ?>').val();
                                $.post("<?= _SPPATH; ?>StockWebHelper/updateKartuStock", post, function (data) {
                                    console.log(data);
                                    if (data.status_code) {
                                        //success
                                        alert(data.status_message);
//                                    lwclose(selected_page);
                                        openLw("read_kartu_stok_kpo", "<?= _SPPATH; ?>StokWeb/read_kartu_stok_kpo", 'fade');
                                    } else {
                                        alert(data.status_message);
                                    }
                                }, 'json');
                            }

                        }
                    );

                </script>
                <?
            }
        }
    }

    public function get_anzahl_available_buku(){
        $brg_id = $_GET['brg_id'];
        $i=0;
        $myorgid = AccessRight::getMyOrgID();
        $myOrgType = AccessRight::getMyOrgType();
        $arrJenisBarang = Generic::getLevelByBarangID();
        $arrStatusBuku = Generic::getStatusBuku();
        $stockNo = new StockBuku();
        if ($myOrgType == KEY::$KPO) {
            $jumlah = $stockNo->getJumlah("stock_buku_status_kpo = 1 AND stock_id_buku = $brg_id AND stock_buku_kpo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$IBO) {
            $jumlah = $stockNo->getJumlah("stock_status_ibo = 1 AND stock_id_buku = $brg_id AND stock_buku_ibo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$TC) {
            $jumlah = $stockNo->getJumlah("stock_status_tc = 1 AND stock_id_buku = $brg_id AND stock_buku_tc =$myorgid ORDER by stock_buku_id ASC");
        }

        echo "<b>Jumlah buku yang tersedia: " . $jumlah . "</b><br>";

    }
    public function get_available_buku()
    {

        $brg_id = $_GET['brg_id'];
        $i=0;
        $myorgid = AccessRight::getMyOrgID();
        $myOrgType = AccessRight::getMyOrgType();
        $arrJenisBarang = Generic::getLevelByBarangID();
        $arrStatusBuku = Generic::getStatusBuku();
        $stockNo = new StockBuku();
        if ($myOrgType == KEY::$KPO) {
            $arrStock = $stockNo->getWhere("stock_buku_status_kpo = 1 AND stock_id_buku = $brg_id AND stock_buku_kpo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$IBO) {
            $arrStock = $stockNo->getWhere("stock_status_ibo = 1 AND stock_id_buku = $brg_id AND stock_buku_ibo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$TC) {
            $arrStock = $stockNo->getWhere("stock_status_tc = 1 AND stock_id_buku = $brg_id AND stock_buku_tc =$myorgid ORDER by stock_buku_id ASC");
        }
        foreach ($arrStock as $val) {
            $i++;
            ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $val->stock_buku_no; ?></td>
                <td><?= $arrJenisBarang[$val->stock_id_buku]; ?></td>
                <td><?
                    if ($myOrgType == KEY::$KPO) {
                        echo $val->stock_buku_tgl_masuk_kpo;
                    } elseif ($myOrgType == KEY::$IBO) {
                        echo $val->stock_buku_tgl_masuk_ibo;
                    } elseif ($myOrgType == KEY::$TC) {
                        echo $val->stock_buku_tgl_masuk_tc;
                    }
                    ?></td>

                <td><?
                    if ($myOrgType == KEY::$KPO) {
                        echo $arrStatusBuku[$val->stock_buku_status_kpo];
                    } elseif ($myOrgType == KEY::$IBO) {
                        echo $arrStatusBuku[$val->stock_status_ibo];
                    } elseif ($myOrgType == KEY::$TC) {
                        echo $arrStatusBuku[$val->stock_status_tc];
                    }
                    ?></td>
            </tr>
            <?
        }
    }


    public function get_non_available_buku()
    {

        $brg_id = $_GET['brg_id'];
        $i =0;
        $myorgid = AccessRight::getMyOrgID();
        $myOrgType = AccessRight::getMyOrgType();
        $arrJenisBarang = Generic::getLevelByBarangID();
        $arrStatusBuku = Generic::getStatusBuku();
        $stockNo = new StockBuku();
        if ($myOrgType == KEY::$KPO) {
            $arrStock = $stockNo->getWhere("stock_buku_status_kpo = 0 AND stock_id_buku = $brg_id AND stock_buku_kpo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$IBO) {
            $arrStock = $stockNo->getWhere("stock_status_ibo = 0 AND stock_id_buku = $brg_id AND stock_buku_ibo =$myorgid ORDER by stock_buku_id ASC");
        } elseif ($myOrgType == KEY::$TC) {
            $arrStock = $stockNo->getWhere("stock_status_tc = 0 AND stock_id_buku = $brg_id AND stock_buku_tc =$myorgid ORDER by stock_buku_id ASC");
        }
        foreach ($arrStock as $val) {
            $i++;
            ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $val->stock_buku_no; ?></td>
                <td><?= $arrJenisBarang[$val->stock_id_buku]; ?></td>
                <td><?
                    if ($myOrgType == KEY::$KPO) {
                        echo $val->stock_buku_tgl_keluar_kpo;
                    } elseif ($myOrgType == KEY::$IBO) {
                        echo $val->stock_buku_tgl_keluar_ibo;
                    } elseif ($myOrgType == KEY::$TC) {
                        echo $val->stock_buku_tgl_keluar_tc;
                    }
                    ?></td>

                <td><?
                    if ($myOrgType == KEY::$KPO) {
                        echo Generic::getTCNamebyID($val->stock_buku_ibo);
                    } elseif ($myOrgType == KEY::$IBO) {
                        echo Generic::getTCNamebyID($val->stock_buku_tc);
                    } elseif ($myOrgType == KEY::$TC) {
                        echo Generic::getMuridNamebyID($val->stock_murid_id);
                    }
                    ?></td>
                <td><?
                    if ($myOrgType == KEY::$KPO) {
                        echo $arrStatusBuku[$val->stock_buku_status_kpo];
                    } elseif ($myOrgType == KEY::$IBO) {
                        echo $arrStatusBuku[$val->stock_status_ibo];
                    } elseif ($myOrgType == KEY::$TC) {
                        echo $arrStatusBuku[$val->stock_status_tc];
                    }
                    ?></td>
            </tr>
            <?
        }
    }

}
