<?php

require "environment.php";

$config = array();

// Defining the database configuration
if (ENVIRONMENT == "development") {
    $config['dbtype'] = "pgsql";
    $config['dbhost'] = "localhost";
    $config['dbname'] = "apparking";
    $config['dbuser'] = "caio";
    $config['dbpass'] = "Caio1995";
}
else {
    $config['dbtype'] = "";
    $config['dbhost'] = "";
    $config['dbname'] = "";
    $config['dbuser'] = "";
    $config['dbpass'] = "";
}

try {
    global $pdo;
    $pdo = new PDO("{$config['dbtype']}:dbname={$config['dbname']};host={$config['dbhost']}", $config['dbuser'], $config['dbpass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Falhou: " . $e->getMessage();
    exit;
}