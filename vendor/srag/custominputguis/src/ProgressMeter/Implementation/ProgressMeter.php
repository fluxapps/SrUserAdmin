<?php

/* Copyright (c) 2017 Ralph Dittrich <dittrich@qualitus.de> Extended GPL, see docs/LICENSE */

namespace srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Implementation;

use ILIAS\UI\Implementation\Component\ComponentHelper;
use srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Component\ProgressMeter as ProgressMeterComponent;

/**
 * Class ProgressMeter
 *
 * @package srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Implementation
 *
 * @author  Ralph Dittrich <dittrich@qualitus.de>
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ProgressMeter implements ProgressMeterComponent {

	use ComponentHelper;
	/**
	 * @var int
	 */
	protected $maximum;
	/**
	 * @var int
	 */
	private $required;
	/**
	 * @var int
	 */
	protected $main;
	/**
	 * @var int
	 */
	protected $comparison;


	/**
	 * @inheritdoc
	 */
	public function __construct($maximum, $main, $required = NULL, $comparison = NULL) {
		$this->checkIntArg("maximum", $maximum);
		$this->maximum = $maximum;
		$this->checkIntArg("main", $main);
		$this->main = $this->getSafe($main);

		if ($required != NULL) {
			$this->checkIntArg("required", $required);
			$this->required = $this->getSafe($required);
		} else {
			$this->checkIntArg("required", $maximum);
			$this->required = $this->getSafe($maximum);
		}
		if ($comparison != NULL) {
			$this->checkIntArg("comparison", $comparison);
			$this->comparison = $this->getSafe($comparison);
		} else {
			$this->comparison = 0;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getMaximum() {
		return $this->maximum;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequired() {
		return $this->getSafe($this->required);
	}


	/**
	 * Get required value as percent
	 *
	 * @return int
	 */
	public function getRequiredAsPercent() {
		return $this->getAsPercentage($this->required);
	}


	/**
	 * @inheritdoc
	 */
	public function getMainValue() {
		return $this->getSafe($this->main);
	}


	/**
	 * Get main value as percent
	 *
	 * @return int
	 */
	public function getMainValueAsPercent() {
		return $this->getAsPercentage($this->main);
	}


	/**
	 * Get integer value "1" if a value is negative or "maximum" if value is more then maximum
	 *
	 * @param int $a_int
	 *
	 * @return int
	 */
	protected function getSafe($a_int) {
		return (($a_int < 0) ? 0 : ($a_int > $this->getMaximum() ? $this->getMaximum() : $a_int));
	}


	/**
	 * get an integer value as percent value
	 *
	 * @param int $a_int
	 *
	 * @return int
	 */
	protected function getAsPercentage($a_int) {
		return round(100 / $this->getMaximum() * $this->getSafe($a_int), 0, PHP_ROUND_HALF_UP);
	}
}
