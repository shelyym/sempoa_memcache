<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VRCustMapper
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class VRCustMapper {
    
    public $dob;
    
    public function __construct($VRO) {
        
        // $arrIndi = $VRO->CustomerBody->EntityInformation->Individual;
        // pr($arrIndi->Name->Name);CustomerID
        $this->id = (string)$VRO->CustomerBody->CustomerID;
        
        
        //insert name
        $arrName = $VRO->CustomerBody->EntityInformation->Individual->Name;
        /*pr($arrName);
        $name = $arrName->Name;
        echo "<h1>$name</h1>";
        pr($name);
        $gv = $arrName[1]->Name;
        echo "<h3>$gv</h3>";
        //$pop = array_pop($arrName);
        //pr($pop);
        foreach($arrName->Name->attributes() as $a => $b) {
            echo $a,'="',$b,"\"";
            echo "IN $a $b";
            echo "haloo ".$arrName->Name[$b];
        }
*/
        foreach($arrName->Name as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            //pr($obj);
            //echo "var : ".$var;
            if($var == "FamilyName"){
                
                $this->lastname = (string)$obj;
            }
            if($var == "GivenName"){
                $this->firstname = (string)$obj;
            }
            if($var == "PreferredName")
                 $this->nickname = (string)$obj;
        }
        //$this->firstname = (string)$obj->Name[1];
       // $this->lastname = $VRO->CustomerBody->EntityInformation->Individual->Name->Name[0];
        //$this->firstname = $VRO->CustomerBody->EntityInformation->Individual->Name->Name[1];
       // $this->nickname = (string) $VRO->CustomerBody->EntityInformation->Individual->Name->Name[2];
        
        
        
        //insert dob
        $arrTelp = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->Telephone;
        foreach($arrTelp as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            if($var == "Home"){
                $this->phone_home = (string)$obj->LocalNumber;
            }
            if($var == "Mobile"){
                $this->phone_mobile = (string)$obj->LocalNumber;
            }
            if($var == "Work"){
                $this->phone_work = (string)$obj->LocalNumber;
            }
        }
        
        //Address
        $arrAddress = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->Address;
        $this->address = (string) $arrAddress->AddressLine;
        $this->address_city = (string) $arrAddress->City;
        $this->address_territory = (string) $arrAddress->Territory;        
        $this->address_postalcode = (string) $arrAddress->PostalCode;
        $this->address_country = (string) $arrAddress->Country;
        
        //email
        $arrEmail = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->EMail;
        foreach($arrEmail as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            if($var == "Home"){
                $this->email_home = (string)$obj->EMailAddress;
            }
            
        }
        
        //PersonalSummary
        $personalSum = $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary;
        foreach($personalSum->attributes() as $a => $b) {
            //echo $a,'="',$b,"\"";
            //echo "IN $a $b";
            //echo "haloo ".$arrName->Name[$b];
            if($a == "GenderType")
                $this->gender = (string)$b;
        }
        //insert dob
        $this->dob = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->BirthDate;
        $this->loyalty_tokenID = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->LoyaltyTokenID;
        $this->loyalty_barcode = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->LoyaltyTokenBarcode;
        $this->member_type = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberType;
        $this->member_tier = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberTier;
        $this->token_issue_date = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->TokenIssueDate;
        $this->token_status = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->TokenStatus;

        //converter member type Stamp card
        if($this->member_type == "STC") {
            $this->member_type = "Stamp Card Member";
            $this->member_tier = "Stamp Card Member";
        }

//        if($this->member_type == "Stamp Card Member")

        
        //points
        $arrPoints = $VRO->CustomerBody->CustomerAccount->LoyaltyAccount->Points;
        //pr($arrPoints);
        $sem = array();
        $pointsDetails = array();
        foreach($arrPoints as $obj){
            $var = self::xml_attribute($obj, 'Type');
            $sem[$var] = (string)$obj;

            foreach($obj->attributes() as $a => $b) {
                $pointsDetails[$var][$a] = (string)$b;
            }
        }
        
        $this->points = $sem;
        $this->points_details = $pointsDetails;
    }
    static function xml_attribute($object, $attribute)
    {
        if(isset($object[$attribute]))
            return (string) $object[$attribute];
    }
    
    public static function parseToLLAccount($VRO) {

        $ll = new LL_Account();
        $ll->macc_ll_customer_id = (string)$VRO->CustomerBody->CustomerID;
        $ll->macc_id = (string)$VRO->CustomerBody->CustomerID;

        if(!$ll->macc_id)return 0;
        /*
         * cek apa di database sudah ada
         */
        $ll->getByID($ll->macc_id);
        if($ll->macc_id != "" || $ll->macc_id!=0)
            $ll->load = 0;

        
        /*
         * cek if ada fb_id atau foto
         */
        $macc_foto = addslashes($_POST['macc_foto']);
        $macc_fb_id = addslashes($_POST['macc_fb_id']);
        if($macc_foto != ""){
            $ll->macc_foto = Crud::savePic($macc_foto);
        }
        if($macc_fb_id != ""){
            $ll->macc_fb_id = $macc_fb_id;
        }


        //insert name
        $arrName = $VRO->CustomerBody->EntityInformation->Individual->Name;

        foreach($arrName->Name as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            //pr($obj);
            //echo "var : ".$var;
            if($var == "FamilyName"){
                
                $ll->macc_last_name = (string)$obj;
            }
            if($var == "GivenName"){
                $ll->macc_first_name = (string)$obj;
            }
            if($var == "PreferredName")
                 $ll->macc_prefered_name = (string)$obj;
        }

        if($_GET['test']){
            echo  "names : ";
            pr($ll);

        }

 
        //insert dob
        $arrTelp = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->Telephone;
        foreach($arrTelp as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            if($var == "Home"){
                $ll->macc_phone_home = (string)$obj->LocalNumber;
            }
            if($var == "Mobile"){
                $ll->macc_phone = (string)$obj->LocalNumber;
            }
            if($var == "Work"){
                $ll->macc_phone_work = (string)$obj->LocalNumber;
            }
        }

        if($_GET['test']){
            echo  "telp : ";
            pr($ll);

        }
        
        //Address
        $arrAddress = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->Address;
        $ll->macc_address = (string) $arrAddress->AddressLine;
        $ll->macc_address_city = (string) $arrAddress->City;
        $ll->macc_address_territory = (string) $arrAddress->Territory;        
        $ll->macc_address_postalcode = (string) $arrAddress->PostalCode;
        $ll->macc_address_country = (string) $arrAddress->Country;
        
        //email
        $arrEmail = $VRO->CustomerBody->EntityInformation->Individual->ContactInformation->EMail;
        foreach($arrEmail as $obj){
            $var = self::xml_attribute($obj, 'TypeCode');
            if($var == "Home"){
                $ll->macc_email = (string)$obj->EMailAddress;
            }           
        }

        if($_GET['test']){
            echo  "email : ";
            pr($ll);

        }

        //PersonalSummary
        $personalSum = $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary;
        foreach($personalSum->attributes() as $a => $b) {
            //echo $a,'="',$b,"\"";
            //echo "IN $a $b";
            //echo "haloo ".$arrName->Name[$b];
            if($a == "GenderType")
                $ll->macc_gender = (string)$b;
        }
        if($_GET['test']){
            echo  "gender : ";
            pr($ll);

        }


        //insert dob
        $dob = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->BirthDate;
        $exp = explode("+", $dob);
        $ll->macc_dob = date("Y-m-d",strtotime($exp[0]));
        $ll->macc_card_nr = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->LoyaltyTokenID;
        $ll->macc_card_barcode = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->LoyaltyTokenBarcode;
        $ll->macc_member_type = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberType;
        $ll->macc_member_tier = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberTier;


        //real tier n type
        $ll->macc_real_member_type = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberType;
        $ll->macc_real_tier = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->MemberTier;



        $tkdate = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->TokenIssueDate;
        $ll->macc_token_issue_date =  date("Y-m-d h:i:s",strtotime($tkdate));
        $ll->macc_token_status = (string) $VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->TokenStatus;




        if($_GET['test']){
            echo  "members : ";
            pr($ll);

        }


        $ll->macc_member_mismatch = 0;
        //mismatch calculator
        if($ll->macc_real_member_type == "STC" && $ll->macc_real_tier != "Stamp Card Member"){
            $ll->macc_member_mismatch = 1;
        }
        if($ll->macc_real_member_type == "133"){
            if($ll->macc_real_tier != "Fan" && $ll->macc_real_tier != "LYB Member")
            $ll->macc_member_mismatch = 1;
        }
        if($ll->macc_real_member_type == "LYB"){
            if($ll->macc_real_tier != "Fan" && $ll->macc_real_tier != "LYB Member")
                $ll->macc_member_mismatch = 1;
        }

        //converter member type Stamp card
        if($ll->macc_member_tier == "Fan" || $ll->macc_member_tier == "LYB Member") {
            $ll->macc_member_type == "LYB";
        }
//        if($ll->macc_member_tier == "Stamp Card Member") {
//            $ll->macc_member_type == "STC";
//        }

        //converter member type Stamp card
        if($ll->macc_member_type == "STC") {
//            $ll->macc_member_type = "STC";
            $ll->macc_member_tier = "Stamp Card Member";
        }
        
        //points
        $arrPoints = $VRO->CustomerBody->CustomerAccount->LoyaltyAccount->Points;
        //pr($arrPoints);
        $sem = array();
        $pointsDetails = array();
        foreach($arrPoints as $obj){
            $var = self::xml_attribute($obj, 'Type');
            $sem[$var] = (string)$obj;

            foreach($obj->attributes() as $a => $b) {
                $pointsDetails[$var][$a] = (string)$b;
            }
        }

        if($_GET['test']){
            echo  "points : ";
            pr($ll);

        }

        
        //sementara pakai balance
        $ll->macc_points = $sem['Balance'];
        //sementara saja
        $ll->macc_point_details = serialize(array("points"=>$sem,"details"=>$pointsDetails));
        //$this->points_details = $pointsDetails;
        return $ll;
    }
    public static function getBeginDate($ll){
        $cardtype = $ll->macc_member_tier;

        if($cardtype == "Stamp Card Member" || $cardtype == "STC"){
            $cardtype = $ll->macc_member_type;

//            if($cardtype == "Stamp Card Member" || $cardtype == "STC" ) {
                /*
                $begindate = date("Y-m-d",strtotime($ll->macc_token_issue_date));
                $today = date("Y-m-d");
                $datetime1 = new DateTime($begindate);
                $datetime2 = new DateTime($today);
                $interval = $datetime1->diff($datetime2);
                $m = $interval->m;
                $days = $interval->days;
                //pr($interval);

                while($m>=3 || $days > 90){
                    //sekarang bagi 3 bulanan ..how ?
                    $begindate = date('Y-m-d', strtotime('+3 months', strtotime($begindate)));
                    //echo "begin ".$begindate."<br>";
                    $datetime1 = new DateTime($begindate);
                    $datetime2 = new DateTime($today);
                    $interval = $datetime1->diff($datetime2);
                    $m = $interval->m;
                    $days = $interval->days;
                    //pr($interval);
                }
                $ll->begindate = $begindate;
                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+3 months', strtotime($begindate)));
                $ll->todate = $ll->macc_lyb_expiry_date;
    //            $ll->macc_lyb_status = "Stampcard";
    */
                $begindate = date('Y-m-d', mktime(0, 0, 0, date("m") - 3, date("d"), date("Y")));
                $ll->begindate = $begindate;
                $ll->todate = date("Y-m-d");
                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+3 months', strtotime($begindate)));
                $ll->macc_lyb_status = "The Body Shop Friend";
//            }

        }
        if($cardtype == "LYB Member"){
             $begindate = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y")-2));
             $ll->begindate = $begindate;
             $ll->todate = date("Y-m-d");
             //need confirmation
//             if($ll->macc_member_type == "133")
             $ll->macc_lyb_status = "LYB Club";
//             else
//                 $ll->macc_lyb_status = "LYB Fan";
             //macc_lyb_expiry_date
             //need to be confirmed upon latest transaction
             
        }

        //new one to add fan
        if($cardtype == "Fan"){
            $begindate = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y")-2));
            $ll->begindate = $begindate;
            $ll->todate = date("Y-m-d");
            //need confirmation
//            if($ll->macc_member_type == "133")
//                $ll->macc_lyb_status = "LYB Club";
//            else
                $ll->macc_lyb_status = "LYB Fan";
            //macc_lyb_expiry_date
            //need to be confirmed upon latest transaction

        }
        //pr($begindate);
        return $ll;
    }

    public static function parseStatement($ST,$ll){
        $vs = new VRStatement();

        //untuk save 12 nov 2015
        self::parseStatementwType($ST,$ll);

        $vs->response_code = (string)$ST->ARTSHeader->Response['ResponseCode'];
        $vs->point_total = 0;
        $vs->cash_total = 0;
        $transaction = array();
        
        if($vs->response_code != 'OK')return 0;
        
        $arrStatement = $ST->CustomerBody->LineItems;
        //pr($ST);
        
        $num = 0;
        foreach($arrStatement as $obj){
            $num++;
            $type =  (string)$obj->TransactionValue[0]->Type;
            /*
             * macam2 type
             *
             * PAYMENT , kalau payment TransactionValue ada 4 array
             *
             * ADJUST
             *
             * CATALOGUE ITEM REDEEMED , cuman ada 1 object
             */
            if($type!= 'REDEEMED'){
                $vs->cash_total += (int)$obj->TransactionValue[0]->TransactionCurrencyValue;
                $vs->point_total += (int)$obj->TransactionValue[1]->TransactionCurrencyValue;
            }
            
            $array = array();
            $array['TransactionID'] =  (string)$obj->TransactionID;
            $array['TransactionDateTime'] = date("Y-m-d", strtotime(substr((string)$obj->TransactionDateTime,0,10)));
            $array['Description'] =  (string)$obj->Description;
            $array['StoreName'] =  (string)$obj->StoreName;
            $array['ReferenceNumber'] =  (string)$obj->ReferenceNumber;
            $array['ReceiptNumber'] =  (string)$obj->ReceiptNumber;
            $array['CardNumber'] =  (string)$obj->CardNumber;
            
            //cash
            $array['Cash_Value'] =  (int)$obj->TransactionValue[0]->TransactionCurrencyValue;
            $array['Cash_Currency'] =  (string)$obj->TransactionValue[0]->TransactionCurrency;
            $array['Cash_Type'] =  (string)$obj->TransactionValue[0]->Type;
            $array['Cash_Descr'] =  (string)$obj->TransactionValue[0]->TransactionCurrencyDescription;
            //points
            $array['Point_Value'] =  (int)$obj->TransactionValue[1]->TransactionCurrencyValue;
            $array['Point_Currency'] =  (string)$obj->TransactionValue[1]->TransactionCurrency;
            $array['Point_Type'] =  (string)$obj->TransactionValue[1]->Type;
            $array['Point_Descr'] =  (string)$obj->TransactionValue[1]->TransactionCurrencyDescription;
            
            $array['Point_Balance'] =  (string)$obj->TransactionBalance->BalanceCurrencyValue;
            //echo "trans : ".$array['TransactionID']."<br>";
            $transaction[] = $array;
        }
        //pr($transaction);
        $vs->total_transaction = $num;
        $vs->transactions = $transaction;
        
        
        return $vs;
        
        
    }
    public static function parseStatementwType($ST,$ll){
        $vs = new VRStatement();
        $vs->response_code = (string)$ST->ARTSHeader->Response['ResponseCode'];
//        $vs->point_total = 0;
//        $vs->cash_total = 0;
//        $transaction = array();

        if($vs->response_code != 'OK')return 0;

        $arrStatement = $ST->CustomerBody->LineItems;
        //pr($ST);

        $num = 0;
        foreach($arrStatement as $obj){
            $num++;
            $type =  (string)$obj->TransactionValue[0]->Type;
            /*
             * macam2 type , update 12 nov 2015
             *
             * Konsep baru, we should go by description
             *
             * ada :
             *
             * Purchase , punya 4 TransactionValue kl beli offline, krn bs tuker point, kl beli online cuman payment and earn saja
             *
             * Point Adjustment
             *
             * Catalogue Redeem
             *
             * Point Expiry
             *
             * GCT Transaction
             */

            $array = array();
            $array['TransactionID'] =  (string)$obj->TransactionID;
            $array['TransactionDateTime'] = date("Y-m-d", strtotime(substr((string)$obj->TransactionDateTime,0,10)));
            $array['Description'] =  (string)$obj->Description;
            $array['StoreName'] =  (string)$obj->StoreName;
            $array['ReferenceNumber'] =  (string)$obj->ReferenceNumber;
            $array['ReceiptNumber'] =  (string)$obj->ReceiptNumber;
            $array['CardNumber'] =  (string)$obj->CardNumber;

            if($array['Description'] == "Purchase") {
                //cash
                $array['Cash_Value'] = (int)$obj->TransactionValue[0]->TransactionCurrencyValue;
                $array['Cash_Currency'] = (string)$obj->TransactionValue[0]->TransactionCurrency;
                $array['Cash_Type'] = (string)$obj->TransactionValue[0]->Type;
                $array['Cash_Descr'] = (string)$obj->TransactionValue[0]->TransactionCurrencyDescription;
                //points
                $array['Point_Value'] = (int)$obj->TransactionValue[1]->TransactionCurrencyValue;
                $array['Point_Currency'] = (string)$obj->TransactionValue[1]->TransactionCurrency;
                $array['Point_Type'] = (string)$obj->TransactionValue[1]->Type;
                $array['Point_Descr'] = (string)$obj->TransactionValue[1]->TransactionCurrencyDescription;

            }else{

                //cash
                $array['Cash_Value'] = 0;
                $array['Cash_Currency'] = "";
                $array['Cash_Type'] = "";
                $array['Cash_Descr'] = "";

                //not a purchase
                $array['Point_Value'] = (int)$obj->TransactionValue->TransactionCurrencyValue;
                $array['Point_Currency'] = (string)$obj->TransactionValue->TransactionCurrency;
                $array['Point_Type'] = (string)$obj->TransactionValue->Type;
                $array['Point_Descr'] = (string)$obj->TransactionValue->TransactionCurrencyDescription;
            }

            $array['Point_Balance'] =  (string)$obj->TransactionBalance->BalanceCurrencyValue;
            $array['trans_acc_id'] = $ll->macc_id;

            $nn = new LL_AccStatement();
            $nn->fill($array);
            $nn->save();
            //echo "trans : ".$array['TransactionID']."<br>";
//            $transaction[] = $array;
        }
        //pr($transaction);
//        $vs->total_transaction = $num;
//        $vs->transactions = $transaction;


//        return $vs;


    }
    
    public static function getExpiryDate($ll,$parsed_statement){
        $cardtype = $ll->macc_member_tier;
        $sem = $parsed_statement->transactions;


        if($cardtype == "LYB Member" || $cardtype == "Fan"){
            $expired1 = 2300-01-01;
            $expired2 = 2300-01-01;

            //cara 1 ambil exp 1 thn
            if(count($sem)>0){
                $pop = array_pop($sem);
                //pr($pop);
                $begindate = $pop['TransactionDateTime'];
                //echo $begindate;
                $expired1 = date('Y-m-d', strtotime('+1 year', strtotime($begindate)));
//                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+1 year', strtotime($begindate)));
            }

            foreach($sem as $trans){
                if($trans['Cash_Type'] == "CATALOGUE ITEM REDEEMED"){
                    //kalo redeem cek apakah masih dari 2 tahun terakhir
                    ///kalau dalam 2 tahun tidak redeem, maka po
                    $begindate = $trans['TransactionDateTime'];
                    $expired2 = date('Y-m-d', strtotime('+2 year', strtotime($begindate)));
                    break;
                }
            }
//            if(count($sem)>0){
//                $pop = array_pop($sem);
//                //pr($pop);
//                $begindate = $pop['TransactionDateTime'];
//                //echo $begindate;
//
//                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+1 year', strtotime($begindate)));
//            }
//            echo $expired1;echo "<br>";
//            echo $expired2;
            $satu = strtotime($expired1);
            $dua = strtotime($expired2);
            if($satu>$dua){
                $ll->macc_lyb_expiry_type = "dua";
            }else{
                $ll->macc_lyb_expiry_type = "satu";
            }

            $dipakai = min($satu,$dua);
            //echo $dipakai;
            $ll->macc_lyb_expiry_date = date("Y-m-d",  $dipakai);

        }


        if($cardtype == "Stamp Card Member" || $cardtype == "STC"){
            if(count($sem)>0){
                $pop = array_pop($sem);
                //pr($pop);
                $begindate = $pop['TransactionDateTime'];
                //echo $begindate;
   //             $expired1 = date('Y-m-d', strtotime('+3 month', strtotime($begindate)));
//                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+3 month', strtotime($begindate)));
                //untuk mengisi date yang kosong
                $ll->macc_lyb_expiry_date = date('Y-m-d', strtotime('+3 month', strtotime($begindate)));
                $ll->macc_lyb_expiry_type = "stc_rolling";
            }
        }




        //control saja
        if(!isset($ll->macc_lyb_expiry_date)){

//            $ll->macc_lyb_expiry_date = date("Y-m-d",  strtotime($ll->macc_token_issue_date));
            //untuk mengisi date yang kosong
            $ll->macc_lyb_expiry_date = "notfound";
            $ll->macc_lyb_expiry_type = "notfound";
        }

        $datetime1 = new DateTime($ll->macc_lyb_expiry_date);
        $datetime2 = new DateTime(date("Y-m-d"));
        $interval = $datetime1->diff($datetime2);
        //$m = $interval->m;
        $days = $interval->days; 
        $ll->selisih_expired = $days;




        return $ll;
    }
    
    public static function kerjakan($VRO,$dob = "",$acquire = 0){
        //print $VRO->saveXML();
        $json = array();
        //$map = new VRCustMapper($VRO);
        //pr($map);
        //pr($VRO->CustomerBody->EntityInformation->Individual->PersonalSummary->BirthDate);
        //pr($VRO);
        if($_GET['test'])
        echo "in1".$dob;
        
        $ll = VRCustMapper::parseToLLAccount($VRO);


        /*
         * tambahan 9 nov 2015
         * untuk handle kalau tokenstatus != '1' , 4 adalah sdh tidak aktif
         */
        if($ll->macc_token_status!='1'){
            //request ulang, tetapi apa yang terjadi kalau request nanti berkali2 ?
            //request sekali lagi saja ...
            $VRO = VRCustModel::findByID($ll->macc_id);
            $ll = VRCustMapper::parseToLLAccount($VRO);
        }

        //pr($ll);
        if($_GET['test']){
            echo  "finished : ";
            pr($ll);

        }

        if($dob!=""){
            if($ll->macc_dob != $dob){
                $json['status_code'] = 0;
                $json['status_message'] = Efiwebsetting::getData("Constant_invalid_credential");
                echo json_encode($json);
                die();
            }
        }
        
        $ll = VRCustMapper::getBeginDate($ll);
        //pr($ll);
        if($_GET['test']){
            echo  "getbegindate : ";
            pr($ll);

        }

        $statement = VRCustModel::statement($ll, $ll->macc_id, $ll->macc_member_tier);

        if($_GET['test']){
            echo  "statement : ";
            pr($statement);

        }
        
        /*
         * $datetime1 = new DateTime('2009-10-11');
        $datetime2 = new DateTime('2009-10-13');
        $interval = $datetime1->diff($datetime2);
        pr($interval);
         */
        
        $parsed_statement = VRCustMapper::parseStatement($statement,$ll);
        
        $ll = VRCustMapper::getExpiryDate($ll,$parsed_statement);
        
        $ll->statements = $parsed_statement;
        $ll->statement_cash_total = $parsed_statement->cash_total;
        $ll->statement_point_total = $parsed_statement->point_total;
        $ll->statement_total_transaction = $parsed_statement->total_transaction;
        
        $ll->macc_acquire = $acquire;
        
        //pr($parsed_statement);
        //pr($statement);
        //pr($ll);
        if($_GET['test']){
            echo  "getexpiry : ";
            pr($parsed_statement);
            echo "ll final sebelum save";
            pr($ll);

        }


        //save tanggal acquire
        if($ll->macc_acquire_date == "0000-00-00 00:00:00" || $ll->macc_acquire_date ==""){
            $ll->macc_acquire_date = leap_mysqldate();
        }

        $ll->macc_login_date = leap_mysqldate();

        //update lyb_expiry_date


        // update database
        // insert on duplicate key updates
        $succ = $ll->save(1);
        if($succ){

            //logged all login 19 nov 2015 roy
            $logged = new LL_AccountLogger();
            $logged->log_acc_id = $ll->macc_id;
            $logged->log_date = leap_mysqldate();
            $logged->save();

            if($_GET['test']){
                echo  "succ : ".$succ;
                pr($ll);

            }

            $json['status_code'] = 1;
            
            $obj = $ll;
            $obj->default_read_coloms = $obj->crud_webservice_allowed;
            $main_id = $obj->main_id;
            $exp = explode(",",$obj->crud_webservice_allowed);
            $sem = array();
            foreach($exp as $attr){
                if(!isset($obj->$attr)||$obj->$attr==NULL)
                    $obj->$attr = 0;
                $sem[$attr] = $obj->$attr;
            }
            $json['results'] = $sem;
            return $json;
            //echo json_encode($json);
            //die();
        }else{
            
            $json['status_code'] = 0;
            $json['status_message'] = "Save Failed";
            echo json_encode($json);
            die();
        
        }
    }
}
