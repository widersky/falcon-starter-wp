<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Raleway:wght@200;400&display=swap" rel="stylesheet">

  <?php wp_head() ?>
</head>
<body <?php body_class( 'flex flex-col' ) ?>>
<?php wp_body_open(); ?>

<?= get_template_part('parts/globals/header') ?>

<main class="falcon">
