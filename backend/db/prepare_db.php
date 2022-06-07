<?php

$config = parse_ini_file('../../config/config.ini', true);
$type = $config['db']['type'];
$host = $config['db']['host'];
$user = $config['db']['user'];
$password = $config['db']['password'];

function prepareDatabase($type, $host, $user, $password)
{
  try {
    $connection = new PDO(
      "$type:host=$host",
      $user,
      $password,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );

    $connection->exec(file_get_contents('../../database/create_tables.sql'));
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}

prepareDatabase($type, $host, $user, $password);
