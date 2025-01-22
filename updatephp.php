<!DOCTYPE html>
<html>
<head>
    <title>Update</title>
    <style>

.wrap{
            width: 500px;
            margin: 0px auto;
            background-color: #2d2b2b;
            border: 20px solid #2d2b2b;
            border-radius: 20px;
            box-shadow: 0 0 10px #6cdafb;
        }

        body {
            font-family: Arial, sans-serif;
        }
        /* form {
            width: 300px;
            margin: 0 auto;
        } */
        label {
            color: white;
            display: block;
            margin-top: 10px;
        }
        input[type=price], select, textarea {
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
    </style>
</head>
<body>
   <?php
    require_once("models/stocks.php");
    require_once("models/save.php");


    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $user = stocks::find($id);

        if (isset($user)) {
    ?>

    <div class="wrap">  
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="id" value="<?php echo $user->id;?>">

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user->name);?>" required><br>

        <label for="balance">balance:</label><br>
        <input type="text" id="balance" name="balance" value="<?php echo htmlspecialchars($user->balance);?>"><br>

        <label for="price">price:</label><br>
        <input type="price" id="price" name="price" value="<?php  echo htmlspecialchars($user->price);?>"><br>

        <input type="submit" name="submit" value="Update stock">
    </form>
    </div>
    <?php
        } else {
            echo "<p>stock not found.</p>";
        }
    }

    if (isset($_POST["submit"])) {
        $id = intval($_POST["id"]);
        $user = new stocks();
        $user->id = $id;

        $old_stock = stocks::find($id);
        $old_name = $old_stock->name;
        $old_balance = $old_stock->balance;
        $old_price = $old_stock->price;
        $user->name = $_POST["name"];
        $user->balance = $_POST["balance"];
        $user->price = $_POST["price"];
    
        $result = $user->update();
        if ($result) {
            // Insert into update_stock table
            $upd = new save_date();
            $upd->id = $id;
            $upd->name = $old_name;
            $upd->last_balance = $old_balance;
            $upd->price = $old_price;
            $result = $upd->create($upd);
            if ($result) {
                echo "<p>Stock updated successfully.</p>";
                header("Location: stock.php");
                exit(); // Terminate the script after redirection
            } else {
                echo "<p>Error creating update record.</p>";
            }
        } else {
            echo "<p>Error updating stock.</p>";
        }
    }
    ?>
</body>
</html>