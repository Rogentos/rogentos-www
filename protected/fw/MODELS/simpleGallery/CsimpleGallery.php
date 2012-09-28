<?php
class CsimpleGallery{

    var $C;               //main object
    var $nameF;
    var $LG;

    var $imgDir = 'images/';
    var $imgURL = '';

    var $files = array();

    var $pageQuota = 9;
    var $extensions = 'png|jpg|jpeg';
    var $thumbSizeX = 200;
    var $thumbSizeY = 200;

    var $sessionStorage = TRUE;

    var $currentPage = 1;

    function DISPLAY(){

        $kcfinder = '<a target="_blank" rel="shadowbox;height=600c"
                        href="/fw/GENERAL/js/kcfinder/browse.php?type=images" style="border:0px;">
                            <img src="/fw/MODELS/simpleGallery/css/images.png"
                                style="display:inline-block; width: 36px; margin-left: 35px; margin-bottom: -15px;" />
                        Browse
                     </a>';

        $display = (isset($_SESSION['admin']) ? $kcfinder : '');

        $display .= '<div id="simpleGalleryContainer">';
        //$files = scandir($this->imgDir);


        $i = 1;

        if (count($this->files) < 1) {
            $display .= "Sorry, no images yet. Stay tuned!";
        } else {

            if(count($this->files) > $this->pageQuota)
                $display .= '<div id="pageLinks">'.$this->createPageLinks()."</div><br/>\n";

            $filesSlice = array_slice($this->files,($this->pageQuota * ($this->currentPage - 1)),$this->pageQuota);
            foreach ($filesSlice as $file) {
                if(!file_exists($this->imgURL."thumbs/$file")) {
                    $this->resizeImage($file);
                }

                $title = $this->formatTitle($file);
                $display .= "<a href='{$this->imgURL}$file' rel='shadowbox[Rogentos]' title='$title'>
                    <div class='simpleGalleryImageContainer'>
                        <img src='{$this->imgURL}thumbs/$file' class='simpleGalleryImage' />
                        <span class='simpleGalleryImageTitle'>".$title."</span>
                    </div>
                </a>";
                $i++;
            }
        }

        $display .= '</div>';

        return  $display;
    }

    function imgFilter($filename) {
        if(preg_match('/\.('.$this->extensions.')$/i',$filename) == 1)
            return $filename;
        else
            return FALSE;
    }

    function readImages() {
        $filelist = scandir($this->imgDir);
        $filelist = array_filter($filelist,array($this, 'imgFilter'));
        return $filelist;
    }

    function resizeImage($filename) {
        $image = tulipIP::loadImage($this->imgDir.$filename);
        $dest = $this->imgDir."thumbs/";

        $resized = tulipIP::resize($image, 250, TIP_FIXED);
        if(tulipIP::getMime($this->imgDir.$filename) == "image/jpeg") {
            $mime = TIP_JPG;
        } elseif(tulipIP::getMime($this->imgDir.$filename) == "image/png") {
            $mime = TIP_PNG;
        } elseif(tulipIP::getMime($this->imgDir.$filename) == "image/jpg") {
            $mime = TIP_JPG;
        }
        tulipIP::saveImage($dest, $resized, $mime, substr($filename,0,-4));
        imagedestroy($resized);

/*
        $thumbnail = tulipIP::loadImage($this->imgDir..$filename);
        $copy = tulipIP::gdClone($thumbnail);
        tulipIP::Gblur($copy, 1);
        tulipIP::saveImage($dest, $copy, $mime, substr($filename,0,-4));
        imagedestroy($copy);
*/
    }

    function formatTitle($filename) {
        $filename = preg_replace('/(\.'.$this->extensions.')$/i','',$filename);
        $filename = preg_replace('/([a-z0-9]*)(-|\s|\.|_)([a-z0-9]*)/i','$1 $3',$filename);
        return $filename;
    }

    function createPageLinks() {
        $pagination = "";
        $total_pages = ceil(count($this->files)/$this->pageQuota);
        $galleryURL = preg_replace('/(\/[0-9+])$/i','',$_SERVER['REQUEST_URI']);

        $current = ($this->currentPage == 1 ? "class='currentPageLink'" : '');
        $pagination .= "<a href='$galleryURL' $current>1</a>";
        for($i=2;$i<=$total_pages;$i++){
            $current = ($this->currentPage != 1 && $this->currentPage == $i ? "class='currentPageLink'": '');
            $pagination .= "<a href='$galleryURL/$i' $current>$i</a>";
        }
        return $pagination;
    }

    function  setINI() {}
    function __construct($C){

        $this->C = &$C;
        $this->LG = &$C->lang;
        $this->nameF = $this->C->nameF;

        $this->setINI();

        $this->imgURL = fw_pubURL.'MODELS/simpleGallery/'.$this->imgDir;
        $this->imgDir = fw_pubPath.'MODELS/simpleGallery/'.$this->imgDir;

        $this->files = $this->readImages();
        $_SESSION['simpleGalleryCurrent'] = (!isset($_SESSION['simpleGalleryCurrent']) ?
                                                  1 : $_SESSION['simpleGalleryCount']+1);

        //$this->currentPage = $_SESSION['simpleGalleryCurrent'];
        $this->currentPage = $_GET['slice'];
    }
}
