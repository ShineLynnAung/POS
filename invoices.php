<?php
//session_start();
require_once("models/invoice.php");
require_once("./Templates/header.php");

echo "<h4><center>INVOICES</center></h4><br><br>";


$invoice = invoice::getAll();

//$result = $_SESSION['result'];
?>
<?php if( isset($result) && $result['code'] == -1): ?>
<h1 class="text-center bg-danger text-white"> <?=$result["message"]?> </h1>
<?php
   // $_SESSION['result'] = null;
?>
<?php endif; ?>
<?php
    $conn = new mysqli('localhost', 'root', '', 'sales');
    $result = $conn->query('select * from invoice ORDER BY invoice_number DESC');
    $invoices = [];
    while($invoice = mysqli_fetch_object($result))
    $invoices[] = $invoice;

    
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
                            <input type="text" class="form-control" placeholder="City"  value="<?= $i->city ?>" readonly>
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
                
                <table width="100%" border="1" cellspacing="0" cellpadding="2" class="table table-striped table-hover">
                    <thead class="table1-success">
                      <tr>
                        
                        <th>item</th>
                        <th >Balance</th>
                        <th>Price</th>
                        <th>Amount</th>
                        

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
                    <td><?= $stock->name ?></td>
                    <td><?= $s->quantity ?></td>
                    <td><?= $s->price ?></td>
                    <td><?= $s->amount ?></td>
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