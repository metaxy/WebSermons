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
 
if (t3lib_extMgm::isLoaded('t3getid3')) require_once(t3lib_extMgm::extPath('t3getid3').'getid3/getid3.php');
else die('GetID3() Library not loaded!');

class tx_websermons_ImportFiles extends tx_scheduler_Task {

	/**
	 * A page uid to be cleaned up
	 *
	 * @var	int		$pageid
	 */
    var $pageid;
    var $monitoredPath;
	/**
	 * Function executed from the Scheduler.
	 * Hides all content elements of a page
	 *
	 * @return	boolean	TRUE if success, otherwise FALSE
	 */
	public function execute() {
        $success = true;
        $monitoredPath = "/srv/www/htdocs/t4/fileadmin/predigten/";
        $getID3 = t3lib_div::makeInstance('getID3');
        $notUsed = $this->getNotUsedFiles($monitoredPath);
        $i = 0;
        foreach($notUsed as $mp3file) {
            $i++;
            if($i > 2)
                break;
            $id3Info = $getID3->analyze($mp3file);
            if (isset($id3Info->info['error'])) {
                $GLOBALS['BE_USER']->simplelog("could not get id3 from $mp3file", "websermons", 1);
                $success = false;
            } else {
                $dataArr = array();
                $fieldList = "path,title,speaker,topic,links,parentfolder,pdate";
                $dataArr["path"] = $mp3file;
                
                $dataArr["title"] = "Predigt";
                $dataArr["speaker"] = $id3Info['tags']['id3v2']['artist'][0];
                $dataArr["topic"] = $id3Info['tags']['id3v2']['title'][0];
                $dataArr["links"] = $id3Info['tags']['id3v2']['comments'][0];
                $dataArr["pdate"] = strtotime($id3Info['tags']['id3v2']['date'][0]);
                $dataArr["parentfolder"] = 4;

                tslib_cObj::DBgetInsert("tx_websermons_files", 74, $dataArr, $fieldList, true);
                $GLOBALS['BE_USER']->simplelog(print_r($id3Info, true), "websermons", 1);
                $GLOBALS['BE_USER']->simplelog("speaker = " . print_r($id3Info['tags']['id3v2']['artist'], true), "websermons", 1);

            }
            //$GLOBALS['BE_USER']->simplelog("$mp3file pharsed", "websermons");
        }
        return $success;
    }
    private function getNotUsedFiles($dir)
    {
        $fileList = array();
        if ($handle = opendir($dir)) {
            $cache = "";
            $folderList = array();

            while (false !== ($file = @readdir ($handle))) {
                if ($file != "." && $file != ".." && $file != "index.php" && $file != "index.html") {
                    if(!is_dir('../'.$dir.'/'.$file)) {
                        //todo: sql injection?
                        $path = $GLOBALS['TYPO3_DB']->fullQuoteStr($dir.'/'.$file);
                        $count = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows('uid', 'tx_websermons_files', "path = ".$path."");
                        $vfile = $dir . '/' . $file;
                        
                        if($count == 0) {
                            $fileList[] = $vfile;
                        }
                    } else {
                        $folderList[] = $file;
                    }
                }
            }
            foreach ($folderList as $value) {
                $fileList += $this->getNotUsedFiles($dir."/".$value);
            }           
        }
        return $fileList;
    }
	

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/websermons/classes/class.tx_websermons_importfiles.php']);
}

?> 
