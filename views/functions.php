<?php

// declare(strict_type=1);


// ----------------- [ DB connection ] ------------------ 

function db(): PDO
{

    $dir = "sqlite:../app/databases/h4ck3r.sqlite";
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

// ----------------------------------------------------------------






// ----------------- [ Sanitize form inputs ] ------------------ 

function form_sanitizer(array $post_data)
{
    // die(var_dump($post_data));
    echo "Inside function: <br/>";
    $filtered_data = [];
    foreach ($post_data as $key => $value) {
        if ($key === "submit") {
            continue;
        }
        echo $key . ": " . $post_data[$key] . "</br>";

        $trimmed = filter_var(trim($post_data[$key]), FILTER_SANITIZE_EMAIL);

        if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
            echo "<br>This is valid email</br>";
            $filtered_data[$key] = $trimmed;
        } else {
            echo "Normal string sanitizer <br/>";
            $filtered_data[$key] = filter_var(trim($post_data[$key]), FILTER_SANITIZE_STRING);
        }
        echo "Updated value of " . $key . ": " . $filtered_data[$key] . "<br>";
    }
    $filtered_data['test'] = "Right array";
    print_r($filtered_data);
    return $filtered_data;
}

// ----------------------------------------------------------------