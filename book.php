<?php
require_once 'inc/template/header.php';
require_once 'book.class.php';

if ( isset($_GET['id']) ) {
    if ( is_numeric($_GET['id']) ) {
        $book = new Book( htmlspecialchars($_GET['id']) );
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>

<div class="container">
    <div class="btn-container">
        <a class="btn btn-default" href="index.php">Go back to books list</a>
    </div>
    <?php
        echo $book->printBookContent();
    ?>
</div>

<?php require_once 'inc/template/footer.html' ?>