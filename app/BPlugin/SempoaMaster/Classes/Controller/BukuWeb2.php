<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BukuWeb2
 *
 * @author efindiongso
 */
class BukuWeb2 extends WebService {

    //put your code here

    /*
     * [0] => get_pemesanan_barang_tc
      [1] => create_pemesanan_barang_ibo
      [2] => read_pemesanan_barang_ibo
      [3] => delete_pemesanan_barang_ibo
      [4] => update_pemesanan_barang_ibo
     */

    function get_pemesanan_barang_tc() {
        
    }

    function create_pemesanan_barang_ibo() {
        $ibo_id = AccessRight::getMyOrgID();
        $kpo_id = Generic::getMyParentID($ibo_id);
        $objBarang = new BarangWebModel();
        $arrBarang = $objBarang->getWhere("kpo_id='$kpo_id'");
        $t = time();
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>Nama Barang</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody id='container_pemesanan_barang'>
                    <tr id='pesanan_1'>
                        <td>
                            <select class = "form-control" id = "barang_pesanan_1">
                                <?
                                foreach ($arrBarang as $barang) {
                                    ?>
                                    <option id='<?= $barang->nama_barang . "_" . $t; ?>' value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input class = "form-control" type="number" id="qty_barang_pesanan_1" min="1" value="1"  >
                        </td>
                        <td>
                            <button id="add_barang" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script>

        </script>
        <button class="btn btn-default" type="submit" onclick="kirim_request()">Submit</button>

        <script>
            var jml_row = 1;
            var barang_obj = [];
            $('#add_barang').click(function () {
                jml_row++;
                var html = '<tr id= "pesanan_' + jml_row + '">' +
                        '<td>' +
                        '<select class = "form-control" id = "barang_pesanan_' + jml_row + '">' +
        <?
        foreach ($arrBarang as $barang) {
            ?>
                    '<option id="<?= $barang->nama_barang . "_" . $t; ?>" value="<?= $barang->id_barang_harga; ?>"><?= $barang->nama_barang; ?></option>' +
            <?
        }
        ?> +
                        '</select> ' +
                        '</td>' +
                        '<td>' +
                        '<input class = "form-control" type="number" id="qty_barang_pesanan_' + jml_row + '" min="1" value="1"  >' +
                        '</td>' +
                        '<td>' +
                        '<button id="remove_barang" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-remove" onclick="remove_row(' + jml_row + ');"></i></button>' +
                        '</td>' +
                        '</tr>';
                $('#container_pemesanan_barang').append(html);

                barang_obj.push(jml_row);

            });

            function remove_row(id) {
                
               
                $('#pesanan_' + id).remove();
                var index = barang_obj.indexOf(id);
                if (index > -1) {
                    barang_obj.splice(index, 1);
                }

                relode_row();
            }

            function relode_row() {
                var barang_arr_obj = {};
                for (key in barang_obj) {
                    var jml_barang = barang_obj[key];
                    
                    var nama_barang = $("#barang_pesanan_" + jml_barang+ " option:selected").val();
                    var qty_barang = $('#qty_barang_pesanan_'+ jml_barang).val();
                    barang_arr_obj[jml_barang] = {
                        nama_barang: nama_barang,
                        qty_barang: qty_barang,
                        jml_barang: jml_barang
                    };
                }

                console.log(barang_arr_obj);
            }


            function kirim_request() {

                var post = {};
                post.as = barang_obj;
                post.jumlah = jml_row;
                
                
                for(var x=1;x<=jml_row;x++){
                    var jml_bundle = x;

//                    arr_bundle.push(x);

                    var nama_barang = $("#barang_pesanan_" + x+ " option:selected").val();
                    var qty_barang = $('#qty_barang_pesanan_'+ x).val();;


                    post["nama_barang_"+x] = nama_barang;
                    post["qty_barang_"+x] = qty_barang;

                  

                    //validasi input yang lain : Efindi

                }
                if (confirm("Anda akan mengirimkan ")) {
                    $.post("<?= _SPPATH; ?>BarangWebHelper/accept_req", post,
                            function (data) {
                                console.log(data);

                            }
                    );
                }
        //                    $.post("<?= _SPPATH; ?>KuponWebHelper/accept_req", post,
        //                            function (data) {
        //                                console.log(data);
        //                                if (data.status_code) {
        //                                    alert(data.status_message);
        //                                    $('#modal_bundle_kupon').modal('hide');
        //                                    lwrefresh(selected_page);
        //
        //                                } else {
        //                                    alert(data.status_message);
        //                                }
        //                            }, 'json');
            }
        </script>

        <?
    }

    function read_pemesanan_barang_ibo() {
        
    }

    function delete_pemesanan_barang_ibo() {
        
    }

    function update_pemesanan_barang_ibo() {
        
    }

}
