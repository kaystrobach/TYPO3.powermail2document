<?php
class Tx_Powermail2document_FileTypes_Xml extends Tx_Powermail2Document_FileTypes_Abstract_File {
	/**
	 * remove bad chars - better would be a whitelist - the encoding to utf8
	 * with htmlentities doesn't work well :(	 
	 */	 	
	protected function prepareMarker($value) {
		$value = str_replace('<','',$value);
		$value = str_replace('>','',$value);
		$value     = $GLOBALS['TSFE']->csConvObj->conv($value,$GLOBALS['TSFE']->renderCharset,'utf-8',false);
		return $value;
	}
}