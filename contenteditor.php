<?php

require _PS_MODULE_DIR_ . 'contenteditor/vendor/autoload.php';

use Classes\PrototypeModule;

class contenteditor extends PrototypeModule {

    public static $excluded_tables;
    public static $excluded_columns;

    public function __construct()
    {
        $this->version = '1.0';
        $this->name = $this->l('contenteditor');
        $this->author = 'Modestas Slivinskas';

        parent::__construct();
        $this->displayName =  $this->l('Content Editor');
        $this->description = $this->l('Module is used to edit content globally in your database.');
        $this->bootstrap = true;
        $this->controllers = ['query'];
        $this->tabs = [
            ['name'=>$this->l('Content Editor'), 'class_name' => 'AdminContentFilter', 'id_parent' => 0,  'active' => true]
        ];
        //todo: user excludes table himself?
        if(!isset(self::$excluded_tables))
        {
            $tables = ['access', 'admin_filter', 'advice', 'alias', 'attribute', 'authorization_role', 'attribute_shop', 'badge',
                'badge_lang', 'carrier', 'carrier_shop', 'gender', 'guest', 'hook', 'image', 'image_type', 'layered_filter', 'layered_filter_block', 'zone'];
            self::$excluded_tables = array_map(function($el) {
                return _DB_PREFIX_ . $el;
            }, $tables);
        }
        if(!isset(self::$excluded_columns))
        {
            self::$excluded_columns = ['int', 'tinyint', 'datetime', 'bigint', 'decimal', 'enum', 'timestamp'];
        }
    }

    public function install()
    {
        $res = true;
        $this->installTable();
        return $res && parent::install();
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminContentFilter'));
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

    public function getDbTables()
    {
        $sql = "SHOW TABLES FROM " . _DB_NAME_ . ' WHERE `Tables_in_' . _DB_NAME_ . "` NOT IN ('". implode('\',\'', self::$excluded_tables). "')";
        $tables = Db::getInstance()->executeS($sql);
        return $tables;
    }

    public function getTableDescription($table)
    {
        $sql = "DESCRIBE " . $table;
        $table_description = Db::getInstance()->executeS($sql);
        $table_description_filtered = array_filter($table_description, [$this, 'filterExcludedTypes']);
        return $table_description_filtered;
    }

    public function filterExcludedTypes($column)
    {
        foreach (self::$excluded_columns as $excl_col)
        {
            if(substr($column['Type'], 0, strlen($excl_col)) === $excl_col)
                return false;
        }
        return true;
    }
}