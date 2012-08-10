<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */

echo '<h1>Website settings</h1>
    <form action="setSettings.php" method="post">
         Website name: <input type="text" name="webname" value="'.$siteSetting->getName().'"/><br />
         Website description: <input type="text" name="description" value="'.$siteSetting->getDescription().'"/><br />
         Header image address: <input type="text" name="headerimg" value="'.$siteSetting->getHeaderImg().'"/><br />
         Footer text: <br /><textarea id="editor" name="footer" cols=70 rows=8>'.$siteSetting->getFooter().'</textarea>
         <input type="submit" value="Submit changes" />
     </form>';

?>
<script type="text/javascript">
    CKEDITOR.replace( 'editor',
        {
            toolbar: 'Basic',
            height:'150',
            width:'450'
        });
</script>