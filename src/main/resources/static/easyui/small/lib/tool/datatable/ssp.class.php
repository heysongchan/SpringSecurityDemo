<?php

/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
include_once (dirname(__FILE__) . '/../../db/database.php');

class SSP
{

    /**
     * Create the data output array for the DataTables rows
     *
     * @param array $columns
     *            Column information array
     * @param array $data
     *            Data from the SQL get
     * @return array Formatted data in a row based format
     */
    static function data_output($columns, $data)
    {
        $out = array();
        
        for ($i = 0, $ien = count($data); $i < $ien; $i ++) {
            $row = array();
            
            for ($j = 0, $jen = count($columns); $j < $jen; $j ++) {
                $column = $columns[$j];
                
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                }
            }
            
            $out[] = $row;
        }
        
        return $out;
    }

    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     * @param array $request
     *            Data sent to server by DataTables
     * @param array $columns
     *            Column information array
     * @param array $bindings
     *            Array of values for PDO bindings, used in the
     *            sql_exec() function
     * @return string SQL where clause
     */
    static function filter($request, $columns, &$bindings, $mywhere)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');
        
        // $dtColumns数组为[0,1,2,3,4,5,6...]
        
        // get data which user search
        if (isset($request['search']) && $request['search']['value'] != '') {
            // $str为用户搜索的数据
            $str = $request['search']['value'];
            
            for ($i = 0, $ien = count($request['columns']); $i < ($ien - 1); $i ++) {
                $requestColumn = $request['columns'][$i];
                // $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[$i];
                
                if ($requestColumn['searchable'] == 'true') {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $globalSearch[] = "`" . $column['db'] . "` LIKE binary" . '\'' . '%' . $str . '%' . '\'';
                }
            }
        }
        
        // Combine the filters into a single string
        if (! empty($mywhere)) {
            $where = $mywhere;
        } else {
            $where = '';
        }
        
        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }
        
        if (count($columnSearch)) {
            $where = $where === '' ? implode(' AND ', $columnSearch) : $where . ' AND ' . implode(' AND ', $columnSearch);
        }
        
        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }
        
        return $where;
    }

    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param array $request
     *            Data sent to server by DataTables
     * @param array $columns
     *            Column information array
     * @return string SQL order by clause
     */
    static function order($request, $columns)
    {
        $order = '';
        
        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'db');
            // 将所有的排序信息全部取出来
            for ($i = 0, $ien = count($request['order']); $i < $ien; $i ++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']); // 1
                $requestColumn = $request['columns'][$columnIdx];
                
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
                    
                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }
            
            $order = 'ORDER BY ' . implode(', ', $orderBy);
        }
        
        return $order;
    }

    /**
     * Paging-success
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     * @param array $request
     *            Data sent to server by DataTables
     * @param array $columns
     *            Column information array
     * @return string SQL limit clause
     */
    static function limit($request, $columns)
    {
        $limit = '';
        
        if (isset($request['start']) && $request['length'] != - 1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }
        
        return $limit;
    }

    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others.
     * The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     * @param array $request
     *            Data sent to server by DataTable
     * @param string $table
     *            SQL table to query
     * @param string $primaryKey
     *            Primary key of the table
     * @param array $columns
     *            Column information array
     * @return array Server-side processing response array
     */
    static function simple($request, $table, $primaryKey, $columns, $mywhere = '', $myjoin = '')
    {
        $bindings = array();
        
        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $where = self::filter($request, $columns, $bindings, $mywhere);
        $order = self::order($request, $columns);
        
        // Main query to actually get the data
        $sql = "SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 	 FROM `$table`
                 $myjoin
             	 $where
             	 $order
			 	 $limit";

	    $data = DB::select($sql)->getResult();
        
        // Data set length after filtering
        $resFilterLength = DB::select("SELECT FOUND_ROWS()")->getResult();
        $recordsFiltered = $resFilterLength[0]['FOUND_ROWS()'];
        
        // Total data set length
        $resTotalLength = DB::select("SELECT COUNT(`{$primaryKey}`) FROM $table")->getResult();
        $recordsTotal = $resTotalLength[0]["COUNT(`{$primaryKey}`)"];
        
        if ($recordsFiltered == 0)
            $data = array();
        
        
        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $data
        );
    }

    /*
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */
    
    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param string $msg
     *            Message to send to the client
     */
    static function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg
        ));
        
        exit(0);
    }

    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param
     *            array &$a Array of bindings
     * @param * $val
     *            Value to bind
     * @param int $type
     *            PDO field type
     * @return string Bound key to be used in the SQL where this parameter
     *         would be used.
     */
    static function bind(&$a, $val, $type)
    {
        $key = ':binding_' . count($a);
        
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );
        
        return $key;
    }

    /**
     * Pull a particular property from each assoc.
     * array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param array $a
     *            Array to get data from
     * @param string $prop
     *            Property to read
     * @return array Array of property values
     */
    static function pluck($a, $prop)
    {
        $out = array();
        
        for ($i = 0, $len = count($a); $i < $len; $i ++) {
            $out[] = $a[$i][$prop];
        }
        
        return $out;
    }
}

?>