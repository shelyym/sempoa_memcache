<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 3/24/15
 * Time: 2:51 PM
 */
class Request {

	const BODY_OPTION    = "body_option";
	const BODY_CONTENT   = "body_content";
	const BODY_TAG       = "body_tag";
	const HEADER_OPTION  = "header_option";
	const HEADER_CONTENT = "header_content";
	const URL            = "url";
	const STORE_CODE     = "14044";

	// ESB Public
	const IP_ADDRESS = "http://123.231.241.42:8280/";

	static function requestWebservice ($obj, $data, $bodyOnly = true)
	{
		if (!$obj) {
			return false;
		}
                //pr($data);
		$data = Request::toXml($data, $obj);
                pr($obj);
                pr($data);
    		echo $data;die;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, Request::IP_ADDRESS . $obj[Request::URL]);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/xml'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		$data = curl_exec($ch);
		curl_close($ch);

		//convert the XML result into array
		$array_data = Request::toJson($data, $bodyOnly);

		print_r($array_data);

		return true;
	}

	static function toJson ($xml, $bodyOnly)
	{
		// Ignore response header, and only return the body
		$response = simplexml_load_string($xml);

		if ($bodyOnly) {
			$response = $response->CustomerBody;
		}

		return json_encode($response);
	}

	static function toXml ($json, $objOption)
	{
		$obj = array (
			'name'       => $objOption[Request::BODY_TAG],
			'attributes' => array (
				'xmlns:xsi'    => "http://www.w3.org/2001/XMLSchema-instance",
				'xmlns:xsd'    => "http://www.w3.org/2001/XMLSchema",
				'MajorVersion' => 3,
				'xmlns'        => 'http://www.nrf-arts.org/IXRetail/namespace/',
			)
		);

		$header = array ();
		$header['name'] = 'ARTSHeader';
		$header['attributes'] = array (
			'MessageType' => 'Request'
		);
		$header[] = array (
			'name'  => 'DateTime',
			'value' => date('c')
		);

		if ($objOption[Request::HEADER_OPTION]) {
			$header['attributes'] = array_merge($header['attributes'], $objOption[Request::HEADER_OPTION]);
		}
		$header[] = $objOption[Request::HEADER_CONTENT];

		$obj[] = $header;

		$body = array ();
		$body['name'] = 'CustomerBody';
		$body['attributes'] = $objOption[Request::BODY_OPTION];
		$body = array_merge($body, Request::parseArray(Request::toArray($json)));

		$obj[] = $body;

		$doc = new DOMDocument();
		$child = Request::generate_xml_element($doc, $obj);
		if ($child) {
			$doc->appendChild($child);
		}
		$doc->formatOutput = true; // Add whitespace to make easier to read XML
		$xml = $doc->saveXML();

		return $xml;
	}

	static function toArray ($json)
	{
		// It has to be started from array
		if (is_object(json_decode($json))) {
			return json_decode("[" . $json . "]");
		}

		return json_decode($json);
	}

	static function parseArray ($arr)
	{
		$newArr = array ();
		foreach ($arr as $content) {
			if (is_object($content)) {
				$newArr[] = Request::parseObj($content);
			}
		}

		return $newArr;
	}

	static function parseObj ($obj)
	{
		$arr = (array)$obj;

		$newArr = array (
			'name'       => "",
			'attributes' => array ()
		);
		foreach ($arr as $key => $value) {
			$isObj = false;
			$isArr = false;
			if (is_object($value)) {
				$isObj = true;
				$value = Request::parseObj($value);
			} else {
				if (is_array($value)) {
					$isArr = true;
					$tempArr = array ();
					foreach ($value as $obj) {
						$tempArr[] = Request::parseObj($obj);
					}

					$value = $tempArr;
				}
			}

			// Attributes
			if (substr($key, 0, 1) == "@") {
				$newArr['attributes'][substr($key, 1)] = $value;
			} else {
				if (substr($key, 0, 1) == "#") {
					$newArr['value'] = $value;
				} else {
					$newArr['name'] = $key;
					if (!$isObj && !$isArr) {
						$newArr['value'] = $value;
					} elseif ($isArr) {
						$newArr = array_merge($newArr, $value);
					} else {
						$newArr[] = $value;

					}
				}
			}
		}

		return $newArr;
	}

	static function generate_xml_element ($dom, $data)
	{
		if (empty($data['name'])) {
			return false;
		}

		// Create the element
		$element_value = (!empty($data['value'])) ? $data['value'] : null;
		$element = $dom->createElement($data['name'], $element_value);

		// Add any attributes
		if (!empty($data['attributes']) && is_array($data['attributes'])) {
			foreach ($data['attributes'] as $attribute_key => $attribute_value) {
				$element->setAttribute($attribute_key, $attribute_value);
			}
		}

		// Any other items in the data array should be child elements
		foreach ($data as $data_key => $child_data) {
			if (!is_numeric($data_key)) {
				continue;
			}

			$child = Request::generate_xml_element($dom, $child_data);
			if ($child) {
				$element->appendChild($child);
			}
		}

		return $element;
	}
        
        public static function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' => ':',//you may want this to be something other than a colon
        'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => '$',       //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace
 
    //get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            //replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }
 
    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);
 
            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
 
            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }
 
    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
 
    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
 
    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}
}
