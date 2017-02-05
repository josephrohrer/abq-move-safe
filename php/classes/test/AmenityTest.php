<?php
namespace Edu\Cnm\Abquery\DataDesign\Test;

use Edu\Cnm\Abquery\DataDesign\{Amenity};

// grab the project test parameters
require_once("DataDesignTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUnit test for the Amenity class
 *
 * This is a complete PHPUnit test of the Amenity class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @author Jennifer Quay Minnich <jminnich@cnm.edu>
 **/

class AmenityTest extends DataDesignTest {
	/**
	 * name of the Amenity
	 * @var string $VALID_AMENITYNAME
	 **/
	protected $VALID_AMENITYNAME = "PHPUnit test passing";
	/**
	 * city name of the Amenity
	 * @var string $VALID_AMENITYCITYNAME
	 **/
	protected $VALID_AMENITYCITYNAME = "PHPUnit test passing";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test Amenity
		$this->profile = new Profile(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Amenity and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAmenity() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("amenity");

		// create a new Amenity and insert it into mySQL
		$amenity = new Amenity(null, $this->VALID_AMENITYNAME, $this->VALID_AMENITYCITYNAME);
		$amenity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAmenity = Amenity::getAmenityByAmenityId($this->getPDO(), $amenity->getAmenityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("amenity"));
	}
	/**
	 * test inserting an Amenity that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAmenity() {
		// create an Amenity with a non null amenity id and watch it fail
		$amenity = new Amenity(AbqueryTest::INVALID_KEY, $this->VALID_AMENITYNAME, $this->VALID_AMENITYCITYNAME);
		$amenity->insert($this->getPDO());
	}
	/**
	 * test grabbing an Amenity by amenity name
	 **/
	public function testGetValidAmenityByAmenityName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("amenity");

		// create a new Amenity and insert it into mySQL
		$amenity = new Amenity(null, $this->VALID_AMENITYNAME, $this->VALID_AMENITYCITYNAME);
		$amenity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Amenity::getAmenityByAmenityName($this->getPDO(), $amenity->getAmenityName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("amenity"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Abquery\\DataDesign\\Amenity", $results);

		// grab the result from the array and validate it
		$pdoAmenity = $results[0];
		$this->assertEquals($pdoAmenity->getAmenityName(), $this->VALID_AMENITYNAME);
		$this->assertEquals($pdoAmenity->getAmenityCityName(), $this->VALID_AMENITYCITYNAME);
	}
}