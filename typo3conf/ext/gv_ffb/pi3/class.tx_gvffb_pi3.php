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
 * Plugin 'Mitglieder Intern' for the 'gv_ffb' extension.
 *
 * @author	Gunnar Vogelsang <hallo@gunnarvogelsang.de>
 * @package	TYPO3
 * @subpackage	tx_gvffb
 */
class tx_gvffb_pi3 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId      = 'tx_gvffb_pi3';		// Same as class name
	var $scriptRelPath = 'pi3/class.tx_gvffb_pi3.php';	// Path to this script relative to the extension dir.
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
		//var_dump($GLOBALS["TSFE"]);
		if( \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('mode') == 'zweigstelle' && $GLOBALS["TSFE"]->fe_user->user["tx_gvffb_zweigstelle"] == 0) {
			$menu = '<p>'.$this->pi_linkTP('Eigene Daten editieren').'</p>';
			$content = $this->zweigstelleAnlegen($menu);
		}else{
			if($GLOBALS["TSFE"]->fe_user->user["tx_gvffb_zweigstelle"] == 0)
			$menu = '<p>'.$this->pi_linkTP('Zweigstelle anlegen',array('mode'=>'zweigstelle')).'</p>';
			$content = $this->hauptstelleBearbeiten($menu);
		}
        //$GLOBALS["TSFE"]->fe_user->user["uid"];
		/*$content=.'
			<strong>This is a few paragraphs:</strong><br />
			<p>This is line 1</p>
			<p>This is line 2</p>
	
			<h3>This is a form:</h3>
			<form action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id).'" method="POST">
				<input type="text" name="'.$this->prefixId.'[input_field]" value="'.htmlspecialchars($this->piVars['input_field']).'">
				<input type="submit" name="'.$this->prefixId.'[submit_button]" value="'.htmlspecialchars($this->pi_getLL('submit_button_label')).'">
			</form>
			<br />
			<p>You can click here to </p>
		';*/
	
		return $this->pi_wrapInBaseClass($content);
	}

	function zweigstelleAnlegen($menu){
		
		$content = $menu;
        
        $conf = include( "/is/htdocs/wp10551939_HXQFVWEQML/www/t3_8/typo3conf/LocalConfiguration.php");
		$connection = mysql_connect( $conf['DB']['host'], $conf['DB']['username'], $conf['DB']['password']) or die ( "Unable to connect!");
	    mysql_select_db( $conf['DB']['database']);
			
		if($this->piVars['db2']['submit'])
		{		
			$reqFields = array('username','password','email','company');
			
			foreach($this->piVars['db'] as $key=>$val)
			{
				if(in_array($key, $reqFields) && strlen($val) == 0)
					$error[] = "Ein ben&ouml;tigtes Feld wurde nicht ausgef&uuml;llt: (". $key .")";
				else
					$sql_values[] = $key.'= \''.mysql_real_escape_string($val).'\'';
			}
			
			$query = "SELECT uid FROM fe_users WHERE username LIKE '".mysql_real_escape_string($this->piVars['db']['username'])."' AND deleted=0";
			$res = mysql_query( $query) or die("Fehler in query: ". $query ."<br>". mysql_error());
			
			if(mysql_num_rows($res) > 0) {
			
				$error[] = 'Der Username ist bereits vorhanden.';
			}
			
			$query = '
			INSERT INTO
				fe_users
			SET
				'.implode(",",$sql_values).', pid = 19, usergroup = 1, tx_gvffb_zweigstelle = '.$GLOBALS["TSFE"]->fe_user->user["uid"];
			
			if(count($error) > 0) {
			
				$content .= implode("<br>",$error);
			
			} else {
			
				mysql_query($query) or die(mysql_error().' in Query: '.$query);
				$lastid = mysql_insert_id();
                
                settype( $this->piVars['db3'], "array");
				foreach($this->piVars['db3'] as $k=>$v)
				{
				    settype( $v, "array");
					foreach($v as $key=>$val)
					{
						$query = 'INSERT INTO fe_users_'.mysql_real_escape_string($k).'_mm SET uid_local='.$lastid.', uid_foreign='.mysql_real_escape_string($val).', sorting=1, tablenames=\'\'';
						mysql_query($query) or die(mysql_error().' in Query: '.$query);
					}
				}
				/*
				// Bestaetigungsmail mit Aktivierungslink senden
				$html_start = '<html><head><title>Benachrichtigung: '. $GLOBALS["TSFE"]->fe_user->user["company"] .' hat eine neue Zweigstelle angelegt</title></head><body>';
				$nachricht = 'Die Firma ' . $GLOBALS["TSFE"]->fe_user->user["company"] . ' hat soeben eine neue Zweigstelle'. ( strlen( $this->piVars['db']['company']) > 0 ? ' mit dem Namen '. $this->piVars['db']['company'] : '') .' angelegt.';
				$html_end = '</body></html>';
				
				#require_once(PATH_t3lib . 'class.t3lib_htmlmail.php');
				if( $this->htmlMail = @\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('t3lib_htmlmail')) {
				    $this->htmlMail->start();
				    $this->htmlMail->recipient = "info@fachverband-fernmeldebau.de";
				    $this->htmlMail->recipient_copy = "";
				    $this->htmlMail->replyto_email = "noreply@fachverband-fernmeldebau.de";
				    $this->htmlMail->replyto_name = 'noreply@fachverband-fernmeldebau.de';
				    $this->htmlMail->subject = 'FFB-Online: Neue Zweigstelle der Firma ' . $GLOBALS["TSFE"]->fe_user->user["company"];
				    $this->htmlMail->from_email = 'noreply@fachverband-fernmeldebau.de';
				    $this->htmlMail->from_name = 'Fachverband Fernmeldebau e.V.';
				    $this->htmlMail->returnPath = "info@fachverband-fernmeldebau.de";
				    $this->htmlMail->addPlain($nachricht);
				    $this->htmlMail->setHTML($this->htmlMail->encodeMsg($html_start . $nachricht . $html_end));
				    $this->htmlMail->send($this->htmlMail->recipient);
			    }
			    */
			}
		}

		#$res = mysql(TYPO3_db,'SELECT uid, taetigkeit FROM tx_gvffb_taetigkeiten');
		$res = mysql_query( 'SELECT uid, taetigkeit FROM tx_gvffb_taetigkeiten') or die(mysql_error());
		while($row = mysql_fetch_assoc($res))
		{
			$taetigkeiten[$row['uid']] = $row['taetigkeit'];
		}

		#$res = mysql(TYPO3_db,'SELECT uid, zertifikation FROM tx_gvffb_zertifikationen');
		$res = mysql_query( 'SELECT uid, zertifikation FROM tx_gvffb_zertifikationen') or die(mysql_error());
		while($row = mysql_fetch_assoc($res))
		{
			$zertifikationen[$row['uid']] = $row['zertifikation'];
		}

		#$res = mysql(TYPO3_db,'SELECT uid, geschaeftsfeld FROM tx_gvffb_geschaeftsfelder');
		$res = mysql_query( 'SELECT uid, geschaeftsfeld FROM tx_gvffb_geschaeftsfelder') or die(mysql_error());
		while($row = mysql_fetch_assoc($res))
		{
			$geschaeftsfelder[$row['uid']] = $row['geschaeftsfeld'];
		}

		$content .= '
			<h2>Zweigstelle anlegen</h2>
			<form id="std_form" method="POST" action="'.$this->pi_getPageLink($GLOBALS["TSFE"]->page["uid"],$target = '',array('mode'=>'zweigstelle','no_cache'=>'1')).'">
			<fieldset>
				<legend>Logindaten</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][username]">Username*</label>
					<input type="text" name="'.$this->prefixId.'[db][username]" value="'.$this->piVars['db']['username'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][password]">Password*</label>
					<input type="password" name="'.$this->prefixId.'[db][password]" value="'.$this->piVars['db']['password'].'">
				</div>
			</fieldset>
			<fieldset>
				<legend>Kontaktdaten</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][company]">Firma*</label>
					<input type="text" name="'.$this->prefixId.'[db][company]" value="'.$this->piVars['db']['company'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][address]">Stra&szlig;e / Hausnummer</label>
					<input type="text" name="'.$this->prefixId.'[db][address]" value="'.$this->piVars['db']['address'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][city]">Stadt</label>
					<input type="text" name="'.$this->prefixId.'[db][city]" value="'.$this->piVars['db']['city'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][zip]">Postleitzahl</label>
					<input type="text" name="'.$this->prefixId.'[db][zip]" value="'.$this->piVars['db']['company'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][telephone]">Telefon</label>
					<input type="text" name="'.$this->prefixId.'[db][telephone]" value="'.$this->piVars['db']['telephone'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][]" ]">Fax</label>
					<input type="text" name="'.$this->prefixId.'[db][fax]" value="'.$this->piVars['db']['fax'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][email]">Email*</label>
					<input type="text" name="'.$this->prefixId.'[db][email]" value="'.$this->piVars['db']['email'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][www]">Webseite</label>
					<input type="text" name="'.$this->prefixId.'[db][www]" value="'.$this->piVars['db']['www'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][tx_gvffb_mobil]">Mobil</label>
					<input type="text" name="'.$this->prefixId.'[db][tx_gvffb_mobil]" value="'.$this->piVars['db']['tx_gvffb_mobil'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][comments]">Postfach</label>
					<input type="text" name="'.$this->prefixId.'[db][comments]" value="'.$this->piVars['db']['comments'].'">
				</div>
			</fieldset>
			';
				
		$content .= '
			<fieldset>
				<legend>Ansprechpartner</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][name]">Anrede</label>
					<input type="text" name="'.$this->prefixId.'[db][name]" value="'.$this->piVars['db']['name'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][first_name]">Vorname</label>
					<input type="text" name="'.$this->prefixId.'[db][first_name]" value="'.$this->piVars['db']['first_name'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][last_name]">Nachname</label>
					<input type="text" name="'.$this->prefixId.'[db][last_name]" value="'.$this->piVars['db']['last_name'].'">
				</div>
			</fieldset>
		';
				
			$content .='
			<fieldset>
				<legend>T&auml;tigkeiten</legend>';
				foreach($taetigkeiten as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_taetigkeiten][]" value="'.$key.'" '.(@in_array($key,$this->piVars['db3']['tx_gvffb_taetigkeiten'])?'checked="true"':'').' id="taetigkeit_'. $key .'" style="width:35px;" /><label class="wide" for="taetigkeit_'. $key .'">'. htmlentities( $val, ENT_NOQUOTES, "ISO8859-1") .'</label></div>';
				}

				$content .='
			</fieldset>
			<fieldset>
				<legend>Gesch&auml;ftsfelder</legend>';
				foreach( $geschaeftsfelder as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_geschaeftsfelder][]" value="'.$key.'" '.(@in_array($key,$this->piVars['db3']['tx_gvffb_geschaeftsfelder'])?'checked="true"':'').' id="geschaeftsfeld_'. $key .'" style="width:35px;" /><label class="wide" for="geschaeftsfeld_'. $key .'">'. htmlentities( $val, ENT_NOQUOTES, "ISO8859-1") .'</label></div>';
				}


				$content .='
			</fieldset>
			<fieldset>
				<legend>Zertifikationen</legend>';
				foreach($zertifikationen as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_zertifikationen][]" value="'.$key.'" '.(@in_array($key,$this->piVars['db3']['tx_gvffb_zertifikationen'])?'checked="true"':'').' id="zertifikat_'. $key .'" style="width:35px;" /><label class="wide" for="zertifikat_'. $key .'">'. htmlentities( $val, ENT_NOQUOTES, "ISO8859-1") .'</label></div>';
				}

				$content .= '
			</fieldset>
			<div class="container clearfix">
				<label for="'.$this->prefixId.'[db][tx_gvffb_freitext]" class="legend">Freies Textfeld</label>
				<br class="clear" />
				<textarea class="big" name="'.$this->prefixId.'[db][tx_gvffb_freitext]">'.$this->piVars['db']['tx_gvffb_freitext'].'</textarea>
			</div>
			<div class="container clearfix">
				<input class="submit_button nomargin_submit_button" type="submit" name="'.$this->prefixId.'[db2][submit]" value="Daten senden">
			</div>
			</form><br>';
		
		return $content;
	}

	function hauptstelleBearbeiten($menu){

		$content = $menu;
		$uid = $GLOBALS["TSFE"]->fe_user->user["uid"];
		
		$conf = include( "/is/htdocs/wp10551939_HXQFVWEQML/www/t3_8/typo3conf/LocalConfiguration.php");
		$connection = mysql_connect( $conf['DB']['host'], $conf['DB']['username'], $conf['DB']['password']) or die ( "Unable to connect!");
		mysql_select_db( $conf['DB']['database']);
		
		if($this->piVars['db2']['submit'])
		{
		
			$reqFields = array('username','password','email','company');
			settype($this->piVars['db'],"array");
			
			foreach($this->piVars['db'] as $key=>$val)
			{
				if(in_array($key, $reqFields) && strlen($val) == 0)
					$error[0] = "Ein ben&ouml;tigtes Feld wurde nicht ausgef&uuml;llt";
				else
					$sql_values[] = $key.'= \''.mysql_real_escape_string( htmlentities( $val)).'\'';
			}
			$query = 'SELECT uid FROM fe_users WHERE username LIKE "'.mysql_real_escape_string($this->piVars['db']['username']).'" AND deleted=0 AND uid != '.$uid;
			#$res = mysql_query($query) or die(mysql_error().'<br>'.$query);
			$res = mysql_query( $query) or die("Fehler in query: ". $query ."<br>". mysql_error());
			
			if(mysql_num_rows($res) == 0)
			{
				
				$query = '
				UPDATE
					fe_users
				SET
					'.implode(",",$sql_values).' WHERE uid = '.$uid;
			}else{
					$error[1] = 'Der Username ist bereits vergeben.';
			}
			if(count($error) > 0)
			{
				$content .= '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'. implode("<br>",$error) .'</div>';
				
			} else {
			
				mysql_query($query) or die(mysql_error().' in Query: '.$query);
				$lastid = $uid;
				
				$query = 'DELETE FROM fe_users_tx_gvffb_geschaeftsfelder_mm WHERE uid_local='.$lastid;
				mysql_query($query) or die(mysql_error().' in Query: '.$query);
				
				$query = 'DELETE FROM fe_users_tx_gvffb_taetigkeiten_mm WHERE uid_local='.$lastid;
				mysql_query($query) or die(mysql_error().' in Query: '.$query);
				
				$query = 'DELETE FROM fe_users_tx_gvffb_zertifikationen_mm WHERE uid_local='.$lastid;
				mysql_query($query) or die(mysql_error().' in Query: '.$query);
				
				settype( $this->piVars['db3'], "array");
				foreach( $this->piVars['db3'] as $k=>$v) {
					
					foreach($v as $key=>$val) {
					
						$query = 'INSERT INTO fe_users_'.mysql_real_escape_string($k).'_mm SET uid_local='.$lastid.', uid_foreign=\''.mysql_real_escape_string($val).'\', sorting=1, tablenames=\'\'';
						mysql_query($query) or die(mysql_error().' in Query: '.$query);
					}
				}
				/*
				// Bestaetigungsmail mit Aktivierungslink senden
				$html_start = '<html><head><title>Benachrichtigung: '. $GLOBALS["TSFE"]->fe_user->user["company"] .' hat seine Daten editiert</title></head><body>';
				$nachricht = 'Die Firma ' . $GLOBALS["TSFE"]->fe_user->user["company"] . ' hat soeben seine Daten editiert.';
				$html_end = '</body></html>';
				
				#require_once(PATH_t3lib . 'class.t3lib_htmlmail.php');
				if( $this->htmlMail = @\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('t3lib_htmlmail')) {
				    $this->htmlMail->start();
				    $this->htmlMail->recipient = "info@fachverband-fernmeldebau.de";
				    $this->htmlMail->recipient_copy = "";
				    $this->htmlMail->replyto_email = "noreply@fachverband-fernmeldebau.de";
				    $this->htmlMail->replyto_name = 'noreply@fachverband-fernmeldebau.de';
				    $this->htmlMail->subject = 'FFB-Online: Firma ' . $GLOBALS["TSFE"]->fe_user->user["company"] . ' hat soeben seine Daten editiert.';
				    $this->htmlMail->from_email = 'noreply@fachverband-fernmeldebau.de';
				    $this->htmlMail->from_name = 'Fachverband Fernmeldebau e.V.';
				    $this->htmlMail->returnPath = "info@fachverband-fernmeldebau.de";
				    $this->htmlMail->addPlain($nachricht);
				    $this->htmlMail->setHTML($this->htmlMail->encodeMsg($html_start . $nachricht . $html_end));
				    $this->htmlMail->send($this->htmlMail->recipient);
				}
				*/
			}
		}
		
		
		// tx_gvffb_taetigkeiten, tx_gvffb_zertifikationen, tx_gvffb_geschaeftsfelder
		$query = "
		SELECT 
			fe_users.username,
			fe_users.password,
			fe_users.company,
			fe_users.address,
			fe_users.zip,
			fe_users.city,
			fe_users.telephone,
			fe_users.fax,
			fe_users.email,
			fe_users.www,
			fe_users.tx_gvffb_mobil,
			fe_users.tx_gvffb_freitext,
			fe_users.name,
			fe_users.first_name,
			fe_users.last_name,
			GROUP_CONCAT(DISTINCT tx_gvffb_taetigkeiten.uid SEPARATOR ', ') AS taetigkeit, 
			GROUP_CONCAT(DISTINCT tx_gvffb_geschaeftsfelder.uid SEPARATOR ', ') AS geschaeftsfeld, 
			GROUP_CONCAT(DISTINCT tx_gvffb_zertifikationen.uid SEPARATOR ', ') AS zertifikation
		FROM
			fe_users
			LEFT JOIN fe_users_tx_gvffb_geschaeftsfelder_mm ON fe_users_tx_gvffb_geschaeftsfelder_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_geschaeftsfelder ON tx_gvffb_geschaeftsfelder.uid = fe_users_tx_gvffb_geschaeftsfelder_mm.uid_foreign
			LEFT JOIN fe_users_tx_gvffb_taetigkeiten_mm ON fe_users_tx_gvffb_taetigkeiten_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_taetigkeiten ON tx_gvffb_taetigkeiten.uid = fe_users_tx_gvffb_taetigkeiten_mm.uid_foreign
			LEFT JOIN fe_users_tx_gvffb_zertifikationen_mm ON fe_users_tx_gvffb_zertifikationen_mm.uid_local = fe_users.uid
			LEFT JOIN tx_gvffb_zertifikationen ON tx_gvffb_zertifikationen.uid = fe_users_tx_gvffb_zertifikationen_mm.uid_foreign
		WHERE
			fe_users.uid = ".$uid."
		GROUP BY
			fe_users.uid";

		#$res = mysql_query(TYPO3_db,$query);
		$res = mysql_query( $query) or die("Fehler in query: ". $query ."<br>". mysql_error());
		
		$this->piVars['db'] = mysql_fetch_assoc( $res);
		
		$this->piVars['db3']['tx_gvffb_taetigkeiten'] = explode(", ",$this->piVars['db']['taetigkeit']);
		$this->piVars['db3']['tx_gvffb_geschaeftsfelder'] = explode(", ",$this->piVars['db']['geschaeftsfeld']);
		$this->piVars['db3']['tx_gvffb_zertifikationen'] = explode(", ",$this->piVars['db']['zertifikation']);
		
		$res = mysql_query('SELECT uid, taetigkeit FROM tx_gvffb_taetigkeiten ORDER BY taetigkeit');
		while($row = mysql_fetch_assoc($res))
		{
			$taetigkeiten[$row['uid']] = $row['taetigkeit'];
		}

		$res = mysql_query('SELECT uid, zertifikation FROM tx_gvffb_zertifikationen ORDER BY zertifikation');
		while($row = mysql_fetch_assoc($res))
		{
			$zertifikationen[$row['uid']] = $row['zertifikation'];
		}

		$res = mysql_query('SELECT uid, geschaeftsfeld FROM tx_gvffb_geschaeftsfelder ORDER BY geschaeftsfeld');
		while($row = mysql_fetch_assoc($res))
		{
			$geschaeftsfelder[$row['uid']] = $row['geschaeftsfeld'];
		}
		$content .= '
			<h2>Eigene Daten bearbeiten</h2>

			 <form id="std_form" method="POST" action="'.$this->pi_getPageLink($GLOBALS["TSFE"]->page["uid"],$target = '',array()).'">
            
            <input type="hidden" name="no_cache" value="1" />
            
			<fieldset>
				<legend>Logindaten</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][username]">Username*</label>
					<input type="text" name="'.$this->prefixId.'[db][username]" value="'.$this->piVars['db']['username'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][password]">Password*</label>
					<input type="password" name="'.$this->prefixId.'[db][password]" value="'.$this->piVars['db']['password'].'">
				</div>
			</fieldset>
			<fieldset>
				<legend>Kontaktdaten</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][company]">Firma*</label>
					<input type="text" name="'.$this->prefixId.'[db][company]" value="'.$this->piVars['db']['company'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][address]">Stra&szlig;e / Hausnummer</label>
					<input type="text" name="'.$this->prefixId.'[db][address]" value="'.$this->piVars['db']['address'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][zip]">Postleitzahl</label>
					<input type="text" name="'.$this->prefixId.'[db][zip]" value="'.$this->piVars['db']['zip'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][city]">Stadt</label>
					<input type="text" name="'.$this->prefixId.'[db][city]" value="'.$this->piVars['db']['city'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][telephone]">Telefon</label>
					<input type="text" name="'.$this->prefixId.'[db][telephone]" value="'.$this->piVars['db']['telephone'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][fax]" ]">Fax</label>
					<input type="text" name="'.$this->prefixId.'[db][fax]" value="'.$this->piVars['db']['fax'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][email]">Email*</label>
					<input type="text" name="'.$this->prefixId.'[db][email]" value="'.$this->piVars['db']['email'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][www]">Webseite</label>
					<input type="text" name="'.$this->prefixId.'[db][www]" value="'.$this->piVars['db']['www'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][tx_gvffb_mobil]">Mobil</label>
					<input type="text" name="'.$this->prefixId.'[db][tx_gvffb_mobil]" value="'.$this->piVars['db']['tx_gvffb_mobil'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][comments]">Postfach</label>
					<input type="text" name="'.$this->prefixId.'[db][comments]" value="'.$this->piVars['db']['comments'].'">
				</div>
			</fieldset>';
	
		    $content .= '
			<fieldset>
				<legend>Ansprechpartner</legend>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][name]">Anrede</label>
					<input type="text" name="'.$this->prefixId.'[db][name]" value="'.$this->piVars['db']['name'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][first_name]">Vorname</label>
					<input type="text" name="'.$this->prefixId.'[db][first_name]" value="'.$this->piVars['db']['first_name'].'">
				</div>
				<div class="container clearfix">
					<label for="'.$this->prefixId.'[db][last_name]">Nachname</label>
					<input type="text" name="'.$this->prefixId.'[db][last_name]" value="'.$this->piVars['db']['last_name'].'">
				</div>
			</fieldset>';
				
			$content .='
			<fieldset>
				<legend>T&auml;tigkeiten</legend>';
				foreach($taetigkeiten as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_taetigkeiten][]" value="'.$key.'" '.(in_array($key,$this->piVars['db3']['tx_gvffb_taetigkeiten'])?'checked="true"':'').' id="taetigkeit_'. $key .'" style="width:35px;" /><label class="wide" for="taetigkeit_'. $key .'">'. htmlentities($val, ENT_NOQUOTES, "ISO8859-1") .'</label></div>';
				}

			$content .='
			</fieldset>
			<fieldset>
				<legend>Gesch&auml;ftsfelder</legend>';
				foreach( $geschaeftsfelder as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_geschaeftsfelder][]" value="'.$key.'" '.(in_array($key,$this->piVars['db3']['tx_gvffb_geschaeftsfelder'])?'checked="true"':'').' id="geschaeftsfeld_'. $key .'" style="width:35px;" /><label class="wide" for="geschaeftsfeld_'. $key .'">'. htmlentities($val, ENT_NOQUOTES, "ISO8859-1") .'</label></div>';
				}


			$content .='
			</fieldset>
			<fieldset>
				<legend>Zertifikationen</legend>';
				foreach($zertifikationen as $key=>$val) {
					$content .= '<div class="container nomargin clearfix" style="margin:3px 0"><input type="checkbox" name="'.$this->prefixId.'[db3][tx_gvffb_zertifikationen][]" value="'.$key.'" '.(in_array($key,$this->piVars['db3']['tx_gvffb_zertifikationen'])?'checked="true"':'').' id="zertifikat_'. $key .'" style="width:35px;" /><label class="wide" for="zertifikat_'. $key .'">'. str_replace( "&nbsp;", " ", htmlentities($val, ENT_NOQUOTES, "ISO8859-1")) .'</label></div>';
				}

			$content .= '
			</fieldset>
			<div class="container clearfix">
				<label for="'.$this->prefixId.'[db][tx_gvffb_freitext]" class="legend">Freies Textfeld</label>
				<br class="clear" />
				<textarea class="big" name="'.$this->prefixId.'[db][tx_gvffb_freitext]">'.$this->piVars['db']['tx_gvffb_freitext'].'</textarea>
			</div>
			<div class="container clearfix">
				<input class="submit_button nomargin_submit_button" type="submit" name="'.$this->prefixId.'[db2][submit]" value="Daten senden">
			</div>
			</form><br>';
		
		unset( $this->piVars['db3']);

		return $content;
	}

	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi3/class.tx_gvffb_pi3.php']) {
	#include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gv_ffb/pi3/class.tx_gvffb_pi3.php']);
}
?>

