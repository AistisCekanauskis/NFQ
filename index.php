<?php
    require_once 'inc/template/header.php';
    require_once 'books.class.php';
    $books = new Books();

    if ( isset($_POST['limit']) ) {
        $_SESSION['limit'] = $_POST['limit'];
        // Quick fix for bug with $_GET['page']
        $books->setPage(1);
    } else {
        !isset($_SESSION['limit']) ? $_SESSION['limit'] = 10 : null;
        isset($_GET['page']) ? $books->setPage(htmlspecialchars($_GET['page'])) : null;
    }
    $books->setBooksDisplayAmount($_SESSION['limit']);
    isset($_GET['sort']) ? $books->setSorted(htmlspecialchars($_GET['sort'])) : null;
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xl-6">
            <h1 class="display-1">Knygų sąrašas</h1>
        </div>
        <div class="col-md-6 col-sm-6 col-xl-6 search-form" id="search-form-container">
            <form id="search-form">
                <input class="form-control" id="search-form-input" type="text" name="search" placeholder="Search..">
            </form>
            <div id="search-form-results">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xl-6">
            <form action="" method="post">
                <select class="form-control fit-width" name="limit" onchange="this.form.submit()">
                    <?php
                        $books->populateSelectMenu();
                    ?>
                </select>
            </form>
        </div>
        <div class="col-md-6 col-sm-6 col-xl-6 text-right">
            <?php
                $books->printBooksPaging();
            ?>
        </div>
    </div>
    <?php
        echo $books->printBooks();
    ?>
</div>

<script src="search/search.js"></script>

<?php require_once 'inc/template/footer.html' ?>
