<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Steffen Müller <typo3@t3node.com>
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
 * Aditional fields provider class for usage with the 'Hide content' task
 *
 * @author		Francois Suter <francois@typo3.org>
 * @author		Steffen Müller <typo3@t3node.com>
 * @package		TYPO3
 * @subpackage		tx_websermons
 *
 */
class tx_websermons_ImportFiles_AdditionalFieldProvider implements tx_scheduler_AdditionalFieldProvider {

	/**
	 * Field generation.
	 * This method is used to define new fields for adding or editing a task
	 * In this case, it adds a page ID field
	 *
	 * @param	array			$taskInfo: reference to the array containing the info used in the add/edit form
	 * @param	object			$task: when editing, reference to the current task object. Null when adding.
	 * @param	tx_scheduler_Module	$parentObject: reference to the calling object (Scheduler's BE module)
	 * @return	array			Array containg all the information pertaining to the additional fields
	 *					The array is multidimensional, keyed to the task class name and each field's id
	 *					For each field it provides an associative sub-array with the following:
	 *						['code']		=> The HTML code for the field
	 *						['label']		=> The label of the field (possibly localized)
	 *						['cshKey']		=> The CSH key for the field
	 *						['cshLabel']		=> The code of the CSH label
	 */
	public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $parentObject) {

			// Initialize extra field value
		if (empty($taskInfo['pageid'])) {
			if ($parentObject->CMD == 'add') {
				$taskInfo['pageid'] = 'Enter id';
			} elseif ($parentObject->CMD == 'edit') {
				$taskInfo['pageid'] = $task->pageid;
			} else {
				$taskInfo['pageid'] = '';
			}
		}
        if (empty($taskInfo['monitoredpath'])) {
            if ($parentObject->CMD == 'add') {
                $taskInfo['monitoredpath'] = 'Enter path';
            } elseif ($parentObject->CMD == 'edit') {
                $taskInfo['monitoredpath'] = $task->monitoredPath;
            } else {
                $taskInfo['monitoredpath'] = '';
            }
        }
        if (empty($taskInfo['parentfolder'])) {
            if ($parentObject->CMD == 'add') {
                $taskInfo['parentfolder'] = 'Enter id';
            } elseif ($parentObject->CMD == 'edit') {
                $taskInfo['parentfolder'] = $task->parentFolder;
            } else {
                $taskInfo['parentfolder'] = '';
            }
        }
			// Generate the additional field
		$fieldID = 'task_pageid';
		$fieldCode_pageid = '<input type="text" name="tx_scheduler[pageid]" id="task_pageid" value="' . $taskInfo['pageid'] . '" size="8" />';
        $fieldCode_monitoredpath = '<input type="text" name="tx_scheduler[pageid]" id="task_monitoredpath" value="' . $taskInfo['monitoredpath'] . '" size="25" />';
		$fieldCode_parentfolder = '<input type="text" name="tx_scheduler[pageid]" id="task_parentfolder" value="' . $taskInfo['parentfolder'] . '" size="8" />';

		$additionalFields = array();
		
		$additionalFields['task_pageid'] = array(
			'code'     => $fieldCode_pageid,
			'label'    => 'LLL:EXT:websermons/locallang.xml:scheduler.importFiles.label.pageid',
			'cshKey'   => 'xMOD_tx_websermons',
			'cshLabel' => 'task_pageid'
		);
		
		$additionalFields['task_monitoredpath'] = array(
            'code'     => $fieldCode_monitoredpath,
            'label'    => 'LLL:EXT:websermons/locallang.xml:scheduler.importFiles.label.monitoredpath',
            'cshKey'   => 'xMOD_tx_websermons',
            'cshLabel' => 'task_monitoredpath'
        );
        
        $additionalFields['task_parentfolder'] = array(
            'code'     => $fieldCode_parentfolder,
            'label'    => 'LLL:EXT:websermons/locallang.xml:scheduler.importFiles.label.parentfolder',
            'cshKey'   => 'xMOD_tx_websermons',
            'cshLabel' => 'task_parentfolder'
        );

		return $additionalFields;
	}

	/**
	 * Field validation.
	 * This method checks if page id given in the 'Hide content' specific task is int+
	 * If the task class is not relevant, the method is expected to return true
	 *
	 * @param	array			$submittedData: reference to the array containing the data submitted by the user
	 * @param	tx_scheduler_Module	$parentObject: reference to the calling object (Scheduler's BE module)
	 * @return	boolean			True if validation was ok (or selected class is not relevant), false otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $parentObject) {
		$pageid = t3lib_div::intval_positive($submittedData['pageid']);

			// If value is not valid, report error with a flash message.
		if ($pageid < 1) {

			$parentObject->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:websermons/locallang.xml:scheduler.importFiles.flashmessage.invalid_pid'),
				t3lib_FlashMessage::ERROR
			);
			$result = FALSE;
		} else {
			$result = TRUE;
		}

		return $result;
	}

	/**
	 * Store field.
	 * This method is used to save any additional input into the current task object
	 * if the task class matches
	 *
	 * @param	array			$submittedData: array containing the data submitted by the user
	 * @param	tx_scheduler_Task	$task: reference to the current task object
	 * @return	void
	 */
	public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
		$task->pageid = $submittedData['pageid'];
		$task->monitoredPath = $submittedData['monitoredpath'];
		$task->parentFolder = $submittedData['parentfolder'];
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles_additionalfieldprovider.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles_additionalfieldprovider.php']);
}

?>
 
