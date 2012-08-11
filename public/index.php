<?php session_start();
    error_log("===============[ Rogentos -> NEW PAGE LOAD ]===============", 0);


    require_once('../protected/GENERAL/config.php');
    require_once(incPath.'GENERAL/LOG.php');
    global $CAD;
    error_reporting(E_ALL);

   require_once(publicPath.'GENERAL/RES/header.php');
?>

    <div id='en' class='pageCont'>
<!--
        <div class="fancybar">
            <?php
                // echo $CAD->MENUhorizontal->DISPLAY();
            ?>
        </div>
-->
        <?php
            $ob_name = $CAD->type;
            echo $CAD->$ob_name->DISPLAY();
        ?>
    </div>

    <? require_once(publicPath.'GENERAL/RES/footer.php'); ?>

    <script type="text/javascript"  src="/GENERAL/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript"  src="/GENERAL/js/ckeditor/ckeditor.js" type="text/javascript"></script>

    <?php echo $CAD->INC_js; ?>


  </body>
</html>
