<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 3/24/15
 * Time: 3:03 PM
 */
class Customer extends WebService {

	/**
	 *
	 * URL
	 * Customer/.../
	 *
	 * BODY_TAG
	 * Mandatory
	 *
	 * BODY_OPTION
	 * array('attributes' => 'value')
	 *
	 * HEADER_CONTENT
	 * array('name' => 'value',
	 * 'attributes' => array('attributes1' => 'value', 'attributes2' => 'value)
	 * 'value' => 'text')
	 *
	 * JSON FORMAT
	 * [{"CustomerDetails":{"CustomerID":3, "@type":"integer"}},{"CustomerType":"LYB Fan"}]
	 * <CustomerDetails>
	 * <CustomerID attr="integer">3</CustomerID>
	 * </CustomerDetails>
	 * <CustomerType>LYB Fan</CustomerType>
	 *
	 */
	public $OBJ_FIND         = [
		Request::URL      => "Customer/Find/",
		Request::BODY_TAG => "CustomerLookup"];
	public $OBJ_ADD          = [
		Request::URL            => "Customer/Add/",
		Request::BODY_TAG       => "CustomerAdd",
		Request::BODY_OPTION    => ["ActionCode" => "Add"],
		Request::HEADER_CONTENT => ["BusinessUnit" => "ValidStore101"],
		Request::HEADER_CONTENT => array (
			'name'  => 'BusinessUnit',
			'value' => Request::STORE_CODE)];
	public $OBJ_TRANSACTIONS = [
		Request::URL => "Customer/TransactionDetails/"];

	public function find ()
	{
		$json = '{"CustomerID":1000}';
		Request::requestWebservice($this->OBJ_FIND, $json);
	}

	public function add ($json)
	{
		$json =
			'[{"ReturnCustomerDetails":"true"},{"EntityInformation":[{"Individual":[{"Name":[{"Salutation":"Mr."},{"Name":"Lee","@TypeCode":"GivenName"},{"Name":"DeWyze","@TypeCode":"FamilyName"},{"Name":"Wise","@TypeCode":"PreferredName"}]},{"ContactInformation":[{"Telephone":[{"LocalNumber":"021312234"}],"@PrimaryFlag":"true","@TypeCode":"Mobile"}]},{"PersonalSummary":[{"BirthDate":"1974-08-19+08:00"}],"@GenderType":"Male"}]}],"@PartyType":"Individual"}]';
		Request::requestWebservice($this->OBJ_ADD, $json);
	}

	public function transactions ()
	{
		$json = '{"CustomerID":1000}';
		Request::requestWebservice($this->OBJ_TRANSACTIONS, $json, false);
	}
} 