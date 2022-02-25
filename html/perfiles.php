<div class="uk-height-1-1" style="padding-top:5px;">
  <div class="uk-height-1-1 uk-grid-small uk-child-width-1-3@m" uk-grid>
    <div class="uk-width-expand uk-height-1-1" listar-users></div>
    <div class="uk-height-1-1 uk-flex uk-flex-column">
      <div class="uk-flex uk-flex-middle">
        <div class="uk-flex-1"></div>
        <div class="">
          <button btn-add-perfil type="button" class="button is-info">
            Nuevo
          </button>
        </div>
      </div>
      <div class="uk-height-1-1 uk-overflow-auto">
        <ul class="uk-list-divider" listar-perfiles>
          <?php foreach ($db2->get_perfiles() as $p): $D->p = $p; ?>
            <?php load_template('perfiles.li') ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
