<?php

/* Copyright (c) 2017 Ralph Dittrich <dittrich@qualitus.de> Extended GPL, see docs/LICENSE */

namespace srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Implementation;

use srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Component\Factory as FactoryComponent;

/**
 * Class Factory
 *
 * @package srag\CustomInputGUIs\SrUserAdmin\ProgressMeter\Implementation
 *
 * @author  Ralph Dittrich <dittrich@qualitus.de>
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryComponent {

	/**
	 * @inheritdoc
	 */
	public function standard($maximum, $main, $required = NULL, $comparison = NULL) {
		return new Standard($maximum, $main, $required, $comparison);
	}


	/**
	 * @inheritdoc
	 */
	public function fixedSize($maximum, $main, $required = NULL, $comparison = NULL) {
		return new FixedSize($maximum, $main, $required, $comparison);
	}


	/**
	 * @inheritdoc
	 */
	public function mini($maximum, $main, $required = NULL) {
		return new Mini($maximum, $main, $required);
	}
}
