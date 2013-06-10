<?php

class Tx_Powermail2document_FileTypes_Pdf extends Tx_Powermail2Document_FileTypes_Abstract_File {
	function renderFile($content = '') {
		$extConfigs = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['powermail2document']);
		switch($extConfigs['pdfRenderer']) {
			case 'fillFormWithPdfTk':
				$this->renderFileWithPdfTk();
			break;
			case 'renderFileJustCopy':
				$this->renderFileJustCopy();
			break;
			case 'fillFormWithPHP':
			default:
				$this->renderFileInternalFormFiller();
			break;
		}
		return '';
	}
	private function renderFileWithPdfTk() {
		if(!extension_loaded('fdf')) {
			throw new Exception('php extension fdf is missing for this usecase');
		}
		
		$outfdf = fdf_create();
		foreach($this->markerArray as $markerName => $markerValue) {
			fdf_set_value($outfdf, $markerName, $markerValue, 0);
		}
		fdf_save($outfdf, $this->outputFile.'.fdf');
		passssthru('pdftk ' . $this->outputFile . ' fill_form ' . $this->outputFile . '.fdf output ' . $this->outputFile); 
		unlink($this->outputFile.'.fdf');
	}
	private function renderFileInternalFormFiller() {
		$pdf = new Tx_Powermail2document_FileTypes_Pdf_FormFiller($this->outputFile);
		foreach($this->markerArray as $markerName => $markerValue) {
			$pdf->set($markerName,$markerValue);
		}
		file_put_contents($this->outputFile, $pdf->render());
	}
	
	private function renderFileJustCopy(){
					
	}
	/**
	 * replace pdflib blocks ... not implemented yet
	 * 
	 * based on:	 
	 * http://www.pdflib.com/de/pdflib-cookbook/block-handling-and-pps/fill-converted-formfields/fill-converted-formfields/	 
	 */	 	
	private function renderFilePDFLib() {
		//prepare
			unlink($this->outputFile);
			copy($this->templateFile,$this->outputFile);
		//render doc
			try {
				//
					if(!class_exists('PDFLib')) {
						throw new Exception ('PDFlib not available');
					}
				// create object
					$pdf = new PDFlib();

				// copy and start template
					$pdf->begin_document($this->outputFile, "destination={type=fitwindow} pagelayout=singlepage");
					
					$pdf->set_info("Creator", "PDFlib starter sample");
				    $pdf->set_info("Title", "starter_block");

				// open existing document
										
					$indoc = $pdf->open_pdi_document($this->outputFile, "");
					$pdf->save();
				
			} catch(Exception $e) {
				echo $e->getMessage();
			}
	}
}