<?php


class Tx_Powermail2document_FileTypes_Pdf_FormFiller {
	private $file;
	public $documentObjectTree = array();
	public $keysOfFormFields   = array();
	function __construct($file) {
		$this->file = $file;
		$this->makeDocumentObjectTree();
		$this->getFormFields();
	}
	function makeDocumentObjectTree() {
		$this->pdfContent           = file($this->file);
		$this->documentObjectTree[] = array(
			$this->pdfContent[0],
			$this->pdfContent[1]
		);
		for($i=2;$i<count($this->pdfContent);$i++) {
			$str3 = trim(substr(trim($this->pdfContent[$i]),-4,4));
			if($str3=='obj') {
				$this->findCompleteObject($i);
			} else {
				$this->documentObjectTree[] = array(
					$this->pdfContent[$i]
				);
			}
		}
		#db($this->documentObjectTree);
	}
	function findCompleteObject(&$i) {
		$buffer = '';
		do {
			$buffer[] = $this->pdfContent[$i];
			$i++;
		} while(trim($this->pdfContent[$i]) !== 'endobj');
		
		$buffer[] = $this->pdfContent[$i];
		$this->documentObjectTree[] = $buffer;
		return $i;
	}
	function sendToBrowser() {
		//send header
			header('Content-Type:application/pdf');
			#header('Content-Type:text/plain');
			#header('Content-Type:applicatiom/octet-stream');
		//
			echo $this->render();
	}
	function render() {
		//replace tokens
			foreach($this->keysOfFormFields as $token) {
				switch($token['type']) {
					//textfields
					case 'Tx':
						$buffer = implode('',$this->documentObjectTree[$token['key']]);
						$value  = '';
						$tempValue = $token['value'];
						//ensure utf8:
						$tempValue = $GLOBALS['TSFE']->csConvObj->conv($tempValue,$GLOBALS['TSFE']->renderCharset,'utf-8',false);
						$byteArray = $GLOBALS['TSFE']->csConvObj->utf8_to_numberarray($tempValue);
						foreach($byteArray as $dec) {
							$value.= str_pad(dechex($dec),4,'0',STR_PAD_LEFT);
						}
						$value = strtoupper($value);
						#for($i = 0;$i<strlen($token['value']);$i++) {
							#$hex   = dechex(ord(substr($tempValue,$i,1)));
						#	$value.= str_pad($hex,4,'0',STR_PAD_LEFT);
						#}
						$buffer = substr($buffer,0,$token['start'])
						        	.'/V <FEFF'.$value.'>'
									.substr($buffer,$token['stop']);
						$this->documentObjectTree[$token['key']] = array(
							$buffer
						);
					break;
					//checkboxes
					case 'Bt':
						$buffer = implode('',$this->documentObjectTree[$token['key']]);
						if($token['value']) {
							#$buffer = str_replace('/AS /No' ,'/AS /Yes' ,$buffer);
							#$buffer = str_replace('/AS /Yes','/AS /Yes' ,$buffer);
							$buffer = str_replace('/V /Yes','/V /Yes' ,$buffer);
							$buffer = str_replace('/V /Yes','/V /Yes' ,$buffer);
						} else {
							$buffer = str_replace('/V /On' ,'/V /No',$buffer);
							$buffer = str_replace('/V /Yes','/V /No',$buffer);
						}
						$this->documentObjectTree[$token['key']] = array(
							$buffer
						);
					break;
					default:
					break;
				}
			}
		//send file
			$buffer = '';
			foreach($this->documentObjectTree as $documentObject) {
				$buffer.= implode("",$documentObject);
			}
			return $buffer;
	}
	function getFormFields() {
		foreach($this->documentObjectTree as $key => $documentObject) {
			$line0 = trim($documentObject[1]);
			if(substr($line0,0,30) == '<</Type/Annot/Subtype/Widget/F') {
				$obj  = implode("",$documentObject);
				$fieldname = $this->getFormFieldName($obj);
				$this->keysOfFormFields[$fieldname]          = array();
				$this->keysOfFormFields[$fieldname]['key']   = $key;
				$this->keysOfFormFields[$fieldname]['type']  = $this->getFormFieldType($obj);
				$this->keysOfFormFields[$fieldname]['name']  = $fieldname;
				$this->keysOfFormFields[$fieldname]['value'] = $this->getFormFieldValue($obj,$start,$stop);
				$this->keysOfFormFields[$fieldname]['start'] = $start;
				$this->keysOfFormFields[$fieldname]['stop']  = $stop+1;
			}
		}
		return $this->keysOfFormFields;
	}
	function getFormFieldType($part) {
		$startPos = strpos($part,'/FT/');
		return substr($part,$startPos+4,2);
	}
	function getFormFieldName($part) {
		$startPos = strpos($part,'/T(');
		$endPos   = strpos($part,')',$startPos+3);
		$buffer   = substr(
			$part,
			$startPos+3,
			$endPos-$startPos-3
		);
		return $buffer;
	}
	function getFormFieldValue($part,&$start,&$stop) {
		$startPos      = strpos($part,'/V(');
		$startPosHex   = strpos($part,'/V <');
		$buffer        = '';
		if($startPos !==false) {
			$endPos   = strpos($part,')',$startPos+2);
			$buffer   = substr(
				$part,
				$startPos+3,
				$endPos-$startPos-3
			);
			$start    = $startPos;
			$stop     = $endPos;
		} elseif($startPosHex !== false) {
			$endPos   = strpos($part,'>',$startPosHex+2);
			$bufferHex= substr(
				$part,
				$startPosHex+3,
				$endPos-$startPosHex-2
			);
			$start    = $startPosHex;
			$stop     = $endPos;
			//render buffer to normal chars
			for($i=5;$i<strlen($bufferHex)-1;$i = $i+4) {
				$char   = hexdec(substr($bufferHex,$i,4));
				$buffer.= chr($char);
			}
		} else {
			$buffer = 'unknown value';
			$start    = 0;
			$stop     = 0;
		}
		return $buffer;
	}
	function debug($die=false) {
		header('Content-Type: text/plain');
		print_r($this->keysOfFormFields);
		if($die) {
			die();
		}
	}
	function get($name) {
		return $this->keysOfFormFields[$fieldname]['value'];
	}
	function set($fieldname,$value) {
		if(array_key_exists($fieldname, $this->keysOfFormFields)) {
			$this->keysOfFormFields[$fieldname]['value'] = $value;
		}
	}
}
