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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Schulen.
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
class Tx_Blsvsa2013_Domain_Model_SchulenTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Schulen();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getSchulnummerReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSchulnummerForStringSetsSchulnummer() { 
		$this->fixture->setSchulnummer('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSchulnummer()
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
	public function getSchulartReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getSchulart()
		);
	}

	/**
	 * @test
	 */
	public function setSchulartForIntegerSetsSchulart() { 
		$this->fixture->setSchulart(12);

		$this->assertSame(
			12,
			$this->fixture->getSchulart()
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
	public function getBezirkReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getBezirk()
		);
	}

	/**
	 * @test
	 */
	public function setBezirkForIntegerSetsBezirk() { 
		$this->fixture->setBezirk(12);

		$this->assertSame(
			12,
			$this->fixture->getBezirk()
		);
	}
	
	/**
	 * @test
	 */
	public function getKreisReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getKreis()
		);
	}

	/**
	 * @test
	 */
	public function setKreisForIntegerSetsKreis() { 
		$this->fixture->setKreis(12);

		$this->assertSame(
			12,
			$this->fixture->getKreis()
		);
	}
	
	/**
	 * @test
	 */
	public function getBlsvkreisReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getBlsvkreis()
		);
	}

	/**
	 * @test
	 */
	public function setBlsvkreisForIntegerSetsBlsvkreis() { 
		$this->fixture->setBlsvkreis(12);

		$this->assertSame(
			12,
			$this->fixture->getBlsvkreis()
		);
	}
	
	/**
	 * @test
	 */
	public function getBankempfaengerReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setBankempfaengerForStringSetsBankempfaenger() { 
		$this->fixture->setBankempfaenger('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBankempfaenger()
		);
	}
	
	/**
	 * @test
	 */
	public function getKtoReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setKtoForStringSetsKto() { 
		$this->fixture->setKto('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getKto()
		);
	}
	
	/**
	 * @test
	 */
	public function getBlzReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setBlzForStringSetsBlz() { 
		$this->fixture->setBlz('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBlz()
		);
	}
	
	/**
	 * @test
	 */
	public function getVerwendungszweckReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setVerwendungszweckForStringSetsVerwendungszweck() { 
		$this->fixture->setVerwendungszweck('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getVerwendungszweck()
		);
	}
	
	/**
	 * @test
	 */
	public function getGrundschulenReturnsInitialValueForInteger() { 
		$this->assertSame(
			false,
			$this->fixture->getGrundschulen()
		);
	}

	/**
	 * @test
	 */
	public function setGrundschulenForIntegerSetsGrundschulen() { 
		$this->fixture->setGrundschulen(true);

		$this->assertSame(
			true,
			$this->fixture->getGrundschulen()
		);
	}
	
	/**
	 * @test
	 */
	public function getSchulwettbewerbReturnsInitialValueForInteger() { 
		$this->assertSame(
			false,
			$this->fixture->getSchulwettbewerb()
		);
	}

	/**
	 * @test
	 */
	public function setSchulwettbewerbForIntegerSetsSchulwettbewerb() { 
		$this->fixture->setSchulwettbewerb(12);

		$this->assertSame(
			12,
			$this->fixture->getSchulwettbewerb()
		);
	}
	
	/**
	 * @test
	 */
	public function getAnzschuelerReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAnzschueler()
		);
	}

	/**
	 * @test
	 */
	public function setAnzschuelerForIntegerSetsAnzschueler() { 
		$this->fixture->setAnzschueler(12);

		$this->assertSame(
			12,
			$this->fixture->getAnzschueler()
		);
	}
	
	/**
	 * @test
	 */
	public function getAnzteilnahmeberechtigtReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAnzteilnahmeberechtigt()
		);
	}

	/**
	 * @test
	 */
	public function setAnzteilnahmeberechtigtForIntegerSetsAnzteilnahmeberechtigt() { 
		$this->fixture->setAnzteilnahmeberechtigt(12);

		$this->assertSame(
			12,
			$this->fixture->getAnzteilnahmeberechtigt()
		);
	}
	
	/**
	 * @test
	 */
	public function getAnzbestandenReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAnzbestanden()
		);
	}

	/**
	 * @test
	 */
	public function setAnzbestandenForIntegerSetsAnzbestanden() { 
		$this->fixture->setAnzbestanden(12);

		$this->assertSame(
			12,
			$this->fixture->getAnzbestanden()
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
	public function getInstitutionsartartReturnsInitialValueForTTx_Blsvsa2013_Domain_Model_Institutionsartart() {
		$this->assertEquals(
				NULL,
				$this->fixture->getInstitutionsartart()
		);
	}
	
	/**
	 * @test
	 */
	public function setInstitutionsartartForTx_Blsvsa2013_Domain_Model_Institutionsartart() {
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Institutionsartart();
		$this->fixture->setInstitutionsartart($dummyObject);
	
		$this->assertSame(
				$dummyObject,
				$this->fixture->getInstitutionsartart()
		);
	}
	
}
?>