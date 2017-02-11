<?php

/**
 * Created by PhpStorm.
 * User: IF130050
 * Date: 2017-02-09
 * Time: 13:27
 */
class Books
{
    protected $db;

    private $page = false;
    private $sorted = false;
    private $booksDisplayAmount = 10;

    public function __construct()
    {
        require_once 'database.php';
        $db = Database::getInstance();
        $this->db = $db ->getConnection();
    }

    /**
     * Returns Paging if needed and Table with books names
     * @return string $output
     */
    public function printBooks() {

        $books = self::getBooksNamesAndIds();

        $output =
            "<table class=\"table table-striped\">"
                ."<thead>"
                    ."<tr>"
                        ."<th>#</th>"
                        ."<th>Book name<a class=\"deco-none\" href='index.php?sort=asc'>▼</a><a class=\"deco-none\" href='index.php?sort=desc'>▲</a></th>"
                     ."</tr>"
                ."</thead>"
                ."<tbody>";

        $this->page ? $count = ( ( $this->page - 1 ) * $this->booksDisplayAmount ) + 1 : $count = 1;
        foreach($books as $book) {
            $output .= "<tr><th>".$count++."</th>"
                      ."<td><a href='book.php?id=".$book['ID']."'>".$book['Name']."</a></td></tr>";
        }

        $output .= "</tbody></table>";

        return $output;
    }

    /**
     * Gets books names from Database
     * @return array $books
     */
    private function getBooksNamesAndIds() {
        $sql = "SELECT b.Name, b.ID FROM books b ";

        if( $this->sorted ) {
            $sql .= 'ORDER BY b.Name '.$this->sorted;
        }
        if( $this->page ) {
            $startingPoint = ($this->page-1) * $this->booksDisplayAmount;
            $sql .= ' LIMIT '.$startingPoint.', '.$this->booksDisplayAmount;
        } else {
            $sql .= ' LIMIT '.$this->booksDisplayAmount;
        }

        $sth = $this->db->prepare($sql);
        $sth->execute();

        $books = $sth->fetchAll();

        return $books;
    }

    /**
     * Gets number of books existing in Database
     * @return integer $amount['amount']
     */
    private function getBooksAmountFromDB() {
        $sql = "SELECT count(b.Name) AS amount FROM books b";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $amount = $sth->fetch();

        return $amount['amount'];
    }

    /**
     *
     */
    public function populateSelectMenu() {
        $numbers = array(10, 25, 50);
        foreach($numbers as $number) {
            if ( $this->booksDisplayAmount == $number ) {
                echo "<option selected>" . $number . "</option>";
            } else {
                echo "<option>" . $number . "</option>";
            }
        }
    }

    /**
     *  Prints buttons for paging if needed
     */
    public function printBooksPaging() {
        $amount = self::getBooksAmountFromDB();
        if( $amount > $this->booksDisplayAmount ) {
            $page = $amount / $this->booksDisplayAmount;
            for( $i = 1; $i < $page+1; $i++) {
                if( $this->sorted ) {
                    echo "<a class=\"btn btn-default\" href=\"index.php?sort=".$this->sorted."&page=".$i."\">".$i."</a>";
                } else {
                    echo "<a class=\"btn btn-default\" href=\"index.php?page=" . $i . "\">" . $i . "</a>";
                }
            }
        }
    }

    /**
     * @param integer $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @param string $sorted
     */
    public function setSorted($sorted)
    {
        $this->sorted = $sorted;
    }

    /**
     * @param int $booksDisplayAmount
     */
    public function setBooksDisplayAmount($booksDisplayAmount)
    {
        $this->booksDisplayAmount = $booksDisplayAmount;
    }


}