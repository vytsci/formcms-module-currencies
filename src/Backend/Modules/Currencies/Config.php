<?php

namespace Backend\Modules\Currencies;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Class Config
 * @package Backend\Modules\Currencies
 */
class Config extends BackendBaseConfig
{
    /**
     * The default action
     *
     * @var	string
     */
    protected $defaultAction = 'Settings';

    /**
     * The disabled actions
     *
     * @var	array
     */
    protected $disabledActions = array();
}
