<?php
class Tx_Powermail2document_FileTypes_UnknownFileEnding extends Tx_Powermail2Document_FileTypes_Abstract_File {
	/**
	 * modified function to prevent file from beeing changed !!! - as the format is unknown
	 */	 	
	public function renderFile() {
		return NULL;
	}
}