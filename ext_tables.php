<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_websermons_files'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files',		
		'label'     => 'topic',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'default_sortby' => 'ORDER BY pdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array(		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'icon_tx_websermons_files.gif',
	),
);

$TCA['tx_websermons_folder'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_folder',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array(		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'icon_tx_websermons_folder.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pfiles'] = 'layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:websermons/locallang_db.xml:tt_content.list_type_pfiles',
	$_EXTKEY . '_pfiles',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY, 'pfiles/static/', 'Last Sermons');


if (TYPO3_MODE === 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_websermons_pfiles_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'pfiles/class.tx_websermons_pfiles_wizicon.php';
}


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pfolder'] = 'layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:websermons/locallang_db.xml:tt_content.list_type_pfolder',
	$_EXTKEY . '_pfolder',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY, 'pfolder/static/', 'Folder');


if (TYPO3_MODE === 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_websermons_pfolder_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'pfolder/class.tx_websermons_pfolder_wizicon.php';
}


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_plast'] = 'layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:websermons/locallang_db.xml:tt_content.list_type_plast',
	$_EXTKEY . '_plast',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY, 'plast/static/', 'All Sermons');


if (TYPO3_MODE === 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_websermons_plast_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'plast/class.tx_websermons_plast_wizicon.php';
}
?>