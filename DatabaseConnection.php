<?php
        $db=mysqli_connect('localhost','root','','sales');

   
   class DBConnection{
        private $server = "localhost";
        private $user = "root";
        private $password = "";
        private $db = "sales";
        

        function getConnection(){
            $conn = new mysqli($this->server, $this->user, $this->password, $this->db);
            return $conn;
        }
   }
?>