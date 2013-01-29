create view tx_blsvsa2013_domain_model_urkunden as

select 
concat(schulen.uid, '-', teilnahmen.uid) as uid,

if((teilnahmen.drucktstamp = 0),0,if((teilnahmen.tstamp = teilnahmen.drucktstamp),1,2)) AS status,

schulen.uid AS schule_uid,
schulen.schulnummer AS schule_schulnummer,
schulen.name AS schule_name,
schulen.schulart AS schule_schulart,
schulen.strasse AS schule_strasse,
schulen.plz AS schule_plz,
schulen.ort AS schule_ort,
schulen.telefon AS schule_telefon,
schulen.email AS schule_email,
schulen.bezirk AS schule_bezirk,
schulen.kreis AS schule_kreis,
schulen.blsvkreis AS schule_blsvkreis,
schulen.bankempfaenger AS schule_bankempfaenger,
schulen.kto AS schule_kto,
schulen.blz AS schule_blz,
schulen.verwendungszweck AS schule_verwendungszweck,
schulen.grundschulen AS schule_grundschulen,
schulen.schulwettbewerb AS schule_schulwettbewerb,
schulen.anzschueler AS schule_anzschueler,
schulen.anzteilnahmeberechtigt AS schule_anzteilnahmeberechtigt,
schulen.anzbestanden AS schule_anzbestanden,
schulen.fegroup AS schule_fegroup,
schulen.feuser AS schule_feuser,
schulen.institutionsartart AS schule_institutionsartart,

teilnahmen.klasse AS teilnahmen_klasse,
teilnahmen.uid AS teilnahmen_uid,
teilnahmen.name AS teilnahmen_nachname,
teilnahmen.vorname AS teilnahmen_vorname,
teilnahmen.geschlecht AS teilnahmen_geschlecht,
teilnahmen.anzteilnahmen AS teilnahmen_pruefungen,
teilnahmen.gedruckt AS teilnahmen_gedruckt ,
teilnahmen.punktegesamt AS teilnahmen_punktegesamt,

-- Urkundendatum
if (drucktstamp=0, 
	date_format(now(),'%d.%m.%Y'),
	date_format(from_unixtime(teilnahmen.drucktstamp), '%d.%m.%Y')
) datum,


-- Alter
(year(now()) - year((from_unixtime(0) + interval teilnahmen.geburtstag second))) AS teilnahmen_alter,



-- Abzeichenname
if(((year(now()) - year((from_unixtime(0) + interval teilnahmen.geburtstag second))) >= 18), 

-- Erwachsene
concat(
	if (teilnahmen.punktegesamt>10, 
	 'Gold',
	 if (teilnahmen.punktegesamt>=8, 
	 'Silber',
	 'Bronze'
	 )
	),
	' ',
	teilnahmen.anzteilnahmen
)

, -- Jugendliche
	if (teilnahmen.punktegesamt>10, 
	 'Gold',
	 if (teilnahmen.punktegesamt>=8, 
	 'Silber',
	 'Bronze'
	 )
)


) AS teilnahmen_abzeichenname,

-- Abzeichenzusatz Jugendliche/Erwachsene
if(((year(now()) - year((from_unixtime(0) + interval teilnahmen.geburtstag second))) >= 18), 'e', 'j') AS teilnahmen_abzeichenzusatz,

teilnahmen.drucktstamp teilnahmen_drucktstamp,
teilnahmen.tstamp teilnahmen_tstamp


from (tx_blsvsa2013_domain_model_teilnahmen teilnahmen 
left join tx_blsvsa2013_domain_model_schulen schulen on((teilnahmen.schule = schulen.uid))) 
where (teilnahmen.anzteilnahmen > 0);