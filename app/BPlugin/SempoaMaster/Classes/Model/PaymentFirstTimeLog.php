<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/13/16
 * Time: 9:27 AM
 */
class PaymentFirstTimeLog extends Model {

    var $table_name = "sempoa__siswa_pay_first";
    var $main_id = "murid_id";
    //Default Coloms for read
    public $default_read_coloms = "murid_id,murid_pay_date,murid_pay_value,murid_biaya_serial,murid_cara_bayar,murid_ak_id,murid_kpo_id,murid_ibo_id,murid_tc_id,bln_no_invoice,bln_no_urut_inv";
//allowed colom in CRUD filter
    public $coloumlist = "murid_id,murid_pay_date,murid_pay_value,murid_biaya_serial,murid_cara_bayar,murid_ak_id,murid_kpo_id,murid_ibo_id,murid_tc_id,bln_no_invoice,bln_no_urut_inv";
    public $murid_id;
    public $murid_pay_date;
    public $murid_pay_value;
    public $murid_biaya_serial;
    public $murid_cara_bayar;
    public $murid_ak_id;
    public $murid_kpo_id;
    public $murid_ibo_id;
    public $murid_tc_id;
    public $bln_no_urut_inv;
    public $bln_no_invoice;

    function getLastNoUrutInvoice($thn, $bln, $tc_id)
    {
        $nourut = new $this();
        $nourut->getWhereOne("murid_tc_id=$tc_id AND MONTH(murid_pay_date)=$bln AND YEAR((murid_pay_date))=$thn AND bln_no_urut_inv !=0  ORDER BY murid_pay_date DESC");
        $urut = $nourut->bln_no_urut_inv + 1;
        return $urut;
    }

}
