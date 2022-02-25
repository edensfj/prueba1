<?php if ($P->logged && $P->user->is_super): ?>
  <li>
    <a btn-nav="perfiles" href="javascript:void(0)">
      <span class="material-icons-outlined">admin_panel_settings</span>
      <span>Perfiles</span>
    </a>
  </li>
<?php endif; ?>
<li>
  <a btn-nav="productos" href="javascript:void(0)">
    <span class="material-icons-outlined">widgets</span>
    <span>Productos</span>
  </a>
</li>
<li>
  <a btn-nav="categorias" href="javascript:void(0)">
    <span class="material-icons-outlined">category</span>
    <span>Categorias</span>
  </a>
</li>
<li>
  <?php if ($P->logged): ?>
    <a btn-nav="logout" href="javascript:void(0)">
      <span class="material-icons-outlined">account_circle</span>
      <span><?=$P->user->nombre?></span>
    </a>
  <?php else: ?>
    <a btn-nav="login" href="javascript:void(0)">
      <span class="material-icons-outlined">login</span>
      <span>Ingresar</span>
    </a>
  <?php endif; ?>

</li>
