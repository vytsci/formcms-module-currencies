<?php

namespace Backend\Modules\Currencies\Actions;

use Backend\Core\Engine\Base\ActionAdd as BackendBaseActionAdd;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Common\Modules\Currencies\Engine\Model as CommonCurrenciesModel;
use Common\Modules\Currencies\Engine\Currency;

/**
 * Class Add
 * @package Backend\Modules\Currencies\Actions
 */
class Add extends BackendBaseActionAdd
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
        parent::execute();

        $this->currency = new Currency();

        $this->loadForm();
        $this->validateForm();

        $this->parse();
        $this->display();
    }

    /**
     * Load the form
     */
    private function loadForm()
    {
        $this->frm = new BackendForm('add');

        $this->frm->addText('code');
        $this->frm->addText('ratio');
        $this->frm->addText('symbol');
        $this->frm->addDropdown('format', CommonCurrenciesModel::getFormatsForDropdown());
        $this->frm->addCheckbox('default');
    }

    /**
     * Validate the form
     */
    private function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            $this->frm->cleanupFields();

            $this->frm->getField('code')->isFilled(BL::err('FieldIsRequired'));
            $this->frm->getField('ratio')->isFilled(BL::err('FieldIsRequired'));
            $this->frm->getField('symbol')->isFilled(BL::err('FieldIsRequired'));
            $this->frm->getField('format')->isFilled(BL::err('FieldIsRequired'));

            if ($this->frm->isCorrect()) {
                $this->currency
                    ->setCode($this->frm->getField('code')->getValue())
                    ->setRatio($this->frm->getField('ratio')->getValue())
                    ->setSymbol($this->frm->getField('symbol')->getValue())
                    ->setFormat($this->frm->getField('format')->getValue())
                    ->setDefault($this->frm->getField('default')->isChecked())
                    ->save();

                BackendModel::triggerEvent(
                    $this->getModule(),
                    'after_add',
                    array('item' => $this->currency->toArray())
                );

                $this->redirect(
                    BackendModel::createURLForAction('Settings').'&report=added&var='.
                    urlencode($this->currency->getCode()).'&highlight='.$this->currency->getCode()
                );
            }
        }
    }
}
