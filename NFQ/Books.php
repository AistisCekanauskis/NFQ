<?php

/**
 * Created by PhpStorm.
 * User: IF130050
 * Date: 2017-02-09
 * Time: 13:27
 */
class Books
{
    private $db;

    public function __construct()
    {
        require_once 'database.php';
        $db = Database::getInstance();
        $this->db = $db ->getConnection();
    }

    /**
     * @param bool|string $sorted
     * @return string
     */
    public function printBooks($sorted = false) {
        $sorted = $sorted == 'asc' || $sorted == 'desc' ? htmlspecialchars($sorted) : false;
        $limit = isset( $_SESSION['limit'] ) ? htmlspecialchars( $_SESSION['limit'] ) : false;

        if( $sorted && $limit ) {
            $books = self::getBooksNames('ORDER BY b.Name '.$sorted.' LIMIT '.$limit);
        } else if ( $limit ) {
            $books = self::getBooksNames('LIMIT '.$limit);
        } else if ( $sorted ) {
            $books = self::getBooksNames('ORDER BY b.Name '.$sorted);
        } else {
            $books = self::getBooksNames();
        }

        $limit = !$limit ? 10 : $limit;
        $amount = self::getBooksAmountFromDB();
        if( $amount > $limit ) {
            $pages = $amount / $limit;
            for( $i = 1; $i < $pages+1; $i++) {
                if( isset($_GET['sort']) ) {
                    echo "<a href=\"index.php?sort=".$_GET['sort']."&pages=".$i."\">".$i."</a>";
                } else {
                    echo "<a href=\"index.php?pages=" . $i . "\">" . $i . "</a>";
                }
            }
        }

        $output = '';
        $output .=
            "<table class=\"table table-striped\">"
                ."<thead>"
                    ."<tr>"
                        ."<th>#</th>"
                        ."<th>Book name<a class=\"deco-none\" href='index.php?sort=asc'>▼</a><a class=\"deco-none\" href='index.php?sort=desc'>▲</a></th>"
                     ."</tr>"
                ."</thead>"
                ."<tbody>";

        $count = 1;
        foreach($books as $book) {
            $output .= "<tr><th scope=\"row\">".$count++."</th>"
                      ."<td>".$book['Name']."</td></tr>";
        }

        $output .= "</tbody></table>";

        return $output;
    }

    /**
     * @param string $sqlEnding    DEFAULT value LIMIT 10
     * @return array $books
     */
    private function getBooksNames($sqlEnding = 'LIMIT 10') {
        $sql = "SELECT b.Name FROM books b ".$sqlEnding;
        $sth = $this->db->prepare($sql);
        $sth->execute();

        $books = $sth->fetchAll();

        return $books;
    }

    private function getBooksAmountFromDB() {
        $sql = "SELECT count(b.Name) AS amount FROM books b";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $amount = $sth->fetch();

        return $amount['amount'];
    }

    /**
     * @param bool $limitSet    DEFAULT false - not SET
     */
    public function populateSelectMenu($limitSet = false) {
        $numbers = array(10, 25, 50);
        foreach($numbers as $number) {
            if ( $limitSet ) {
                if ( $limitSet == $number ) {
                    echo "<option selected>" . $number . "</option>";
                } else {
                    echo "<option>" . $number . "</option>";
                }
            } else {
                echo "<option>" . $number . "</option>";
            }
        }
    }

}