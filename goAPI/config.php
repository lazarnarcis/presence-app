<?php
    $current_dir = __DIR__;

    while ($current_dir != '/' && !file_exists($current_dir . '/index.php')) {
        $current_dir = dirname($current_dir);
    }
    require_once $current_dir . '/vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable($current_dir);
    $dotenv->load();

    $whitelist = array('127.0.0.1', '::1');
    if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_NAME'];
        $server = $_ENV['DB_SERVER'];
    } else {
        $username = "root";
        $password = "";
        $database = "presence";
        $server = "localhost";
    }

    class Database {
        public $server;
        public $password;
        public $username;
        public $database;
        public $string_where = "";

        public function __construct() {
            $this->password = $GLOBALS['password'];
            $this->username = $GLOBALS['username'];
            $this->database = $GLOBALS['database'];
            $this->server = $GLOBALS['server'];
        }
        
        function connect() {
            return mysqli_connect($this->server, $this->username, $this->password, $this->database);
        }

        function disconnect($db) {
            return mysqli_close($db);
        }

        function deleteRow($table) {
            $db = self::connect();
            $query = "DELETE FROM $table".$this->string_where;
            mysqli_query($db, $query);
            self::disconnect($db);
            return true;
        }

        function deleteColumn($table, $column) {
            $db = self::connect();
            $query = "ALTER TABLE $table DROP COLUMN $column";
            mysqli_query($db, $query);
            self::disconnect($db);
            return true;
        }

        function addColumn($table, $column, $type, $value = NULL) {
            $db = self::connect();
            if ($type == "VARCHAR") {
                $value = 64;
            } elseif ($type == "INT") {
                $value = 11;
            }
            $query = "ALTER TABLE $table ADD COLUMN $column $type($value)";
            mysqli_query($db, $query);
            self::disconnect($db);
            return true;
        }

        function select($table, $columns = [], $limit = NULL) {
            $db = self::connect();
            $limit_text = NULL;
            if ($limit != NULL) {
                $limit_text.=" LIMIT $limit";
            }
            $columns_text = "*";
            if (count($columns)) {
                $columns_text = "";
                foreach ($columns as $key => $column) {
                    if (count($columns) - 1 == $key) {
                        $columns_text .= " $column ";
                    } else {
                        $columns_text .= " $column, ";
                    }
                }
            }
            $query = "SELECT $columns_text FROM $table".$this->string_where.$limit_text;
            $data = mysqli_query($db, $query);
            $returndata = array();
            while ($row = mysqli_fetch_assoc($data)) {
                $returndata[] = $row;
            }
            self::disconnect($db);
            return $returndata;
        }

        function update($table, $data) {
            $db = self::connect();

            $keys = array_keys($data);
            $values = array_values($data);
            $string_values = "";

            for ($i=0;$i<count($keys);$i++) {
                if (strlen($string_values) == 0) {
                    $string_values.="".$keys[$i]."='".$values[$i]."'";
                } else {
                    $string_values.=", ".$keys[$i]."='".$values[$i]."'";
                }
            }

            $query = "UPDATE $table SET $string_values".$this->string_where;
            mysqli_query($db, $query);
            self::disconnect($db);
            return true;
        }

        function where($key, $value) {
            if (strlen($this->string_where) == 0) {
                $this->string_where.=" WHERE $key='$value'";
            } else {
                $this->string_where.=" OR $key='$value'";
            }
        }

        function insert($table, $data) {
            $db = self::connect();

            $keys = array_keys($data);
            $string_keys = "";
            for ($i=0;$i<count($keys);$i++) {
                if (strlen($string_keys) == 0) {
                    $string_keys.=$keys[$i];
                } else {
                    $string_keys.=", ".$keys[$i];
                }
            }

            $values = array_values($data);
            $string_values = "";
            for ($i=0;$i<count($values);$i++) {
                if (strlen($string_values) == 0) {
                    $string_values.="'".$values[$i]."'";
                } else {
                    $string_values.=", '".$values[$i]."'";
                }
            }

            $query = "INSERT INTO $table ($string_keys) VALUES ($string_values)";
            mysqli_query($db, $query);
            self::disconnect($db);
            return true;
        }

        function query($query) {
            $db = self::connect();
            $data = mysqli_query($db, $query);

            $returndata = array();
            while($row = mysqli_fetch_assoc($data)) {
                $returndata[] = $row;
            }
            self::disconnect($db);
            return $returndata;
        }
    }
?>