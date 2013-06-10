<?php
class Tx_Powermail2document_FileTypes_Fluid extends Tx_Powermail2Document_FileTypes_Abstract_File {
	/**
	 * render fluid standalone view
	 * based on	 	
	 * http://forge.typo3.org/projects/typo3v4-mvc/wiki/How_to_userender_a_fluid_template_in_a_ServiceeIdCLI_Script3
	 */	 	
	function renderFile($content = '') {
		if(version_compare(TYPO3_version,'4.5.0','<')) {
			return 'Fluid support needs atleast TYPO3 4.5 LTS ;)';
		} else {
			//init
				$view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');
				$view->setTemplatePathAndFilename($this->outputFile);
			//asign
				$view->assign('markers', $this->markerArray);
			//render and save
				$template = $view->render();
				file_put_contents($this->outputFile, $template);

		}
	}
}