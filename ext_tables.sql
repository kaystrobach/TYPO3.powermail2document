#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_powermail2document_attachments_recipient                 text,
	tx_powermail2document_attachments_recipient_dynamicfilename text,
	tx_powermail2document_attachments_recipient_filesettings    text,
	tx_powermail2document_attachments_sender                    text,
	tx_powermail2document_attachments_sender_dynamicfilename    text,
	tx_powermail2document_attachments_sender_filesettings       text,
	tx_powermail2document_attachments_sender_downloadable       tinyint(4) unsigned DEFAULT '0' NOT NULL,
);
