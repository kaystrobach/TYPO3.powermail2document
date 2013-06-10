<?php

$tempColumnsExtensionListAllowed    = 'fluid,zip,rtf,odt,odc,odg,ods,doc,docx,pdf,xls,xlsx,ppt,pptx,'.
                                      $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'].
                                      ','.
                                      $GLOBALS['TYPO3_CONF_VARS']['SYS']['textfile_ext'];

$tempColumnsExtensionListDisallowed = 'php,php3,php4,php5,php6,phpsh,inc,phtml';

require_once(t3lib_extMgm::extPath('powermail2document').'Classes/Util/List.php');
$tempColumnsExtensionListAllowed    = Tx_Powermail2Document_Util_List::removeFromList(
	$tempColumnsExtensionListAllowed,
	$tempColumnsExtensionListDisallowed
);


$tempColumns = Array (
	'tx_powermail2document_attachments_recipient' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_recipient',
		'config' => Array (
			'type'          => 'group',
			'internal_type' => 'file',
			'allowed'       => $tempColumnsExtensionListAllowed,
			//'disallowed'    => $tempColumnsExtensionListDisallowed,
			'max_size'      => '5000',
			'uploadfolder'  => 'uploads/tx_powermail2document',
			'size'          => '1',
			'maxitems'      => '200',
			'minitems'      => '0',
			'autoSizeMax'   => 40,
			#'show_thumbs'   => 1,
		)
	),
	'tx_powermail2document_attachments_recipient_dynamicfilename' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_recipient_dynamicfilename',
		'config' => Array (
			'type'          => 'text',
			'wrap'          => 'off'
		),	
	),
	'tx_powermail2document_attachments_recipient_filesettings' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_recipient_zipmanipulation',
		'config' => Array (
			'type'          => 'text',
			'wrap'          => 'off',
			'cols'          => 240,
		),	
	),
	'tx_powermail2document_attachments_sender' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_sender',
		'config' => Array (
			'type'          => 'group',
			'internal_type' => 'file',
			'allowed'       => $tempColumnsExtensionListAllowed,
			//'disallowed'    => $tempColumnsExtensionListDisallowed,
			'max_size'      => '5000',
			'uploadfolder'  => 'uploads/tx_powermail2document',
			'size'          => '1',
			'maxitems'      => '200',
			'minitems'      => '0',
			'autoSizeMax'   => 40,
			#'show_thumbs'   => 1,
		),
	),
	'tx_powermail2document_attachments_sender_dynamicfilename' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_sender_dynamicfilename',
		'config' => Array (
			'type'          => 'text',
			'wrap'          => 'off'
		),	
	),
	'tx_powermail2document_attachments_sender_filesettings' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_sender_zipmanipulation',
		'config' => Array (
			'type'          => 'text',
			'wrap'          => 'off',
			'cols'          => 240,
		),	
	),
	'tx_powermail2document_attachments_sender_downloadable' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_attachments_sender_downloadable',
		'config' => Array (
			'type'          => 'check',
		),	
	),
);

$TCA['tt_content']['palettes']['powermail2document_recipient'] = array(
	'showitem' => 'tx_powermail2document_attachments_recipient,
				   tx_powermail2document_attachments_recipient_dynamicfilename,
				   --linebreak--,
				   tx_powermail2document_attachments_recipient_filesettings',
	'canNotCollapse' => 1,
);
$TCA['tt_content']['palettes']['powermail2document_sender'] = array(
	'showitem' => 'tx_powermail2document_attachments_sender,
	               tx_powermail2document_attachments_sender_dynamicfilename,
	               --linebreak--,
				   tx_powermail2document_attachments_sender_filesettings,
				   --linebreak--,
				   tx_powermail2document_attachments_sender_downloadable',
	'canNotCollapse' => 1,
);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('tt_content', '--palette--;LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_palette;powermail2document_recipient','powermail_pi1','after:tx_powermail_mailreceiver');
t3lib_extMgm::addToAllTCAtypes('tt_content', '--palette--;LLL:EXT:powermail2document/Resources/Private/Language/locallang_db.xml:tx_powermail2document_palette;powermail2document_sender'   ,'powermail_pi1','after:tx_powermail_mailsender');


t3lib_extMgm::addLLrefForTCAdescr(
   'tt_content',
   'EXT:powermail2document/Resources/Private/Language/locallang_csh.xml'
);
