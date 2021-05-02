<?php

namespace core;


class Model
{
    protected $driver;
    protected $table;
    protected $foreign_key;
    protected $primary_key = 'id';
    private $fields;
    private $where = [];
    private $limit;
    private $offset;
    private $params = [];
    private $orderBy;

    public function __construct()
    {
        $this->driver = new Driver;
    }

    private function whereSql()
    {
        $sql = '';
        foreach ($this->where as $key => $item) {
            if ($i == 0) {
                $sql .= ' WHERE ';
            } else {
                $sql .= ' AND ';
            }
            $sql .= $item['column'] . ' ' . $item['operator'] . ' :' . $item['column'] . $key;

            $this->params[$item['column'] . $key] = $item['value'];
            $i++;
        }
        return $sql;
    }

    private function sql()
    {
        $sql = $this->fields;
        $i = 0;
        $sql .= $this->whereSql();
        $sql .= $this->orderBy . $this->limit . $this->offset;
        return $sql;
    }

    public function get()
    {

        return $this->driver->row($this->sql(), $this->params);
    }

    public function first()
    {
        return $this->driver->column($this->sql(), $this->params);
    }

    public function select($fields = '*')
    {
        $this->fields = 'SELECT ' . $fields . ' FROM ' . $this->table;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $params = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];
        $this->where[] = $params;
        return $this;
    }


    public function limit($number)
    {
        $this->limit = ' LIMIT :limit ';
        $this->params['limit'] = $number;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = ' OFFSET :offset ';
        $this->params['offset'] = $offset;
        return $this;
    }

    public function orderBy($column, $type = 'ASC')
    {
        $this->orderBy = ' ORDER BY ' . $column . ' ' . $type;
        return $this;
    }

    public function count()
    {
        $result = $this->select('COUNT(' . $this->primary_key . ') AS count')->get();
        $this->select('');
        return $result[0]['count'];
    }

    public function add(array $params = [])
    {
        $fields = '';
        $value = '';
        $i = 0;

        foreach ($params as $key => $val) {
            $i++;
            if (count($params) == $i) {
                $fields .= $key;
                $value .= ':' . $key;
            } else {
                $fields .= $key . ',';
                $value .= ':' . $key . ',';
            }

        }
        $sql = 'INSERT INTO ' . $this->table . '(' . $fields . ')  VALUES(' . $value . ') '.$this->whereSql();
        return $this->driver->query($sql, $params);
    }

    public function update(array $fields){
        $sql = 'Update '.$this->table.' SET ';
        $i = 1;

        foreach ($fields as $key => $val){
            if ($i == count($fields)){
                $query .= $key.' = :'.$key;
            }else{
                $query .= $key.' = :'.$key.', ';
            }
            $params[$key] = $val;
            $i++;
        }
        $sql .= $query.$this->whereSql();
        $this->params = array_merge($this->params, $params);
        return $this->driver->query($sql, $this->params);
    }
}

















































