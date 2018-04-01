<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ffbinterndl_items'] = array (
	'ctrl' => $TCA['tx_ffbinterndl_items']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'dateititle,datei,beschreibung,screenshot'
	),
	'feInterface' => $TCA['tx_ffbinterndl_items']['feInterface'],
	'columns' => array (
		'dateititle' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ffb_intern_dl/locallang_db.xml:tx_ffbinterndl_items.dateititle',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'datei' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ffb_intern_dl/locallang_db.xml:tx_ffbinterndl_items.datei',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ffbinterndl',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'beschreibung' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ffb_intern_dl/locallang_db.xml:tx_ffbinterndl_items.beschreibung',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'screenshot' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ffb_intern_dl/locallang_db.xml:tx_ffbinterndl_items.screenshot',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ffbinterndl',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'dateititle;;;;1-1-1, datei, beschreibung;;;richtext[]:rte_transform[mode=ts], screenshot')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>