<div class="uk-height-1-1" style="padding-top:5px;">
  <div class="uk-height-1-1 uk-grid-small uk-child-width-1-3@m" uk-grid>
    <div class="uk-width-expand uk-height-1-1" listar-productos></div>
    <div class="uk-height-1-1 uk-flex uk-flex-column">
      <div class="field has-addons uk-margin-small">
        <div class="control uk-flex-1">
          <input input-search-categoria class="input" type="search" placeholder="Buscar categoria">
        </div>
        <div class="control">
          <button btn-add-categoria type="button" class="button is-info">
            Nueva
          </button>
        </div>
      </div>
      <div class="uk-height-1-1 uk-overflow-auto">
        <ul class="uk-list-divider" listar-categorias>
          <?php foreach ($db2->buscar_categoria() as $c): $D->c = $c; ?>
            <?php load_template('categorias.li') ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
