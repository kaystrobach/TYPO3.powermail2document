<?php
class Tx_Powermail2document_FileTypes_Rtf extends Tx_Powermail2Document_FileTypes_Abstract_File {
	/**
	 * prefix for token
	 */
	var $tokenStart  = '###';
	/**
	 * suffix for token
	 */
	var $tokenEnd    = '###';
	function renderFile($content = '') {
			//process
		foreach($this->markerArray as $markerName => $markerValue) {
			$content = str_replace($this->tokenStart . utf8_decode($markerName) . $this->tokenEnd, utf8_decode($markerValue), $content);
		}
			//write content
		return $content;
	}
}