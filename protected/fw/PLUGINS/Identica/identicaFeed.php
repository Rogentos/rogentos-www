<?php

/*
 * Wrapper class for identi.ca library, to preserve easy upgradeability 
 * instead of directly hacking the library class
 *
 * Will return the HTML formatted Replies feed
 * 
 */

class identicaFeed extends Identica {

    protected $username = '';
    protected $password = '';
    private $template = '';
    private $id;


    private function connectAccount () {
        $this->id = new Identica($this->username,$this->password);
    }

    private function getFeed ( $format = 'xml' ) {
        $this->id->getReplies($format);
    }

    public function render () {
        echo $this->getFeed();
    }

    public function __construct () {
        $this->username = identicaUser;
        $this->password = identicaPass;

        $this->connectAccount();
        $this->getFeed();
        
        // return $this->render();
    }

    public function __toString () {
        var_dump($this->getFeed());
    }

}
