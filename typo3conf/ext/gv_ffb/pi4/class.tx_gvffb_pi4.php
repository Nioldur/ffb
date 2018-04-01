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
 * Plugin 'Mitgliederliste' for the 'gv_ffb' extension.
 *
 * @author	Gunnar Vogelsang <hallo@gunnarvogelsang.de>
 * @package	TYPO3
 * @subpackage	tx_gvffb
 */
class tx_gvffb_pi4 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_gvffb_pi2';		// Same as class name
	var $scriptRelPath = 'pi4/class.tx_gvffb_pi4.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gv_ffb';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
	
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$query = "
		SELECT 
			fe_users . *, 
			GROUP_CONCAT(DISTINCT tx_gvffb_taetigkeiten.taetigkeit SEPARATOR ', ') AS taetigkeit, 
			GROUP_CONCAT(DISTINCT tx_gvffb_geschaeftsfelder.geschaeftsfeld SEPARATOR ', ') AS geschaeftsfeld, 
			GROUP_CONCAT(DISTINCT tx_gvffb_zertifikationen.zertifikation SEPARATOR ', ') AS zertifikation
		FROM
			fe_users
			LEFT JOIN fe_users_tx_gvffb_geschaeftsfelder_mm ON fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_geschaeftsfelder ON tx_gvffb_geschaeftsfelder.uid = fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign
			LEFT JOIN fe_users_tx_gvffb_taetigkeiten_mm ON fe_users_tx_gvffb_taetigkeiten_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_taetigkeiten ON tx_gvffb_taetigkeiten.uid = fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign
			LEFT JOIN fe_users_tx_gvffb_zertifikationen_mm ON fe_users_tx_gvffb_zertifikationen_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_zertifikationen ON tx_gvffb_zertifikationen.uid = fe_users_tx_gvffb_zertifikationen_mm.uid_foreign
		WHERE
			tx_gvffb_zweigstelle=0 AND
			deleted=0 AND
			disable=0
		GROUP BY 
			fe_users.uid 
		ORDER BY 
			fe_users.company ASC";

		
		$content = "";
		
		$debug = false;
		if( $debug) {
			$content .= "<div class='content_element'>".$query."</div>";
		}
		
		#$res = mysql(TYPO3_db, $query);
		#$res = mysql( $GLOBALS['TYPO3_CONF_VARS']['DB']['database'], $query);
        $conf = include( "/is/htdocs/wp10551939_HXQFVWEQML/www/t3_8/typo3conf/LocalConfiguration.php");
		/*
		$mysqli = new mysqli($conf['DB']['host'], $conf['DB']['username'], $conf['DB']['password'], $conf['DB']['database']);
		if ($mysqli->connect_errno) {
			die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
		}
		
		$mysqli->query($query);
		*/
		
	    #$connection = mysql_connect( $conf['DB']['host'], $conf['DB']['username'], $conf['DB']['password']) or die ( "Unable to connect!");
	    #mysql_set_charset('utf8', $connection); 
	    #mysql_select_db( $conf['DB']['database']); 
	    #$res = mysql_query( $query) or die("Fehler in query: ". $query ."<br>". mysql_error());
		#while( $row = $result->fetch_assoc()) {
			
		$pdo = new PDO('mysql:host='. $conf['DB']['Connections']['Default']['host'] .';dbname='. $conf['DB']['Connections']['Default']['dbname'], $conf['DB']['Connections']['Default']['user'], $conf['DB']['Connections']['Default']['password']);
		$pdo->exec("SET NAMES utf8");
		
		foreach($pdo->query($query) as $tmp) $rows[] = $tmp;
		
		foreach( $rows as $row) {
			$content .= "
<div class=\"content_element bordertop\">
	<h3 class='hauptsitz_head'>". $row['company'] ."</h3>
	<div class='hauptsitz'>
		<dl>
			<dt>Anschrift:</dt><dd>". $row['address'] ."<br>". $row['zip'] ." ". $row['city'] ."</dd>";
			if( strlen( $row['name']) > 0 && strlen( $row['last_name']) > 0) $content .= "<dt>Ansprechpartner:</dt><dd>". $row['name'] ." ". ( strlen( $row['first_name']) > 0 ? $row['first_name']." " : "") . $row['last_name'] ."</dd>";
			if( strlen( $row['telephone']) > 0) $content .= "<dt>Fon:</dt><dd>". $row['telephone'] ."</dd>";
			if( strlen( $row['fax']) > 0) $content .= "<dt>Fax:</dt><dd>". $row['fax'] ."</dd>";
			if( strlen( $row['email']) > 0) $content .= "<dt>Mail:</dt><dd><a href=\"mailto:". $row['email'] ."\" title=\"Email senden an: ". $row['company'] ."\">". $row['email'] ."</a></dd>";
			if( strlen( $row['www']) > 0) $content .= "<dt>Web:</dt><dd><a href=\"". ( substr( $row['www'], 0, 7) == "http://" ? "" : "http://") . $row['www'] ."\" title=\"". $row['company'] ." im Internet besuchen\" target=\"_blank\">". $row['www'] ."</a></dd>";
			if( strlen( $row['tx_gvffb_freitext']) > 0) $content .= "<dt>Freitext:</dt><dd>". $row['tx_gvffb_freitext'] ."</dd>";
			if( strlen( $row['taetigkeit']) > 0) $content .= "<dt>T&auml;tigkeiten:</dt><dd>". $row['taetigkeit'] ."</dd>";
			if( strlen( $row['geschaeftsfeld']) > 0) $content .= "<dt>Gesch&auml;ftsfelder:</dt><dd>". $row['geschaeftsfeld'] ."</dd>";
			if( strlen( $row['zertifikation']) > 0) $content .= "<dt>Zertifikationen:</dt><dd>". str_replace( "&nbsp;", "", $row['zertifikation']) ."</dd>";
			$content .= "
		</dl>
";
			
			# Zweigstellen zur aktuellen Firma suchen
			$query = "
			SELECT 
				fe_users.*, 
				GROUP_CONCAT(DISTINCT tx_gvffb_taetigkeiten.taetigkeit SEPARATOR ', ') AS taetigkeit, 
				GROUP_CONCAT(DISTINCT tx_gvffb_geschaeftsfelder.geschaeftsfeld SEPARATOR ', ') AS geschaeftsfeld, 
				GROUP_CONCAT(DISTINCT tx_gvffb_zertifikationen.zertifikation SEPARATOR ', ') AS zertifikation
			FROM
				fe_users
				LEFT JOIN fe_users_tx_gvffb_geschaeftsfelder_mm ON fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local = fe_users.uid
				LEFT JOIN tx_gvffb_geschaeftsfelder ON tx_gvffb_geschaeftsfelder.uid = fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign
				LEFT JOIN fe_users_tx_gvffb_taetigkeiten_mm ON fe_users_tx_gvffb_taetigkeiten_mm.uid_local = fe_users.uid
				LEFT JOIN tx_gvffb_taetigkeiten ON tx_gvffb_taetigkeiten.uid = fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign
				LEFT JOIN fe_users_tx_gvffb_zertifikationen_mm ON fe_users_tx_gvffb_zertifikationen_mm.uid_local = fe_users.uid
				LEFT JOIN tx_gvffb_zertifikationen ON tx_gvffb_zertifikationen.uid = fe_users_tx_gvffb_zertifikationen_mm.uid_foreign
			WHERE
				tx_gvffb_zweigstelle=". $row['uid'] ." AND
				deleted=0
			GROUP BY 
				fe_users.uid 
			ORDER BY 
				fe_users.company ASC";
			
			#$res2 = mysql(TYPO3_db, $query);
			#while( $zweigstelle = mysql_fetch_assoc( $res2)) {
			
			foreach($pdo->query($query) as $zweigstelle) {
			
				$content .= "
	<div class=\"zweigstelle_container zweigstelle_border\">
		<p class=\"nomargin small\">Niederlassung</p>
		<h3 class=\"zweigstelle_head\">". $zweigstelle['company'] ."</h3>
		<dl>
			<dt>Anschrift:</dt><dd>". $zweigstelle['address'] ."<br>". $zweigstelle['zip'] ." ". $zweigstelle['city'] ."</dd>";
			if( strlen( $zweigstelle['name']) > 0 && strlen( $zweigstelle['last_name']) > 0) $content .= "<dt>Ansprechpartner:</dt><dd>". $zweigstelle['name'] ." ". ( strlen( $zweigstelle['first_name']) > 0 ? $zweigstelle['first_name']." " : "") . $zweigstelle['last_name'] ."</dd>";
			if( strlen( $zweigstelle['telephone']) > 0) $content .= "<dt>Fon:</dt><dd>". $zweigstelle['telephone'] ."</dd>";
			if( strlen( $zweigstelle['fax']) > 0) $content .= "<dt>Fax:</dt><dd>". $zweigstelle['fax'] ."</dd>";
			if( strlen( $zweigstelle['email']) > 0) $content .= "<dt>Mail:</dt><dd><a href=\"mailto:". $zweigstelle['email'] ."\" title=\"Email senden an: ". $zweigstelle['company'] ."\">". $zweigstelle['email'] ."</a></dd>";
			if( strlen( $zweigstelle['www']) > 0) $content .= "<dt>Web:</dt><dd><a href=\"". ( substr( $zweigstelle['www'], 0, 7) == "http://" ? "" : "http://") . $zweigstelle['www'] ."\" title=\"". $zweigstelle['company'] ." im Internet besuchen\" target=\"_blank\">". $zweigstelle['www'] ."</a></dd>";
			if( strlen( $zweigstelle['tx_gvffb_freitext']) > 0) $content .= "<dt>Freitext:</dt><dd>". $zweigstelle['tx_gvffb_freitext'] ."</dd>";
			if( strlen( $zweigstelle['taetigkeit']) > 0) $content .= "<dt>T&auml;tigkeiten:</dt><dd>". $zweigstelle['taetigkeit'] ."</dd>";
			if( strlen( $zweigstelle['geschaeftsfeld']) > 0) $content .= "<dt>Gesch&auml;ftsfelder:</dt><dd>". $zweigstelle['geschaeftsfeld'] ."</dd>";
			if( strlen( $zweigstelle['zertifikation']) > 0) $content .= "<dt>Zertifikationen:</dt><dd>". str_replace( "&nbsp;", "", $zweigstelle['zertifikation']) ."</dd>";
				$content .= "
		</dl>
	</div>
";
			}
			
			$content .= "
	</div>
</div>
";
		}
	
		return $this->pi_wrapInBaseClass($content);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi4/class.tx_gvffb_pi4.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi4/class.tx_gvffb_pi4.php']);
}

?>
