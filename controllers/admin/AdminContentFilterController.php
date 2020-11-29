<?php

class AdminContentFilterController extends ModuleAdminController
{

    public function initContent()
    {
        $this->addCSS("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
        $this->addJS("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.js");
        $tables = $this->module->getDbTables();
        $table_name_id = "Tables_in_" . _DB_NAME_;
        $table_descriptions = [];
        foreach ($tables as $table)
        {
            $td = $this->module->getTableDescription($table[$table_name_id]);
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