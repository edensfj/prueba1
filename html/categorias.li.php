<div class="">
  <div class="uk-flex uk-flex-middle">
    <div class="uk-flex-1">
      <div class=""><?=$D->c->categoria?></div>
      <?php if (!$D->c->estado): ?>
        <span class="has-text-danger is-size-7"><?=$D->c->estadotext?></span>
      <?php endif; ?>
    </div>
    <div class="field has-addons">
      <div class="control">
        <button uk-tooltip="title:Visualizar los productos de esta categoria" btn-view-categoria="<?=$D->c->id?>" style="padding: 0 20px;" class="button is-small is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">view_list</span>
          </span>
        </button>
      </div>
      <div class="control">
        <button btn-edit-categoria="<?=$D->c->id?>" style="padding: 0 20px;" class="button is-small is-info is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">edit</span>
          </span>
        </button>
      </div>
      <div class="control">
        <button btn-delete-categoria="<?=$D->c->id?>" style="padding: 0 20px;" class="button is-small is-danger is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">delete</span>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>
