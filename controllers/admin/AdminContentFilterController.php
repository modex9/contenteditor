<?php

class AdminContentFilterController extends ModuleAdminController
{
    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        Media::addJsDef(
            [
                'query_controller' => $this->context->link->getModuleLink($this->module->name, 'query'),
            ]
        );
        $this->addCSS("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
        $this->addJS("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.js");
        $this->addJS(__PS_BASE_URI__ . "modules/" . $this->module->name . "/views/js/admin/admin.js");
    }


    public function initContent()
    {
        $tables = $this->module->getDbTables();
        $table_name_id = "Tables_in_" . _DB_NAME_;
        $table_descriptions = [];
        foreach ($tables as $key => $table)
        {
            $td = $this->module->getTableDescription($table[$table_name_id]);
            if(empty($td))
                unset($tables[$key]);
            foreach ($td as $t)
            {
                $table_descriptions[$table[$table_name_id]][$t['Field']] = $t['Type'];
            }
        }
        $this->context->smarty->assign([
            'tables' => $tables,
            'table_name_id' => $table_name_id,
            'table_descriptions' => $table_descriptions,
        ]);
        $this->context->smarty->assign(array(
            'content' => $this->module->fetch("module:" . $this->module->name . "/views/templates/admin/list.tpl")
        ));
    }
}