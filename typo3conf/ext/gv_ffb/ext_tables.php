<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$GLOBALS['TCA']['tx_gvffb_taetigkeiten'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_taetigkeiten',		
		'label'     => 'taetigkeit',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile'          => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_tx_gvffb_taetigkeiten.gif',
	),
);

$GLOBALS['TCA']['tx_gvffb_geschaeftsfelder'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_geschaeftsfelder',		
		'label'     => 'geschaeftsfeld',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile'          => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_tx_gvffb_geschaeftsfelder.gif',
	),
);

$GLOBALS['TCA']['tx_gvffb_zertifikationen'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_zertifikationen',		
		'label'     => 'zertifikation',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile'          => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_tx_gvffb_zertifikationen.gif',
	),
);

$tempColumns = array (
	'tx_gvffb_taetigkeiten' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_taetigkeiten',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_gvffb_taetigkeiten',	
			'foreign_table_where' => 'ORDER BY tx_gvffb_taetigkeiten.uid',	
			'size' => 10,	
			'minitems' => 0,
			'maxitems' => 17,	
			"MM" => "fe_users_tx_gvffb_taetigkeiten_mm",
		)
	),
	'tx_gvffb_geschaeftsfelder' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_geschaeftsfelder',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_gvffb_geschaeftsfelder',	
			'foreign_table_where' => 'ORDER BY tx_gvffb_geschaeftsfelder.uid',	
			'size' => 10,	
			'minitems' => 0,
			'maxitems' => 17,	
			"MM" => "fe_users_tx_gvffb_geschaeftsfelder_mm",
		)
	),
	'tx_gvffb_zertifikationen' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_zertifikationen',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_gvffb_zertifikationen',	
			'foreign_table_where' => 'ORDER BY tx_gvffb_zertifikationen.uid',	
			'size' => 10,	
			'minitems' => 0,
			'maxitems' => 17,	
			"MM" => "fe_users_tx_gvffb_zertifikationen_mm",
		)
	),
	'tx_gvffb_zweigstelle' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_zweigstelle',		
		'config' => array (
			'type' => 'select',	
			'items' => array (
				array('',0),
			),
			'foreign_table' => 'fe_users',	
			'foreign_table_where' => 'ORDER BY fe_users.uid',	
			'size' => 10,	
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_gvffb_mobil' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_mobil',		
		'config' => array (
			'type' => 'input',	
			'size' => '48',	
			'max' => '25',
		)
	),
	'tx_gvffb_freitext' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:fe_users.tx_gvffb_freitext',		
		'config' => array (
			'type' => 'text',
			'cols' => '30',	
			'rows' => '5',
		)
	),
);


//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('fe_users');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tempColumns,1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users','tx_gvffb_taetigkeiten;;;;1-1-1, tx_gvffb_geschaeftsfelder, tx_gvffb_zertifikationen, tx_gvffb_zweigstelle, tx_gvffb_mobil, tx_gvffb_freitext');


//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:gv_ffb/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'pi1/static/','Mitglieder Suchbox');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_gvffb_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi1/class.tx_gvffb_pi1_wizicon.php';
}


//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:gv_ffb/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_gvffb_pi2_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi2/class.tx_gvffb_pi2_wizicon.php';
}


//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:gv_ffb/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_gvffb_pi3_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi3/class.tx_gvffb_pi3_wizicon.php';
}


//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:gv_ffb/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_gvffb_pi4_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi4/class.tx_gvffb_pi4_wizicon.php';
}
?>