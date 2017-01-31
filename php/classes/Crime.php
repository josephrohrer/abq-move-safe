<?php

/**
 * Classes for the crime entity
 *
 * These are the classes for the crime entity including the accessor and mutator methods
 *
 * @author bgilbert9@cnm.edu
 */
class Crime implements \JsonSerializable {
	/**
	 * id for each individual crime as provided by the city data, this is a primary key
	 * @var int $crimeId
	 */
	private $crimeId;
	/**
	 * basic block location of the crime as provided by the city data
	 * @var string &crimeLocation
	 */
	private $crimeLocation;
	/**
	 * type of crime committed i.e. robbery, auto theft, etc. this ia a ghost entity
	 * @var string $crimeDescription
	 */
	private $crimeDescription;
	/**
	 * spatial coordinates that can be used to place the crime on a map
	 * @var point $crimeGeometry
	 */
	private $crimeGeometry;
	/**
	 * the date on which the crime was reported
	 * @var datetime $crimeDate
	 */
	private $crimeDate;


	/**
	 * constructor for the crime entity
	 *
	 * @param int $newCrimeId id of a specific crime
	 * @param string $newCrimeLocation block-level location that the crime was committed
	 * @param string $newCrimeDescription the type of crime that was committed
	 * @param point $newCrimeGeometry coordinates near where the crime was committed
	 * @param datetime $newCrimeDate date on which the crime was reported
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newCrimeId, string $newCrimeLocation, string $newCrimeDescription, point $newCrimeGeometry, datetime $newCrimeDate) {
		try {
			$this->setCrimeId($newCrimeId);
			$this->setCrimeLocation($newCrimeLocation);
			$this->setCrimeDescription($newCrimeDescription);
			$this->setCrimeGeometry($newCrimeGeometry);
			$this->setCrimeDate($newCrimeDate);
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
	 * accessor method for crimeId
	 *
	 * @return int value for crime id
	 */
	public function getCrimeId() {
		return ($this->crimeId);
	}


	/**
	 * mutator for crimeId
	 *
	 * @param int $newCrimeId new value of crime id
	 * @throws \RangeException if $newCrimeId is not positive
	 * @throws \TypeError if $newCrimeId is not an integer
	 */
	public function setCrimeId(int $newCrimeId) {
		if($newCrimeId <= 0) {
			throw(new \RangeException("crime id is not positive"));
		}
		$this->crimeId = $newCrimeId;
	}


	/**
	 * accessor for crimeLocation
	 *
	 * @return string value of crime location content
	 */
	public function getCrimeLocation() {
		return ($this->crimeLocation);
	}


	/**
	 * mutator method for crime location
	 *
	 * @param string $newCrimeLocation new value of crime location
	 * @throws \InvalidArgumentException if $newCrimeLocation is insecure
	 * @throws \RangeException if $newCrimeLocation is > 72 characters
	 * @throws \TypeError if $newCrimeLocation is not a string
	 */
	public function setCrimeLocation(string $newCrimeLocation) {
		$newCrimeLocation = trim($newCrimeLocation);
		$newCrimeLocation = filter_var($newCrimeLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCrimeLocation) === true) {
			throw(new \InvalidArgumentException("crime location is empty or insecure"));
		}
		if(strlen($newCrimeLocation) > 72) {
			throw(new \RangeException("crime location too large"));
		}
		$this->crimeLocation = $newCrimeLocation;
	}


	/**
	 * accessor method for crime geometry
	 *
	 * @return point value of crime gemoetry
	 */
	public function getCrimeGeometry() {
		return($this->crimeGeometry);
	}


	/**
	 * mutator method for crime geometry
	 *
	 * @param point $newCrimegemoetry new value of crime geometry
	 */


	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}