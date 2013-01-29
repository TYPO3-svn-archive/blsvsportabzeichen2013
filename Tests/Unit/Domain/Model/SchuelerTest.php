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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Schueler.
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
class Tx_Blsvsa2013_Domain_Model_SchuelerTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Schueler
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Schueler();
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
	public function getGeschlechtReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setGeschlechtForStringSetsGeschlecht() { 
		$this->fixture->setGeschlecht(1);

		$this->assertSame(
			1,
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
	public function getGrundschulwettbewerbReturnsInitialValueForBoolean() { 
		$this->assertSame(
			FALSE,
			$this->fixture->getGrundschulwettbewerb()
		);
	}

	/**
	 * @test
	 */
	public function setGrundschulwettbewerbForBooleanSetsGrundschulwettbewerb() { 
		$this->fixture->setGrundschulwettbewerb(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getGrundschulwettbewerb()
		);
	}
	
	/**
	 * @test
	 */
	public function getStrasseReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setStrasseForStringSetsStrasse() { 
		$this->fixture->setStrasse('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getStrasse()
		);
	}
	
	/**
	 * @test
	 */
	public function getPlzReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPlzForStringSetsPlz() { 
		$this->fixture->setPlz('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPlz()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrtReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrtForStringSetsOrt() { 
		$this->fixture->setOrt('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrt()
		);
	}
	
	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail() { 
		$this->fixture->setEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getTelefonReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTelefonForStringSetsTelefon() { 
		$this->fixture->setTelefon('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTelefon()
		);
	}
	
	/**
	 * @test
	 */
	public function getJahrderletztenpruefungReturnsInitialValueForInteger() { 
		$this->assertSame(
			2000,
			$this->fixture->getJahrderletztenpruefung()
		);
	}

	/**
	 * @test
	 */
	public function setJahrderletztenpruefungForIntegerSetsJahrderletztenpruefung() { 
		$this->fixture->setJahrderletztenpruefung(12);

		$this->assertSame(
			12,
			$this->fixture->getJahrderletztenpruefung()
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
	public function getSchulnummerReturnsInitialValueForInteger() {
		$this->assertSame(
				'0',
				$this->fixture->getSchulnummer()
		);
	}
	
	/**
	 * @test
	 */
	public function setSchulnummerForIntegerSetsSchulnummer() {
		$this->fixture->setSchulnummer('9013');
	
		$this->assertSame(
				'9013',
				$this->fixture->getSchulnummer()
		);
	}
	
	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function setSchulnummerEquals0throwsInvalidArgumentException() {
		$this->fixture->setSchulnummer('0');
	
	}
	
	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function setSchulnummerEqualsNullthrowsInvalidArgumentException() {
		$this->fixture->setSchulnummer(Null);
	
	}
	
	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function setSchulnummerEqualsEmptyStringthrowsInvalidArgumentException() {
		$this->fixture->setSchulnummer('');
	
	}
	
	
	
}
?>