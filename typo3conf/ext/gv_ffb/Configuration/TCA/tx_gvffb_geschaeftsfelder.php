<?
return [
	'ctrl' => [
		'title'     => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_geschaeftsfelder',		
		'label'     => 'geschaeftsfeld',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		#'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'tca.php',
		'iconfile'          => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'icon_tx_gvffb_geschaeftsfelder.gif',
	],
    'columns' => [
		'geschaeftsfeld' => [
			'exclude' => 0,		
			'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_geschaeftsfelder.geschaeftsfeld',		
			'config' => [
				'type' => 'input',	
				'size' => '30',
			]
		],
    ],
]
?>