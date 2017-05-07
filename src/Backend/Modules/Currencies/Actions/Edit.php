<?php

namespace Backend\Modules\Currencies\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Common\Modules\Currencies\Engine\Model as CommonCurrenciesModel;
use Common\Modules\Currencies\Engine\Currency;

/**
 * Class Edit
 * @package Backend\Modules\Currencies\Actions
 */
class Edit extends BackendBaseActionEdit
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

        $this->id = $this->getParameter('id', 'string');
        $this->currency = new Currency($this->id);

        if (!$this->currency->isLoaded()) {
            $this->redirect(BackendModel::createURLForAction('Settings').'&error=non-existing');
        }

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
        $this->frm = new BackendForm('edit');

        $this->frm->addText('code', $this->currency->getCode());
        $this->frm->addText('ratio', $this->currency->getRatio());
        $this->frm->addText('symbol', $this->currency->getSymbol());
        $this->frm->addDropdown('format', CommonCurrenciesModel::getFormatsForDropdown(), $this->currency->getFormat());
        $this->frm->addCheckbox('default', $this->currency->isDefault());
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
                    'after_edit',
                    array('item' => $this->currency->toArray())
                );

                $this->redirect(
                    BackendModel::createURLForAction('Settings').'&report=edited&var='.
                    urlencode($this->currency->getCode()).'&highlight='.$this->currency->getCode()
                );
            }
        }
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        parent::parse();

        $this->tpl->assign('item', $this->currency->toArray());
    }
}
