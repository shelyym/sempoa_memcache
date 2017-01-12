<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VRCustomer
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class VRCustModel {
    
    public static function gabung($customer_body,$mode = "read"){
        $actcode = '';
        $heading = '<CustomerLookup xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" MajorVersion="3" xmlns="http://www.nrf-arts.org/IXRetail/namespace/">
';
        $footing = '</CustomerLookup>';
        $arts = '<MessageID>daed46b2-cd0d-40c6-9c51-be44bd873dfc</MessageID>
                <DateTime>2010-06-15T12:54:55.3430287+12:00</DateTime>';
        if($mode == "update"){
            $actcode = ' ActionCode="Update" ';
            $heading = '<CustomerUpdate xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.nrf-arts.org/IXRetail/namespace/ ../CustomerUpdateV3.0.1.xsd" xmlns="http://www.nrf-arts.org/IXRetail/namespace/" MajorVersion="3" MinorVersion="0" FixVersion="1"> 
';
            $footing = '</CustomerUpdate>';
        }
        if($mode == "add"){
            $heading = '<CustomerAdd xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.nrf-arts.org/IXRetail/namespace/ ../CustomerAddV3.0.0.xsd" xmlns="http://www.nrf-arts.org/IXRetail/namespace/" MajorVersion="3" MinorVersion="0" FixVersion="0"> 
';
            $footing = '</CustomerAdd>';
            $actcode = ' ActionCode="Add" ';
            $arts = '
            <DateTime>2015-05-17T09:30:47-05:00</DateTime> 
            <BusinessUnit>100</BusinessUnit> 
            ';
            

        }
        
        
        $xml = '<?xml version="1.0"?>
'.$heading.'
<ARTSHeader MessageType="Request">
                
                '.$arts.'
</ARTSHeader>
<CustomerBody '.$actcode.' >
'.$customer_body.'
</CustomerBody>
'.$footing;
        return $xml;
    }
    
    /*
     * Find Single Entry
     */
    public static function findByID($id = 0){
        if(!$id)return 0;
        //$id = addslashes($_GET['id']);
        
        $customer_body ='<CustomerID>'.$id.'</CustomerID>';
        $xml = self::gabung($customer_body);        
        $url = "Customer/Find/";
        $json = VR::run($url, $xml,2);
        //pr($result);
        return $json;
    }
    
    public static function findByCard($id = 0){
        if(!$id)return 0;
        //$id = addslashes($_GET['id']);
        //13327001000060 //example
$customer_body = '<EntityInformation>
            <Individual>
                <PersonalSummary>
                    <LoyaltyTokenID>'.$id.'</LoyaltyTokenID>
                </PersonalSummary>
            </Individual>
        </EntityInformation>    
';
        
        $xml = self::gabung($customer_body);    
        $url = "Customer/Find/";
        $json = VR::run($url, $xml,2);
        //pr($result);
        return $json;
    }
    public function findWithGift(){
        
        $id = addslashes($_GET['id']);
        //13327001000060 //example
$xml = '<?xml version="1.0"?>
<CustomerLookup xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" MajorVersion="3" xmlns="http://www.nrf-arts.org/IXRetail/namespace/">
                <ARTSHeader MessageType="Request">
                                <MessageID>daed46b2-cd0d-40c6-9c51-be44bd873dfc</MessageID>
                                <DateTime>2010-06-15T12:54:55.3430287+12:00</DateTime>
                </ARTSHeader>
                <CustomerBody>
                                <CustomerID>3336</CustomerID>
                </CustomerBody>
                <GiftAvailable>
		<RequestGiftInfo>1</RequestGiftInfo>
                </GiftAvailable>
</CustomerLookup>
';
  
        $url = "Customer/Find/";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    public function findByBarcode(){
        $id = addslashes($_GET['id']);
        

$customer_body = '<EntityInformation>
            <Individual>
                <PersonalSummary>
                    <LoyaltyTokenBarcode>2518082200013</LoyaltyTokenBarcode>
                </PersonalSummary>
            </Individual>
        </EntityInformation>   
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/Find/";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    
    
    public function findByEMail(){
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
      
 $customer_body = '<EntityInformation PartyType="Individual"> 
                        <Individual> 
                               <ContactInformation> 
                                     <EMail TypeCode="Home"> 
                                           <EMailAddress>'.$id.'</EMailAddress> 
                                        </EMail> 
                                </ContactInformation>  
				                   
                        </Individual> 
                </EntityInformation>   
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/Find/";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    public function findByMobile(){
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
   
 $customer_body = '<EntityInformation PartyType="Individual"> 
                        <Individual> 
                               <ContactInformation> 
                               <Telephone TypeCode="Mobile">
                                        <LocalNumber>628158900740</LocalNumber>
                               </Telephone>

                                     
                                </ContactInformation>  
				                   
                        </Individual> 
                </EntityInformation>   
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/Find/";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    public function findByName(){
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
   
 $customer_body = '<EntityInformation PartyType="Individual"> 
                        <Individual> 
                                <Name> 
                                        <Name TypeCode="FamilyName">Hana Natalia W</Name> 
                                        <Name TypeCode="GivenName">Maria</Name> 
                                </Name> 
                        </Individual> 
                </EntityInformation>  
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/Find/";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
     
    /*
     * Find Multiple Entry
     */
    public function findMultipleByLastName(){
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
   
 $customer_body = '<EntityInformation PartyType="Individual"> 
                        <Individual> 
                                <Name> 
                                        
                                        <Name TypeCode="FamilyName">Smith</Name> 
                                </Name> 
                        </Individual> 
                </EntityInformation> 
 
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/FindMultiple/5";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    public function findMultipleByFirstName(){
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
   
 $customer_body = '<EntityInformation PartyType="Individual"> 
                        <Individual> 
                                <Name> 
                                        
                                        <Name TypeCode="GivenName">Michelle</Name> 
                                </Name> 
                        </Individual> 
                </EntityInformation> 
 
';
        
        $xml = self::gabung($customer_body);
        $url = "Customer/FindMultiple/5";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    
    public function search()
    {
        
        $id = addslashes($_GET['id']);
        //email //sample : natalia@cetro.or.id
        //mode = EXACT, START, END, ANYWHERE
        //contoh dibawah untuk mengeluarkan address dan name sekaligus dicari didua tempat itu
 $customer_body = '<EntityInformation PartyType="Individual" WildcardFlag="true" WildcardSearchMode="ANYWHERE"> 
<Individual>  
     <Name>
        <Name TypeCode="GivenName">Sere</Name> 
 </Name> 
 <ContactInformation>
 <Address>
<AddressLine TypeCode="Street">Sakti</AddressLine>
</Address>
</ContactInformation>
 </Individual>
 </EntityInformation>
';
        $xml = self::gabung($customer_body);
        $url = "Customer/FindMultiple/5";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
        
        

    }
    
    public static function update(){
        
        $macc_email  = addslashes($_POST['macc_email']);
        $macc_phone  = addslashes($_POST['macc_phone']);
        
        $macc_id  = addslashes($_POST['macc_id']);
        //email //sample : natalia@cetro.or.id
        $ret = 1;
        $rettext = '';
        if($ret)
            $rettext = '<ReturnCustomerDetails>true</ReturnCustomerDetails>';
       
        $customer_body = $rettext.'
        <CustomerID>'.$macc_id.'</CustomerID>
        <EntityInformation PartyType="Individual"> 
               <Individual> 
                  <ContactInformation>
                        <Telephone TypeCode="Mobile"> 
                            <LocalNumber>'.$macc_phone.'</LocalNumber> 
                        </Telephone> 
                       <EMail TypeCode="Home">
                           <EMailAddress>'.$macc_email.'</EMailAddress>
                       </EMail>
                   </ContactInformation> 
        </Individual>
        </EntityInformation> 
        ';
        
        $xml = self::gabung($customer_body,"update");
        $url = "Customer/Update";
        $json = VR::run($url, $xml,2);
        return $json;
        //pr($result);
        //echo $json;
    }
    
    /*
     * ADD
     */
    public function add(){
        
   
 $customer_body = '<ReturnCustomerDetails>true</ReturnCustomerDetails> 
<EntityInformation PartyType="Individual"> 
    <Individual> 
        <Name> 
            <Salutation>Mr.</Salutation> 
            <Name TypeCode="GivenName">Marcel</Name> 
            <Name TypeCode="FamilyName">Santoso</Name> 
            <Name TypeCode="PreferredName">Acel</Name> 
        </Name> 
        <ContactInformation> 
            <Telephone PrimaryFlag="true" TypeCode="Mobile"> 
                <LocalNumber>02131234</LocalNumber> 
            </Telephone> 
            <Telephone TypeCode="Work"> 
                 <LocalNumber>081278228</LocalNumber> 
            </Telephone> 
            <Address> 
                <TypeCode>Home</TypeCode> 
                <AddressLine TypeCode="Street">1234 Highline Place</AddressLine> 
                <AddressLine TypeCode="Unit">26</AddressLine> 
                <City>Atlanta</City> 
                <Territory TypeCode="State">Georgia</Territory> 
                <PostalCode>123456</PostalCode> 
            </Address> 
            <EMail TypeCode="Home"> 
                <EMailAddress>marcel@imb.com</EMailAddress> 
            </EMail> 
        </ContactInformation>
        <PersonalSummary GenderType="Male">
<BirthDate>1993-06-11+08:00</BirthDate>
<MemberType>021</MemberType>
<DNSFlag AddressType="Email">false</DNSFlag>
<DNSFlag AddressType="Mail">false</DNSFlag>
<DNSFlag AddressType="Phone">false</DNSFlag>
<DNSFlag AddressType="SMS">true</DNSFlag>
        </PersonalSummary>
    </Individual> 
</EntityInformation>      
';
        
        $xml = self::gabung($customer_body);
        
$xml = '<?xml version="1.0" encoding="UTF-8"?> 
<CustomerAdd xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.nrf-arts.org/IXRetail/namespace/ ../CustomerAddV3.0.0.xsd" xmlns="http://www.nrf-arts.org/IXRetail/namespace/" MajorVersion="3" MinorVersion="0" FixVersion="0"> 
    <ARTSHeader ActionCode="Begin" MessageType="Request"> 
        
        <DateTime>2015-05-15T09:30:47-05:00</DateTime> 
        <BusinessUnit>BSONL</BusinessUnit> 
    </ARTSHeader> 
    <CustomerBody ActionCode="Add"> 
     <ReturnCustomerDetails>true</ReturnCustomerDetails> 
        <EntityInformation PartyType="Individual"> 
            <Individual> 
                <Name> 
                    <Salutation>Mr.</Salutation> 
                    <Name TypeCode="GivenName">Marcel</Name> 
                    <Name TypeCode="FamilyName">Santoso</Name> 
                    <Name TypeCode="PreferredName">Acel</Name> 
                </Name> 
                <ContactInformation> 
                    <Telephone PrimaryFlag="true" TypeCode="Mobile"> 
                        <LocalNumber>0211681681</LocalNumber> 
                    </Telephone> 
                    <Telephone TypeCode="Work"> 
                         <LocalNumber>0888123456</LocalNumber> 
                    </Telephone> 
                    <Address> 
                        <TypeCode>Home</TypeCode> 
                        <AddressLine TypeCode="Street">1234 Highline Place</AddressLine> 
                        <AddressLine TypeCode="Unit">26</AddressLine> 
                        <City>Atlanta</City> 
                        <Territory TypeCode="State">Georgia</Territory> 
                        <PostalCode>123456</PostalCode> 
                    </Address> 
                    <EMail TypeCode="Home"> 
                        <EMailAddress>marcel@leap-systems.com</EMailAddress> 
                    </EMail> 
                </ContactInformation>
                <PersonalSummary GenderType="Male">
	<BirthDate>1993-06-11+08:00</BirthDate>
	<LoyaltyTokenID>23399002244884</LoyaltyTokenID>
		<MemberType>STC</MemberType>   
	<DNSFlag AddressType="Email">false</DNSFlag>
	<DNSFlag AddressType="Mail">false</DNSFlag>
	<DNSFlag AddressType="Phone">false</DNSFlag>
	<DNSFlag AddressType="SMS">true</DNSFlag>
                </PersonalSummary>
            </Individual> 
        </EntityInformation> 
    </CustomerBody> 
</CustomerAdd> 
';
        
        $url = "Customer/Add";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    
    /*
     * FInd stores
     */
    function store(){
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<StoreLookup FixVersion="" MajorVersion="1" MinorVersion="" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="StoreMaintenanceV1.0.0.xsd">
  <VRLHeader ActionCode="Find" MessageType="Request">
    <DateTime TypeCode="Message">2001-12-31T12:00:00</DateTime>
    <Description Language="eng">Description</Description>
    
  </VRLHeader>
  <StoreBody>
   
     
    </StoreBody>
</StoreLookup>
';
        $url = "Site/Find";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    /*
     * Add Store
     */
    function addstore(){
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<StoreAdd FixVersion="" MajorVersion="1" MinorVersion="" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="StoreMaintenanceV1.0.0.xsd">
  <VRLHeader ActionCode="Create" MessageType="Request">
    <DateTime TypeCode="Message">2001-12-31T12:00:00</DateTime>
    <Description Language="eng">Description</Description>
    <Response ResponseCode="OK">
      <ResponseMessage>ResponseMessage</ResponseMessage>
    </Response>
  </VRLHeader>
<ReturnStoreDetails>true</ReturnStoreDetails>
 
 <StoreBody>
   
    <StoreCode>LEAP</StoreCode>
    <StoreName>TestAdd1</StoreName>
    <StoreShortName>StoreShortName1</StoreShortName>
    <Address>Address1</Address>
    <Suburb>Suburb1</Suburb>
    <City>City1</City>
    <State>State1</State>
    <PostCode>PostCode1</PostCode>
    <CountryCode>AU</CountryCode>
    <PhoneNumber>1111111</PhoneNumber>
    <FaxNumber>222222</FaxNumber>
    <Email>Email</Email>
    <OwnerName>OwnerName</OwnerName>
    <Representative>Representative</Representative>
    <LiveDate>2011-01-01</LiveDate>
    <CloseDate>2021-01-01</CloseDate>
      
  </StoreBody>
</StoreAdd>


';
        $url = "Site/Add";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    
    public static function statement($ll, $id = 0,$cardtype = "LYB Member",$to = '0',$from = '0'){
        if(!$id)die("no iD");
        if($to == '0'){
            $to = $ll->todate;
            //$to = date("Y-m-d");
        }
        if($from == '0'){
            $from = $ll->begindate;
            /*if($cardtype == "Stamp Card Member"){
                
                //echo $interval->format('%R%a days');

                $from = date('Y-m-d', mktime(0, 0, 0, date("m")-3 , date("d"), date("Y")));
            }
            if($cardtype == "LYB Member")
                $from = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y")-1));*/
        }
        //<MaximumTransaction>10</MaximumTransaction>
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<CustomerStatement xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" MajorVersion="1" xmlns="http://www.nrf-arts.org/IXRetail/namespace/">
 	 <ARTSHeader ActionCode="Begin" MessageType="Request">
  	  <MessageID>829b0b1a-3def-4bec-b72f-48fadfcf9bb3</MessageID>
  	  <DateTime>'.date("Y-m-d").'T11:33:01.7695381+12:00</DateTime>
 	 </ARTSHeader>
        <CustomerBody>
 	    <CustomerID>'.$id.'</CustomerID>
            <MaximumTransaction>500</MaximumTransaction>
            <FromDate>'.$from.'</FromDate>
            <ToDate>'.$to.'</ToDate>
         	 <CustomerAccount>
         	    <LoyaltyAccount>
           	      <Points LoyaltyCurrency="IDR">0</Points>   <!-- VR to decide the loyalty currency --> 
                </LoyaltyAccount>
   	 </CustomerAccount>
    </CustomerBody>
 </CustomerStatement>
';
        $url = "Customer/GetCustomerTransactionStatement";
        $json = VR::run($url, $xml,2);
        //pr($result);
        return $json;
    }
    
    public function replaceCard(){
        
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<CustomerCardReplacement xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.nrf-arts.org/IXRetail/namespace/ ../CustomerCardReplacementV1.0.0.xsd" xmlns="http://www.nrf-arts.org/IXRetail/namespace/" MajorVersion="1" MinorVersion="0" FixVersion="0">
<ARTSHeader ActionCode="Begin" MessageType="Request">
   <DateTime>2013-02-13T16:50:32+10:00</DateTime>
  <BusinessUnit>BSONL</BusinessUnit>
</ARTSHeader>
<CustomerBody ActionCode="Replace">
<!--replace reason must be provided and follow XSD enumerated options -->	
	<ReplacementReason>Upgrade Card</ReplacementReason>
	<OperatorID>1</OperatorID>
	<EntityInformation>
	<Individual>
	  <PersonalSummary>
<!--current card number -->		  <LoyaltyTokenID>13399002004884</LoyaltyTokenID>

<!--new card number --> 
 <ReplacementLoyaltyTokenID>13399002144884</ReplacementLoyaltyTokenID>
 


	  </PersonalSummary>
	</Individual>
</EntityInformation>
</CustomerBody></CustomerCardReplacement>
';
        //	<!--If member type is not specified, the old member type is created --> 
//<ReplacementMemberType>LYB</ReplacementMemberType>
        
        $url = "Customer/ReplaceCard";
        $json = VR::run($url, $xml);
        //pr($result);
        echo $json;
    }
    
    
     /*
     * ADD AUTO
     */
    public static function addauto(){
        $macc_fb_id = addslashes($_POST['macc_fb_id']);
        $macc_last_name = addslashes($_POST['macc_last_name']);
        $macc_first_name = addslashes($_POST['macc_first_name']);
        $macc_gender  = addslashes($_POST['macc_gender']);
        $macc_dob  = addslashes($_POST['macc_dob']);
        $macc_email  = addslashes($_POST['macc_email']);
        $macc_phone  = addslashes($_POST['macc_phone']);
        $macc_foto  = addslashes($_POST['macc_foto']);
        
//        $businessUnit = 34999; //ecom
        $businessUnit = Efiwebsetting::getData("LL_Site_ID");
        if($businessUnit == "")$businessUnit = 34999; //pake punya ecom

$xml = '<?xml version="1.0" encoding="UTF-8"?> 
<CustomerAdd xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.nrf-arts.org/IXRetail/namespace/ ../CustomerAddV3.0.0.xsd" xmlns="http://www.nrf-arts.org/IXRetail/namespace/" MajorVersion="3" MinorVersion="0" FixVersion="0"> 
    <ARTSHeader ActionCode="Begin" MessageType="Request"> 
        
        <DateTime>'.date("Y-m-d").'T09:30:47-05:00</DateTime> 
        <BusinessUnit>'.$businessUnit.'</BusinessUnit> 
    </ARTSHeader> 
    <CustomerBody ActionCode="Add"> 
     <ReturnCustomerDetails>true</ReturnCustomerDetails> 
        <EntityInformation PartyType="Individual"> 
            <Individual> 
                <Name> 
                    
                    <Name TypeCode="GivenName">'.$macc_first_name.'</Name> 
                    <Name TypeCode="FamilyName">'.$macc_last_name.'</Name> 
                   
                </Name> 
                <ContactInformation> 
                    
                    <Telephone TypeCode="Mobile"> 
                         <LocalNumber>'.$macc_phone.'</LocalNumber> 
                    </Telephone> 
                    
                    <EMail TypeCode="Home"> 
                        <EMailAddress>'.$macc_email.'</EMailAddress> 
                    </EMail> 
                </ContactInformation>
                <PersonalSummary GenderType="'.$macc_gender.'">
	<BirthDate>'.$macc_dob.'+08:00</BirthDate>
	<MemberType>STC</MemberType>   
	<DNSFlag AddressType="Email">false</DNSFlag>
	<DNSFlag AddressType="Mail">false</DNSFlag>
	<DNSFlag AddressType="Phone">false</DNSFlag>
	<DNSFlag AddressType="SMS">false</DNSFlag>
                </PersonalSummary>
            </Individual> 
        </EntityInformation> 
    </CustomerBody> 
</CustomerAdd> 
';
        //<LoyaltyTokenID>23399002244884</LoyaltyTokenID>
        $url = "Customer/Add";
        $json = VR::run($url, $xml,2);
        return $json;
        //pr($result);
        //echo $json;
    }
}
