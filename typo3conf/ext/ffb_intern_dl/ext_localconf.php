<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
	options.saveDocNew.tx_ffbinterndl_items=1
');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi1/class.tx_ffbinterndl_pi1.php', '_pi1', 'list_type', 1);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_ffbinterndl_items = < plugin.'.\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_ffbinterndl_items.CMD = singleView
',43);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi2/class.tx_ffbinterndl_pi2.php', '_pi2', 'list_type', 1);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_ffbinterndl_items = < plugin.'.\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getCN($_EXTKEY).'_pi2
	tt_content.shortcut.20.0.conf.tx_ffbinterndl_items.CMD = singleView
',43);
?>