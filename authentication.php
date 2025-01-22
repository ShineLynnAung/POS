<?php      
require_once("DatabaseConnection.php");
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($db, $username);  
        $password = mysqli_real_escape_string($db, $password);  
      
        $sql = "select *from users where username = '$username' and password = '$password'";  
        $result = mysqli_query($db, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            // echo "<h1><center> Login successful </center></h1>";  
            header("location:stock.php");
        }  
        else{  
            print "<p> Login failed. Invalid username or password.</p>";  
        }     
?>  