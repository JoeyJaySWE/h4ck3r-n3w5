<?php
require "functions.php";
// require "restricted.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:site_name" content="Vengeful Scars">
    <meta property="og:title" content="<?= $meta_title; ?>" />
    <meta property="og:description" content="<?= $meta_desc; ?>" />
    <meta property="og:image" content="<?= $meta_img; ?>" />
    <meta name="twitter:image" content="<?= $meta_img; ?>" />
    <meta name="twitter:card" content="<?= $meta_card; ?>" />
    <meta name="twitter:image:alt" content="<?= $meta_card_alt; ?>">
    <meta propety="og:url" content="https://projects.joeyjaydigital.com/h4ck3r-n3w5/" />
    <?php
    foreach ($styles as $stylesheet) {
    ?>
        <link rel="stylesheet" href="<?= $stylesheet; ?>">
    <?php
    }
    ?>
    <title><?= $title; ?></title>
</head>

<body>
    <section class="navbar">
        <nav>
            <li>
                <a href="/index.php">Home</a>
            </li>
            <li><a href="/app/user/terms.php">Terms & Conditions</a></li>
            <li>
                <?php
                if (!isset($_SESSION['user'])) { ?>
                    <a href="/app/users/login.php">Login</a>
            </li>
            <li><a href="/app/users/reg.php">Register</a></li>
            </li>
        <?php

                } else { ?>
            <a href="/app/users/user.php"><?= $_SESSION['user'] ?></a>
            </li>
            <li><a href="Log-out.php">Log out</a></li>
        <?php
                }
        ?>

        </nav>
    </section>