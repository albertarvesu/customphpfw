<?php
    class Database
    {
        private static $instance = null;
        private $numRows = null;
        private $connect = null;

        private function __construct()
        {}

        public static function getInstance()
        {
            if(null == self::$instance)
                self::$instance = new Database();
            return self::$instance;
        }

        public function connect($host, $username, $password, $dbname)
        {

            if( !$this->connect = mysql_connect($host, $username, $password) )
            {
                die("cannot connect to the database");
            }

             if( !$select = mysql_select_db($dbname) )
             {
                die("$dbname cannot be select to the database");
             }
             return $this->connect;
        }

        public function query($query)
        {
            #die ($query);

            if( !$rs = mysql_query(  $query  ) )
            {
                die(htmlentities($query)." cannot execute this query");
            }

		    if( eregi("^SELECT",$query) )
		    {
			    $this->numRows = mysql_num_rows($rs);
			}

			//mysql_free_result($rs);

            return $rs;
        }

        public function fetchAll($rs)
        {
            $rows = array();
            while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
		    {
			    $rows[] = $row;
		    }
		    return $rows;
        }

        public function fetchRow($rs)
        {
            if( !$row = mysql_fetch_array($rs, MYSQL_ASSOC) )
            {
                die("Error fetching row");
            }
            return $row;
        }

        public function getNumRows()
        {
            return $this->numRows;
        }

        public function disconnect()
        {
            if( !$close = mysql_close($this->connect) )
            {
                die("Error closing connection");
            }
            return $close;
        }
    }
