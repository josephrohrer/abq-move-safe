<?php
namespace Edu\Cnm\Abquery\Test;

use Edu\Cnm\Abquery\Amenity;
use Edu\Cnm\Abquery\Feature;
use Edu\Cnm\Abquery\Park;
use Edu\Cnm\Abquery\Point;

// grab the project test parameters
require_once("AbqueryTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Feature class
 *
 * This is a complete PHPUnit test of the Feature class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 * @see Tweet example
 * @author Benjamin Smith <bsmtih@cnm.edu>
 **/
class FeatureTest extends AbqueryTest {
	/**
	 * name of the Feature
	 * @var int $VALID_FEATUREVALUE
	 **/
	protected $VALID_FEATUREVALUE = 5;
	/**
	 * Amenity that created the feature; this is for foreign key relations
	 * @var Amenity amenity
	 */
	protected $amenity = null;

	/**
	 * Park that created the feature; this is for foreign key relations
	 * @var Park park
	 */
	protected $park = null;

	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert an Amenity to own the test Feature
		$this->amenity = new Amenity(9, "househouse", "dumbshit-house");
		$this->amenity->insert($this->getPDO());

		//create a stupid pos point to use in the park setUp
		$basePoint = new Point(12.12312312312312, 12.12312312312312);

		//create and insert a Park to own the test Feature
		$this->park = new Park(2, "park-for-lil-shits", $basePoint, 1);
		$this->park->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Feature and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFeature() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("feature");

		// create a new Feature and insert it into mySQL
		$feature = new Feature($this->amenity->getAmenityId(), $this->park->getParkId(), $this->VALID_FEATUREVALUE);
		$feature->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFeature = Feature::getFeatureByFeatureAmenityId($this->getPDO(), $feature->getFeatureAmenityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("feature"));
	}

	/**
	 * test inserting a feature that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidFeatureAmenityId() {
		// create an Feature with a non null feature amenity id and watch it fail
		$feature = new Feature(AbqueryTest::INVALID_KEY, $this->VALID_FEATUREVALUE, $this->amenity->getAmenityId(), $this->park->getParkId());
		$feature->insert($this->getPDO());
	}

	/**
	 * test grabbing a Feature by feature park id
	 **/
	public function testGetValidFeatureParkId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("feature");

		// create a new feature and insert it into mySQL
		$feature = new Feature($this->amenity->getAmenityId(),  $this->park->getParkId(), $this->VALID_FEATUREVALUE);
		$feature->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Feature::getFeatureByFeatureParkId($this->getPDO(), $feature->getFeatureParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("feature"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Abquery\\Feature", $results);

		// grab the result from the array and validate it
		$pdoFeature = $results[0];
		$this->assertEquals($pdoFeature->getFeatureAmenityId(), $this->amenity->getAmenityId());
		$this->assertEquals($pdoFeature->getFeatureParkId(), $this->park->getParkId());
		$this->assertEquals($pdoFeature->getFeatureValue(), $this->VALID_FEATUREVALUE);
	}
	/**
	 * test grabbing a Feature by an id that does not exist
	 **/
	public function testGetInvalidFeatureByFeatureAmenityId() {
		// grab a feature by searching for a name that does not exist
		$feature = Feature::getFeatureByFeatureAmenityId($this->getPDO(), 42);
		$this->assertCount(0, $feature);
	}
	/**
	 * test grabbing all Features
	 **/
	public function testGetAllValidFeatures() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("feature");

		// create a new Feature and insert to into mySQL
		$feature = new Feature($this->amenity->getAmenityId(), $this->park->getParkId(), $this->VALID_FEATUREVALUE);
		$feature->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Feature::getAllFeatures($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("feature"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Abquery\\Feature", $results);

		// grab the result from the array and validate it
		$pdoFeature = $results[0];
		$this->assertEquals($pdoFeature->getFeatureAmenityId(), $this->amenity->getAmenityId());
		$this->assertEquals($pdoFeature->getFeatureParkId(), $this->park->getParkId());
		$this->assertEquals($pdoFeature->getFeatureValue(), $this->VALID_FEATUREVALUE);
	}
}