<?php
namespace Edu\Cnm\Abquery\Test;

use Edu\Cnm\Abquery\{
	Park, Point
};

// grab the project test parameters
require_once("AbqueryTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Park class
 *
 * This is a complete PHPUnit test of the Park class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 * @see Tweet example
 * @author Joseph Rohrer <jrohrer@cnm.edu>
 **/
class ParkTest extends AbqueryTest {
	/**
	 * valid value of park id
	 * @var int $VALID_PARKID
	 */
	protected $VALID_PARKID = 42;
	/**
	 * content of the park name
	 * @var string $VALID_PARKNAME
	 */
	protected $VALID_PARKNAME = "Park For Little Shits";
	/**
	 * content of the crime geometry
	 * @var Point $VALID_PARKGEOMETRY
	 */
	protected $VALID_PARKGEOMETRY = null;
	/**
	 * content of park developed
	 * @var int $VALID_PARKDEVELOPED
	 */
	protected $VALID_PARKDEVELOPED = 1;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		parent::setUp();

		$this->VALID_PARKGEOMETRY = new Point(35.10964229145246, -106.69703244562174);
		var_dump($this->VALID_PARKGEOMETRY);
	}

	/**
	 * test inserting a valid Park and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPark() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// create a new Park and insert it into mySQL
		$park = new Park($this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_PARKGEOMETRY, $this->VALID_PARKDEVELOPED);
		$park->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
	}

	/**
	 * test inserting a Park that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidPark() {
		// create a Park with a non null amenity id and watch it fail
		$park = new Park(AbqueryTest::INVALID_KEY, $this->VALID_PARKNAME, $this->VALID_PARKGEOMETRY, $this->VALID_PARKDEVELOPED);
		$park->insert($this->getPDO());
	}

	/**
	 * test grabbing all Parks
	 **/
	public function testGetAllValidParks() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// create a new Park and insert to into mySQL
		$park = new Park($this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_PARKGEOMETRY, $this->VALID_PARKDEVELOPED);
		$park->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Park::getAllParks($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Abquery\\Park", $results);

		// grab the result from the array and validate it
		$pdoPark = $results[0];
		$this->assertEquals($pdoPark->getParkId(), $this->VALID_PARKID);
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertEquals($pdoPark->getParkGeometry(), $this->VALID_PARKGEOMETRY);
		$this->assertEquals($pdoPark->getParkDeveloped(), $this->VALID_PARKDEVELOPED);
	}

}