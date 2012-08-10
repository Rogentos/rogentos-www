<?php
/**
 * Author: Paul Cioanca
 * Author URI: cioan.ca
 * 2012
 */
if(isset($_GET['mod'])){
    if($_GET['mod']==='AddPage')
        echo '<h2>Add new page</h2>
              <form action="pageOP.php" method="post">
                  Page name: <input type="text" name="postName" /><br />
                  Text: <br /><textarea id="editor" name="postText" cols=70 rows=8></textarea>
              <input type="submit" value="Submit" />
              </form>';
    else echo '<h2>Edit '.$post->getTitle().'</h2>
              <form action="pageOP.php" method="post">
                  Page name: <input type="text" name="postName" value="'.$post->getTitle().'"/><br />
                  Text: <br /><textarea id="editor" name="postText" cols=70 rows=8>'.$post->Display().'</textarea>
              <input type="submit" value="Submit changes" id="submit_button" />
              <input type="hidden" name="edit" value="'.$_GET['mod'].'" />
              </form>';
}
?>

<script type="text/javascript">
    CKEDITOR.replace( 'editor',
        {
            height:'350',
            width:'850'
        });
</script>