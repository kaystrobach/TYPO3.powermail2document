<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "powermail2document".
 *
 * Auto generated 11-03-2013 20:24
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'powermail2document',
	'description' => 'Dynamically attach and modify documents to mail which is send either to the sender or the recipient. Filename can be change dynamically also a variety of fileformats is supported. E.g.: Csv, Docx, Fluid, Htm, Html, Odg, Ods, Odt, Pdf, Pptx, Rtf, Txt, Xlsx, Xml',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.6.1',
	'dependencies' => 'powermail',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_powermail2document/',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Kay Strobach',
	'author_email' => 'kay.strobach@typo3.org',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => 
	array (
		'depends' => 
		array (
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.5.0-4.7.0',
			'powermail' => '1.6.2-1.6.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'_md5_values_when_last_written' => 'a:36:{s:16:"ext_autoload.php";s:4:"c255";s:21:"ext_conf_template.txt";s:4:"dfeb";s:12:"ext_icon.gif";s:4:"6759";s:17:"ext_localconf.php";s:4:"7e80";s:14:"ext_tables.php";s:4:"213c";s:14:"ext_tables.sql";s:4:"0b88";s:39:"Classes/ExtMgm/Configuration/Donate.php";s:4:"d144";s:25:"Classes/FileTypes/Csv.php";s:4:"067f";s:26:"Classes/FileTypes/Docx.php";s:4:"f9f7";s:27:"Classes/FileTypes/Fluid.php";s:4:"0711";s:25:"Classes/FileTypes/Htm.php";s:4:"08fc";s:26:"Classes/FileTypes/Html.php";s:4:"73bd";s:25:"Classes/FileTypes/Odg.php";s:4:"4f0c";s:25:"Classes/FileTypes/Ods.php";s:4:"669a";s:25:"Classes/FileTypes/Odt.php";s:4:"c90a";s:25:"Classes/FileTypes/Pdf.php";s:4:"f679";s:26:"Classes/FileTypes/Pptx.php";s:4:"508b";s:25:"Classes/FileTypes/Rtf.php";s:4:"ef6a";s:25:"Classes/FileTypes/Txt.php";s:4:"beb0";s:39:"Classes/FileTypes/UnknownFileEnding.php";s:4:"f963";s:26:"Classes/FileTypes/Xlsx.php";s:4:"281d";s:25:"Classes/FileTypes/Xml.php";s:4:"2bc9";s:29:"Classes/FileTypes/content.xml";s:4:"4b5f";s:35:"Classes/FileTypes/Abstract/File.php";s:4:"ab56";s:41:"Classes/FileTypes/Abstract/ZipWithXml.php";s:4:"9103";s:36:"Classes/FileTypes/Pdf/FormFiller.php";s:4:"a2f5";s:47:"Classes/Hooks/Powermail/Markers/MarkerArray.php";s:4:"68bd";s:51:"Classes/Hooks/Powermail/Submit/SubmitEmailHook2.php";s:4:"a35c";s:21:"Classes/Util/List.php";s:4:"64b3";s:73:"Resources/Private/CshImages/default.tx_powermail2document_attachments.png";s:4:"920c";s:39:"Resources/Private/Language/Language.zip";s:4:"b879";s:40:"Resources/Private/Language/locallang.xml";s:4:"0ba7";s:44:"Resources/Private/Language/locallang_csh.xml";s:4:"64f9";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"94fd";s:29:"Resources/Private/PHP/eID.php";s:4:"2baf";s:14:"doc/manual.sxw";s:4:"83d9";}',
	'suggests' => 
	array (
	),
);

?>
