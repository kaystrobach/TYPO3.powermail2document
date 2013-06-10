<?php
// script outputs files which are sent to the sender
//attachments are stored via
// $GLOBALS['TSFE']->fe_user->setAndSaveSessionData("powermail2document",$value)

tslib_eidtools::connectDB();               //Connect to database
$feUserObj    = tslib_eidtools::initFeUser(); // Initialize FE user object         
$files        = unserialize($feUserObj->getKey("ses","powermail2document"));
$filename     = t3lib_div::_GP('filename');

if(count($files)>0) {
	if(array_key_exists($filename,$files)) {
		header('Content-Type: application/octet-stream');
	    header("Content-Disposition: attachment; filename=\"".$filename."\";" );
		header("Content-Length: ".strlen($files[$filename]['content']));
 		echo $files[$filename]['content'];
	}
}
echo 'There was a problem loading the file';