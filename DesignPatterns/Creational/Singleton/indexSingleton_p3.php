<?php

/*
 *   Singleton classes
 */

class BookSingleton
{
    private $author = 'Author Book Simple';
    private $title = 'Title Book Simple';
    private static $book = NULL;
    private static $isLoanedOut = FALSE;

    private function __construct()
    {
    }

    static function borrowBook()
    {
        if (FALSE == self::$isLoanedOut) {
            if (NULL == self::$book) {
                self::$book = new BookSingleton();
            }
            self::$isLoanedOut = TRUE;
            return self::$book;
        } else {
            return NULL;
        }
    }

    function returnBook(BookSingleton $bookReturned)
    {
        self::$isLoanedOut = FALSE;
    }

    function getAuthor()
    {
        return $this->author;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getAuthorAndTitle()
    {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

class BookBorrower
{
    private $borrowedBook;
    private $haveBook = FALSE;

    function __construct()
    {
    }

    function getAuthorAndTitle()
    {
        if (TRUE == $this->haveBook) {
            return $this->borrowedBook->getAuthorAndTitle();
        } else {
            return "I don't have the book";
        }
    }

    function borrowBook()
    {
        $this->borrowedBook = BookSingleton::borrowBook();
        if ($this->borrowedBook == NULL) {
            $this->haveBook = FALSE;
        } else {
            $this->haveBook = TRUE;
        }
    }

    function returnBook()
    {
        $this->borrowedBook->returnBook($this->borrowedBook);
    }
}

/*
 *   Initialization
 */

writeln('');

$bookBorrower1 = new BookBorrower();
$bookBorrower2 = new BookBorrower();

$bookBorrower1->borrowBook();
writeln('BookBorrower1 asked to borrow the book');
writeln('BookBorrower1 Author and Title: ');
writeln($bookBorrower1->getAuthorAndTitle());
writeln('');

$bookBorrower2->borrowBook();
writeln('BookBorrower2 asked to borrow the book');
writeln('BookBorrower2 Author and Title: ');
writeln($bookBorrower2->getAuthorAndTitle());
writeln('');

$bookBorrower1->returnBook();
writeln('BookBorrower1 returned the book');
writeln('');

$bookBorrower2->borrowBook();
writeln('BookBorrower2 Author and Title: ');
writeln($bookBorrower1->getAuthorAndTitle());
writeln('');

function writeln($line_in)
{
    echo $line_in . '<br/>';
}

/* kq:

BookBorrower1 asked to borrow the book
BookBorrower1 Author and Title:
Title Book Simple by Author Book Simple

BookBorrower2 asked to borrow the book
BookBorrower2 Author and Title:
I don't have the book

BookBorrower1 returned the book

BookBorrower2 Author and Title:
Title Book Simple by Author Book Simple
