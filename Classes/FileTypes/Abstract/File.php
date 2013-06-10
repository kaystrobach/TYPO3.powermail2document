<?php
abstract class Tx_Powermail2document_FileTypes_Abstract_File {
	/**
	 * prefix for token
	 */	 	
	var $tokenStart  = '${';
	/**
	 * suffix for token
	 */	 	
	var $tokenEnd    = '}';
	/**
	 * special settings
	 */	 	
	protected $settings = array();
	/**
	 * init function normally empty
	 * return void	 
	 */	 	
	public function init() {
		
	}
	public function pushSettings($array) {
		$this->settings = $array;
	} 
	public function setSubPart(&$subPart) {
		$this->subPart = $subPart;
	}
	public function setMailer(&$htmlMail) {
		$this->htmlMail = $htmlMail;
	}
	public function setParent(&$parent) {
		$this->parent = $parent;
	}
	public function setTemplate($templateFile) {
		$this->templateFile       = $templateFile;
		$this->attachmentFilename = basename($templateFile);
	}
	/**
	 * perform marker setup
	 */	 	
	public function setMarkers(&$markerArray) {
		$this->markerArray = $markerArray;
		foreach($this->markerArray as $markerName=>$markerValue) {
			$this->markerArray[$markerName] = $this->prepareMarker($markerValue);
		}
	}
	/**
	 * central processing function
	 */	 	
	public function process() {
		if(!is_file($this->templateFile) || !file_exists($this->templateFile)) {
			return;
		}
		$this->getTempFileName();
			//load content
		$content = $this->renderFile(file_get_contents($this->templateFile));
		if($content !== NULL) {
			file_put_contents($this->outputFile, $content);
		}
	}
	/**
	 * changes the file - needs to be implemented for each format
	 */	 	
	public function renderFile($content = '') {
			//process
		foreach($this->markerArray as $markerName => $markerValue) {
			$content = str_replace(
				$this->tokenStart . $markerName . $this->tokenEnd,
				$markerValue,
				$content
			);
		}
			// non replaced markers bug
		if(t3lib_extMgm::isLoaded('powermail_cond')) {
				// @todo add replace algorithm for escaping
			$regex   = '/' . '\$\{' . 'UID[0-9]+' . '\}' . '/Ui';
			$content = preg_replace($regex, '', $content);
		}
			// write content
		return $content;
	}
	public function getFilenameOfModifiedFile() {
		return $this->outputFile;
	}
	/**
	 * prepare markers according to value
	 */	 	
	protected function prepareMarker($value) {
		return $value;
	}
	/**
	 * retrieves a tempfile name and creates the file
	 */	 	
	protected function getTempFileName() {
		//$extension    = strtolower(array_pop(explode('.',$file)));
		$basename         = basename($this->templateFile);
		$tempFileName     = t3lib_div::tempnam('powermail2word');
		$this->outputFile = $tempFileName.'.'.$basename;
		unlink($tempFileName);
		copy($this->templateFile,$this->outputFile);
		return $this->outputFile; 
	}
	/**
	 * deletes temporary files
	 */	 	
	public function cleanUp() {
		#echo 'should drop:'.$this->outputFile.'<br>';
		#unlink($this->outputFile);
	}
	public function getContent() {
		return file_get_contents($this->getFilenameOfModifiedFile());
	}
}