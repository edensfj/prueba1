<div class="uk-height-1-1 uk-flex uk-flex-column">

  <div class="uk-flex uk-flex-middle">
    <div class="uk-flex-1">
      Productos en:
      [<?=$D->c->id?>] <strong><?=$D->c->categoria?></strong>
    </div>
    <div class="">
      <div class="field has-addons uk-margin-small">
        <div class="control" uk-tooltip="title:Seleccione este campo si desea buscar en todos los productos.">
          <label style="padding:0px 10px;" class="button">Todos<input type="checkbox" check-buscar-all></label>
        </div>
        <div class="control uk-flex-1">
          <input input-search-prodcutos class="input" type="search" placeholder="Buscar productos">
        </div>
        <div class="control">
          <button style="padding:0px 10px;" btn-add-producto type="button" class="button is-success is-outlined">
            <span class="material-icons-outlined">add_circle</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="uk-height-1-1 uk-overflow-auto">

    <table class="uk-table uk-table-small uk-table-middle uk-table-divider">
      <thead>
        <tr>
          <th class="uk-table-shrink">id</th>
          <th class="uk-table-shrink">img</th>
          <th class="uk-table-expand">producto</th>
          <th class="uk-table-shrink">precio</th>
          <th class="uk-table-shrink"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($D->productos as $p): $D->p = $p; ?>
          <?php load_template('categorias.productos.tr') ?>
        <?php endforeach; ?>
      </tbody>
    </table>


  </div>
</div>
