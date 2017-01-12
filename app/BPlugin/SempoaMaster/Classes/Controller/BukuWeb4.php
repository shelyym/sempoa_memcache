<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BukuWeb4
 *
 * @author efindiongso
 */
class BukuWeb4 extends WebService
{

    //put your code here

    public function create_stok_buku()
    {

    }

    public function delete_stok_buku()
    {

    }

    public function update_stok_buku()
    {

    }

    public function read_stok_buku_ibo_tmp()
    {
        $myID = AccessRight::getMyOrgID();
        $arrMyIBO = (Generic::getAllsMyIBO($myID));
        $myStock = new StockModel();
        $arrMyStocks = $myStock->getWhere("org_id='$myID'");
        $objStock = new StockModel();
        ?>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Nama\IBO</th>


                <?
                foreach ($arrMyIBO as $key => $ibo) {
                    ?>

                    <th id='<?= $key . "_" . $ibo; ?>'>
                        <?= $ibo; ?>
                    </th>

                    <?
                }


                ?>
            </tr>
            </thead>
            <tbody>

            <?

            $reihenFolge = array();
            foreach ($arrMyStocks as $myStock) {
                $reihenFolge[$myID] = $myStock->id_barang;
                ?>
                <tr>
                    <td id='<?= $myStock->id_barang; ?>'>
                        <b><?= Generic::getNamaBarangByIDKPOID($myStock->id_barang, $myID); ?></b></td>
                     <td><?=Generic::getStockByOrgID($myStock->id_barang, $myID);?></td>


                </tr>
                <?
            }
            ?>


            </tbody>
        </table>
        </div>
        <center>
            <button id="read_stock_kpo_<?= time(); ?>" class="btn btn-success text-center">Update</button>
        </center>
        <script>
            $('#read_stock_kpo_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>
        <?
    }

    public function read_stok_buku_ibo()
    {
        $myID = AccessRight::getMyOrgID();
        $arrMyIBO = (Generic::getAllsMyIBO($myID));
        $myStock = new StockModel();
        $arrMyStocks = $myStock->getWhere("org_id='$myID'");
        $objStock = new StockModel();
        ?>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Nama\IBO</th>

                <?
                foreach ($arrMyStocks as $myStock) {
                    $reihenFolge[] = $myStock->id_barang;
                    ?>
                    <th id='<?= $myStock->id_barang; ?>'>
                        <b><?= Generic::getNamaBarangByIDKPOID($myStock->id_barang, $myID); ?></b></th>
                    <?
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?
            foreach ($arrMyIBO as $key => $ibo) {
                ?>
                <tr>
                    <td id='<?= $key . "_" . $ibo; ?>'>
                        <?= $ibo; ?>
                    </td>
                    <?
                    foreach ($reihenFolge as $keyreihen => $reihen) {
                        $arrStok = $objStock->getWhere("org_id='$key' AND id_barang='$reihen'");
                        ?>
                        <td id='<?= $key . "_" . $reihen; ?>'><?= $arrStok[0]->jumlah_stock; ?></td>
                        <?
                    }
                    ?>

                </tr>
                <?
            }
            ?>
            </tbody>
        </table>
        </div>
        <center>
            <button id="read_stock_kpo_<?= time(); ?>" class="btn btn-success text-center">Update</button>
        </center>
        <script>
            $('#read_stock_kpo_<?= time(); ?>').click(function () {
                lwrefresh(selected_page);
            });
        </script>
        <?
    }

    public function read_stok_buku_tc()
    {

        $myOrgID = AccessRight::getMyOrgID();
        $allMyTC = Generic::getAllMyTC($myOrgID);
        $allMyGroups = Generic::getGroup($myOrgID);
//        pr($allMyTC);
        $myStock = new StockModel();
        $arrMyStocks = $myStock->getWhere("org_id='$myOrgID'");
        $objStock = new StockModel();
        foreach ($arrMyStocks as $myStock) {
            $reihenFolgeBarangIBO[] = $myStock->id_barang;
        }

        foreach ($allMyGroups as $key => $myGroup) {
            ?>
            <center>
                <h2><?= $myGroup; ?></h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nama\IBO</th>

                            <?
                            foreach ($reihenFolgeBarangIBO as $myStock) {
                                ?>
                                <th id='<?= $myStock; ?>'><b><?= Generic::getNamaBarangByIDBarang($myStock); ?></b></th>
                                <?
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $tcs = Generic::fgetGroupMember($key);
                        foreach ($tcs as $gpTcs) {
                            $arrMyTC = explode(",", $gpTcs);
                            foreach ($arrMyTC as $keyTC => $tc) {
                                ?>
                                <tr>
                                    <td id='<?= $keyTC . "_" . $tc; ?>'>
                                        <?= Generic::getOrgNamebyID($tc); ?>
                                    </td>

                                    <?
                                    foreach ($reihenFolgeBarangIBO as $keyreihen => $reihen) {
                                        $arrStok = $objStock->getWhere("org_id='$tc' AND id_barang='$reihen'");
                                        ?>
                                        <td id='<?= $keyreihen . "_" . $reihen; ?>'><?= $arrStok[0]->jumlah_stock; ?></td>
                                        <?
                                    }
                                    ?>

                                </tr>
                                <?
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </center>
            <?
        }
        ?>
        <center>
            <button id="refresh_stock_tc_<?= time(); ?>" class="btn btn-success text-center">Update</button>

            <script>
                $('#refresh_stock_tc_<?= time(); ?>').click(function () {
                    lwrefresh(selected_page);
                });
            </script>
        </center>
        <?
    }

}
