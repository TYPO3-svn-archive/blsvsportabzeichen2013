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
 * Test case for class Tx_Blsvsa2013_Domain_Model_Artikel.
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
class Tx_Blsvsa2013_Domain_Model_ArtikelTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Blsvsa2013_Domain_Model_Artikel
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Blsvsa2013_Domain_Model_Artikel();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getArtikelnummerReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setArtikelnummerForStringSetsArtikelnummer() { 
		$this->fixture->setArtikelnummer('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getArtikelnummer()
		);
	}
	
	/**
	 * @test
	 */
	public function getArtikelReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setArtikelForStringSetsArtikel() { 
		$this->fixture->setArtikel('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getArtikel()
		);
	}
	
	/**
	 * @test
	 */
	public function getPreisReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPreis()
		);
	}

	/**
	 * @test
	 */
	public function setPreisForIntegerSetsPreis() { 
		$this->fixture->setPreis(12);

		$this->assertSame(
			12,
			$this->fixture->getPreis()
		);
	}
	
}
?>