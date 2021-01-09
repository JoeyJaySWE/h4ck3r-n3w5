<?php

require "../../views/functions.php";



?>

<head>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/defaults.css">
</head>

<body>
    <style>
        .log_out {
            width: 90%;
            height: 500px;
            font-size: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            line-height: 3rem;
            margin: auto;


        }

        span.quote {
            font-size: 1.5rem;
        }
    </style>
    <main>
        <?php if (!isset($_GET['update'])) :  ?>
            <p class="log_out">
                Ta-ta...! Come visit again...!<br> ... OR I'LL PLUCK OUT YOUR EYES! <br>
                <span class="quote">&dash; Sheagorath, Prince of Madness</span>
            </p>
        <?php else : ?>

            <p>
                Passwrod has been changed successfully, signing out...
            </p>

        <?php endif; ?>
    </main>
</body>
<?php
Log_out();
header("refresh:5; url=login.php");

?>