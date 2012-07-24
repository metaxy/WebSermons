<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_websermons_files=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi2/class.tx_websermons_pi2.php', '_pi2', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_files = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_pi2
	tt_content.shortcut.20.0.conf.tx_websermons_files.CMD = singleView
', 43);


t3lib_extMgm::addPItoST43($_EXTKEY, 'pi3/class.tx_websermons_pi3.php', '_pi3', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_folder = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_pi3
	tt_content.shortcut.20.0.conf.tx_websermons_folder.CMD = singleView
', 43);


t3lib_extMgm::addPItoST43($_EXTKEY, 'pi4/class.tx_websermons_pi4.php', '_pi4', 'list_type', 1);


t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', '
	tt_content.shortcut.20.0.conf.tx_websermons_files = < plugin.' . t3lib_extMgm::getCN($_EXTKEY) . '_pi4
	tt_content.shortcut.20.0.conf.tx_websermons_files.CMD = singleView
', 43);
?>