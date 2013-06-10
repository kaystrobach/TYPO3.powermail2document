<?php
class Tx_Powermail2document_FileTypes_Abstract_ZipWithXml extends Tx_Powermail2Document_FileTypes_Xml {
	var $xmlLocation = null;

	function process() {
		if(!is_file($this->templateFile) || !file_exists($this->templateFile)) {
			return;
		}
			//init
		if($this->xmlLocation === null) {
			throw new Exception('you need to specify the location inside the zip file class.');
		}
		$this->objZip = new ZipArchive();
		$this->objZip->open($this->outputFile);

			//replace markers
		foreach($this->xmlLocation as $xmlContentFile) {
			$content = $this->objZip->getFromName($xmlContentFile);
			if($content!==false) {
				$content = $this->renderFile($content);
				$this->objZip->addFromString($xmlContentFile, $content);
			}
		}
			//add files
		$path = $this->parent->div->correctPath($this->parent->conf['upload.']['folder']);
		foreach($this->settings as $setting) {
			$tFilename = $path.$this->parent->sessionfields[strtolower($setting[1])];
			if(is_file(t3lib_div::getFileAbsFileName($tFilename))) {
				$this->objZip->addFile($tFilename,$setting[2]);
			}
		}
			//close
		if($this->objZip->close() === false) {
			throw new Exception('Problem saving zip file');
		}
	}
}