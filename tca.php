<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_websermons_files'] = array(
	'ctrl' => $TCA['tx_websermons_files']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group,title,speaker,topic,path,pdate,links,parentfolder'
	),
	'feInterface' => $TCA['tx_websermons_files']['feInterface'],
	'columns' => array(
		't3ver_label' => array(		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array(		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array(		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array(
				'type'  => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table'       => 'tx_websermons_files',
				'foreign_table_where' => 'AND tx_websermons_files.pid=###CURRENT_PID### AND tx_websermons_files.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array(		
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'hidden' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array(
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array(
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array(
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array(
				'type'  => 'select',
				'items' => array(
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'speaker' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.speaker',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'topic' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.topic',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'path' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.path',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'pdate' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.pdate',		
			'config' => array(
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'links' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.links',		
			'config' => array(
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',	
				'wizards' => array(
					'_PADDING' => 2,
					'example' => array(
						'title'         => 'Example Wizard:',
						'type'          => 'script',
						'notNewRecords' => 1,
						'icon'          => t3lib_extMgm::extRelPath('websermons').'tx_websermons_files_links/wizard_icon.gif',
						'script'        => t3lib_extMgm::extRelPath('websermons').'tx_websermons_files_links/index.php',
					),
				),
			)
		),
		'parentfolder' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_files.parentfolder',		
			'config' => array(
				'type' => 'select',	
				'foreign_table' => 'tx_websermons_folder',	
				'foreign_table_where' => 'ORDER BY tx_websermons_folder.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,	
				"MM" => "tx_websermons_files_parentfolder_mm",
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title;;;;2-2-2, speaker;;;;3-3-3, topic, path, pdate, links, parentfolder')
	),
	'palettes' => array(
		'1' => array('showitem' => 'starttime, endtime, fe_group')
	)
);



$TCA['tx_websermons_folder'] = array(
	'ctrl' => $TCA['tx_websermons_folder']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,fe_group,title,path,parentfolder'
	),
	'feInterface' => $TCA['tx_websermons_folder']['feInterface'],
	'columns' => array(
		'hidden' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array(
				'type'  => 'select',
				'items' => array(
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_folder.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'path' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_folder.path',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'parentfolder' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:websermons/locallang_db.xml:tx_websermons_folder.parentfolder',		
			'config' => array(
				'type' => 'select',	
				'foreign_table' => 'tx_websermons_folder',	
				'foreign_table_where' => 'ORDER BY tx_websermons_folder.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,	
				"MM" => "tx_websermons_folder_parentfolder_mm",	
				'wizards' => array(
					'_PADDING'  => 2,
					'_VERTICAL' => 1,
					'add' => array(
						'type'   => 'script',
						'title'  => 'Create new record',
						'icon'   => 'add.gif',
						'params' => array(
							'table'    => 'tx_websermons_folder',
							'pid'      => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
						'script' => 'wizard_add.php',
					),
					'list' => array(
						'type'   => 'script',
						'title'  => 'List',
						'icon'   => 'list.gif',
						'params' => array(
							'table' => 'tx_websermons_folder',
							'pid'   => '###CURRENT_PID###',
						),
						'script' => 'wizard_list.php',
					),
					'edit' => array(
						'type'                     => 'popup',
						'title'                    => 'Edit',
						'script'                   => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon'                     => 'edit2.gif',
						'JSopenParams'             => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				),
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, path;;;;3-3-3, parentfolder')
	),
	'palettes' => array(
		'1' => array('showitem' => 'fe_group')
	)
);
?>