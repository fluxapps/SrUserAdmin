<?php

namespace srag\RemovePluginDataConfirm\SrUserAdmin;

use ilUIPluginRouterGUI;
use srag\DIC\SrUserAdmin\DICTrait;
use srag\RemovePluginDataConfirm\SrUserAdmin\Exception\RemovePluginDataConfirmException;

/**
 * Trait AbstractPluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\SrUserAdmin
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @access  namespace
 */
trait AbstractPluginUninstallTrait {

	use DICTrait;

	/* *
	 * @var bool
	 *
	 * TODO: Implement Constants in Traits in PHP Core
	 * /
	const REMOVE_PLUGIN_DATA_CONFIRM = true;*/
	/* *
	 * @var string
	 *
	 * @abstract
	 *
	 * TODO: Implement Constants in Traits in PHP Core
	 * /
	const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = "";*/

	/**
	 * @var AbstractRemovePluginDataConfirm[]
	 *
	 * @internal
	 */
	private static $remove_plugin_data_confirm_classes = [];


	/**
	 * @param bool $remove_data
	 *
	 * @return bool
	 * @throws RemovePluginDataConfirmException
	 *
	 * @internal
	 */
	protected final function pluginUninstall(/*bool*/
		$remove_data = true)/*: bool*/ {
		$remove_plugin_data_confirm_class = self::getRemovePluginDataConfirmClass();
		$remove_plugin_data_confirm_class_name = static::REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME;

		$uninstall_removes_data = $remove_plugin_data_confirm_class->getUninstallRemovesData();

		if ($uninstall_removes_data === NULL) {
			if (self::getRemovePluginDataConfirmConst()) {
				$remove_plugin_data_confirm_class_name::saveParameterByClass();

				self::dic()->ctrl()->redirectByClass([
					ilUIPluginRouterGUI::class,
					$remove_plugin_data_confirm_class_name
				], $remove_plugin_data_confirm_class_name::CMD_CONFIRM_REMOVE_DATA);

				return false;
			} else {
				$uninstall_removes_data = true;
				$remove_plugin_data_confirm_class->setUninstallRemovesData($uninstall_removes_data);
			}
		}

		$uninstall_removes_data = boolval($uninstall_removes_data);

		if ($remove_data) {
			if ($uninstall_removes_data) {
				$this->deleteData();
			}

			$remove_plugin_data_confirm_class->removeUninstallRemovesData();
		}

		return true;
	}


	/**
	 * Delete your plugin data in this method
	 */
	protected abstract function deleteData()/*: void*/
	;


	/**
	 * @return bool
	 *
	 * @internal
	 */
	private static final function getRemovePluginDataConfirmConst()/*: bool*/ {
		if (defined("static::REMOVE_PLUGIN_DATA_CONFIRM")) {
			return boolval(static::REMOVE_PLUGIN_DATA_CONFIRM);
		} else {
			return true;
		}
	}


	/**
	 * @return AbstractRemovePluginDataConfirm
	 * @throws RemovePluginDataConfirmException Class not exists!
	 * @throws RemovePluginDataConfirmException Class not extends AbstractRemovePluginDataConfirm!
	 *
	 * @internal
	 */
	protected static final function getRemovePluginDataConfirmClass()/*: AbstractRemovePluginDataConfirm*/ {
		self::checkRemovePluginDataConfirmClassNameConst();

		$remove_plugin_data_confirm_class_name = static::REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME;

		if (!isset(self::$remove_plugin_data_confirm_classes[$remove_plugin_data_confirm_class_name])) {
			if (!class_exists($remove_plugin_data_confirm_class_name)) {
				throw new RemovePluginDataConfirmException("Class $remove_plugin_data_confirm_class_name not exists!", RemovePluginDataConfirmException::CODE_INVALID_REMOVE_PLUGIN_DATA_CONFIRM_CLASS);
			}

			if (!method_exists($remove_plugin_data_confirm_class_name, "getInstance")) {
				throw new RemovePluginDataConfirmException("Class $remove_plugin_data_confirm_class_name not extends AbstractRemovePluginDataConfirm!", RemovePluginDataConfirmException::CODE_INVALID_REMOVE_PLUGIN_DATA_CONFIRM_CLASS);
			}

			$remove_plugin_data_confirm_class = $remove_plugin_data_confirm_class_name::getInstance();

			if (!$remove_plugin_data_confirm_class instanceof AbstractRemovePluginDataConfirm) {
				throw new RemovePluginDataConfirmException("Class $remove_plugin_data_confirm_class_name not extends AbstractRemovePluginDataConfirm!", RemovePluginDataConfirmException::CODE_INVALID_REMOVE_PLUGIN_DATA_CONFIRM_CLASS);
			}

			self::$remove_plugin_data_confirm_classes[$remove_plugin_data_confirm_class_name] = $remove_plugin_data_confirm_class;
		}

		return self::$remove_plugin_data_confirm_classes[$remove_plugin_data_confirm_class_name];
	}


	/**
	 * @throws RemovePluginDataConfirmException Your class needs to implement the REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME constant!
	 *
	 * @internal
	 */
	private static final function checkRemovePluginDataConfirmClassNameConst()/*: void*/ {
		if (!defined("static::REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME") || empty(static::REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME)) {
			throw new RemovePluginDataConfirmException("Your class needs to implement the REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME constant!", RemovePluginDataConfirmException::CODE_MISSING_CONST_REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME);
		}
	}
}
