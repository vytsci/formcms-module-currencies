<?php

namespace Backend\Modules\Currencies\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\DataGrid as BackendDataGrid;
use Backend\Core\Engine\DataGridArray as BackendDataGridArray;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Common\Modules\Currencies\Engine\Model as CommonCurrenciesModel;

/**
 * Class Settings
 * @package Backend\Modules\Currencies\Actions
 */
class Settings extends BackendBaseActionIndex
{
    /**
     * Datagrids
     *
     * @var    BackendDataGrid
     */
    private $dgCurrencies;

    /**
     * Execute the action
     */
    public function execute()
    {
        // call parent, this will probably add some general CSS/JS or other required files
        parent::execute();

        // load datagrid
        $this->loadDataGrids();

        // parse page
        $this->parse();

        // display the page
        $this->display();
    }

    /**
     * @throws \Exception
     * @throws \SpoonDatagridException
     */
    private function loadDataGrids()
    {
        $this->dgCurrencies = new BackendDataGridArray(
	        CommonCurrenciesModel::getCurrencies(),
            BL::getWorkingLanguage()
        );

        $this->dgCurrencies->setColumnURL('code', BackendModel::createURLForAction('Edit') . '&amp;id=[code]');
        $this->dgCurrencies->addColumn(
            'edit',
            null,
            BL::lbl('Edit'),
            BackendModel::createURLForAction('Edit') . '&amp;id=[code]', BL::lbl('Edit')
        );
    }

    /**
     * @throws \SpoonTemplateException
     */
    protected function parse()
    {
        $this->tpl->assign(
            'dgCurrencies',
            $this->dgCurrencies->getNumResults() != 0?$this->dgCurrencies->getContent():false
        );
    }
}
