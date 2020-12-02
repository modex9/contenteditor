<?php

//General use methods.

class Tools extends ToolsCore
{

    public function tableExistsDb($table)
    {
        $sql = "SELECT null FROM " . $table . " LIMIT 1";
        try {
            Db::getInstance()->executeS($sql);
            return true;
        }
        catch(PrestaShopDatabaseException $e) {
            // Table definitively does not exists.
            return false;
        }
    }

}