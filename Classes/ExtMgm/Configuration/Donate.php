<?php

class Tx_powermail2document_ExtMgm_Configuration_Donate {
	function render(&$params) {
		return '
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="Z8M5F7MA76PGC">
				<input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
				<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
		';
	} 
}