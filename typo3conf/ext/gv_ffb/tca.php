<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gvffb_taetigkeiten'] = array (
	'ctrl' => $TCA['tx_gvffb_taetigkeiten']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'taetigkeit'
	),
	'feInterface' => $TCA['tx_gvffb_taetigkeiten']['feInterface'],
	'columns' => array (
		'taetigkeit' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_taetigkeiten.taetigkeit',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'taetigkeit;;;;1-1-1')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_gvffb_geschaeftsfelder'] = array (
	'ctrl' => $TCA['tx_gvffb_geschaeftsfelder']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'geschaeftsfeld'
	),
	'feInterface' => $TCA['tx_gvffb_geschaeftsfelder']['feInterface'],
	'columns' => array (
		'geschaeftsfeld' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_geschaeftsfelder.geschaeftsfeld',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'geschaeftsfeld;;;;1-1-1')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_gvffb_zertifikationen'] = array (
	'ctrl' => $TCA['tx_gvffb_zertifikationen']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'zertifikation'
	),
	'feInterface' => $TCA['tx_gvffb_zertifikationen']['feInterface'],
	'columns' => array (
		'zertifikation' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gv_ffb/locallang_db.xml:tx_gvffb_zertifikationen.zertifikation',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'zertifikation;;;;1-1-1')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>