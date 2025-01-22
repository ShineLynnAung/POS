<?php
require_once("./Templates/header.php");
?>
<?php require_once("./DatabaseConnection.php");
$nameError = '';
$balanceError = '';
$priceError = '';

if (isset($_POST['create-button'])) {

    $name = $_POST['name'];
    $balance = $_POST['balance'];
    $price = $_POST['price'];
    

    $query = "INSERT INTO stocks(name,balance,price) VALUES('$name',$balance,$price)";

    if (empty($name)) {
        $nameError = "Name is required";
    }
    if (empty($balance)) {
        $balanceError = "Balance is required";
    }
    if (empty($price)) {
        $priceError = "Price is required";
    }
    if (!empty($name) && !empty($balance) && !empty($price)) {
        mysqli_query($db, $query);
        header("Location: index.php");
    }
}


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-title">Adding stock items</div>
                        </div>
                    </div>
                    <form action="create1.php" method="post">
                        <div class="card-body">


                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name" >
                                <span class="text-danger"><?php echo $nameError; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Stock Balance</label>
                                <input type="text" name="balance" class="form-control" placeholder="Enter stock balance">
                                <span class="text-danger"><?php echo $balanceError; ?></span>

                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Enter Price in Kyats">
                                <span class="text-danger"><?php echo $priceError; ?></span>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" name="create-button" class="btn btn-primary">
                                Create New
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once("./Templates/footer.php");
?>