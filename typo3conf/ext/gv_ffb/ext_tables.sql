#
# Table structure for table 'tx_gvffb_taetigkeiten'
#
CREATE TABLE tx_gvffb_taetigkeiten (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	taetigkeit tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_gvffb_geschaeftsfelder'
#
CREATE TABLE tx_gvffb_geschaeftsfelder (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	geschaeftsfeld tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_gvffb_zertifikationen'
#
CREATE TABLE tx_gvffb_zertifikationen (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	zertifikation tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'fe_users_tx_gvffb_taetigkeiten_mm'
# 
#
CREATE TABLE fe_users_tx_gvffb_taetigkeiten_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);




#
# Table structure for table 'fe_users_tx_gvffb_geschaeftsfelder_mm'
# 
#
CREATE TABLE fe_users_tx_gvffb_geschaeftsfelder_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);




#
# Table structure for table 'fe_users_tx_gvffb_zertifikationen_mm'
# 
#
CREATE TABLE fe_users_tx_gvffb_zertifikationen_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	tx_gvffb_taetigkeiten int(11) DEFAULT '0' NOT NULL,
	tx_gvffb_geschaeftsfelder int(11) DEFAULT '0' NOT NULL,
	tx_gvffb_zertifikationen int(11) DEFAULT '0' NOT NULL,
	tx_gvffb_zweigstelle int(11) DEFAULT '0' NOT NULL,
	tx_gvffb_mobil tinytext,
	tx_gvffb_freitext text
);