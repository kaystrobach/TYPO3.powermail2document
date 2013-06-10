<?php

class Tx_Powermail2Document_Util_List {
	public static function removeFromList($base,$itemsToRemove) {
		$baseList   = $base;
		$removeList = explode(',',$itemsToRemove);
		foreach($removeList as $item) {
			$baseList = t3lib_div::rmFromList($item,$baseList);
		} 
		return $baseList;
	}
}