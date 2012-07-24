<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_websermons_files=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pfiles/class.tx_websermons_pfiles.php', '_pfiles', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_files = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_pfiles
	tt_content.shortcut.20.0.conf.tx_websermons_files.CMD = singleView
', 43);


t3lib_extMgm::addPItoST43($_EXTKEY, 'pfolder/class.tx_websermons_pfolder.php', '_pfolder', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_folder = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_pfolder
	tt_content.shortcut.20.0.conf.tx_websermons_folder.CMD = singleView
', 43);


t3lib_extMgm::addPItoST43($_EXTKEY, 'plast/class.tx_websermons_plast.php', '_plast', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_files = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_plast
	tt_content.shortcut.20.0.conf.tx_websermons_files.CMD = singleView
', 43);

	// Register information for the task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_websermons_importFiles'] = array(
	'extension'        => $_EXTKEY,
	'title'            => 'LLL:EXT:' . $_EXTKEY . '/locallang.xml:scheduler.importFiles.name',
	'description'      => 'LLL:EXT:' . $_EXTKEY . '/locallang.xml:scheduler.importFiles.description',
	'additionalFields' => 'tx_websermons_importfiles_additionalfieldprovider'
);
?>