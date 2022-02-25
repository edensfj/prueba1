<?php
require_once('./config.php');
if (!isset($_SESSION['is_logged'])) {
  $_SESSION['is_logged'] = FALSE;
}
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = (object) [];
}
$P->logged = $_SESSION['is_logged'];
$P->user = $_SESSION['user'];

?>
<!DOCTYPE html>
<html lang="es" class="uk-height-1-1">
<head>
  <meta charset="utf-8">
  <title>PRUEBA - PHP</title>
  <meta property="og:type" content="prueba"/>
  <meta property="og:title" content="prueba"/>
  <meta property="og:description" content="esta es la prueba"/>
  <meta property="og:site_name" content="prueba"/>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta http-equiv="X-UA-Compatible" content="IE=9"/>
  <meta http-equiv="cache-control" content="max-age=600"/>
  <meta http-equiv="expires" content="never"/>
  <meta http-equiv="pragma" content="cache"/>
  <meta name="HandheldFriendly" content="True">
  <meta name="language" content="ES"/>
  <meta name='author' content='Edens Florez'>
  <meta name='designer' content='Edens Florez'>
  <meta name="Keywords" content="edens,edems,skipp,jaramillo,edens skipp"/>
  <meta name="Description" content="esta es la prueba"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="<?=$P->CSS?>style.css">
  <link rel="stylesheet" href="<?=$P->CSS?>jquery.fancybox.css">

  <script type="text/javascript">
  const SITE_URL = '<?=$P->SITE_URL?>';
  </script>
  <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit-icons.min.js"></script>
  <script type="text/javascript" src="<?=$P->JS?>jquery.js"></script>
  <script type="text/javascript" src="<?=$P->JS?>jquery.fancybox.js"></script>
</head>
  <body class="uk-height-1-1 uk-container uk-flex uk-flex-column">
    <div class="uk-width-1-1 uk-navbar-container tm-navbar-container">
      <div class="uk-container uk-container-expand">
        <nav class="uk-navbar">
          <div class="uk-navbar-left">
            <a href="javascript:void(0)" class="uk-navbar-item uk-logo">PRUEBA</a>
          </div>
          <div class="uk-navbar-right">
            <ul class="uk-navbar-nav uk-visible@m">
              <?php load_template('nav.li') ?>
            </ul>
            <a uk-navbar-toggle-icon="" href="#offcanvas" uk-toggle="" class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon" aria-expanded="false"></a>
          </div>
        </nav>
      </div>
    </div>
    <div id="offcanvas" uk-offcanvas="overlay: true;flip: true;mode: push">
      <div class="uk-offcanvas-bar uk-background-default">
        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <ul class="uk-nav uk-nav-default uk-list">
          <?php load_template('nav.li') ?>
        </ul>
      </div>
    </div>
    <div style="height:calc(100vh - 80px);" class="" main-container>
      <?php load_template($P->logged?'index':'login'); ?>
    </div>
    <script type="text/javascript" src="<?=$P->JS?>index.js"></script>
  </body>
</html>
