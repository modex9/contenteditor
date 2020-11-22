<?php

class contenteditor extends Module {

    public function __construct() {
        $this->version = '1.0';
        $this->name = $this->l('contenteditor');
        $this->author = 'Modestas Slivinskas';

        parent::__construct();
        $this->displayName =  $this->l('Content Editor');
        $this->description = $this->l('Module is used to edit content globally in your database.');
        $this->bootstrap = true;
    }


    public function getContent() {

    }
}