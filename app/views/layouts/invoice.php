<!doctype html>

<?php $lang_current = get_lang_code_defaut();?>

<html lang="<?=(!empty($lang_current)) ? $lang_current->code : 'en' ?>" dir="<?=(!empty($lang_current) && $lang_current->code=='en') ? 'ltr' : 'rtl' ?>">

  <head>

    <meta charset="UTF-8">

    <title><?=get_option('website_title', "SmartPanel - SMM Panel Reseller Tool")?></title>


    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="mobile-web-app-capable" content="yes">

    <meta name="HandheldFriendly" content="True">

    <meta name="MobileOptimized" content="320">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
  
    <!-- Core -->

    <link href="<?=BASE?>assets/css/core.css" rel="stylesheet">
      
  </head>

  <body>

    <div class="container">
      <?=$template['body']?>
    </div>

  </body>

</html>