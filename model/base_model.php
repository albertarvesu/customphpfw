<?php
    require_once dirname(__FILE__).'/../config/database.php';
    require_once dirname(__FILE__).'/../util/database.php';
    require_once dirname(__FILE__).'/../util/sql_helper.php';

    class BaseModel
    {
        public $db = NULL;

        public $id = NULL;
        public $data = NULL;

        public $table = NULL;
        public $primary = NULL;

        public function __construct()
        {
            $this->db = Database::getInstance();
            $this->db->connect(HOST, USERNAME, PASSWORD, DBNAME);
        }

        // getters - all and by row
        public function findAll($data, $cond=NULL, $order=NULL)
        {
            $sql = SqlHelper::genSelect($data, $this->table, $cond);
            if($order) $sql .= " ORDER BY ".$order['field']." ".$order['order'];
            $rs = $this->db->query($sql);
            if($rs && 0 < $this->db->getNumRows())
                return $this->db->fetchAll($rs);
            return false;
        }

        public function find($data, $cond=NULL)
        {
            $sql = (is_array($data)) ? SqlHelper::genSelect($data, $this->table, $cond) : $data;
            $rs = $this->db->query($sql);
            if($rs && 0 < $this->db->getNumRows())
                return $this->db->fetchRow($rs);
            return false;
        }

        public function findMax()
        {
            $sql = "SELECT MAX(".$this->primary.") AS max FROM ".$this->table;
            $rs = $this->db->query($sql);
            if($rs && 0 < $this->db->getNumRows())
                return $this->db->fetchRow($rs);
            return false;
        }

        // updaters
        public function add()
        {
            $sql = SqlHelper::genInsert($this->data, $this->table);
            return $this->db->query($sql);
        }

        public function update()
        {
            $sql = SqlHelper::genUpdate($this->data, $this->table, $this->primary, $this->id);
            return $this->db->query($sql);
        }

        public function delete()
        {
            $sql = "DELETE FROM ".$this->table." WHERE ".$this->primary." = '".$this->id."';";
            return $this->db->query($sql);;
        }

        // setters
        public function setData($data)
        {
            $this->data = $data;
        }

        public function setId($id)
        {
            $this->id = $id;
        }
    }
