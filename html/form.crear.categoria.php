<div class="">


<div class="">
  <label for="" class="">Nombre de categoria</label>
  <div class="control">
    <input type="text" name="categoria" class="input" value="<?=isset($D->c)?$D->c->categoria:''?>">
  </div>
</div>

<div class="">
  <label>
    <input type="checkbox" <?=isset($D->c)?($D->c->estado?'checked':''):'checked'?> name="estado">
    habilitar
  </label>
</div>

<div class="uk-margin-small">
  <?php if (isset($D->c)): ?>
    <button btn-update="<?=$D->c->id?>" type="button" class="button is-info is-outlined uk-width-1-1">
      Actualizar categoria
    </button>
  <?php else: ?>
    <button btn-crear type="button" class="button is-success is-outlined uk-width-1-1">
      Crear categoria
    </button>
  <?php endif; ?>
</div>

</div>
