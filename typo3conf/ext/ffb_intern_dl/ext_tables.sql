#
# Table structure for table 'tx_ffbinterndl_items'
#
CREATE TABLE tx_ffbinterndl_items (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	dateititle varchar(255) DEFAULT '' NOT NULL,
	datei text,
	beschreibung text,
	screenshot text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);