Demand if plugin data should be removed on uninstall

### Usage

#### Composer
First add the following to your `composer.json` file:
```json
"require": {
  "srag/removeplugindataconfirm": ">=0.1.0"
},
```

And run a `composer install`.

If you deliver your plugin, the plugin has it's own copy of this library and the user doesn't need to install the library.

Tip: Because of multiple autoloaders of plugins, it could be, that different versions of this library exists and suddenly your plugin use an older or a newer version of an other plugin!

So I recommand to use [srag/librariesnamespacechanger](https://packagist.org/packages/srag/librariesnamespacechanger) in your plugin.

#### Use
First declare your plugin class like follow:
```php
//...
use srag\RemovePluginDataConfirm\SrUserAdmin\PluginUninstallTrait;
//...
use PluginUninstallTrait;
//...
const PLUGIN_CLASS_NAME = self::class;
const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = XRemoveDataConfirm::class;
//...
/**
 * @inheritdoc
 */
protected function deleteData()/*: void*/ {
    // TODO: Delete your plugin data in this method
}
//...
```
`XRemoveDataConfirm` is the name of your remove data confirm class.
You don't need to use `DICTrait`, it is already in use!

If your plugin is a RepositoryObject use `RepositoryObjectPluginUninstallTrait` instead:
```php
//...
use srag\RemovePluginDataConfirm\SrUserAdmin\RepositoryObjectPluginUninstallTrait;
//...
use RepositoryObjectPluginUninstallTrait;
//...
```

Remove also the methods `beforeUninstall`, `afterUninstall`, `beforeUninstallCustom` and `uninstallCustom` in your plugin class.

Then create a class called `XRemoveDataConfirm` in `classes/uninstall/class.XRemoveDataConfirm.php`:
```php
<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\RemovePluginDataConfirm\SrUserAdmin\AbstractRemovePluginDataConfirm;

/**
 * Class XRemoveDataConfirm
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy XRemoveDataConfirm: ilUIPluginRouterGUI
 */
class XRemoveDataConfirm extends AbstractRemovePluginDataConfirm {

    const PLUGIN_CLASS_NAME = ilXPlugin::class;
}

```
`ilXPlugin` is the name of your plugin class ([DICTrait](https://github.com/studer-raimann/DIC)).
Replace the `X` in `XRemoveDataConfirm` with your plugin name.
You don't need to use `DICTrait`, it is already in use!

Then you need to declare some language variables like:
English:
```
removeplugindataconfirm_cancel#:#Cancel
removeplugindataconfirm_confirm_remove_data#:#Do you want to remove the %1$s data as well? At most, you just want to disable the %1$s plugin?
removeplugindataconfirm_deactivate#:#Just deactivate %1$s plugin
removeplugindataconfirm_data#:#%1$s data
removeplugindataconfirm_keep_data#:#Keep %1$s data
removeplugindataconfirm_msg_kept_data#:#The %1$s data was kept
removeplugindataconfirm_msg_removed_data#:#The %1$s data was also removed
removeplugindataconfirm_remove_data#:#Remove %1$s data
```
German:
```
removeplugindataconfirm_cancel#:#Abbrechen
removeplugindataconfirm_confirm_remove_data#:#Möchten Sie die %1$s-Daten auch entfernen? Allenfalls möchten Sie das %1$s-Plugin nur deaktivieren?
removeplugindataconfirm_deactivate#:#%1$s-Plugin nur deaktivieren
removeplugindataconfirm_data#:#%1$s-Daten
removeplugindataconfirm_keep_data#:#%1$s-Daten behalten
removeplugindataconfirm_msg_kept_data#:#Die %1$s-Daten wurden behalten
removeplugindataconfirm_msg_removed_data#:#Die %1$s-Daten wurden auch entfernt
removeplugindataconfirm_remove_data#:#Entferne %1$s-Daten
```
If you want you can modify these. The `%1$s` placeholder is the name of your plugin.

Notice to also adjust `dbupdate.php` so it can be reinstalled if the data should already exists!

If you want to use this library, but don't want to confirm to remove data, you can disable it with add the follow to your `ilXPlugin` class:
```php
//...
const REMOVE_PLUGIN_DATA_CONFIRM = false;
//...
```
### Dependencies
* PHP >=5.6
* [composer](https://getcomposer.org)
* [srag/dic](https://packagist.org/packages/srag/dic)

Please use it for further development!

### Adjustment suggestions
* Adjustment suggestions by pull requests on https://git.studer-raimann.ch/ILIAS/Plugins/RemovePluginDataConfirm/tree/develop
* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/LRPDC
* Bug reports under https://jira.studer-raimann.ch/projects/LRPDC
* For external users please send an email to support-custom1@studer-raimann.ch

### Development
If you want development in this library you should install this library like follow:

Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/libraries
cd Customizing/global/libraries
git clone -b develop git@git.studer-raimann.ch:ILIAS/Plugins/RemovePluginDataConfirm.git RemovePluginDataConfirm
```
