<?php

/**
 * Description of LL_Account
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Account extends Model{
    //Nama Table
    public $table_name = "ll__account";  
    
    //Primary
    public $main_id = 'macc_id';
    
   //Default Coloms for read
//public $default_read_coloms = "macc_id,macc_card_nr,macc_card_barcode,macc_last_name,macc_first_name,macc_prefered_name,macc_gender,macc_dob,macc_email,macc_phone,macc_phone_home,macc_phone_work,macc_address,macc_address_city,macc_address_territory,macc_address_postalcode,macc_address_country,macc_points,macc_point_details,macc_fb_id,macc_lyb_status,macc_lyb_expiry_date,macc_foto,macc_ll_customer_id,macc_member_type,macc_member_tier,macc_token_issue_date,macc_token_status,statement_point_total,statement_cash_total,statement_total_transaction,macc_acquire";
    public $default_read_coloms = "macc_id,macc_last_name,macc_first_name,macc_dob,macc_lyb_status,macc_acquire_date";

//allowed colom in CRUD filter
public $coloumlist = "macc_id,macc_card_nr,macc_card_barcode,macc_last_name,macc_first_name,macc_prefered_name,macc_gender,macc_dob,macc_email,macc_phone,macc_phone_home,macc_phone_work,macc_address,macc_address_city,macc_address_territory,macc_address_postalcode,macc_address_country,macc_points,macc_point_details,macc_fb_id,macc_lyb_status,macc_lyb_expiry_date,macc_foto,macc_ll_customer_id,macc_member_type,macc_member_tier,macc_token_issue_date,macc_token_status,statement_point_total,statement_cash_total,statement_total_transaction,selisih_expired,macc_acquire,macc_real_member_type,macc_real_tier,macc_acquire_date,macc_member_mismatch,macc_login_date";
 
    public $macc_id;
    public $macc_card_nr;
    public $macc_card_barcode;
    public $macc_last_name;
    public $macc_first_name;
    public $macc_prefered_name;
    public $macc_gender;
    public $macc_dob;
    public $macc_email;
    public $macc_phone;
    public $macc_phone_home;
    public $macc_phone_work;
    public $macc_address;
    public $macc_address_city;
    public $macc_address_territory;
    public $macc_address_postalcode;
    public $macc_address_country;
    public $macc_points;
    public $macc_point_details;
    public $macc_fb_id;
    public $macc_lyb_status;
    public $macc_lyb_expiry_date;
    public $macc_foto;
    public $macc_ll_customer_id;
    public $macc_acquire;
    //member
    public $macc_member_type;
    public $macc_member_tier;
    public $macc_token_issue_date;
    public $macc_token_status;

    //tambahan untuk tipe expiry date
    public $macc_lyb_expiry_type;
    
    //statement
    public $statement_point_total;
    public $statement_cash_total;
    public $statement_total_transaction;

    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = "macc_id,macc_card_nr,macc_card_barcode,macc_last_name,macc_first_name,macc_prefered_name,macc_gender,macc_dob,macc_email,macc_phone,macc_phone_home,macc_phone_work,macc_address,macc_address_city,macc_address_territory,macc_address_postalcode,macc_address_country,macc_points,macc_fb_id,macc_lyb_status,macc_lyb_expiry_date,macc_foto,macc_ll_customer_id,macc_member_type,macc_member_tier,macc_token_issue_date,macc_token_status,statement_point_total,statement_cash_total,statement_total_transaction,begindate,todate,selisih_expired,statements,macc_acquire,macc_lyb_expiry_type";
    public $crud_webservice_images = array("macc_foto");
    
    //tambahan dari Mapper
    public $begindate;
    public $statements;
    public $todate;
    public $selisih_expired;

    public $macc_real_member_type;
    public $macc_real_tier;
    public $macc_acquire_date;
    public $macc_member_mismatch;
    public $macc_login_date;





    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->macc_lyb_status)) {
                $this->macc_lyb_status = "Stampcard";
        }

        
        
        if (!isset($this->macc_lyb_expiry_date)) {
            $effectiveDate = date('Y-m-d h:i:s', strtotime("+3 months", strtotime(date("Y-m-d"))));
            $this->macc_lyb_expiry_date = $effectiveDate;                
        }

        

        return $err;
    }
}
