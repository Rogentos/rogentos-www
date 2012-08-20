<?
//print_r($_POST);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Rogentos GNU/Linux - <?php echo $CAD->name; ?></title>

    <base href="<?php echo publicURL; ?>" />

    <link rel="stylesheet" href="/GENERAL/css/style.css"  />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="<?php echo $CAD->desc; ?>" />
    <meta name="keywords" content="rogentos, gnu linux, linux, gentoo, sabayon, romania" />

    <?php echo $CAD->INC_css; ?>

    <script type="text/javascript"  src="/GENERAL/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script async type="text/javascript"  src="/GENERAL/js/ckeditor/ckeditor.js" type="text/javascript"></script>

    <link rel="icon" type="image/png" href="/GENERAL/css/img/icon.png" />

    <script type="text/javascript"  src="/GENERAL/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript"  src="/GENERAL/js/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript"  src="/GENERAL/js/jquery-ui-1.8.19.custom/js/jquery-ui-1.8.19.custom.min.js" type="text/javascript"></script>
    <script type="text/javascript"  src="/GENERAL/js/jquery.ui.nestedSortable.js" type="text/javascript"></script>

    <?php echo $CAD->INC_js; ?>

</head>



<body >
    <?php echo $CAD->ctrlDISPLAY('TOOLbar'); ?>
    <input type='hidden' name='current_idT' value='<?php echo $CAD->idT; ?>'  />
    <input type='hidden' name='current_idC' value='<?php echo $CAD->idC; ?>'  />
    <input type='hidden' name='lang'        value='<?php echo $CAD->lang; ?>' />
    <input type='hidden' name='lang2'       value='<?php echo $CAD->lang2; ?>'/>
    <div id='header'>
        <div id="menu"><?php echo $CAD->MENUhorizontal->DISPLAY(); ?></div>
    </div>




