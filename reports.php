<?php

require_once("Templates/header.php");
require_once("models/stocks.php");
require_once("models/invoice.php");

$conn = new mysqli('localhost', 'root', '', 'sales');
$result = $conn->query('SELECT * FROM invoice ORDER BY invoice_number DESC');
$invoices = [];
while($invoice = mysqli_fetch_object($result))
    $invoices[] = $invoice;

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Report List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1"/>
                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                    </svg>
                
                
                Print</button>
            </div>
        </div>
    </div>

    <?php foreach ($invoices as $invoice) : ?>
        <?php
        $result_items = $conn->query('SELECT * FROM sale_items WHERE sale_id =' . $invoice->invoice_number);
        $items = [];
        while ($item = mysqli_fetch_object($result_items)) {
            $items[] = $item;
        }
        $total = 0;
        foreach ($items as $item) {
            $total += $item->amount;
        }
        ?>

        <?php require_once("css/sale.php"); ?>

        <div class="table-responsive">
        <table class="table table-striped table-hover" id="dataTable<?= $invoice->invoice_number ?>">
                <thead>
                    <tr>
                        <th scope="col">Inv.Date</th>
                        <th scope="col">Inv.No</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            
                            <td><?= $invoice->invoice_number ?></td>
                            <td><a href="invoicedeatail.php?invoice_number=<?= $invoice->invoice_number ?>"> <?= $invoice->customer ?> </a></td>
                            <td><?= $invoice->invoice_date ?></td>
                            <td><?= $invoice->address ?></td>
                            <td><?= $invoice->city ?></td>
                            <?php
                            $stock = mysqli_fetch_object($conn->query("SELECT * FROM stocks WHERE id = " . $item->stock_id));
                            ?>
                           
                            <td><?= $item->quantity ?></td>
                            <td><?= $item->price ?></td>
                            <td><?= $item->amount ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button id="dwnldBtn<?= $invoice->invoice_number ?>" type="button" class="btn btn-primary" role="button" data-bs-toggle="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z"/>
            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
            </svg>

                    Download <?= $invoice->invoice_number ?></button>
    <?php endforeach; ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
      function downloadExcelTable(tableID, filename = '') {
    const linkToDownloadFile = document.createElement("a");
    const fileType = 'application/vnd.ms-excel';
    const selectedTable = document.getElementById(tableID);
    const selectedTableHTML = selectedTable.outerHTML.replace(/ /g, '%20');

    filename = filename ? filename + '.xls' : 'excel_data.xls';
    document.body.appendChild(linkToDownloadFile);

    if (navigator.msSaveOrOpenBlob) {
        const myBlob = new Blob(['\ufeff', selectedTableHTML], {
            type: fileType
        });
        navigator.msSaveOrOpenBlob(myBlob, filename);
    } else {
        linkToDownloadFile.href = 'data:' + fileType + ', ' + selectedTableHTML;
        linkToDownloadFile.download = filename;
        linkToDownloadFile.click();
    }
}

$(document).on('click', '[id^="dwnldBtn"]', function() {
    var invoiceNumber = $(this).attr('id').replace('dwnldBtn', '');
    var tableID = 'dataTable' + invoiceNumber;
    var filename = 'POS' + invoiceNumber;
    downloadExcelTable(tableID, filename);
});
    </script>

</main>
