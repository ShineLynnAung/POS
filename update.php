<!-- <?php

     require_once("models/stocks.php");
    // require_once("user_create.php");
    $id = $_GET['id'];

    $getList=stocks::find($id);
   

    // var_dump( $getList );
    // echo'<hr>';

    // echo($getList->name);
    // echo($getList->password);
    // echo($getList->role_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <style>
        .wrap{
            width: 500px;
            margin: 0px auto;
            background-color: #2d2b2b;
            border: 20px solid #2d2b2b;
            border-radius: 20px;
            box-shadow: 0 0 10px #6cdafb;
        }
        input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 2px solid #6cdafb;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 10px;
  resize: vertical;
  box-shadow: 0 0 20px #6cdafb;
  
}

  input[type=number], select, textarea {
  width: 100%;
  padding: 12px;
  border: 2px solid #6cdafb;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 10px;
  resize: vertical;
  box-shadow: 0 0 20px #6cdafb;
}

label{
    color: white;
}

  input[type=submit]{
  background-color: #2d2b2b;
  color: rgb(6, 6, 6);
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  border: 1px solid #6cdafb;
  width: 100%;
  box-shadow: 0 0 20px #6cdafb;
  color: white;
}
  

  .head{
    font-family: sans-serif;
    color: #2a2a2a;
  }
    </style>
</head>
<body>
    <h2 class="head"><center><u>Stock Data Edition Form</u></center></h2>
    <div class="wrap">
    <form method="GET" action="updatephp.php">
        <label for="id">ID:</label><br>
        <input type="number" id="id" name="id" value="<?=$getList->id?>" required><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?=$getList->name?>" required><br>

        <label for="balance">Balance:</label><br>
        <input type="number" id="balance" name="balance" value="<?=$getList->balance?>" required><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?=$getList->price?>" required><br>

        <input type="submit" name="submit" value="Add Stock" class="btn btn-primary">
    </form>

   

</div>
</body>
</html> -->