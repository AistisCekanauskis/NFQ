<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'inc/template/header.html';
    require_once 'Books.php';
    $books = new Books();

    if ( isset($_POST['limit']) ) {
        $_SESSION['limit'] = $_POST['limit'];
    }
?>

<div class="container">
    <h1 class="display-1">Knygų sąrašas</h1>
    <form action="" method="post">
        <select class="form-control fit-width" name="limit" onchange="this.form.submit()">
            <?php
                isset( $_SESSION['limit'] ) ? $books->populateSelectMenu( $_SESSION['limit'] ) : $books->populateSelectMenu();
            ?>
        </select>
    </form>

    <?php
        if ( isset($_GET['sort']) && isset($_GET['pages']) ) {
            echo $books->printBooks( $_GET['sort'] );
        } else if ( isset($_GET['sort'] )) {
            echo $books->printBooks( $_GET['sort'] );
        } else if ( isset($_GET['pages'] )) {

        }else {
            echo $books->printBooks();
        }
    ?>
</div>

<?php require_once 'inc/template/footer.html' ?>
