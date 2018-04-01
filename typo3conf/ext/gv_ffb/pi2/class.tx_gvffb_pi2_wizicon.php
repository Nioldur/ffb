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




/**
 * Class that adds the wizard icon.
 *
 * @author	Gunnar Vogelsang <hallo@gunnarvogelsang.de>
 * @package	TYPO3
 * @subpackage	tx_gvffb
 */
class tx_gvffb_pi2_wizicon {

					/**
					 * Processing the wizard items array
					 *
					 * @param	array		$wizardItems: The wizard items
					 * @return	Modified array with wizard items
					 */
					function proc($wizardItems)	{
						global $LANG;

						#$LL = $this->includeLocalLang();

						$wizardItems['plugins_tx_gvffb_pi2'] = array(
							'icon'=>\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('gv_ffb').'pi2/ce_wiz.gif',
							'title'=>$LANG->getLLL('pi2_title',$LL),
							'description'=>$LANG->getLLL('pi2_plus_wiz_description',$LL),
							'params'=>'&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=gv_ffb_pi2'
						);

						return $wizardItems;
					}

					/**
					 * Reads the [extDir]/locallang.xml and returns the $LOCAL_LANG array found in that file.
					 *
					 * @return	The array with language labels
					 */
					function includeLocalLang()	{
						$llFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('gv_ffb').'locallang.xml';
						$LOCAL_LANG = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);

						return $LOCAL_LANG;
					}
				}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi2/class.tx_gvffb_pi2_wizicon.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi2/class.tx_gvffb_pi2_wizicon.php']);
}

?>