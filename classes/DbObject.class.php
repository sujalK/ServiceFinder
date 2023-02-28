<?php 

    class DbObject {
        
        public static $database;
        protected static $table_name = '';
        public static $count_rows    = 0;
        static protected $db_columns = [];

        // errors, grab errors here
        public $errors = [];
        
        public static function set_db($database) 
        {
            self::$database= $database;
        }
        
        public static function find_by_sql($sql) 
        {
            $result= self::$database->query($sql);
            
            // set rows count to property itself
            // self::$count_rows = $result->num_rows;

            if(!$result) {
                exit("Oops! Something wrong (with db query).");
            }

            // grabbing results into array, array contains objects.
            $object_array= [];
            
            while($record= $result->fetch_assoc()) {
                $object_array[]= static::instantiate($record);
            }
            // free up the result
            $result->free();
            return $object_array;
        }
        
        public static function find_all() {
            $sql= "SELECT * FROM ". static::$table_name;
            return static::find_by_sql($sql);
        }

        public static function find_by_id($id) 
        {
            $sql     = "SELECT * FROM ". static::$table_name;
            $sql    .= " WHERE id=". self::$database->escape_string($id);
            $obj_arr = static::find_by_sql($sql);
            if(!empty($obj_arr)) {
                return array_shift($obj_arr);
            } else {
                return false;
            }
        }
        
        public static function instantiate($record) 
        {
            // create new object, which stores db values
            $object= new static;
            foreach($record as $property => $value) {
                if(property_exists($object, $property)) {
                    $object->$property = $value;
                }
            }
            return $object;
        }

        protected function create() 
        {
            // validate
            $this->validate();
            
            if(!empty($this->errors)) { return false; }
            
            // use sanitized
            $sanitized= $this->sanitized();
            
            // merge attrs to right data type values.
            $merged_attrs= [];
            
            $sql  = "INSERT INTO ". static::$table_name . "(";
            $sql .= join(', ', array_keys($sanitized)) . ")";
            $sql .= " VALUES(";
            $sql .= join(", ", $this->create_sql_parameters($sanitized));
            $sql .= " )";

            // echo "<pre>";
            //     print_r($sql);
            // echo "</pre>";exit;
            // return $sql;

            $result= self::$database->query($sql);

            if($result) {
                $this->id= self::$database->insert_id;
            }

            return $result;
        }

        // update
        public function update() 
        {
            
            $this->validate();

            if(!empty($this->errors)) { return false; }

            $sanitized= $this->sanitized();
            
            $attribute_pairs= [];

            foreach($sanitized as $k=> $v) {
                $attribute_pairs[]= "{$k}=". $this->create_sql_param($v);
            }

            $sql  = "UPDATE ". static::$table_name . " SET ";
            $sql .= join(', ', $attribute_pairs);
            $sql .= " WHERE id=". self::$database->escape_string($this->id);
            $sql .= " LIMIT 1";

            // print_r($sql);

            $result= self::$database->query($sql);

            return $result;
        }
        
        // create sql parameters
        protected function create_sql_parameters($properties) 
        {
            $params= [];
            foreach($properties as $k => $v) {
                $params[$k]= $this->create_sql_param($v);
            }
            return $params;
        }

        // create sql param , for right data type
        protected function create_sql_param($value) 
        {
            if(is_null($value)) {
                return 'NULL';
            }

            if(is_numeric($value)) {
                $value += 0;
                if(is_int($value)) {
                    return $value;
                }
            }
            return "'{$value}'";
        }

        // returns properties and values
        protected function property() 
        {
            $prop_arr= [];
            foreach(static::$db_columns as $c) {
                if(property_exists($this, $c)) {
                    if($c == 'id') { continue; }
                    $prop_arr[$c]= $this->$c;
                }
            }
            return $prop_arr;
        }


        // sanitized property
        protected function sanitized() 
        {
            $sanitized= [];
            foreach($this->property() as $k => $v) {
                $sanitized[$k]= self::$database->escape_string($v);
            }
            return $sanitized;
        }

        public function delete() {
            $sql  = "DELETE FROM ". static::$table_name . " ";
            $sql .= "WHERE id=". self::$database->escape_string($this->id);
            $sql .= " LIMIT 1";
            $result= self::$database->query($sql);
            return $result;
        }
        
        protected function validate() {
            return $this->errors;
        }
        
    }
?>