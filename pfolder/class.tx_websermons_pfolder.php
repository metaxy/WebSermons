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

// require_once(PATH_tslib . 'class.tslib_pibase.php');

/**
 * Plugin 'Folder' for the 'websermons' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_websermons
 */
class tx_websermons_pfolder extends tslib_pibase {
	public $prefixId      = 'tx_websermons_pfolder';		// Same as class name
	public $scriptRelPath = 'pfolder/class.tx_websermons_pfolder.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'websermons';	// The extension key.
	public $pi_checkCHash = TRUE;
	
	/**
	 * Main method of your Plugin.
	 *
	 * @param string $content The content of the Plugin
	 * @param array $conf The Plugin Configuration
	 * @return string The content that should be displayed on the website
	 */
	public function main($content, array $conf) {
		switch ((string)$conf['CMD']) {
			case 'singleView':
				list($t) = explode(':', $this->cObj->currentRecord);
				$this->internal['currentTable'] = $t;
				$this->internal['currentRow'] = $this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content, $conf));
				break;
			default:
				if (strstr($this->cObj->currentRecord, 'tt_content')) {
					$conf['pidList'] = $this->cObj->data['pages'];
					$conf['recursive'] = $this->cObj->data['recursive'];
				}
				return $this->pi_wrapInBaseClass($this->listView($content, $conf));
				break;
		}
	}
	
	/**
	 * Shows a list of database entries.
	 *
	 * @param string $content content of the Plugin
	 * @param array $conf Plugin Configuration
	 * @return string HTML list of table entries
	 */
	protected function listView($content, array $conf) {
		$this->conf = $conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		// Loading the LOCAL_LANG values
		
		$lConf = $this->conf['listView.'];	// Local settings for the listView function
	
		if (is_numeric($this->piVars['showUid'])) {	// If a single element should be displayed:
			$this->internal['currentTable'] = 'tx_websermons_folder';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_websermons_folder', $this->piVars['showUid']);
	
			$content = $this->singleView($content, $conf);
			return $content;
		} else {
			$items = array(
				'1' => $this->pi_getLL('list_mode_1', 'Mode 1'),
				'2' => $this->pi_getLL('list_mode_2', 'Mode 2'),
				'3' => $this->pi_getLL('list_mode_3', 'Mode 3'),
			);
			if (!isset($this->piVars['pointer'])) $this->piVars['pointer'] = 0;
			if (!isset($this->piVars['mode'])) $this->piVars['mode'] = 1;
	
				// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':', $this->piVars['sort']);
			$version = class_exists('t3lib_utility_VersionNumber')
					? t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version)
					: t3lib_div::int_from_ver(TYPO3_version);
			if ($version < 4006000) {
				$this->internal['results_at_a_time'] = t3lib_div::intInRange($lConf['results_at_a_time'], 0, 1000, 3);		// Number of results to show in a listing.
				$this->internal['maxPages'] = t3lib_div::intInRange($lConf['maxPages'], 0, 1000, 2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			} else {
				$this->internal['results_at_a_time'] = t3lib_utility_Math::forceIntegerInRange($lConf['results_at_a_time'], 0, 1000, 3);		// Number of results to show in a listing.
				$this->internal['maxPages'] = t3lib_utility_Math::forceIntegerInRange($lConf['maxPages'], 0, 1000, 2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			}
			$this->internal['searchFieldList'] = 'title,path';
			$this->internal['orderByList'] = 'uid,title,path';
	
				// Get number of records:
			$res = $this->pi_exec_query('tx_websermons_folder', 1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
	
				// Make listing query, pass query to SQL database:
			$res = $this->pi_exec_query('tx_websermons_folder');
			$this->internal['currentTable'] = 'tx_websermons_folder';
	
				// Put the whole list together:
			$fullTable = '';	// Clear var;
			// $fullTable .= t3lib_div::view_array($this->piVars);	// DEBUG: Output the content of $this->piVars for debug purposes. REMEMBER to comment out the IP-lock in the debug() function in t3lib/config_default.php if nothing happens when you un-comment this line!
	
				// Adds the mode selector.
			$fullTable .= $this->pi_list_modeSelector($items);
	
				// Adds the whole list table
			$fullTable .= $this->makeList($res);
	
				// Adds the search box:
			$fullTable .= $this->pi_list_searchBox();
	
				// Adds the result browser:
			$fullTable .= $this->pi_list_browseresults();
	
				// Returns the content from the plugin.
			return $fullTable;
		}
	}
	/**
	 * Creates a list from a database query.
	 *
	 * @param resource $res A database result resource
	 * @return string A HTML list if result items
	 */
	protected function makeList($res) {
		$items = array();
			// Make list table rows
		while (($this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) !== FALSE) {
			$items[] = $this->makeListItem();
		}
	
		$out = '<div' . $this->pi_classParam('listrow') . '>
			' . implode(chr(10), $items) . '
			</div>';
		return $out;
	}
	
	/**
	 * Implodes a single row from a database to a single line.
	 *
	 * @return string Imploded column values
	 */
	protected function makeListItem() {
		$out = '
				<p' . $this->pi_classParam('listrowField-title') . '>' . $this->getFieldContent('title') . '</p>
				<p' . $this->pi_classParam('listrowField-path') . '>' . $this->getFieldContent('path') . '</p>
				<p' . $this->pi_classParam('listrowField-parentfolder') . '>' . $this->getFieldContent('parentfolder') . '</p>
			';
		return $out;
	}
	/**
	 * Display a single item from the database
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string HTML of a single database entry
	 */
	protected function singleView($content, array $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
	
			// This sets the title of the page for use in indexed search results:
		if ($this->internal['currentRow']['title'])	{
			$GLOBALS['TSFE']->indexedDocTitle = $this->internal['currentRow']['title'];
		}
	
		$content = '<div' . $this->pi_classParam('singleView') . '>
			<h2>Record "' . $this->internal['currentRow']['uid'] . '" from table "' . $this->internal['currentTable'] . '":</h2>
				<p' . $this->pi_classParam("singleViewField-title") . '><strong>' . $this->getFieldHeader('title') . ':</strong> ' . $this->getFieldContent('title') . '</p>
				<p' . $this->pi_classParam("singleViewField-path") . '><strong>' . $this->getFieldHeader('path') . ':</strong> ' . $this->getFieldContent('path') . '</p>
				<p' . $this->pi_classParam("singleViewField-parentfolder") . '><strong>' . $this->getFieldHeader('parentfolder') . ':</strong> ' . $this->getFieldContent('parentfolder') . '</p>
		<p>' . $this->pi_list_linkSingle($this->pi_getLL('back', 'Back'), 0) . '</p></div>' .
		$this->pi_getEditPanel();
	
		return $content;
	}
	/**
	 * Returns the content of a given field
	 *
	 * @param string $fN Name of table field
	 * @return string Value of the field
	 */
	protected function getFieldContent($fN) {
		switch($fN) {
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN], $this->internal['currentRow']['uid'], 1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
				break;
			case "title":
					// This will wrap the title in a link.
				return $this->pi_list_linkSingle($this->internal['currentRow']['title'], $this->internal['currentRow']['uid'], 1);
				break;
			default:
				return $this->internal['currentRow'][$fN];
				break;
		}
	}
	/**
	 * Returns the label for a field name from local language array.
	 *
	 * @param string $fN Name of table field
	 * @return string
	 */
	protected function getFieldHeader($fN) {
		switch ($fN) {
			case "title":
				return $this->pi_getLL('listFieldHeader_title', '<em>title</em>');
				break;
			default:
				return $this->pi_getLL('listFieldHeader_' . $fN, '[' . $fN . ']');
				break;
		}
	}
	
	/**
	 * Returns a sorting link for a column header.
	 *
	 * @param string $fN Name of table field
	 * @return string The field label wrapped in link that contains sorting vars
	 */
	protected function getFieldHeader_sortLink($fN) {
		return $this->pi_linkTP_keepPIvars(
			$this->getFieldHeader($fN),
			array(
				'sort' => $fN . ' : ' . ($this->internal['descFlag'] ? 0 : 1),
			)
		);
	}
}



if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/websermons/pfolder/class.tx_websermons_pfolder.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/websermons/pfolder/class.tx_websermons_pfolder.php']);
}

?>