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

  </body>
</html>
