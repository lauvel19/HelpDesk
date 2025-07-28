<?php
    require_once("../config/conexion.php");
    require_once("../models/Email.php");
    $email = new Email();

    switch ($_GET["op"]) {
        case "ticket_abierto":
            $email->ticket_abierto($_POST["tick_id"]);
            break;
    }
?>