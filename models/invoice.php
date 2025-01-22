<?php
    require_once("models/model.php");
    require_once("DatabaseConnection.php");

    class invoice extends Model{
        private static $table = "invoice";

        public $customer;
        public $address;
        public $city;
        public $invoice_number;
        public $invoice_date;
        public $total;

        public static function getAll(){
            $query = "SELECT * FROM ". invoice::$table;
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $invoices = [];

            while($row = mysqli_fetch_object($results)){
                $invoice = new invoice();
                $invoice-> customer = $row->customer;
                $invoice->address = $row->address;
                $invoice->city = $row->city;
                $invoice->invoice_number = $row->invoice_number;
                $invoice->invoice_date = $row->invoice_date;
                // $invoice->total = $row->total;
               
                $invoices[] = $invoice;
            }
            return $invoices;
        }
        public static function find($id){
            $query = "SELECT * FROM ". invoice::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            $row = mysqli_fetch_object($results);
            $invoice = null;
            if(isset($row)){
                $invoice = new invoice();
                $invoice-> customer = $row->customer;
                $invoice->address = $row->address;
                $invoice->city = $row->city;
                $invoice->invoice_number = $row->invoice_number;
                $invoice->invoice_date = $row->invoice_date;
                $invoice->total = $row->total;
            }
            return $invoice;
        }

        public static function delete($id){
            $query = "DELETE FROM ". invoice::$table . " where id = $id limit 1;";
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

        public static function create($invoice){
            $table = invoice::$table;

            $query = "INSERT INTO $table (customer, address, city, invoice_number, invoice_date, item, quantity, price, amount, total) VALUES ('{$invoice->customer}', '{$invoice->address}', '{$invoice->city}', null, '{$invoice->invoice_date}', '{$invoice->item}', '{$invoice->quantity}', '{$invoice->price}', '{$invoice->amount}', '{$invoice->total}')";
            
            $db = new DBConnection();
            $conn = $db->getConnection();
            $results = $conn->query($query);
            return true;
        }

    }

?>