<?php
     header("Content-Type:  application/json");
     header("Access-Control-Allow-Origin: *");
     
     $usuarios=[
        ["id" => 1, "nombre"  => "Lizeth Salcido", " Correos" => "lisal.aigal@gmail.com" ],
        ["id" => 1, "nombre"  => "Isaac Salomon", " Correos" => "isaaksaren@gmail.com" ],
        ["id" => 1, "nombre"  => "Ethan Salcido", " Correos" => "SaRAn@gmail.com" ],


     ];

     echo json_encode($usuarios);


    ?>