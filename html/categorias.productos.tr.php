<tr>
  <td class="uk-table-shrink"><?=$D->p->id?></td>
  <td class="uk-table-shrink"></td>
  <td class="uk-table-expand">
    <?php if (!$D->p->estado): ?>
      <small class="is-size-7 has-text-danger">Inactivo</small>
    <?php endif; ?>
    <?=$D->p->nombre_producto?>
  </td>
  <td class="uk-table-shrink"><?=toMoney($D->p->precio)?></td>
  <td class="uk-table-shrink">
    <div class="field has-addons">
      <div class="control">
        <button btn-edit-producto="<?=$D->p->id?>" style="padding: 0 20px;" class="button is-small is-info is-outlined uk-border-none">
          <span class="icon is-small">
            <span class="material-icons-outlined">edit</span>
          </span>
        </button>
      </div>
      <div class="control">
        <button btn-delete-producto="<?=$D->p->id?>" style="padding: 0 20px;" class="button is-small is-danger is-outlined uk-border-none">
          <span class="icon is-small">
            <span class="material-icons-outlined">delete</span>
          </span>
        </button>
      </div>
    </div>
  </td>
</tr>
