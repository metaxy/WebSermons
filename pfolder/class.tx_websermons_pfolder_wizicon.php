<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012  <>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/



/**
 * Class that adds the wizard icon.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_websermons
 */
class tx_websermons_pfolder_wizicon {

	/**
	 * Processing the wizard items array
	 *
	 * @param array $wizardItems The wizard items
	 * @return array Modified array with wizard items
	 */
	public function proc(array $wizardItems) {
		$LL = $this->includeLocalLang();

		$wizardItems['plugins_tx_websermons_pfolder'] = array(
			'icon' => t3lib_extMgm::extRelPath('websermons') . 'pfolder/ce_wiz.gif',
			'title' => $GLOBALS['LANG']->getLLL('pfolder_title', $LL),
			'description' => $GLOBALS['LANG']->getLLL('pfolder_plus_wiz_description', $LL),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=websermons_pfolder'
		);

		return $wizardItems;
	}

	/**
	 * Reads the [extDir]/locallang.xml and returns the $LOCAL_LANG array found in that file.
	 *
	 * @return array The array with language labels
	 */
	protected function includeLocalLang() {
		$llFile = t3lib_extMgm::extPath('websermons') . 'locallang.xml';
		$version = class_exists('t3lib_utility_VersionNumber')
				? t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version)
				: t3lib_div::int_from_ver(TYPO3_version);
		if ($version < 4006000) {
			$LOCAL_LANG = t3lib_div::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);
		} else {
			/** @var $llxmlParser t3lib_l10n_parser_Llxml */
			$llxmlParser = t3lib_div::makeInstance('t3lib_l10n_parser_Llxml');
			$LOCAL_LANG = $llxmlParser->getParsedData($llFile, $GLOBALS['LANG']->lang);
		}

		return $LOCAL_LANG;
	}
}



if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/websermons/pfolder/class.tx_websermons_pfolder_wizicon.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/websermons/pfolder/class.tx_websermons_pfolder_wizicon.php']);
}

?>