<?php

namespace srag\DIC\SrUserAdmin\Plugin;

/**
 * Interface Pluginable
 *
 * @package srag\DIC\SrUserAdmin\Plugin
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Pluginable {

	/**
	 * @return PluginInterface
	 */
	public function getPlugin()/*: PluginInterface*/
	;


	/**
	 * @param PluginInterface $plugin
	 */
	public function setPlugin(PluginInterface $plugin)/*: void*/
	;
}
