

<?php
require_once("DatabaseConnection.php");
//invoice insert
class Invoice {
    public static $table = "invoice";

    public static function create($invoice) {
        $db = (new DBConnection())->getConnection();
        $customer = $db->real_escape_string($invoice->customer);
        $address = $db->real_escape_string($invoice->address);
        $city = $db->real_escape_string($invoice->city);
        $invoice_date = $db->real_escape_string($invoice->invoice_date);
        $query = "INSERT INTO " . self::$table . " (customer, address, city, invoice_date) VALUES ('$customer', '$address', '$city', '$invoice_date')";
        $result = $db->query($query);
        if ($result) {
            return $db->insert_id;
        } else {
            return false;
        }
    }
}

//sale item insert
class SaleItem {
    public static $table = "sale_items";

    public static function create($saleItem) {
        $db = (new DBConnection())->getConnection();
        $invoiceId = $db->real_escape_string($saleItem->sale_id);
        $item = $db->real_escape_string($saleItem->stock_id);
        $quantity = intval($saleItem->quantity);
        $price = floatval($saleItem->price);
        $amount = floatval($saleItem->amount);
        $total = $quantity * $price;
        $query = "INSERT INTO " . self::$table . " (sale_id, stock_id, quantity, price, amount, total) VALUES ('$invoiceId', '$item', '$quantity', '$price', '$amount', '$total')";
        $result = $db->query($query);
    
        if ($result === false) {
            echo "Error: " . $db->error;
        }
    
        return $result !== false;
    }
}

function updateStockBalance($item, $quantity) {
    
    $db = (new DBConnection())->getConnection();
    $item = $db->real_escape_string($item);
    $quantity = intval($quantity);
    $result =null;
    //$result = ["code" => 0, "message"=>"success];
    //echo "SELECT * FROM stocks where id = $item";
    //var_dump($db->query("SELECT * FROM stocks where id = $item"));
    $stock = mysqli_fetch_object( $db->query("SELECT * FROM stocks where id = $item") );
    // var_dump($stock);
    if($stock->balance >= $quantity){
        $query = "UPDATE stocks SET balance = balance - $quantity WHERE id = '$item'";
        $db_result = $db->query($query);
        if ($db_result === false) {
            $result['code'] = -1;
            $result['message'] = $db->error;
            //echo "Error: " . $db->error;
        }
    }else{
        $result['code'] = -1;
        $result['message'] = $stock->name. " is out of stock <br> available qty : ". $stock->balance;
    }
    return $result;
}

function handleFormSubmission() {
    $result = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer = $_POST["Customer"];
        $address = $_POST["Address"];
        $city = $_POST["City"];
        $Invdate = $_POST["Inv_Date"];
        $items = isset($_POST["stock_id"]) ? $_POST["stock_id"] : [];
        $quantities = isset($_POST["balance"]) ? $_POST["balance"] : [];
        $prices = isset($_POST["price"]) ? $_POST["price"] : [];
        $amounts = isset($_POST["amount"]) ? $_POST["amount"] : [];

        // Check stock availability
        foreach ($items as $index => $item) {
            $result = updateStockBalance($item, $quantities[$index]);
            if (is_array($result) && $result['code'] == -1) {
                return $result;
            }
        }

        // Create invoice and sale items
        $invoice = new stdClass();
        $invoice->customer = $customer;
        $invoice->address = $address;
        $invoice->city = $city;
        $invoice->invoice_date = $Invdate;

        $invoiceId = Invoice::create($invoice);

        if ($invoiceId) {
            for ($i = 0; $i < count($items); $i++) {
                $saleItem = new stdClass();
                $saleItem->sale_id = $invoiceId;
                $saleItem->stock_id = $items[$i];
                $saleItem->quantity = $quantities[$i];
                $saleItem->price = $prices[$i];
                $saleItem->amount = $amounts[$i];
                SaleItem::create($saleItem);
            }

            $result['code'] = 0;
            $result['message'] = "success";
        } else {
            $result['code'] = -1;
            $result['message'] = "Failed";
        }
    }

    return $result;
}

$result = handleFormSubmission();
$items = isset($_POST["stock_id"]) ? $_POST["stock_id"] : [];
$quantities = isset($_POST["balance"]) ? $_POST["balance"] : [];
$prices = isset($_POST["price"]) ? $_POST["price"] : []; // Add prices
$amounts = isset($_POST["amount"]) ? $_POST["amount"] : [];


?>
<?php
require_once("./Templates/header.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h4>SALES</h4>
            </div>
           
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
                <div class="card-body1">
                    <?php 
                    //var_dump($result);exit();
                    if(is_array($result)):

                    ?>
                    <div class="container-fluid">
                        <p class="bg-white text-danger text-center my-3 p-2 h2">
                            <?=$result["message"]?>
                        </p>
                    </div>
                        <?php endif;?>
                    <div class="row">
                        <div class="col-5">
                            <div class="input-group mb-3">
                                <span class="input-group-text" >Customer</span>
                                <input type="text" class="form-control" placeholder="Customer" name="Customer" >
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" >Address</span>
                                <input type="text" class="form-control" placeholder="Address" name="Address" >
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input-group mb-3">
                                <span class="input-group-text" >City</span>
                                <input type="text" class="form-control" placeholder="City" name="City"  >
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" >Inv_Date</span>
                                <input type="date" class="form-control" placeholder="Inv_Date" name="Inv_Date" id="date" >
                            </div>
                        </div>
                    </div>  

                <?php require_once("css/sale.php"); ?>
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            
                            <th scope="col">Item</th>
                            <th scope="col" class="text-end">Balance</th>
                            <th scope="col" class="text-end">Price</th>
                            <th scope="col" class="text-end">Amount</th>
                            <th scope="col" class="NoPrint">
                                <button type="button" class="btn btn-sm btn-success" onclick="BtnAdd()">+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        
                    <?php if (empty($items)): ?>
                        <tr id="currentRow">
                            
                            <td>
                                <?php
                                require_once("models/stocks.php");
                                $stocks = stocks::getAll();
                                ?>
                                <select class="form-select product-select" name="stock_id[]" onchange="product_changed(this);">
                                    <option value="">Select item</option>
                                    <?php foreach ($stocks as $s) : ?>
                                    <option value="<?php echo htmlspecialchars($s->id); ?>" data-price="<?php echo htmlspecialchars($s->price); ?>">
                                        <?php echo htmlspecialchars($s->name); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="number" class="form-control text-end quantity-input" name="balance[]" onchange="calculateAmount(this)"></td>
                            <td>
    <input type="text" class="form-control text-end price-input" name="price[]">
</td>
<td>
    <input type="number" class="form-control text-end amount-input" name="amount[]" readonly>
</td>

                        <td class="NoPrint"><button type="button" class="btn btn-sm btn-danger" onclick="BtnDel(this)">X</button></td>
                    </tr>
                    <?php endif;?>
                    <?php
                        if (isset($items)):
                            for ($i = 0; $i < count($items); $i++):
                                $saleItem = new stdClass();
                                // $saleItem->sale_id = $invoiceId;
                                $saleItem->stock_id = $items[$i];
                                $saleItem->quantity = $quantities[$i];
                                $saleItem->price = $prices[$i]; // Add price
                                $saleItem->amount = $amounts[$i]; // Add amount                                
                                ?>
                                <tr id="currentRow">
                           
                            <td>
                                <?php
                                require_once("models/stocks.php");
                                $stocks = stocks::getAll();
                                ?>
                                <select class="form-select product-select" name="stock_id[]" onchange="product_changed(this);">
                                    <option value="">Select item</option>
                                    <?php foreach ($stocks as $s) : ?>
                                    <option <?=($saleItem->stock_id == $s->id)?"selected":""?> value="<?php echo htmlspecialchars($s->id); ?>" data-price="<?php echo htmlspecialchars($s->price); ?>">
                                        <?php echo htmlspecialchars($s->name); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="number" value="<?= $saleItem->quantity?>" class="form-control text-end quantity-input" name="balance[]" onchange="calculateAmount(this)"></td>
                            <td>
    <input type="text" class="form-control text-end price-input" value="<?= $saleItem->price?>" name="price[]">
</td>
<td>
    <input type="number" class="form-control text-end amount-input"value="<?= $saleItem->amount?>"  name="amount[]" readonly>
</td>

                        <td class="NoPrint"><button type="button" class="btn btn-sm btn-danger" onclick="BtnDel(this)">X</button></td>
                    </tr>
                                <?php endfor;  endif;?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-primary" onclick="GetPrint()">Print</button>
                </div>
                <div class="col-5"></div>
                <div class="col-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" >Total</span>
                        <input type="text" class="form-control text-end" id="FTotal" name="Total" disabled="">
                    </div>
                    <input type="submit" name="submit" value="save" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script>
function BtnAdd() {
    // Get the table body element
    var tableBody = document.getElementById("tableBody");

    // Get the current row
    var currentRow = document.getElementById("currentRow");

    // Clone the current row
    var newRow = currentRow.cloneNode(true);

    // Clear the input values in the new row
    var inputs = newRow.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
    }

    // Append the new row to the table body
    tableBody.appendChild(newRow);

    // Bind event listeners to the new row
    bindEventListeners(newRow);
}

function BtnDel(v) {
    $(v).parent().parent().remove(); 
    GetTotal();
    $("#TBody").find("tr").each(
        function(index) {
            $(this).find("th").first().html(index);
        }
    );
}

function bindEventListeners(row) {
    // Update price when product changes
    $(row).find('.product-select').change(function() {
        var selectedOption = $(this).find(':selected');
        var price = selectedOption.data('price');
        $(this).closest('tr').find('.price-input').val(price);
        calculateAmount($(this).closest('tr'));
    });

    // Calculate amount when quantity changes
    $(row).find('.quantity-input').on('input', function() {
        calculateAmount($(this).closest('tr'));
    });
}

function calculateAmount(row) {
    var quantity = parseInt($(row).find('.quantity-input').val());
    var price = parseFloat($(row).find('.price-input').val());
    var amount = quantity * price;
    $(row).find('.amount-input').val(amount.toFixed(0));
    calculateTotal();
}

function calculateTotal() {
    var total = 0;
    $('.amount-input').each(function() {
        total += parseFloat($(this).val());
    });
    $('#FTotal').val(total.toFixed(0));
}

// Bind event listeners to the initial row
$(document).ready(function() {
    bindEventListeners($('#currentRow'));
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get today's date
        var today = new Date();
        
        // Format the date to YYYY-MM-DD
        var year = today.getFullYear();
        var month = ("0" + (today.getMonth() + 1)).slice(-2); // Months are zero-based
        var day = ("0" + today.getDate()).slice(-2);
        
        // Combine into the format needed for the input
        var formattedDate = year + "-" + month + "-" + day;
        
        // Set both min and max attributes for the input
        var dateInput = document.getElementById("date");
        dateInput.setAttribute("min", formattedDate); // Prevent past dates
        dateInput.setAttribute("max", formattedDate); // Prevent future dates
    });
</script> 