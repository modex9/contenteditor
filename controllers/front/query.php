<?php

class contenteditorQueryModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        parent::initContent();
        if(!Tools::getIsset('query') || (Tools::getIsset('query') && !($query_string = Tools::getValue('query'))))
        {
            die(json_encode([
                'error' => 'Query string cannot be empty',
            ]));
        }
        $query_data = Tools::getAllValues();
        $tables = [];
        // Collected queried tables.
        foreach ($query_data as $key => $data)
        {
            if(Tools::tableExistsDb($key) && is_array($data))
                $tables[$key] = $data;
        }

        $queries = [];
        // Build content queries for each table.
        foreach ($tables as $table => $columns) {
            $queries[$table] = $this->buildTableQueries($table, $columns, $query_string);
        }

        // Run queries.
        $query_results = [];

        foreach ($queries as $table => $query) {
            $query_results[$table] = Db::getInstance()->executeS($query);
        }
        $this->context->smarty->assign(
            [
                'query_results' => $query_results,
            ]
        );

        header('Content-Type: application/json');
        die(json_encode([
            'query_results_table' => $this->module->fetch("module:" . $this->module->name . "/views/templates/admin/query_result.tpl"),
        ]));
    }

    public function buildTableQueries($table, $columns, $query_string)
    {
        if(!$table || empty($table))
        {
            return false;
        }

        // Table may have multiple queries. One for each column.
        $queries = [];

        // Need only the key - column.
        $query_start = "SELECT * FROM " . $table . " WHERE ";
        $query_end = '';
        if(!empty($columns))
        {
            $length = count($columns);
            $count = 1;
            foreach (array_keys($columns) as $column)
            {
                $query_end .= $column . " LIKE '%" . $query_string . "%'";
                if($count != $length)
                    $query_end .= 'OR ';
                $count++;
            }
        }
        $query = $query_start . $query_end;

        return $query;
    }

    public function fetchContent($query)
    {
        $result = Db::getInstance()->executeS($query);
        if($result && !empty($result))
        {
            return $result;
        }
        return false;
    }

}
