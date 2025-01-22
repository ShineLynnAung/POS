<?php
require_once("models/save.php"); // Update the file name to "save.php"

$update = save_date::getAll();
?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Updated History</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">Export</button>
            </div>
        </div>
    </div>
    <a href="stock.php" class="btn btn-primary">
        Back
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
    </a>
    <?php require_once("css/sale.php"); ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Last Balance</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date and Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($update as $u) : ?>
                    <tr>
                        <td><?= $u->id ?></td>
                        <td><?= $u->name ?></td>
                        <td><?= $u->last_balance ?></td>
                        <td><?= $u->price ?></td>
                        <td><?= $u->upd_time ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once("./Templates/footer.php");
?>