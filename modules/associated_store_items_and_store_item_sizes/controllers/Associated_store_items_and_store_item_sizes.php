<?php
class Associated_store_items_and_store_item_sizes extends Trongate {

    private $associated_modules = ['store_items', 'store_item_sizes'];
    private $assoc_module = 'associated_store_items_and_store_item_sizes';
    private $relationshipType = 'many to many';
    private $bridgingTblRequired = 'true';

    function _get_identifier_column($module_name) {

        if ($module_name == 'store_items') {
            $identifier_column = 'item_title';
        } else {
            $identifier_column = 'item_size';
        }

        return $identifier_column;

    }

    function _draw_association_info($token) {
        $data['calling_module'] = $this->url->segment(1); 

        if ($data['calling_module'] == 'store_items') {
            $data['associated_records_singular'] = 'Store Item Size ';
            $data['associated_records_plural'] = 'store item sizes';
        } else {
            $data['associated_records_singular'] = 'Store Item ';
            $data['associated_records_plural'] = 'store items';            
        }

        $data['relationshipType'] = $this->relationshipType;
        $data['bridgingTblRequired'] = $this->bridgingTblRequired;
        $data['update_id'] = $this->url->segment(3);      
        $data['token'] = $token;
        $data['assoc_module'] = $this->assoc_module;
        $this->view('association_info', $data);
    }

    function fetch($update_id) {

        //fetch associated records from the related module
        api_auth();

        if (!is_numeric($update_id)) {
            http_response_code(422);
            echo 'Non numeric update_id.'; die();
        }

        $calling_module_name = $this->url->segment(4);

        if (!in_array($calling_module_name, $this->associated_modules)) {
            http_response_code(422);
            echo 'Invalid calling module name.'; die();            
        } else {
            $associated_module_name = $this->_get_associated_module_name($calling_module_name);
        }

        $identifier_column = $this->_get_identifier_column($associated_module_name);
        $comma_pos = strpos($identifier_column, ',');

        if (is_numeric($comma_pos)) {

            $sql = '
                SELECT
                    associated_store_items_and_store_item_sizes.id as recordId,
                    associated_module_name.id ,
                    CONCAT(xxxx) as identifierColumn 
                FROM
                    associated_module_name
                LEFT JOIN associated_store_items_and_store_item_sizes ON associated_module_name.id = associated_store_items_and_store_item_sizes.associated_module_name_id
                WHERE
                    associated_store_items_and_store_item_sizes.calling_module_name_id = '.$update_id;

            $sql = str_replace('associated_module_name', $associated_module_name, $sql);
            $sql = str_replace('calling_module_name', $calling_module_name, $sql);

            $identifier_columns = explode(',', $identifier_column);
            $num_identifier_columns = count($identifier_columns);

            $count = 0;
            $identifier_column_str = '';
            foreach ($identifier_columns as $column_name) {
                $count++;
                $column_name = trim($column_name);
                $column_name = str_replace(' ', '', $column_name);
                $identifier_column_str.=$column_name;

                if ($count<$num_identifier_columns) {
                    $identifier_column_str.= ', \' \', ';
                }
                
            }

            $replace = 'CONCAT('.$identifier_column_str.')';
            $sql = str_replace('CONCAT(xxxx)', $replace, $sql);
            $sql.= ' ORDER BY '.$identifier_columns[1];

        } else {

            $sql = '
                SELECT
                    associated_store_items_and_store_item_sizes.id as recordId,
                    associated_module_name.id ,
                    associated_module_name.'.$identifier_column.' AS identifierColumn
                FROM
                    associated_module_name
                LEFT JOIN associated_store_items_and_store_item_sizes ON associated_module_name.id = associated_store_items_and_store_item_sizes.associated_module_name_id
                WHERE
                    associated_store_items_and_store_item_sizes.calling_module_name_id = '.$update_id;

                $sql.= ' ORDER BY '.$identifier_column;

                $sql = str_replace('associated_module_name', $associated_module_name, $sql);
                $sql = str_replace('calling_module_name', $calling_module_name, $sql);
        }

        $results = $this->model->query($sql, 'object');
        $output = json_encode($results);

        echo $output;
    }

    function get_dropdown_options() {

        api_auth();

        $post = file_get_contents('php://input');
        $params = json_decode($post, true);

        $calling_module_name = $params['callingModuleName'];
        $update_id = $params['updateId'];
        $selected_records = $params['selectedRecords'];
        $num_results = count($selected_records);
        
        $relationshipType = $this->relationshipType;

        if ((!is_numeric($update_id)) || (!is_numeric($num_results))) {
            http_response_code(418);
            echo 'Non numeric parameters.'; die();                
        } elseif (($relationshipType == 'one to one') && ($num_results>0)) {
            echo '[]'; die();
        }

        if (!in_array($calling_module_name, $this->associated_modules)) {
            http_response_code(422);
            echo 'Invalid calling module name.'; die();            
        }

        $post = file_get_contents('php://input');
        $params = json_decode($post, true);
        $associated_module_name = $this->_get_associated_module_name($calling_module_name);
        $identifier_column = $this->_get_identifier_column($associated_module_name);

        $sql = $this->_build_sql_statement($identifier_column, $associated_module_name, $update_id);
        $results = $this->model->query($sql, 'object');

        if ($relationshipType == 'many to many') {
            $new_results = [];
            foreach ($results as $result) {

                if (!in_array($result->id, $selected_records)) {
                    $new_results[] = $result;
                }
            }

            $results = $new_results;
        }

        echo json_encode($results);
    }

    function _build_sql_statement($identifier_column, $associated_module_name, $update_id) {

        $relationshipType = $this->relationshipType;

        $comma_pos = strpos($identifier_column, ',');

        if (is_numeric($comma_pos)) {

            $sql = '

                SELECT
                '.$associated_module_name.'.id, 
                CONCAT(xxxx) as identifier_column 
                FROM
                '.$associated_module_name.'
                LEFT JOIN associated_store_items_and_store_item_sizes                ON '.$associated_module_name.'.id = associated_store_items_and_store_item_sizes.'.$associated_module_name.'_id 
                WHERE associated_store_items_and_store_item_sizes.'.$associated_module_name.'_id IS NULL';

            $identifier_columns = explode(',', $identifier_column);
            $sql = $this->_build_concat_code($identifier_column, $sql, $identifier_columns);

        } else {

            $sql = '

                SELECT
                '.$associated_module_name.'.id, 
                '.$associated_module_name.'.'.$identifier_column.' as identifier_column 
                FROM
                '.$associated_module_name.'
                LEFT JOIN associated_store_items_and_store_item_sizes                ON '.$associated_module_name.'.id = associated_store_items_and_store_item_sizes.'.$associated_module_name.'_id 
                WHERE associated_store_items_and_store_item_sizes.'.$associated_module_name.'_id IS NULL';

        }

        if (isset($identifier_columns[1])) {
            $sql.= ' GROUP BY identifier_column';
        } else {
            $sql.= ' ORDER BY '.$identifier_column;
        }

        if ($relationshipType == 'many to many') {
            $calling_module_name = $this->_get_associated_module_name($associated_module_name);
            $ditch = 'WHERE associated_store_items_and_store_item_sizes.'.$associated_module_name.'_id IS NULL';
            $replace = 'WHERE associated_store_items_and_store_item_sizes.'.$calling_module_name.'_id >0 ';
            $replace.= 'OR associated_store_items_and_store_item_sizes.'.$calling_module_name.'_id IS NULL';
            $sql = str_replace($ditch, $replace, $sql);
        }

        return $sql;
    }

    function _build_concat_code($identifier_column, $sql, $identifier_columns) {
        $num_identifier_columns = count($identifier_columns);

        $count = 0;
        $identifier_column_str = '';
        foreach ($identifier_columns as $column_name) {
            $count++;
            $column_name = trim($column_name);
            $column_name = str_replace(' ', '', $column_name);
            $identifier_column_str.=$column_name;

            if ($count<$num_identifier_columns) {
                $identifier_column_str.= ', \' \', ';
            }
            
        }

        $replace = 'CONCAT('.$identifier_column_str.')';
        $sql = str_replace('CONCAT(xxxx)', $replace, $sql);

        return $sql;
    }

    function _get_associated_module_name($calling_module_name) {

        if ($calling_module_name == 'store_items') {
            $associated_module_name = 'store_item_sizes';
        } else {
            $associated_module_name = 'store_items';
        }

        return $associated_module_name;
    }

    function _prep_inbound($input) {

        $params = $input['params'];

        if ($params['callingModule'] == 'store_item_sizes') {
            $data['store_items_id'] = $params['selectedValue'];
            $data['store_item_sizes_id'] = $params['update_id'];
        } else {
            $data['store_item_sizes_id'] = $params['selectedValue'];
            $data['store_items_id'] = $params['update_id'];
        }

        $input['params'] = $data;

        return $input;
    }

}