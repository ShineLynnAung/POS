<?php
    require_once("models/model.php");
    // require_once("models/role.php");
    require_once("DatabaseConnection.php");

    class stocks extends Model{
        private static $table = "stocks";

        public $id;
        public $name;
        public $balance;
        public $price;

        public static function getAll(){
            $query = "SELECT * FROM ". stocks::$table;
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $stocks = [];

            while($row = mysqli_fetch_object($results)){
                $user = new stocks();
                
                $user-> id= $row->id;
                $user->name = $row->name;
                $user->balance = $row->balance;
                $user->price = $row->price;
                $stocks[] = $user;
            }
            return $stocks;
        }
        public static function find($id){
            $query = "SELECT * FROM ". stocks::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $row = mysqli_fetch_object($results);
            $user = null;
            if(isset($row)){
                $user = new stocks();
                $user-> id = $row->id;
                $user->name = $row->name;
                $user->balance = $row->balance;
                $user->price = $row->price;
            }
            return $user;
        }

        public static function delete($id){
            $query = "DELETE FROM ". stocks::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

        public function update(){
            $table = stocks::$table;

            $query = "
                        UPDATE $table 
                        SET name = '$this->name', balance = '$this->balance', price = $this->price
                        WHERE id = $this->id
                    ";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

       

        public static function create($user){
            $table = stocks::$table;

            $query = "
                        INSERT INTO $table (id, name, balance, price) values (null, '$user->name', '$user->balance', '$user->price');
                    ";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

    }

?>