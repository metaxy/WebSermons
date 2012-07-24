<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Steffen Müller (typo3@t3node.com)
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
 * Class "tx_websermons_ImportFiles" provides task procedures
 *
 * @author		Steffen Müller <typo3@t3node.com>
 * @package		TYPO3
 * @subpackage		tx_smscheddemo
 *
 */
class tx_websermons_ImportFiles extends tx_scheduler_Task {

	/**
	 * A page uid to be cleaned up
	 *
	 * @var	int		$pageid
	 */
	 var $pageid;

	/**
	 * Function executed from the Scheduler.
	 * Hides all content elements of a page
	 *
	 * @return	boolean	TRUE if success, otherwise FALSE
	 */
	public function execute() {
		$success = FALSE;
		/*$data = array();

		if (!empty($this->pageid)) {
			$this->pageid = intval($this->pageid);

				// Get uids of all content elements of the page
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'uid',
				'tt_content',
				'pid=' . $this->pageid . t3lib_Befunc::BEenableFields('tt_content') . t3lib_Befunc::deleteClause('tt_content')
			);

				// Hide content of page
			if (!empty($row)) {
				$tce = t3lib_div::makeInstance('t3lib_TCEmain');
				foreach ($row as $field) {
					$data['tt_content'][$field['uid']] = array(
						'hidden' => '1'
					);
				}
				$tce->start($data,array());
				$tce->process_datamap();

					// Clear cache of page
				$tce->clear_cacheCmd($this->pageid);
			}	
			$success = TRUE;
		} else {
				// No pageid defined, just log the task
			t3lib_div::devLog('[scheduler: Hide content]: Fail. No page id was given', 'websermons', 3);
		}*/
		return $success;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles.php']);
}

?> 
