#
# Table structure for table 'tx_blsvsa2013_domain_model_schulen'
#
CREATE TABLE tx_blsvsa2013_domain_model_schulen (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	schulnummer varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	schulart int(11) DEFAULT '0' NOT NULL,
	strasse varchar(255) DEFAULT '' NOT NULL,
	plz varchar(255) DEFAULT '' NOT NULL,
	ort varchar(255) DEFAULT '' NOT NULL,
	telefon varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	bezirk int(11) DEFAULT '0' NOT NULL,
	kreis int(11) DEFAULT '0' NOT NULL,
	blsvkreis int(11) DEFAULT '0' NOT NULL,
	bankempfaenger varchar(255) DEFAULT '' NOT NULL,
	kto varchar(255) DEFAULT '' NOT NULL,
	blz varchar(255) DEFAULT '' NOT NULL,
	verwendungszweck varchar(255) DEFAULT '' NOT NULL,
	grundschulen int(11) DEFAULT '0' NOT NULL,
	schulwettbewerb int(11) DEFAULT '0' NOT NULL,
	anzschueler int(11) DEFAULT '0' NOT NULL,
	anzteilnahmeberechtigt int(11) DEFAULT '0' NOT NULL,
	anzbestanden int(11) DEFAULT '0' NOT NULL,
	feuser int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_blsvsa2013_domain_model_schueler'
#
CREATE TABLE tx_blsvsa2013_domain_model_schueler (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	vorname varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	geschlecht int(11) DEFAULT '0' NOT NULL,
	geburtstag int(11) DEFAULT '0' NOT NULL,
	anzteilnahmen int(11) DEFAULT '0' NOT NULL,
	punktegesamt int(11) DEFAULT '0' NOT NULL,
	urkundenart int(11) DEFAULT '0' NOT NULL,
	gedruckt int(11) DEFAULT '0' NOT NULL,
	drucktstamp int(11) DEFAULT '0' NOT NULL,
	klasse varchar(255) DEFAULT '' NOT NULL,
	grundschulwettbewerb int(11) DEFAULT '0' NOT NULL,
	schwimmnachweis tinyint(1) unsigned DEFAULT '0' NOT NULL,
	gueltigbis int(11) DEFAULT '0' NOT NULL,
	leistungstabelle1 int(11) DEFAULT '0' NOT NULL,
	ablagedatum1 int(11) DEFAULT '0' NOT NULL,
	pruefer1 int(11) DEFAULT '0' NOT NULL,
	ergebnis1 int(11) DEFAULT '0' NOT NULL,
	punkte1 int(11) DEFAULT '0' NOT NULL,
	leistungstabelle2 int(11) DEFAULT '0' NOT NULL,
	ablagedatum2 int(11) DEFAULT '0' NOT NULL,
	pruefer2 int(11) DEFAULT '0' NOT NULL,
	ergebnis2 int(11) DEFAULT '0' NOT NULL,
	punkte2 int(11) DEFAULT '0' NOT NULL,
	leistungstabelle3 int(11) DEFAULT '0' NOT NULL,
	ablagedatum3 int(11) DEFAULT '0' NOT NULL,
	pruefer3 int(11) DEFAULT '0' NOT NULL,
	ergebnis3 int(11) DEFAULT '0' NOT NULL,
	punkte3 int(11) DEFAULT '0' NOT NULL,
	leistungstabelle4 int(11) DEFAULT '0' NOT NULL,
	ablagedatum4 int(11) DEFAULT '0' NOT NULL,
	pruefer4 int(11) DEFAULT '0' NOT NULL,
	ergebnis4 int(11) DEFAULT '0' NOT NULL,
	punkte4 int(11) DEFAULT '0' NOT NULL,
	schule int(11) unsigned DEFAULT '0',
	leistung1 int(11) unsigned DEFAULT '0',
	leistung2 int(11) unsigned DEFAULT '0',
	leistung3 int(11) unsigned DEFAULT '0',
	leistung4 int(11) unsigned DEFAULT '0',
	feuser int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	schule int(11) unsigned DEFAULT '0',
	feuser int(11) unsigned DEFAULT '0',

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_blsvsa2013_domain_model_leistungstabelle'
#
CREATE TABLE tx_blsvsa2013_domain_model_leistungstabelle (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	leistungbronze varchar(10) DEFAULT '1' NOT NULL,
	leistungsilber varchar(10) DEFAULT '2' NOT NULL,
	leistunggold varchar(10) DEFAULT '3' NOT NULL,
	sportart int(11) unsigned DEFAULT '0',
	altersgruppe int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_blsvsa2013_domain_model_sportarten'
#
CREATE TABLE tx_blsvsa2013_domain_model_sportarten (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	sportartgruppe int(11) DEFAULT '0' NOT NULL,
	ergebnisart int(11) DEFAULT '0' NOT NULL,
	reihenfolge int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_blsvsa2013_domain_model_altersgruppen'
#
CREATE TABLE tx_blsvsa2013_domain_model_altersgruppen (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	bezeichnung text NOT NULL,
	geschlecht int(11) DEFAULT '0' NOT NULL,
	altervon int(11) DEFAULT '0' NOT NULL,
	alterbis int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);