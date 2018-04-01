<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi1/class.tx_gvffb_pi1.php', '_pi1', 'list_type', 1);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_gvffb_taetigkeiten = < plugin.'.\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_gvffb_taetigkeiten.CMD = singleView
',43);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi2/class.tx_gvffb_pi2.php', '_pi2', 'list_type', 1);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi3/class.tx_gvffb_pi3.php', '_pi3', 'list_type', 1);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi4/class.tx_gvffb_pi4.php', '_pi4', 'list_type', 1);
?>