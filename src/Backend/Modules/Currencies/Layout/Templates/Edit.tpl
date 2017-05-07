{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$msgEdit|sprintf:{$item.code}|ucfirst}</h2>
  </div>
</div>
{form:edit}
  <div class="row fork-module-content">
    <div class="col-md-12">
      <div class="form-group">
        <label for="code">{$lblCode|ucfirst}</label>
        {$txtCode} {$txtCodeError}
      </div>
      <div class="form-group">
        <label for="ratio">{$lblRatio|ucfirst}</label>
        {$txtRatio} {$txtRatioError}
      </div>
      <div class="form-group">
        <label for="symbol">{$lblSymbol|ucfirst}</label>
        {$txtSymbol} {$txtSymbolError}
      </div>
      <div class="form-group">
        <label for="format">{$lblFormat|ucfirst}</label>
        {$ddmFormat} {$ddmFormatError}
      </div>
      <div class="form-group">
        <ul class="list-unstyled">
          <li class="checkbox">
            <label for="default">{$chkDefault} {$lblDefault|ucfirst}</label>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row fork-page-actions">
    <div class="col-md-12">
      <div class="btn-toolbar">
        <div class="btn-group pull-left" role="group">
          {option:showCurrenciesDelete}
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete">
            <span class="glyphicon glyphicon-trash"></span>
            {$lblDelete|ucfirst}
          </button>
          {/option:showCurrenciesDelete}
        </div>
        <div class="btn-group pull-right" role="group">
          <button id="editButton" type="submit" name="edit" class="btn btn-primary">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp;
            {$lblEdit|ucfirst}
          </button>
        </div>
      </div>
      {option:showCurrenciesDelete}
      <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="{$lblDelete|ucfirst}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <span class="modal-title h4">{$lblDelete|ucfirst}</span>
            </div>
            <div class="modal-body">
              <p>{$msgConfirmDelete|sprintf:{$item.code}}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{$lblCancel|ucfirst}</button>
              <a href="{$var|geturl:'delete'}&amp;id={$item.code}" class="btn btn-primary">
                {$lblOK|ucfirst}
              </a>
            </div>
          </div>
        </div>
      </div>
      {/option:showCurrenciesDelete}
    </div>
  </div>
{/form:edit}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
