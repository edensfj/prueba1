<div class="">
  <div class="uk-margin-small">
    <label class="uk-form-label">Nombre/Titulo producto</label>
    <div class="control">
      <input type="text" maxlength="250" name="nombre_producto" class="input" value="<?=isset($D->p)?$D->p->nombre_producto:''?>">
    </div>
  </div>
  <div class="uk-margin-small">
    <label class="uk-form-label">Precio</label>
    <div class="control">
      <input type="number" step="100" name="precio" class="input" min="0" value="<?=isset($D->p)?$D->p->precio:'0'?>">
    </div>
  </div>
  <div class="uk-margin-small">
    <label class="uk-form-label">Descripcion</label>
    <div class="control">
      <textarea name="descripcion" class="uk-textarea uk-border-rounded" rows="4" cols="80"><?=isset($D->p)?$D->p->descripcion:''?></textarea>
    </div>
  </div>
  <div class="">
    <label>
      <input <?=isset($D->p)?($D->p->estado?'checked':''):''?> type="checkbox" name="estado">
      ¿Activar producto?
    </label>
  </div>

  <?php if (isset($D->p)): ?>
    <hr class="uk-margin-small">
    <div class="uk-text-bold">Categorias asignadas</div>
    <div class="">
      <?php foreach ($db2->buscar_categoria() as $c): ?>
        <label class="uk-display-block">
          <input <?=($c->estado)?'':'disabled'?> <?=in_array($c->id,$D->p->categorias)?'checked':''?> type="checkbox" name="idcategoria" value="<?=$c->id?>">
          <?=$c->categoria?>
        </label>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="uk-margin-small">
    <?php if (isset($D->p)): ?>
      <button btn-update-producto="<?=$D->p->id?>" type="button" class="button uk-width-1-1 is-info is-outlined">Actualizar producto</button>
    <?php else: ?>
      <button btn-crear-producto type="button" class="button uk-width-1-1 is-success is-outlined">Crear producto</button>
    <?php endif; ?>
  </div>


</div>
