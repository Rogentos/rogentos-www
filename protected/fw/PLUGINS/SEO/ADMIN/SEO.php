<?php

    $LG = $_POST['LG'];
    $list_id = $_POST['id'];                #id-ul vine de la GEN_edit.js ca list_[id]
    $idarr = explode('_',$list_id);         #extragem id-ul elementului schimbat
    $id = end($idarr);

#=======================================================================================================================
    $DB = new mysqli(dbHost,dbUser,dbPass,dbName);
    $query = "SELECT SEO from ITEMS  WHERE id='{$id}' ";
    $SEO_res = $DB->query($query)->fetch_assoc();
    $SEO = unserialize($SEO_res['SEO']);


    $title_tag       = $SEO[$LG]['title_tag'];
    $title_meta      = $SEO[$LG]['title_meta'];
    $description_meta= $SEO[$LG]['description_meta'];
    $keywords_meta   = $SEO[$LG]['keywords_meta'];

#=======================================================================================================================
$disp =  "    <p id='descr-SEO'>Detalii Seo</p>
               <input type='text' name='title_tag'         value='{$title_tag}'        placeholder='Title Tag'/> Title tag<br />
               <input type='text' name='title_meta'        value='{$title_meta}'       placeholder='Title meta'/> Title <br />
               <input type='text' name='description_meta'  value='{$description_meta}' placeholder='Description meta'/> Description <br />
               <input type='text' name='keywords_meta'     value='{$keywords_meta}'    placeholder='Keywords meta'/>       Keywords<br />
              ";
echo $disp;

