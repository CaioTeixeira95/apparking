<?php

require "environment.php";

$config = array();

// Defining the database configuration
if (ENVIRONMENT == "development") {
    $config['dbtype'] = "pgsql";
    $config['dbhost'] = "localhost";
    $config['dbname'] = "apparking";
    $config['dbuser'] = "caio";
    $config['dbpass'] = "";
}
else {
    $config['dbtype'] = "";
    $config['dbhost'] = "";
    $config['dbname'] = "";
    $config['dbuser'] = "";
    $config['dbpass'] = "";
}

try {

    $driver_config = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );

    global $pdo;
    $pdo = new PDO("{$config['dbtype']}:dbname={$config['dbname']};host={$config['dbhost']}", $config['dbuser'], $config['dbpass'], $driver_config);

} catch(PDOException $e) {
    echo "Falhou: " . $e->getMessage();
    exit;
}