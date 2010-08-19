<?php
    class SqlHelper
    {
        public static function genSelect($data, $table, $cond = NULL)
        {
            $fields = join(', ', $data);
            $cond = is_array($cond) ? SqlHelper::createEq($cond, 'AND ') : $cond;
            $sql = "SELECT $fields FROM $table";
            $sql .= ($cond) ? " WHERE $cond" : "";
            return $sql;
        }
 
        public static function genInsert($data, $table)
        {
            $data = SqlHelper::quote($data);
            $keys = join(', ' , array_keys($data));
            $vals = join('\', \'' , array_values($data));
            return "INSERT INTO $table ({$keys}) VALUES ('{$vals}')";
        }

        public static function genUpdate($data, $table, $pri, $id, $cond = null)
        {
            $data = is_array($data) ? SqlHelper::createEq(SqlHelper::quote($data), ', ') : $data;
            $cond = is_array($cond) ? SqlHelper::createEq($cond, 'AND ') : $cond;
            $sql = "UPDATE $table SET $data WHERE $pri = '$id'";
            $sql .= ($cond) ? " AND $cond" : "";
            return $sql;
        }
        
        private static function quote($data)
        {
            if(is_array($data))
            {
                foreach($data as $key=>$value)
                {
                    if(is_array($value))
                        SqlHelper::quote($value);
                    else
                        $data[$key] = mysql_real_escape_string($value);
                }
            }
            return $data;
        }

        public static function createEq($data, $sep)
        {
            $arr = array();
            
            foreach($data as $key=>$val)
            {
                $arr[] = "$key='$val'";
            }
            return join($sep, $arr);
            
        }
    }
?>
