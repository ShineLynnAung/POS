<?php
    require_once("models/model.php");
     require_once("models/stocks.php");
    require_once("DatabaseConnection.php");

    class save_date extends Model{
        private static $table = "update_record";

        public $id;
        public $name;
        public $last_balance;
        public $price;
        public $upd_time;

        public static function getAll(){
            $query = "SELECT * FROM ". save_date::$table;
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $update = [];

            while($row = mysqli_fetch_object($results)){
                $upd = new save_date();
                
                $upd-> id= $row->id;
                $upd->name = $row->name;
                $upd->last_balance = $row->last_balance;
                $upd->price = $row->price;
                $upd->upd_time = $row->upd_time;

                $update[] = $upd;
            }
            return $update;
        }
       

        public static function find($id){
            $query = "SELECT * FROM ". save_date::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $row = mysqli_fetch_object($results);
            $user = null;
            if(isset($row)){
                $upd = new save_date();
                $upd-> id= $row->id;
                $upd->name = $row->name;
                $upd->last_balance = $row->last_balance;
                $upd->price = $row->price;
                $upd->upd_time = $row->upd_time;
            }
            return $upd;
        }


        public static function delete($id){
            $query = "DELETE FROM ". save_date::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

        public function update(){
            $table = save_date::$table;

            $query = "
                        UPDATE $table 
                        SET last_balance = '$this->last_balance', upd_time = '$this->upd_time'
                        WHERE id = $this->id
                    ";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

        // public function updateStock($item, $quantity) {
        //     $db = (new DBConnection())->getConnection();
        //     $item = $db->real_escape_string($item);
        //     $quantity = $db->real_escape_string($quantity);
            
        //     // Update the stock quantity by deducting the sold quantity
        //     $query = "UPDATE stocks SET balance = balance - $quantity WHERE item = '$item'";
        //    $results = $db->query($query);
        //    return true;
        // }
       

        public static function create($upd){
            $stocks = stocks::getAll();
    
            $table = save_date::$table;
            
            date_default_timezone_set('Asia/Yangon');
            $currentDateTime = date("Y-m-d H:i:s"); // Get the current datetime
            // $previousBalance = ($stocks) ? $stocks[0]->balance : null;
        
            $query = "INSERT INTO $table (id, name, last_balance,price, upd_time) values (null, '$upd->name','$upd->last_balance', '$upd->price', '$currentDateTime')";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }
    }

?>