<?php
require_once("Templates/header.php");
require_once("models/stocks.php");
require_once("models/invoice.php");

$conn = new mysqli('localhost', 'root', '', 'sales');
$result = $conn->query('SELECT * FROM invoice');
$invoices = [];
while ($invoice = mysqli_fetch_object($result)) {
    $invoices[] = $invoice;
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Report List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Share</button> -->
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">Export</button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Inv.Date</th>
                    <th scope="col">Invice ID</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice) : ?>
                    <?php
                    $result = $conn->query('SELECT * FROM sale_items WHERE sale_id =' . $invoice->invoice_number);
                    $items = [];
                    while ($item = mysqli_fetch_object($result)) {
                        $items[] = $item;
                    }
                    $total = 0;
                    foreach ($items as $item) {
                        $total += $item->amount;
                    }
                    ?>
                    <tr>
                        <td><?= $invoice->invoice_date ?></td>
                        <td><?= $invoice->invoice_number ?></td>
                        <td><?= $total ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
