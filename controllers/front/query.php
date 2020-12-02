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
        foreach ($queries as $table => $table_queries)
        {
            foreach ($table_queries as $column => $query)
            {
                $query_results[$table][$column] = Db::getInstance()->executeS($query);
            }
        }
        header('Content-Type: application/json');
        die(json_encode([
            'post' => $_POST,
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
        foreach (array_keys($columns) as $column)
        {
            $queries[$column] = "SELECT " . $column . " FROM " . $table . " WHERE " . $column . " LIKE '%" . $query_string . "%'";
        }

        return $queries;
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
