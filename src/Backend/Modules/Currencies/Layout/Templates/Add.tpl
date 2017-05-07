{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblAdd|ucfirst}</h2>
  </div>
</div>
{form:add}
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
  <div class="row fork-module-actions">
    <div class="col-md-12">
      <div class="btn-toolbar">
        <div class="btn-group pull-right" role="group">
          <button id="addButton" type="submit" name="add" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;
            {$lblAdd|ucfirst}
          </button>
        </div>
      </div>
    </div>
  </div>
{/form:add}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
