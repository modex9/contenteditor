<?php

class AdminContentFilterController extends ModuleAdminController
{

    public function initContent()
    {
        $this->addCSS("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
        $tables = $this->module->getDbTables();
        $table_name_id = "Tables_in_" . _DB_NAME_;
        $td = $this->module->getTableDescription("ps_cms_lang");
        $this->context->smarty->assign([
            'tables' => $tables,
            'table_name_id' => $table_name_id,
        ]);
        $this->context->smarty->assign(array(
            'content' => $this->module->fetch("module:" . $this->module->name . "/views/templates/admin/list.tpl")
        ));
    }
}