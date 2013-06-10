<?php
class Tx_Powermail2document_FileTypes_Html extends Tx_Powermail2Document_FileTypes_Abstract_File {
	protected function prepareMarker($value) {
		return nl2br($value);
	}
}