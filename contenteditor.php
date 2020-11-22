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

    public function install()
    {
        $res = true;
        $this->installTable();
        return $res && parent::install();
    }

    public function getContent() {

    }

    public function installTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS " . _DB_PREFIX_ . "content_history (" .
            "`id_content_history` int(10) UNSIGNED NOT NULL AUTO_INCREMENT," .
            "`id_employee` int(10) UNSIGNED NOT NULL," .
            "`original_content` varchar(255) NOT NULL," .
            "`new_content` varchar(255) DEFAULT NULL," .
            "`added` datetime NOT NULL," .
            "PRIMARY KEY (`id_content_history`)
            ) DEFAULT CHARSET=utf8";
        return Db::getInstance()->execute($sql);
    }
}