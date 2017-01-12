<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/12/15
 * Time: 10:49 AM
 */

class LL_AccStatement extends Model{
    //Nama Table
    public $table_name = "ll__transactions";

    //Primary
    public $main_id = 'TransactionID';

    //Default Coloms for read
    public $default_read_coloms = "TransactionID,trans_acc_id,TransactionDateTime,Description,StoreName,ReferenceNumber,ReceiptNumber,CardNumber,Cash_Value,Cash_Currency,Cash_Type,Cash_Descr,Point_Value,Point_Currency,Point_Type,Point_Descr,Point_Balance";

//allowed colom in CRUD filter
    public $coloumlist = "TransactionID,trans_acc_id,TransactionDateTime,Description,StoreName,ReferenceNumber,ReceiptNumber,CardNumber,Cash_Value,Cash_Currency,Cash_Type,Cash_Descr,Point_Value,Point_Currency,Point_Type,Point_Descr,Point_Balance";
    public $TransactionID;
    public $trans_acc_id;
    public $TransactionDateTime;
    public $Description;
    public $StoreName;
    public $ReferenceNumber;
    public $ReceiptNumber;
    public $CardNumber;
    public $Cash_Value;
    public $Cash_Currency;
    public $Cash_Type;
    public $Cash_Descr;
    public $Point_Value;
    public $Point_Currency;
    public $Point_Type;
    public $Point_Descr;
    public $Point_Balance;

} 