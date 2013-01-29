<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Berti Golf <berti.golf@blsv.de>, BLSV
 *  			Martin Gonschor <martin.gonschOr@blsv.de>, blsv
 *  			
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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Teilnahmen.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Sportabzeichen online 2013
 *
 * @author Berti Golf <berti.golf@blsv.de>
 * @author Martin Gonschor <martin.gonschOr@blsv.de>
 */
class Tx_Blsvsa2013_Domain_Model_TeilnahmenTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Teilnahmen
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Teilnahmen();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getVornameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setVornameForStringSetsVorname() { 
		$this->fixture->setVorname('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getVorname()
		);
	}
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getGeschlechtReturnsInitialValueForInteger() { 
		$this->assertSame(
			1,
			$this->fixture->getGeschlecht()
		);
	}

	/**
	 * @test
	 */
	public function setGeschlechtForIntegerSetsGeschlecht() { 
		$this->fixture->setGeschlecht(12);

		$this->assertSame(
			12,
			$this->fixture->getGeschlecht()
		);
	}
	
	/**
	 * @test
	 */
	public function getGeburtstagReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getGeburtstag()
		);
	}

	/**
	 * @test
	 */
	public function setGeburtstagForIntegerSetsGeburtstag() { 
		$this->fixture->setGeburtstag(12);

		$this->assertSame(
			12,
			$this->fixture->getGeburtstag()
		);
	}
	
	/**
	 * @test
	 */
	public function getAnzteilnahmenReturnsInitialValueForInteger() { 
		$this->assertSame(
			1,
			$this->fixture->getAnzteilnahmen()
		);
	}

	/**
	 * @test
	 */
	public function setAnzteilnahmenForIntegerSetsAnzteilnahmen() { 
		$this->fixture->setAnzteilnahmen(12);

		$this->assertSame(
			12,
			$this->fixture->getAnzteilnahmen()
		);
	}
	
	/**
	 * @test
	 */
	public function getPunktegesamtReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPunktegesamt()
		);
	}

	/**
	 * @test
	 */
	public function setPunktegesamtForIntegerSetsPunktegesamt() { 
		$this->fixture->setPunktegesamt(12);

		$this->assertSame(
			12,
			$this->fixture->getPunktegesamt()
		);
	}
	
	/**
	 * @test
	 */
	public function getUrkundenartReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getUrkundenart()
		);
	}

	/**
	 * @test
	 */
	public function setUrkundenartForIntegerSetsUrkundenart() { 
		$this->fixture->setUrkundenart(12);

		$this->assertSame(
			12,
			$this->fixture->getUrkundenart()
		);
	}
	
	/**
	 * @test
	 */
	public function getGedrucktReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getGedruckt()
		);
	}

	/**
	 * @test
	 */
	public function setGedrucktForIntegerSetsGedruckt() { 
		$this->fixture->setGedruckt(12);

		$this->assertSame(
			12,
			$this->fixture->getGedruckt()
		);
	}
	
	/**
	 * @test
	 */
	public function getDrucktstampReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getDrucktstamp()
		);
	}

	/**
	 * @test
	 */
	public function setDrucktstampForIntegerSetsDrucktstamp() { 
		$this->fixture->setDrucktstamp(12);

		$this->assertSame(
			12,
			$this->fixture->getDrucktstamp()
		);
	}
	
	/**
	 * @test
	 */
	public function getKlasseReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setKlasseForStringSetsKlasse() { 
		$this->fixture->setKlasse('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getKlasse()
		);
	}
	
	/**
	 * @test
	 */
	public function getGrundschulwettbewerbReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getGrundschulwettbewerb()
		);
	}

	/**
	 * @test
	 */
	public function setGrundschulwettbewerbForIntegerSetsGrundschulwettbewerb() { 
		$this->fixture->setGrundschulwettbewerb(12);

		$this->assertSame(
			12,
			$this->fixture->getGrundschulwettbewerb()
		);
	}
	
	/**
	 * @test
	 */
	public function getSchwimmnachweisgueltigbisReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getSchwimmnachweisgueltigbis()
		);
	}

	/**
	 * @test
	 */
	public function setSchwimmnachweisgueltigbisForIntegerSetsSchwimmnachweisgueltigbis() { 
		$this->fixture->setSchwimmnachweisgueltigbis(12);

		$this->assertSame(
			12,
			$this->fixture->getSchwimmnachweisgueltigbis()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistungstabelle1ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getLeistungstabelle1()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungstabelle1ForIntegerSetsLeistungstabelle1() { 
		$this->fixture->setLeistungstabelle1(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungstabelle1()
		);
	}
	
	/**
	 * @test
	 */
	public function getAblagedatum1ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAblagedatum1()
		);
	}

	/**
	 * @test
	 */
	public function setAblagedatum1ForIntegerSetsAblagedatum1() { 
		$this->fixture->setAblagedatum1(12);

		$this->assertSame(
			12,
			$this->fixture->getAblagedatum1()
		);
	}
	
	/**
	 * @test
	 */
	public function getPruefer1ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPruefer1()
		);
	}

	/**
	 * @test
	 */
	public function setPruefer1ForIntegerSetsPruefer1() { 
		$this->fixture->setPruefer1(12);

		$this->assertSame(
			12,
			$this->fixture->getPruefer1()
		);
	}
	
	/**
	 * @test
	 */
	public function getErgebnis1ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getErgebnis1()
		);
	}

	/**
	 * @test
	 */
	public function setErgebnis1ForIntegerSetsErgebnis1() { 
		$this->fixture->setErgebnis1(12);

		$this->assertSame(
			12,
			$this->fixture->getErgebnis1()
		);
	}
	
	/**
	 * @test
	 */
	public function getPunkte1ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPunkte1()
		);
	}

	/**
	 * @test
	 */
	public function setPunkte1ForIntegerSetsPunkte1() { 
		$this->fixture->setPunkte1(12);

		$this->assertSame(
			12,
			$this->fixture->getPunkte1()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistungstabelle2ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getLeistungstabelle2()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungstabelle2ForIntegerSetsLeistungstabelle2() { 
		$this->fixture->setLeistungstabelle2(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungstabelle2()
		);
	}
	
	/**
	 * @test
	 */
	public function getAblagedatum2ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAblagedatum2()
		);
	}

	/**
	 * @test
	 */
	public function setAblagedatum2ForIntegerSetsAblagedatum2() { 
		$this->fixture->setAblagedatum2(12);

		$this->assertSame(
			12,
			$this->fixture->getAblagedatum2()
		);
	}
	
	/**
	 * @test
	 */
	public function getPruefer2ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPruefer2()
		);
	}

	/**
	 * @test
	 */
	public function setPruefer2ForIntegerSetsPruefer2() { 
		$this->fixture->setPruefer2(12);

		$this->assertSame(
			12,
			$this->fixture->getPruefer2()
		);
	}
	
	/**
	 * @test
	 */
	public function getErgebnis2ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getErgebnis2()
		);
	}

	/**
	 * @test
	 */
	public function setErgebnis2ForIntegerSetsErgebnis2() { 
		$this->fixture->setErgebnis2(12);

		$this->assertSame(
			12,
			$this->fixture->getErgebnis2()
		);
	}
	
	/**
	 * @test
	 */
	public function getPunkte2ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPunkte2()
		);
	}

	/**
	 * @test
	 */
	public function setPunkte2ForIntegerSetsPunkte2() { 
		$this->fixture->setPunkte2(12);

		$this->assertSame(
			12,
			$this->fixture->getPunkte2()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistungstabelle3ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getLeistungstabelle3()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungstabelle3ForIntegerSetsLeistungstabelle3() { 
		$this->fixture->setLeistungstabelle3(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungstabelle3()
		);
	}
	
	/**
	 * @test
	 */
	public function getAblagedatum3ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAblagedatum3()
		);
	}

	/**
	 * @test
	 */
	public function setAblagedatum3ForIntegerSetsAblagedatum3() { 
		$this->fixture->setAblagedatum3(12);

		$this->assertSame(
			12,
			$this->fixture->getAblagedatum3()
		);
	}
	
	/**
	 * @test
	 */
	public function getPruefer3ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPruefer3()
		);
	}

	/**
	 * @test
	 */
	public function setPruefer3ForIntegerSetsPruefer3() { 
		$this->fixture->setPruefer3(12);

		$this->assertSame(
			12,
			$this->fixture->getPruefer3()
		);
	}
	
	/**
	 * @test
	 */
	public function getErgebnis3ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getErgebnis3()
		);
	}

	/**
	 * @test
	 */
	public function setErgebnis3ForIntegerSetsErgebnis3() { 
		$this->fixture->setErgebnis3(12);

		$this->assertSame(
			12,
			$this->fixture->getErgebnis3()
		);
	}
	
	/**
	 * @test
	 */
	public function getPunkte3ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPunkte3()
		);
	}

	/**
	 * @test
	 */
	public function setPunkte3ForIntegerSetsPunkte3() { 
		$this->fixture->setPunkte3(12);

		$this->assertSame(
			12,
			$this->fixture->getPunkte3()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistungstabelle4ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getLeistungstabelle4()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungstabelle4ForIntegerSetsLeistungstabelle4() { 
		$this->fixture->setLeistungstabelle4(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungstabelle4()
		);
	}
	
	/**
	 * @test
	 */
	public function getAblagedatum4ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAblagedatum4()
		);
	}

	/**
	 * @test
	 */
	public function setAblagedatum4ForIntegerSetsAblagedatum4() { 
		$this->fixture->setAblagedatum4(12);

		$this->assertSame(
			12,
			$this->fixture->getAblagedatum4()
		);
	}
	
	/**
	 * @test
	 */
	public function getPruefer4ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPruefer4()
		);
	}

	/**
	 * @test
	 */
	public function setPruefer4ForIntegerSetsPruefer4() { 
		$this->fixture->setPruefer4(12);

		$this->assertSame(
			12,
			$this->fixture->getPruefer4()
		);
	}
	
	/**
	 * @test
	 */
	public function getErgebnis4ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getErgebnis4()
		);
	}

	/**
	 * @test
	 */
	public function setErgebnis4ForIntegerSetsErgebnis4() { 
		$this->fixture->setErgebnis4(12);

		$this->assertSame(
			12,
			$this->fixture->getErgebnis4()
		);
	}
	
	/**
	 * @test
	 */
	public function getPunkte4ReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPunkte4()
		);
	}

	/**
	 * @test
	 */
	public function setPunkte4ForIntegerSetsPunkte4() { 
		$this->fixture->setPunkte4(12);

		$this->assertSame(
			12,
			$this->fixture->getPunkte4()
		);
	}
	
	/**
	 * @test
	 */
	public function getPruefungsjahrReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPruefungsjahr()
		);
	}

	/**
	 * @test
	 */
	public function setPruefungsjahrForIntegerSetsPruefungsjahr() { 
		$this->fixture->setPruefungsjahr(12);

		$this->assertSame(
			12,
			$this->fixture->getPruefungsjahr()
		);
	}
	
	/**
	 * @test
	 */
	public function getSchuleReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Schulen() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getSchule()
		);
	}

	/**
	 * @test
	 */
	public function setSchuleForTx_Blsvsa2013_Domain_Model_SchulenSetsSchule() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Schulen();
		$this->fixture->setSchule($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getSchule()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistung1ReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Leistungstabelle() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getLeistung1()
		);
	}

	/**
	 * @test
	 */
	public function setLeistung1ForTx_Blsvsa2013_Domain_Model_LeistungstabelleSetsLeistung1() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Leistungstabelle();
		$this->fixture->setLeistung1($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getLeistung1()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistung2ReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Leistungstabelle() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getLeistung2()
		);
	}

	/**
	 * @test
	 */
	public function setLeistung2ForTx_Blsvsa2013_Domain_Model_LeistungstabelleSetsLeistung2() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Leistungstabelle();
		$this->fixture->setLeistung2($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getLeistung2()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistung3ReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Leistungstabelle() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getLeistung3()
		);
	}

	/**
	 * @test
	 */
	public function setLeistung3ForTx_Blsvsa2013_Domain_Model_LeistungstabelleSetsLeistung3() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Leistungstabelle();
		$this->fixture->setLeistung3($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getLeistung3()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistung4ReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Leistungstabelle() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getLeistung4()
		);
	}

	/**
	 * @test
	 */
	public function setLeistung4ForTx_Blsvsa2013_Domain_Model_LeistungstabelleSetsLeistung4() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Leistungstabelle();
		$this->fixture->setLeistung4($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getLeistung4()
		);
	}
	
	/**
	 * @test
	 */
	public function getFeuserReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Feuser() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getFeuser()
		);
	}

	/**
	 * @test
	 */
	public function setFeuserForTx_Blsvsa2013_Domain_Model_FeuserSetsFeuser() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Feusers();
		$this->fixture->setFeuser($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getFeuser()
		);
	}
	
	/**
	 * @test
	 */
	public function getSchuelerReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Schueler() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getSchueler()
		);
	}

	/**
	 * @test
	 */
	public function setSchuelerForTx_Blsvsa2013_Domain_Model_SchuelerSetsSchueler() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Schueler();
		$this->fixture->setSchueler($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getSchueler()
		);
	}
	
	/**
	 * @test
	 */
	public function getSchulnummerReturnsInitialValueForInteger1() {
		$this->assertSame(
				'0',
				$this->fixture->getSchulnummer()
		);
	}
	
	/**
	 * @test
	 */
	public function setSchulnummerSetsSchulnummer() {
		$this->fixture->setSchulnummer('9013');
	
		$this->assertSame(
				'9013',
				$this->fixture->getSchulnummer()
		);
	}

	/**
	 * @test
	 */
	public function getBestellungReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Bestellung() {
		$this->assertEquals(
				NULL,
				$this->fixture->getBestellung()
		);
	}
	
	/**
	 * @test
	 */
	public function setBestellungForTx_Blsvsa2013_Domain_Model_BestellungSetsBestellung() {
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Bestellung();
		$this->fixture->setBestellung($dummyObject);
	
		$this->assertSame(
				$dummyObject,
				$this->fixture->getBestellung()
		);
	}
	
}
?>