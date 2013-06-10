<?php

class tx_Powermail2Document_Hooks_Powermail_Submit_SubmitEmailHook2 {
	private $sessionFiles = array();
	/**
	 * calls functions generic based on fileextension to add dynamic content
	 * if no dynamic content can be applied, the file is simply attached ;)	 
	 *
	 * @param $subpart reference to subpart
	 * @param $htmlMail reference to Mail
	 * @param $parent reference	to powermail_submit
	 */	 	 	
	function PM_SubmitEmailHook2(&$subpart, &$htmlMail, &$parent) {
		//ensure that both UIDxx and Name vals are replaced ....
			$this->prepareMarkerArray($parent);
		//make mailer accessable
			$this->htmlMail     = $htmlMail;
		//make parent accessable
			$this->parent       = $parent;
		//make subpart accessable
			$this->subpart      = $subpart;
		//render file field and process settings
			if($subpart == 'recipient_mail') {
				$this->files        = explode(',' ,$parent->cObj->data['tx_powermail2document_attachments_recipient']);
				$this->dynamicFile  = explode("\n",$parent->cObj->data['tx_powermail2document_attachments_recipient_dynamicfilename']);
				$fileSettings       = explode("\n",$parent->cObj->data['tx_powermail2document_attachments_recipient_filesettings']);
			} elseif($subpart == 'sender_mail') {
				$this->files        = explode(',' ,$parent->cObj->data['tx_powermail2document_attachments_sender']);
				$this->dynamicFile  = explode("\n",$parent->cObj->data['tx_powermail2document_attachments_sender_dynamicfilename']);
				$fileSettings       = explode("\n",$parent->cObj->data['tx_powermail2document_attachments_sender_filesettings']);
			} else {
				return;
			}
			$this->fileSettings     = array();
			foreach($fileSettings as $fileSettings) {
				$this->fileSettings[] = explode('|',$fileSettings);
			}
		//process attachments
			$this->attachAndModifyFiles();
			if($subpart == 'sender_mail') {
				$this->addFilesToSession();
			}
	}
	private function attachAndModifyFiles() {
		//iterate files
			foreach($this->files as $key=>$file) {
				//split filename
					$extension    = strtolower(array_pop(explode('.',$file)));
					$functionName = 'make'.ucfirst(strtolower($extension)).'File';
					$className    = 'Tx_Powermail2document_FileTypes_'.ucfirst($extension);
				//make class based on filetype
					if(class_exists($className) && method_exists($className, 'process')) {
						$helper   = t3lib_div::makeInstance($className);
					} else {
						$helper   = t3lib_div::makeInstance('Tx_Powermail2document_FileTypes_UnknownFileEnding');
					}
				//modify file
					$helper->init         ();
					$helper->setSubPart   ($this->subpart);
					$helper->setParent    ($this->parent);
					$helper->setTemplate  ('uploads/tx_powermail2document/'.$file);
					$helper->setMarkers   ($this->markerArray);
					$helper->pushSettings ($this->getSettingsForFile($file));
					
					$helper->process      ();
				//check wether there is a dynamic filename supplied
					if(array_key_exists($key, $this->dynamicFile)) {
						$filename = $this->getAttachmentFilename(
								$helper->getFilenameOfModifiedFile(),
								$this->dynamicFile[$key]
							);
		            } else {
						$filename = $this->getAttachmentFilename(
								$helper->getFilenameOfModifiedFile(),
								''
							); 
					}
					$this->attachFile(
							$helper->getFilenameOfModifiedFile(),
							$filename
						);
				//drop temp file
					$helper->cleanup();
					unset($helper);
			}	
	}
	private function getSettingsForFile($filename) {
		$buffer = array();
		foreach($this->fileSettings as $setting) {
			if($setting[0] == $filename) {
				$buffer[] = $setting;
			}
		}
		return $buffer;
	}
	private function addFilesToSession() {
		if($this->parent->cObj->data['tx_powermail2document_attachments_sender_downloadable']) {
			$GLOBALS['TSFE']->fe_user->setAndSaveSessionData(
				"powermail2document",
				serialize($this->sessionFiles)
			);
		} else {
			$GLOBALS['TSFE']->fe_user->setAndSaveSessionData(
				"powermail2document",
				serialize(array())
			);
		}
	}
	/**
	 * Add specified file in $path to the mail as $name	
	 *
	 * $path string path to the file
	 * $name string alias of the file in the mail	 	 	 
	 */	 	
	private function attachFile($path,$name) {
		//add file to mail
			if(is_a($this->htmlMail,'t3lib_mail_Message')) {
				//new way of adding a attachment
				$attachment = Swift_Attachment::newInstance();
				//use it with markers ;)
				$attachment->setFilename($name);
				$attachment->setBody(file_get_contents($path));
				$this->htmlMail->attach($attachment);
			} elseif(is_a($this->htmlMail,'t3lib_htmlmail')) {
				//old mail api as fallback
				#$this->htmlMail->addAttachment($this->outputFile);
				$this->htmlMail->theParts['attach'][] = array(
					'content'       => file_get_contents($path),
					'content_type'  => 'application/octet-stream',
					'filename'      => $name,
				);
			} elseif($this->htmlMail === null) {
				//do nothing if no mailobject is attached
			} else {
				throw new Exception('Unknown mail object type');
			}
		
		//add file to session if allowed
			if($this->parent->cObj->data['tx_powermail2document_attachments_sender_downloadable']) {
				$this->sessionFiles[$name]=array(
					'filename'  => $name,
					'content'   => file_get_contents($path),
				);
			}
	}
	private function prepareMarkerArray($parent) {
		$markers = array();
		foreach($parent->markerArray as $markerName => $markerValue) {
			//manipulate values
				$markerName  = substr($markerName,3,-3);
				$markerValue = strip_tags($markerValue);
				$markerValue = str_replace("\r\n",' ',$markerValue);
				$markerValue = str_replace("\n",' ',$markerValue);
			
			//use of plain ids
				$markers[$markerName] =$markerValue;
				
			//use of fieldlabels
				if(substr($markerName,0,3) == 'UID' ) {
					$markers[$parent->markerArray['###LABEL_'.$markerName.'###']] = $markerValue;
				}
		}
		$this->markerArray = $markers;
	}
	private function getAttachmentFilename($filename,$filenameWithMarkers='') {
		$filenameWithMarkers = trim($filenameWithMarkers);
		if(strlen($filenameWithMarkers)!=0) {
			foreach($this->markerArray as $markerName=>$markerValue) {
				$filenameWithMarkers = str_replace(
					'###'.$markerName.'###',
					strip_tags($markerValue),
					$filenameWithMarkers
				);
			}
			return $filenameWithMarkers;
		} else {
			return basename($filename);
		}
	}
}