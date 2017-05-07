<?php

namespace Backend\Modules\Currencies\Actions;

use Backend\Core\Engine\Base\ActionDelete as BackendBaseActionDelete;
use Backend\Core\Engine\Model as BackendModel;
use Common\Modules\Currencies\Engine\Model as CommonCurrenciesModel;
use Common\Modules\Currencies\Engine\Currency;

/**
 * Class Delete
 * @package Backend\Modules\Currencies\Actions
 */
class Delete extends BackendBaseActionDelete
{

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Execute the action
     */
    public function execute()
    {
        $this->id = $this->getParameter('id', 'string');
        $this->currency = new Currency($this->id);

        if ($this->currency->isLoaded()) {
            parent::execute();

            $this->currency->delete();

            BackendModel::triggerEvent(
                $this->getModule(),
                'after_delete',
                array('item' => $this->currency->toArray())
            );

            $this->redirect(
                BackendModel::createURLForAction('Settings').'&report=deleted&var='.
                urlencode($this->currency->getCode())
            );
        } else {
            $this->redirect(
                BackendModel::createURLForAction('Settings').'&error=non-existing'
            );
        }
    }
}
