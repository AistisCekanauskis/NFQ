<?php

/**
 * Created by PhpStorm.
 * User: IF130050
 * Date: 2017-02-10
 * Time: 14:15
 */
require_once 'books.class.php';

class Book extends Books
{
    private $bookID;

    public function __construct($bookID)
    {
        parent::__construct();
        $this->bookID = $bookID;
    }

    public function printBookContent() {
        $book = self::getBookInfo();
        $output = " <h1 class=\"display-1\">".$book['name']."</h1>"
                 ."<p>Realease Date : ".$book['year']."</p>"
                 ."<p>Genre : ".$book['genre']."</p>"
                 ."<p>Author(-s) : ";
        $authors = self::getBookAuthors();
        foreach( $authors as $author ) {
            $output .= $author['name'] . ", ";
        }
        $output .= "</p>";

        return $output;
    }

    /**
     * @return array $book
     */
    private function getBookInfo() {
        $sql = "SELECT b.ID, b.Name AS name, b.Realese_year AS year, g.Name AS genre FROM books b JOIN genres g ON g.ID = b.Genre_ID WHERE b.ID = ".$this->bookID;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $book = $sth->fetch();

        return $book;
    }

    /**
     * @return array $authors
     */
    private function getBookAuthors() {
        $sql = "SELECT a.Author_name as name FROM books b JOIN book_authors a ON a.Book_ID = b.ID WHERE b.ID = ".$this->bookID;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $authors = $sth->fetchAll();

        return $authors;
    }
    /**
     * @param integer $bookID
     */
    public function setBookID($bookID)
    {
        $this->bookID = $bookID;
    }



}