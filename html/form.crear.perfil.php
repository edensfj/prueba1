<div class="">


  <div class="">
    <label>Perfil/Privilegio</label>
    <div class="control">
      <input type="text" class="input" name="perfil" value="">
    </div>
  </div>

  <?php foreach ([
    'is_super'=>'Super administrador',
    'can_delete'=>'Permitir eliminar',
    'can_update'=>'Permitir actualizar',
    'can_create'=>'Permitir crear',
    ] as $col => $txt): ?>
    <div class="uk-margin-small">
      <label>
        <input type="checkbox" class="" name="<?=$col?>">
        <?=$txt?>
      </label>
    </div>
  <?php endforeach; ?>

  <div class="uk-margin-small">
    <button btn-crear-perfil type="button" class="button uk-width-1-1 is-success is-outlined">
      Crear perfil
    </button>
  </div>


</div>
