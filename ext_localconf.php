<?php

/**
 * react on sending mails
 */ 
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['powermail']['PM_SubmitEmailHook2'][] = 
	'EXT:powermail2document/Classes/Hooks/Powermail/Submit/SubmitEmailHook2.php:tx_Powermail2Document_Hooks_Powermail_Submit_SubmitEmailHook2';
/**
 * react on marker creation
 */
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['powermail']['PM_MarkerArrayHook'][] = 
	'EXT:powermail2document/Classes/Hooks/Powermail/Markers/MarkerArray.php:tx_Powermail2Document_Hooks_Powermail_Marker_MarkerArray';
/**
 * eid script 
 */
	$TYPO3_CONF_VARS['FE']['eID_include']['powermail2document'] =
	'EXT:powermail2document/Resources/Private/PHP/eID.php';

?>