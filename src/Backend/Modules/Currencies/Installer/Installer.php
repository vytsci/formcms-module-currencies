<?php

namespace Backend\Modules\Currencies\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Class Installer
 * @package Backend\Modules\Currencies\Installer
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        $this->addModule('Currencies');

        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->makeSearchable('Currencies');

        $this->setModuleRights(1, 'Currencies');

        $this->setActionRights(1, 'Currencies', 'Add');
        $this->setActionRights(1, 'Currencies', 'Edit');
        $this->setActionRights(1, 'Currencies', 'Delete');
        $this->setActionRights(1, 'Currencies', 'Settings');

        $this->insertExtra('Currencies', 'widget', 'Selection');

        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            'Currencies',
            'currencies/settings',
            array(
                'currencies/add',
                'currencies/edit'
            )
        );
    }
}
