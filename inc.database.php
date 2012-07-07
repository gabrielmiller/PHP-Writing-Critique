<?php

session_start();

function dbConnect()
    {
    $connection = new mysqli('localhost', 'user', 'password', 'ex10') or die ('Couldn\'t establish a connection with the database');
    return $connection;
    }
