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
    <h2 class="head"><center><u>Add New Stock</u></center></h2>
    <div class="wrap">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <!-- <label for="id">ID:</label><br>
        <input type="number" id="id" name="id" required><br> -->

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="balance">Balance:</label><br>
        <input type="number" id="balance" name="balance" required><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br>

        <input type="submit" name="submit" value="Add Stock" class="btn btn-primary">
    </form>

    <?php
    require_once("models/stocks.php");

    if (isset($_POST["submit"])) {
        $user = new stocks();
        
        $user->id = $_POST["id"];
        $user->name = $_POST["name"];
        $user->balance = $_POST["balance"];
        $user->price = $_POST["price"];

        $result = stocks::create($user);

        if ($result) {
            echo "<p> created successfully.</p>";

            header("Location: stock.php");

        } else {
            echo "<p>Error creating user.</p>";
        }   
    }
    ?>

</div>
</body>
</html>