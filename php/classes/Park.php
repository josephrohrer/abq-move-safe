<?php

/**
 * Classes for the Park entity
 *
 * These are the classes for the park entity including the accessor and mutator methods
 *
 * @author Joseph Rohrer <jrohrer@cnm.edu>
 *
 **/
class Park implements \JsonSerializable {
	/**
	 * id for each park as provided by ABQ city data; this is the primary key
	 * @var int $parkId
	 **/
	private $parkId;
	/**
	 * name of each park as provided by ABQ city data
	 * @var string $parkName
	 **/
	private $parkName;
	/**
	 * spatial coordinates that are used to put a center of the park on a map
	 * @var Point $parkGeometry
	 **/
	private $parkGeometry;
	/**
	 * boolean that will determine if park area is developed or undeveloped
	 * @var boolean $parkDeveloped
	 **/
	private $parkDeveloped;

	/**
	 * constructor for the Park class
	 *
	 * @param int $newParkId
	 * @param string $newParkName
	 * @param Point $newParkGeometry
	 * @param boolean $newParkDeveloped
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newParkId, string $newParkName, Point $newParkGeometry, boolean $newParkDeveloped) {
		try {
			$this->setParkId($newParkId);
			$this->setParkName($newParkName);
			$this->setParkGeometry($newParkGeometry);
			$this->setParkDeveloped($newParkDeveloped);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for park id
	 *
	 * @return int value of park id
	 **/
	public function getParkId() {
		return($this->parkId);
	}


	/**
	 * mutator method for park id
	 * @param int $newParkId new value of park id
	 * @throws \RangeException if $newParkId is not positive
	 * @throws \TypeError if $newParkId is not an integer
	 **/
	public function setParkId(int $newParkId) {
		if($newParkId <= 0) {
			throw(new \RangeException("park id is not positive"));
		}

		$this->parkId = $newParkId;
	}



	/**
	 * accessor method for park name
	 *
	 **/

	/**
	 * mutator method for park name
	 *
	 */

	/**
	 * accessor method for park geometry
	 *
	 **/

	/**
	 * mutator method for park geometry
	 *
	 */

	/**
	 * accessor method for park developed
	 *
	 **/

	/**
	 * mutator method for park developed
	 *
	 */

	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}


}