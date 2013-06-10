<?php

class tx_Powermail2Document_Hooks_Powermail_Marker_MarkerArray {
	function PM_markerArrayHook(&$what,&$geoArray,&$markerArray,&$sessiondata,&$tmpl,&$parent) {
		if($what == 'thx') {
			if($parent->cObj->data['tx_powermail2document_attachments_sender_downloadable']) {
				
				$files  = unserialize($GLOBALS['TSFE']->fe_user->getKey("ses","powermail2document"));
				
				if($files===false) {
					echo 'rerender files';
					$mailer  = null;
					$subpart = 'sender_mail';
					$obj = new tx_Powermail2Document_Hooks_Powermail_Submit_SubmitEmailHook2();
					$obj->PM_SubmitEmailHook2(
						$subpart,
						$mailer,
						$parent);
					$files  = unserialize($GLOBALS['TSFE']->fe_user->getKey("ses","powermail2document"));
				}
	
				if(count($files)>0) {
					$buffer = '';
					foreach($files as $key=>$file) {
						$filename                                             = $file['filename'];
						$markerArray['###POWERMAIL2DOCUMENT-FILE'.$key.'###'] = '<a href="index.php?eID=powermail2document&filename='.htmlspecialchars($filename).'">'.$filename.'</a>';
						$buffer                                              .= '<li><a href="index.php?eID=powermail2document&filename='.htmlspecialchars($filename).'">'.$filename.'</a></li>';
					}
					$markerArray['###POWERMAIL2DOCUMENT-FILES###'] = '<ul>'.$buffer.'</ul>';
				}
			}
		}
	}
}