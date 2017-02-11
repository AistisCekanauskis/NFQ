<?php
require_once '../database.php';

$value = htmlspecialchars(strtoupper($_POST['search']));

$db = Database::getInstance();
$con = $db ->getConnection();

$sql = "SELECT b.ID , b.Name AS name, b.Realese_year AS year, g.Name AS genre, a.Author_name AS author ".
        "FROM books b ".
        "JOIN genres g ON g.ID = b.Genre_ID ".
        "JOIN book_authors a ON a.Book_ID = b.ID ".
        "WHERE upper(b.Name) LIKE '%".$value."%' ".
        "OR b.Realese_year LIKE '%".$value."%' ".
        "OR upper(g.Name) LIKE '%".$value."%' ".
        "OR upper(a.Author_name) LIKE '%".$value."%' LIMIT 10";
$sth = $con->prepare($sql);
$sth->execute();
$amount = $sth->fetchAll();

echo json_encode($amount);

