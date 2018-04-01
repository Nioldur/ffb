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
 * Plugin 'Mitglieder Suchergebnis' for the 'gv_ffb' extension.
 *
 * @author	Gunnar Vogelsang <hallo@gunnarvogelsang.de>
 * @package	TYPO3
 * @subpackage	tx_gvffb
 */
class tx_gvffb_pi2 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_gvffb_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_gvffb_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gv_ffb';	// The extension key.
	var $pi_checkCHash = false;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		
		if( $this->piVars) {
		
			$this->conf = $conf;
			$this->pi_setPiVarDefaults();
			$this->pi_loadLL();
			$query = "
			SELECT 
				fe_users.uid
			FROM
				fe_users
				
				LEFT JOIN fe_users_tx_gvffb_geschaeftsfelder_mm ON fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local = fe_users.uid";
				$query .= " LEFT JOIN tx_gvffb_geschaeftsfelder ON (tx_gvffb_geschaeftsfelder.uid = fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign";
				
				//if( count( $_POST['tx_gvffb_pi2']['geschaeftsfeld']) > 0) foreach( $_POST['tx_gvffb_pi2']['geschaeftsfeld'] as $tmp) $query .= " AND fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign=".$tmp;		
				$query .= ") LEFT JOIN fe_users_tx_gvffb_taetigkeiten_mm ON fe_users_tx_gvffb_taetigkeiten_mm.uid_local = fe_users.uid";
				$query .= " LEFT JOIN tx_gvffb_taetigkeiten ON tx_gvffb_taetigkeiten.uid = fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign";
				//if( count( $_POST['tx_gvffb_pi2']['taetigkeit']) > 0) foreach( $_POST['tx_gvffb_pi2']['taetigkeit'] as $tmp) $query .= " AND fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign=".$tmp;
				
				$query .= " LEFT JOIN fe_users_tx_gvffb_zertifikationen_mm ON fe_users_tx_gvffb_zertifikationen_mm.uid_local = fe_users.uid";
				$query .= " LEFT JOIN tx_gvffb_zertifikationen ON tx_gvffb_zertifikationen.uid = fe_users_tx_gvffb_zertifikationen_mm.uid_foreign";
				//if( count( $_POST['tx_gvffb_pi2']['zertifikation']) > 0) foreach( $_POST['tx_gvffb_pi2']['zertifikation'] as $tmp) $query .= " AND fe_users_tx_gvffb_zertifikationen_mm.uid_foreign=".$tmp;
			
			$arrayWhere = array();
			
			# Sonderzeichen
			$this->piVars['suchbegriff'] = htmlentities( trim( mysql_real_escape_string( $this->piVars['suchbegriff'])), ENT_QUOTES, "utf-8");
	
			if( strlen( $this->piVars['suchbegriff']) > 0) {
				
				$arrayWhere[] = " 
					(
					company LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					name LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					first_name LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					middle_name LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					last_name LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					address LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					telephone LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					fax LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					email LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					city LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					country LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					www LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					tx_gvffb_mobil LIKE '%". $this->piVars['suchbegriff'] ."%' OR 
					tx_gvffb_freitext LIKE '%". $this->piVars['suchbegriff'] ."%'
					)
					AND disable=0
				";
			}
			
			# Remove whitespace
			$this->piVars['plz'] = trim( $this->piVars['plz']);
			
			if( strlen( $this->piVars['plz']) > 0) {
				
				# only allow Numbers
				$pattern = "/[0-9]+/";
				$subject = $this->piVars['plz'];
				preg_match_all( $pattern, $subject, $matches);
				$zip = implode( "", $matches[0]);
				
				$arrayWhere[] = " 
					SUBSTR(zip,1,". strlen( $zip) .") = '". $zip ."'
				";
			}
			
			if( count( $this->piVars['taetigkeit']) > 0) {
			
				foreach( $this->piVars['taetigkeit'] as $tmp) $arrayWhere[] = "(SELECT COUNT(*) FROM fe_users_tx_gvffb_taetigkeiten_mm WHERE fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign=". $tmp ." AND fe_users_tx_gvffb_taetigkeiten_mm.uid_local=fe_users.uid) > 0";
			}
			
			if( count( $this->piVars['geschaeftsfeld']) > 0) {
				
				foreach( $this->piVars['geschaeftsfeld'] as $tmp) $arrayWhere[] = "(SELECT COUNT(*) FROM fe_users_tx_gvffb_geschaeftsfelder_mm WHERE fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign=". $tmp ." AND fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local=fe_users.uid) > 0";
			}
			
			if( count( $this->piVars['zertifikation']) > 0) {
			
				foreach( $this->piVars['zertifikation'] as $tmp) $arrayWhere[] = "(SELECT COUNT(*) FROM fe_users_tx_gvffb_taetigkeiten_mm WHERE fe_users_tx_gvffb_zertifikationen_mm.uid_foreign=". $tmp ." AND fe_users_tx_gvffb_zertifikationen_mm.uid_local=fe_users.uid) > 0";
			}
			
			$arrayWhere[] = "deleted=0";
			
			if( count( $arrayWhere) > 0) $query.= " WHERE ". implode( " AND ", $arrayWhere);
			$query .= " GROUP BY fe_users.uid ORDER BY fe_users.company ASC";
			
			$debug = false;
			if( $debug) {
				$content .= "<div class='content_element'>". print_r( $_POST) ."</div>";
				$content .= "<div class='content_element'>". $_SERVER['REQUEST_URI'] ."</div>";
				$content .= "<div class='content_element'>".$query."</div>";
			}
			
			$res = mysql(TYPO3_db, $query);
			
			if( mysql_num_rows( $res) > 0) {
			
				$arrContent = array();
				$content = "";
				while( $row = mysql_fetch_assoc( $res)) $arrContent[] = $row;
			
				$content = "
<div class=\"content_element\">
	<h2>Treffer.</h2>
	<p>Ihre spezifische Suche war erfolgreich ­ nachfolgend finden Sie eine Auflistung der Unternehmen, die exakt Ihrem Anforderungsprofil entsprechen.</p>
</div>
			";
			
				foreach( $arrContent as $user) {
					
					$q = "
					SELECT
						fe_users.*,
						GROUP_CONCAT(DISTINCT tx_gvffb_taetigkeiten.taetigkeit SEPARATOR ', ') AS taetigkeit,
						GROUP_CONCAT(DISTINCT tx_gvffb_geschaeftsfelder.geschaeftsfeld SEPARATOR ', ') AS geschaeftsfeld,
						GROUP_CONCAT(DISTINCT tx_gvffb_zertifikationen.zertifikation SEPARATOR ', ') AS zertifikation
					FROM
						fe_users
					LEFT JOIN
						fe_users_tx_gvffb_geschaeftsfelder_mm ON fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local = fe_users.uid
					LEFT JOIN
						tx_gvffb_geschaeftsfelder ON tx_gvffb_geschaeftsfelder.uid = fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign
					LEFT JOIN
						fe_users_tx_gvffb_taetigkeiten_mm ON fe_users_tx_gvffb_taetigkeiten_mm.uid_local = fe_users.uid
					LEFT JOIN
						tx_gvffb_taetigkeiten ON tx_gvffb_taetigkeiten.uid = fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign
					LEFT JOIN
						fe_users_tx_gvffb_zertifikationen_mm ON fe_users_tx_gvffb_zertifikationen_mm.uid_local = fe_users.uid
					LEFT JOIN
						tx_gvffb_zertifikationen ON tx_gvffb_zertifikationen.uid = fe_users_tx_gvffb_zertifikationen_mm.uid_foreign
					WHERE fe_users.uid = ".$user['uid']."
					GROUP BY
						fe_users.uid
					ORDER BY
						fe_users.company ASC
					LIMIT 1";
		
					$res = mysql_query( $q);
					$row = mysql_fetch_assoc( $res);
		
				$content .= "
<div class=\"content_element\">
	<h3>". $row['company'] ."</h3>
	<dl>
		<dt>Anschrift:</dt><dd>". $row['address'] ."<br>". $row['zip'] ." ". $row['city'] ."</dd>";
				if( strlen( $row['name']) > 0 && strlen( $row['last_name']) > 0) $content .= "<dt>Ansprechpartner:</dt><dd>". $row['name'] ." ". ( strlen( $row['first_name']) > 0 ? $row['first_name']." " : "") . $row['last_name'] ."</dd>";
				if( strlen( $row['telephone']) > 0) $content .= "<dt>Fon:</dt><dd>". $row['telephone'] ."</dd>";
				if( strlen( $row['fax']) > 0) $content .= "<dt>Fax:</dt><dd>". $row['fax'] ."</dd>";
				if( strlen( $row['email']) > 0) $content .= "<dt>Mail:</dt><dd><a href=\"mailto:". $row['email'] ."\">". $row['email'] ."</a></dd>";
				if( strlen( $row['www']) > 0) $content .= "<dt>Web:</dt><dd><a href=\"". $row['www'] ."\" target=\"_blank\" title=\"". $row['company'] ."\">". $row['www'] ."</a></dd>";
				if( strlen( $row['tx_gvffb_mobil']) > 0) $content .= "<dt>Mobil:</dt><dd>". $row['tx_gvffb_mobil'] ."</dd>";
				if( strlen( $row['comments']) > 0) $content .= "<dt>Postfach:</dt><dd>". $row['comments'] ."</dd>";
				if( strlen( $row['tx_gvffb_freitext']) > 0) $content .= "<dt>Freitext:</dt><dd>". $row['tx_gvffb_freitext'] ."</dd>";
				if( strlen( $row['taetigkeit']) > 0) $content .= "<dt>T&auml;tigkeiten:</dt><dd>". $row['taetigkeit'] ."</dd>";
				if( strlen( $row['geschaeftsfeld']) > 0) $content .= "<dt>Gesch&auml;ftsfelder:</dt><dd>". $row['geschaeftsfeld'] ."</dd>";
				if( strlen( $row['zertifikation']) > 0) $content .= "<dt>Zertifikationen:</dt><dd>". htmlentities( str_replace( "&nbsp;", "", $row['zertifikation'])) ."</dd>";
				$content .= "
	</dl>
</div>
";
				}
			} else {
			
			$content .= "
		<div class=\"content_element\">
			<h3>Keine Ergebnisse</h3>
			<p>F&uuml;r Ihre Suche wurden leider keine passenden Ergebnisse gefunden.<br /><br /><br /><br /><br /></p>
		</div>";
			}
		} else {
			
			$content .= "
<div class=\"content_element\">
	<h2>Legen Sie los!</h2>
	<p>Zur Zeit werden keine Suchergebnisse angezeigt. Bitte spezifizieren Sie
	Ihre Suche mit Hilfe der Filterfunktion in der rechten Spalte.
	</p>
</div>
			";
		}
		
		return $this->pi_wrapInBaseClass($content);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi2/class.tx_gvffb_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi2/class.tx_gvffb_pi2.php']);
}

?>
