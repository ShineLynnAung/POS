<?php
require_once("models/invoice.php");
// require_once("./Templates/header.php");



echo "<h4><center>INVOICES</center></h4><br><br>";


$invoice = invoice::getAll();
?>



<?php
$conn = new mysqli('localhost', 'root', '', 'sales');
$result = $conn->query('select * from invoice');
$invoices = [];
$selectedInvoiceNumber = $_GET['invoice_number'];

while ($invoice = mysqli_fetch_object($result)) {
    if ($invoice->invoice_number == $selectedInvoiceNumber) {
        $invoices[] = $invoice;
    }
}

?>
            <?php foreach ($invoices as $i) : ?>
                <?php
                $result = $conn->query('select * from sale_items where sale_id =' . $i->invoice_number);
                $items = [];
                while ($item = mysqli_fetch_object($result)) {
                $items[] = $item;
                }
                $total = 0;
                foreach ($items as $item) {
                 $total += $item->amount;
                 }
                ?>
            <div class="card-body1">


                <div class="row">
                  
                    <div class="col-5">
                        <div class="input-group mb-3">
                            <span class="input-group-text" >Customer</span>
                            <input type="text" class="form-control" placeholder="Customer"  value="<?= $i->customer ?>" readonly>
                        </div>
            
                        <div class="input-group mb-3">
                            <span class="input-group-text" >Address</span>
                            <input type="text" class="form-control" placeholder="Address" value="<?= $i->address ?>" readonly>
                        </div>
            
                        <div class="input-group mb-3">
                            <span class="input-group-text" >City</span>
                            <input type="text" class="form-control" name="invoice_number" placeholder="City"  value="<?= $i->city ?>" readonly>
                        </div>
                    </div>
                    <div class="col-5">
                      
                        <div class="input-group mb-3">
                            <span class="input-group-text" >Inv. No</span>
                            <input type="text" class="form-control" placeholder="Inv. No" value="<?= $i->invoice_number ?>" readonly>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" >Inv. Date</span>
                            <input type="date" class="form-control" placeholder="Inv. Date" value="<?= $i->invoice_date ?>" readonly>
                        </div>



                    </div>
                </div>
                <?php
                $result = $conn->query('select * from sale_items where sale_id ='. $i->invoice_number);
                $items = [];
                while($item = mysqli_fetch_object($result)) $items[] = $item;
            ?>
                <?php require_once("css/sale.php"); ?>
                <table class="table1 table1-bordered">
                    <thead class="table1-success">
                      <tr>
                        
                        <th scope="col">item</th>
                        <th scope="col" class="text-end">Balance</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Amount</th>
                        <th scope="col" class="NoPrint">
                          
                        </th>

                      </tr>
                    </thead>
                    
                    <?php foreach($items as $s):?>

                    <tbody id="TBody">
                      <tr id="TRow" class="d-none">
                        <th scope="row">1</th>
                        <?php
                        $stock = mysqli_fetch_object($conn->query("select * from stocks where id = ". $s->stock_id));
                    ?>
                    <tr>
                    <td><input type="text" name="item[]" value="<?= $stock->name ?>" readonly></td>
                    <td><input type="number" name="quantity[]" value="<?= $s->quantity ?>" readonly></td>
                    <td><input type="number" name="price[]" value="<?= $s->price ?>" readonly></td>
                    <td><input type="number" name="amount[]" value="<?= $s->amount ?>" readonly></td>
                    <?php endforeach; ?>
                   


                        </td>
                    </tr>
                
                    </tbody>
                    

                  </table>


                  <div class="row">
                 
                    <div class="col-4">
                    </div>
                    <div class="col-5"> </div>
                    <div class="col-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" >Total</span>
                            <input type="text" class="form-control text-end" id="FTotal" name="FTotal" disabled="" value="<?= $total ?>">
                        </div>

                        
                        </div>   
                </div>
                <a href="reports.php" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"/>
                </svg> Back to List 
                </a>
             </div>
          </div>

    </div>
     <hr>
     

     <br>

    
     <?php endforeach; ?>



    </form>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>




</html>