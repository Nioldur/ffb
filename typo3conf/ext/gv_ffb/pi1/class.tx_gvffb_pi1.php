<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Gunnar Vogelsang <hallo@gunnarvogelsang.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

#require_once(PATH_tslib.'class.\TYPO3\CMS\Frontend\Plugin\AbstractPlugin.php');


/**
 * Plugin 'Mitglieder Suchbox' for the 'gv_ffb' extension.
 *
 * @author	Gunnar Vogelsang <hallo@gunnarvogelsang.de>
 * @package	TYPO3
 * @subpackage	tx_gvffb
 */
class tx_gvffb_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_gvffb_pi2';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gvffb_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gv_ffb';	// The extension key.
	var $pi_checkCHash = false;
	
	/**
	 * Main method of your PlugIn
	 *
	 * @param	string		$content: The content of the PlugIn
	 * @param	array		$conf: The PlugIn Configuration
	 * @return	The content that should be displayed on the website
	 */
	function main($content, $conf)	{
		switch((string)$conf['CMD'])	{
			case 'singleView':
				list($t) = explode(':',$this->cObj->currentRecord);
				$this->internal['currentTable']=$t;
				$this->internal['currentRow']=$this->cObj->data;
				return $this->pi_wrapInBaseClass($this->singleView($content, $conf));
			break;
			default:
				if (strstr($this->cObj->currentRecord,'tt_content'))	{
					$conf['pidList'] = $this->cObj->data['pages'];
					$conf['recursive'] = $this->cObj->data['recursive'];
				}
				return $this->pi_wrapInBaseClass($this->listView($content, $conf));
			break;
		}
	}
	
	/**
	 * Shows a list of database entries
	 *
	 * @param	string		$content: content of the PlugIn
	 * @param	array		$conf: PlugIn Configuration
	 * @return	HTML list of table entries
	 */
	function listView($content, $conf) {
		$this->conf = $conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		// Loading the LOCAL_LANG values
		
		$lConf = $this->conf['listView.'];	// Local settings for the listView function
	
		if ($this->piVars['showUid'])	{	// If a single element should be displayed:
			$this->internal['currentTable'] = 'tx_gvffb_taetigkeiten';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_gvffb_taetigkeiten',$this->piVars['showUid']);
	
			$content = $this->singleView($content, $conf);
			return $content;
			
		} else {
		
			$items=array(
				'1'=> $this->pi_getLL('list_mode_1','Mode 1'),
				'2'=> $this->pi_getLL('list_mode_2','Mode 2'),
				'3'=> $this->pi_getLL('list_mode_3','Mode 3'),
			);
			
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			if (!isset($this->piVars['mode']))	$this->piVars['mode']=1;
	
			// Initializing the query parameters:
			// Put the whole list together:
			$fullTable='<form id="ajax_form" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,$target = '',array('no_cache'=>'1')).'" method="POST">';	// Clear var;
			
			$fullTable.='<label for="suchbegriff">Suchbegriff</label>';
			$fullTable.='<input id="suchbegriff" type="text" name="'. $this->prefixId.'[suchbegriff]" class="texteingabe" value="'. $this->piVars['suchbegriff'] .'">';
			
			$fullTable.='<label for="plz">PLZ</label>';
			$fullTable.='<input id="plz" type="text" name="'. $this->prefixId.'[plz]" class="texteingabe" value="'. $this->piVars['plz'] .'">';
			
			$this->piVars['sort'] = 'taetigkeit:0';
			$fullTable.='<h4 id="head_taetigkeiten">T&auml;tigkeiten</h4>';
			$fullTable.='<div class="checkboxcontainer">';
			$fullTable.='<fieldset id="auswahl_taetigkeiten">';
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,1000,25);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,5);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='taetigkeit';
			$this->internal['orderByList']='uid,taetigkeit';
			$res = $this->pi_exec_query('tx_gvffb_taetigkeiten',1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
			$res = $this->pi_exec_query('tx_gvffb_taetigkeiten');
			$this->internal['currentTable'] = 'tx_gvffb_taetigkeiten';
			$fullTable.=$this->makelist($res, "taetigkeit");
			$fullTable.='</fieldset>';
			$fullTable.='</div>';
			
			$this->piVars['sort'] = 'geschaeftsfeld:0';
			$fullTable.='<h4 id="head_geschaeftsfelder">Gesch&auml;ftsfelder</h4>';
			$fullTable.='<div class="checkboxcontainer">';
			$fullTable.='<fieldset id="auswahl_geschaeftsfelder">';
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,1000,25);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,5);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='geschaeftsfeld';
			$this->internal['orderByList']='uid,geschaeftsfeld';
			$res = $this->pi_exec_query('tx_gvffb_geschaeftsfelder',1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
			$res = $this->pi_exec_query('tx_gvffb_geschaeftsfelder');
			$this->internal['currentTable'] = 'tx_gvffb_geschaeftsfelder';
			$fullTable.=$this->makelist($res, "geschaeftsfeld");
			$fullTable.='</fieldset>';
			$fullTable.='</div>';
			
			$this->piVars['sort'] = 'zertifikation:0';
			$fullTable.='<h4 id="head_zertifikationen">Zertifikationen</h4>';
			$fullTable.='<div class="checkboxcontainer">';
			$fullTable.='<fieldset id="auswahl_zertifikationen">';
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,1000,25);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,5);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='zertifikation';
			$this->internal['orderByList']='uid,zertifikation';
			$res = $this->pi_exec_query('tx_gvffb_zertifikationen',1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
			$res = $this->pi_exec_query('tx_gvffb_zertifikationen');
			$this->internal['currentTable'] = 'tx_gvffb_zertifikationen';
			$fullTable.=$this->makelist($res, "zertifikation");
			$fullTable.='</fieldset>';
			$fullTable.='</div>';
			
			$fullTable.='<input type="image" src="/fileadmin/template/media/filter_submit.png" name="'.$this->prefixId.'[submit_button]" value="Submit" class="filter_submit">
			</form>';
			
			// Returns the content from the plugin.
			return $fullTable;
		}
	}
	/**
	 * Creates a list from a database query
	 *
	 * @param	ressource	$res: A database result ressource
	 * @return	A HTML list if result items
	 */
	function makelist($res, $var)	{
		$items=array();
			// Make list table rows
		while($this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			$items[]=$this->makeListItem($var);
		}
	
		$out = '<div'.$this->pi_classParam('listrow').'>
			'.implode(chr(10),$items).'
			</div>';
		return $out;
	}
	
	/**
	 * Implodes a single row from a database to a single line
	 *
	 * @return	Imploded column values
	 */
	function makeListItem($var)	{
		$out='
				<div class="ajaxformelement">
					<input type="checkbox" name="'. $this->prefixId.'['.$var.'][]" value="'. $this->getFieldContent('uid') .'" '.( @in_array( $this->getFieldContent('uid'), $this->piVars[$var]) ? 'checked="true"' : '').' id="'. $var .'_'. $this->getFieldContent('uid') .'"> 
					<label for="'. $var .'_'. $this->getFieldContent('uid') .'">'. $this->getFieldContent($var) .'</label>
				</div>
			';
		return $out;
	}
	/**
	 * Display a single item from the database
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	HTML of a single database entry
	 */
	function singleView($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
	
			// This sets the title of the page for use in indexed search results:
		if ($this->internal['currentRow']['title'])	$GLOBALS['TSFE']->indexedDocTitle=$this->internal['currentRow']['title'];
	
		$content='<div'.$this->pi_classParam('singleView').'>
			<H2>Record "'.$this->internal['currentRow']['uid'].'" from table "'.$this->internal['currentTable'].'":</H2>
			<table>
				<tr>
					<td nowrap="nowrap" valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('taetigkeit').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('taetigkeit').'</p></td>
				</tr>
				<tr>
					<td nowrap'.$this->pi_classParam('singleView-HCell').'><p>Last updated:</p></td>
					<td valign="top"><p>'.date('d-m-Y H:i',$this->internal['currentRow']['tstamp']).'</p></td>
				</tr>
				<tr>
					<td nowrap'.$this->pi_classParam('singleView-HCell').'><p>Created:</p></td>
					<td valign="top"><p>'.date('d-m-Y H:i',$this->internal['currentRow']['crdate']).'</p></td>
				</tr>
			</table>
		<p>'.$this->pi_list_linkSingle($this->pi_getLL('back','Back'),0).'</p></div>'.
		$this->pi_getEditPanel();
	
		return $content;
	}
	/**
	 * Returns the content of a given field
	 *
	 * @param	string		$fN: name of table field
	 * @return	Value of the field
	 */
	function getFieldContent($fN)	{
		switch($fN) {
		/*
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;
		*/
			default:
				return $this->internal['currentRow'][$fN];
			break;
		}
	}
	/**
	 * Returns the label for a fieldname from local language array
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldHeader($fN)	{
		switch($fN) {
			
			default:
				return $this->pi_getLL('listFieldHeader_'.$fN,'['.$fN.']');
			break;
		}
	}
	
	/**
	 * Returns a sorting link for a column header
	 *
	 * @param	string		$fN: Fieldname
	 * @return	The fieldlabel wrapped in link that contains sorting vars
	 */
	function getFieldHeader_sortLink($fN)	{
		return $this->pi_linkTP_keepPIvars($this->getFieldHeader($fN),array('sort'=>$fN.':'.($this->internal['descFlag']?0:1)));
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi1/class.tx_gvffb_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi1/class.tx_gvffb_pi1.php']);
}

?>
