<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011  <>
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
 * Plugin 'Mitglieder Downloadliste' for the 'ffb_intern_dl' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ffbinterndl
 */
class tx_ffbinterndl_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_ffbinterndl_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ffbinterndl_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ffb_intern_dl';	// The extension key.
	var $pi_checkCHash = true;
	
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
			$this->internal['currentTable'] = 'tx_ffbinterndl_items';
			$this->internal['currentRow'] = $this->pi_getRecord('tx_ffbinterndl_items',$this->piVars['showUid']);
	
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
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['results_at_a_time'],0,1000,3);		// Number of results to show in a listing.
			$this->internal['maxPages']=\TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($lConf['maxPages'],0,1000,2);;		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='dateititle,beschreibung';
			$this->internal['orderByList']='uid,dateititle';
	
				// Get number of records:
			$res = $this->pi_exec_query('tx_ffbinterndl_items',1);
			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
	
				// Make listing query, pass query to SQL database:
			$res = $this->pi_exec_query('tx_ffbinterndl_items');
			$this->internal['currentTable'] = 'tx_ffbinterndl_items';
	
				// Put the whole list together:
			$fullTable='';	// Clear var;
		#	$fullTable.=\TYPO3\CMS\Core\Utility\GeneralUtility::view_array($this->piVars);	// DEBUG: Output the content of $this->piVars for debug purposes. REMEMBER to comment out the IP-lock in the debug() function in t3lib/config_default.php if nothing happens when you un-comment this line!
	
				// Adds the mode selector.
			$fullTable.=$this->pi_list_modeSelector($items);
	
				// Adds the whole list table
			$fullTable.=$this->makelist($res);
	
				// Adds the search box:
			$fullTable.=$this->pi_list_searchBox();
	
				// Adds the result browser:
			$fullTable.=$this->pi_list_browseresults();
	
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
	function makelist($res)	{
		$items=array();
			// Make list table rows
		while($this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			$items[]=$this->makeListItem();
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
	function makeListItem()	{
		$out='
				<p'.$this->pi_classParam('listrowField-dateititle').'>'.$this->getFieldContent('dateititle').'</p>
				<p'.$this->pi_classParam('listrowField-datei').'>'.$this->getFieldContent('datei').'</p>
				<p'.$this->pi_classParam('listrowField-screenshot').'>'.$this->getFieldContent('screenshot').'</p>
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
					<td nowrap="nowrap" valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('dateititle').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('dateititle').'</p></td>
				</tr>
				<tr>
					<td nowrap="nowrap" valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('datei').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('datei').'</p></td>
				</tr>
				<tr>
					<td nowrap="nowrap" valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('beschreibung').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('beschreibung').'</p></td>
				</tr>
				<tr>
					<td nowrap="nowrap" valign="top"'.$this->pi_classParam('singleView-HCell').'><p>'.$this->getFieldHeader('screenshot').'</p></td>
					<td valign="top"><p>'.$this->getFieldContent('screenshot').'</p></td>
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
			case 'uid':
				return $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;
			
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



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ffb_intern_dl/pi1/class.tx_ffbinterndl_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ffb_intern_dl/pi1/class.tx_ffbinterndl_pi1.php']);
}

?>