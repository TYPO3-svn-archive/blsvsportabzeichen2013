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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Leistungstabelle.
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
class Tx_Blsvsa2013_Domain_Model_LeistungstabelleTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Leistungstabelle();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getLeistungbronzeReturnsInitialValueForInteger() { 
		$this->assertSame(
			1,
			$this->fixture->getLeistungbronze()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungbronzeForIntegerSetsLeistungbronze() { 
		$this->fixture->setLeistungbronze(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungbronze()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistungsilberReturnsInitialValueForInteger() { 
		$this->assertSame(
			2,
			$this->fixture->getLeistungsilber()
		);
	}

	/**
	 * @test
	 */
	public function setLeistungsilberForIntegerSetsLeistungsilber() { 
		$this->fixture->setLeistungsilber(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistungsilber()
		);
	}
	
	/**
	 * @test
	 */
	public function getLeistunggoldReturnsInitialValueForInteger() { 
		$this->assertSame(
			3,
			$this->fixture->getLeistunggold()
		);
	}

	/**
	 * @test
	 */
	public function setLeistunggoldForIntegerSetsLeistunggold() { 
		$this->fixture->setLeistunggold(12);

		$this->assertSame(
			12,
			$this->fixture->getLeistunggold()
		);
	}
	
	/**
	 * @test
	 */
	public function getSportartReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Sportarten() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getSportart()
		);
	}

	/**
	 * @test
	 */
	public function setSportartForTx_Blsvsa2013_Domain_Model_SportartenSetsSportart() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Sportarten();
		$this->fixture->setSportart($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getSportart()
		);
	}
	
	/**
	 * @test
	 */
	public function getAltersgruppeReturnsInitialValueForTx_Blsvsa2013_Domain_Model_Altersgruppen() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getAltersgruppe()
		);
	}

	/**
	 * @test
	 */
	public function setAltersgruppeForTx_Blsvsa2013_Domain_Model_AltersgruppenSetsAltersgruppe() { 
		$dummyObject = new Tx_Blsvsa2013_Domain_Model_Altersgruppen();
		$this->fixture->setAltersgruppe($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getAltersgruppe()
		);
	}
	
}
?>