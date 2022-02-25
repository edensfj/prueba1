<div class="">
  <div class="uk-flex uk-flex-middle">
    <div class="uk-flex-1">
      <div class=""><?=$D->p->perfil?></div>
    </div>
    <div class="field has-addons">
      <div class="control">
        <button uk-tooltip="title:Visualizar los usuarios en este perfil" btn-view-users="<?=$D->p->id?>" style="padding: 0 20px;" class="button is-small is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">people</span>
          </span>
        </button>
      </div>
      <div class="control">
        <button btn-edit-perfil="<?=$D->p->id?>" style="padding: 0 20px;" class="button is-small is-info is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">edit</span>
          </span>
        </button>
      </div>
      <div class="control">
        <button btn-delete-perfil="<?=$D->p->id?>" style="padding: 0 20px;" class="button is-small is-danger is-light">
          <span class="icon is-small">
            <span class="material-icons-outlined">delete</span>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>
