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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Bestellung.
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
class Tx_Blsvsa2013_Domain_Model_BestellungTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Bestellung
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Bestellung();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getAnredeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAnredeForStringSetsAnrede() { 
		$this->fixture->setAnrede('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAnrede()
		);
	}
	
	/**
	 * @test
	 */
	public function getInstitutionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setInstitutionForStringSetsInstitution() { 
		$this->fixture->setInstitution('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getInstitution()
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
	public function getAdresszusatzReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAdresszusatzForStringSetsAdresszusatz() { 
		$this->fixture->setAdresszusatz('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAdresszusatz()
		);
	}
	
	/**
	 * @test
	 */
	public function getStrasseReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setStrasseForStringSetsStarsse() { 
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
	public function getAbweichnedelieferadresseReturnsInitialValueForBoolean() { 
		$this->assertSame(
			False,
			$this->fixture->getAbweichnedelieferadresse()
		);
	}

	/**
	 * @test
	 */
	public function setAbweichnedelieferadresseForBooleanSetsAbweichnedelieferadresse() { 
		$this->fixture->setAbweichnedelieferadresse(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getAbweichnedelieferadresse()
		);
	}
	
	/**
	 * @test
	 */
	public function getLieferinstitutionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLieferinstitutionForStringSetsLieferinstitution() { 
		$this->fixture->setLieferinstitution('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLieferinstitution()
		);
	}
	
	/**
	 * @test
	 */
	public function getLiefernameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLiefernameForStringSetsLiefername() { 
		$this->fixture->setLiefername('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLiefername()
		);
	}
	
	/**
	 * @test
	 */
	public function getLiefervornameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLiefervornameForStringSetsLiefervorname() { 
		$this->fixture->setLiefervorname('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLiefervorname()
		);
	}
	
	/**
	 * @test
	 */
	public function getLieferanredeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLieferanredeForStringSetsLieferanrede() { 
		$this->fixture->setLieferanrede('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLieferanrede()
		);
	}
	
	/**
	 * @test
	 */
	public function getLieferstrasseReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLieferstrasseForStringSetsLieferstrasse() { 
		$this->fixture->setLieferstrasse('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLieferstrasse()
		);
	}
	
	/**
	 * @test
	 */
	public function getLieferplzReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLieferplzForStringSetsLieferplz() { 
		$this->fixture->setLieferplz('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLieferplz()
		);
	}
	
	/**
	 * @test
	 */
	public function getLieferortReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLieferortForStringSetsLieferort() { 
		$this->fixture->setLieferort('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLieferort()
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
	public function getTeilnahmeReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Teilnahmen() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getTeilnahme()
		);
	}

	/**
	 * @test
	 */
	public function setTeilnahmeForTx_Blsvsa2013_Domain_Model_TeilnahmenSetsTeilnahme() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Teilnahmen();
		$this->fixture->setTeilnahme($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getTeilnahme()
		);
	}
	
	/**
	 * @test
	 */
	public function getErfassungsdatumReturnsInitialValueForInteger() {
		$this->assertEquals(
				0,
				$this->fixture->getErfassungsdatum()
		);
		
	}
	
	/**
	 * @test
	 */
	public function setErfassungsdatumForIntegerSetsErfassungsdatum() {
		$this->fixture->setErfassungsdatum( 2 );
	
		$this->assertSame(
				2,
				$this->fixture->getErfassungsdatum()
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
}
?>