<?php

// declare(strict_type=1);

function db(): PDO
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    // path to our db file


    // $mysqli =  mysqli_connect('my142b.sqlserver.se', '207231_im12896', 'VengefulScarsDb', '207231-vengeful-sheet');

    $dir = "sqlite:" . $path . "/app/databases/h4ck3r.sqlite";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $db = new PDO($dir, "", "",  $options); //tries to connect to our databse using $path, $username, $passowrd, $options 
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); //sends out an error message if it fails to connect.
    }

    return $db;
}
