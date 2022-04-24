<?php
/**
 * Created by PhpStorm.
 * User: thomzee
 * Date: 28/01/18
 * Time: 10.04
 */

class Datatables extends CI_Model {
    public $dt;
    public $sql;
    public $columns;
    public $tables;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function generate(){
        /* PREPARE DATA */
        $sql = $this->sql;
        $db_result = $sql['result'];
        $db_query = $sql['queries']->last_query();
        $db_columns = $this->columns;
        $db_rows_count = $db_result->num_rows();

        $dt_column_count = 0;
        foreach ($this->tables as $table => $columns) {
            foreach ($columns as $key => $column) {
                $dt_column_count++;
            }
        }

        $this->dt_search = $this->dt['search']['value'];

        /* SEARCH */
        $where = '';
        if ($this->dt_search != '') {
            $iterator = 0;
            foreach ($this->tables as $table => $columns) {
                foreach ($columns as $key => $column) {
                    $where .= 'LOWER(' . $table . '.' . $column . ') LIKE \'%' . $this->dt_search . '%\' ';
                    if ($iterator < $dt_column_count-1) {
                        $where .= ' OR ';
                    }
                    $iterator++;
                }
            }
        }



        if ($where != '') {
            if(strpos($db_query, 'WHERE') !== false){
                $db_query .= " AND " . $where;
            }else{
                $db_query .= " WHERE " . $where;
            }

            $db_rows_count = $this->db->query($db_query)->num_rows();
        }

        /* SORTING */
        $dtColumns = [];
        if(@$this->dt['order']){
            foreach ($this->dt['columns'] as $column){
                if($column['orderable'] !== "false"){
                    $dtColumns[] = $column['data'];
                }else{
                    $dtColumns[] = null;
                }
            }
            $db_query .= " ORDER BY {$dtColumns[$this->dt['order'][0]['column']]} {$this->dt['order'][0]['dir']}";
        }

        /* LIMIT */
        $start  = $this->dt['start'];
        $length = $this->dt['length'];
        $db_query .= " LIMIT {$length} OFFSET {$start}";

        $return['list'] = $this->db->query($db_query);
        $return['columns'] = $db_columns;
        $return['columns_count'] = $dtColumns;
        $return['rows_count'] = $db_rows_count;
        $return['draw'] = $this->dt['draw'];
        $return['start'] = $this->dt['start'];

        return $return;
    }
}