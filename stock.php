<?php
require_once("models/stocks.php");
require_once("Templates/header.php");



$stocks = stocks::getAll();
?>
<?php
    // require_once("./Templates/header.php");
?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Stocks List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Share</button> -->
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">Export</button>
            </div>
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button> -->
        </div>
    </div>
    <a href="create.php" class="btn btn-primary">Add New
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
        </svg>
    </a>

    <a href="updatehistory.php" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
  <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
  <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
  <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
</svg> History</a>

    <?php require_once("css/sale.php"); ?>
    <div class="table-responsive">
        <table class="table1 table1-bordered">
            <thead class="table-light" >
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Items</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Action</th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($stocks as $s) : ?>
                    <tr>
                        <td><?= $s->id ?></td>
                        <td><?= $s->name ?></td>
                        <td><?= $s->balance ?></td>
                        <td><?= $s->price ?></td>
                        <td><a href="updatephp.php?id=<?= $s->id ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php? id=<?= $s->id ?>" class="btn btn-danger"
                            onclick="return confirm('Are U Sure?')">Delete</a>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once("./Templates/footer.php");
?>