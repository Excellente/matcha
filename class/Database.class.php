<?php

class Database
{
  private $report;
  private $DB_DSN;
  private $DB_USER;
  private $DB_PASSWORD;

  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD)
  {
    $this->DB_DSN = $DB_DSN;
    $this->DB_USER = $DB_USER;
    $this->DB_PASSWORD = $DB_PASSWORD;
  }

  function whoami()
  {
    print "Database class<br>";
  }

  function server_connect()
  {
    try
    {
      $conn = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->report = "connection success<br>";
    }
    catch(PDOException $error) {
        $this->report = $sql . "<br>" . $error->getMessage();
    }
    return ($conn);
  }

  function dropdb($conn)
  {
    $sql = "DROP DATABASE IF EXISTS accounts";
    if ($conn->query($sql))
      return TRUE;
    return FALSE;
  }

  function insert($conn, $tb_name, $sql_query)
  {
    $sql = $conn->prepare($sql_query);
    $sql->bindParam(":table", $tb_name);
    if ($sql->execute())
      $this->report = "data inserted successfully";
    else
      $this->report = "insertion error: ". $sql_query;
  }

  function error_report()
  {
    print $this->report;
  }

  function create_schema($conn)
  {
    $sql  = "CREATE DATABASE IF NOT EXISTS db_vicinity;USE db_vicinity;";
    if ($conn->query($sql))
    {
      $this->report = "Database created successfully<br>";
    }
    else
    {
      $this->report = "couldn't create DATABASE<br>";
      return;
    }
    $sql  = "CREATE TABLE IF NOT EXISTS users(
	        `user_id`	 INT(8) PRIMARY KEY AUTO_INCREMENT NOT NULL,
          `active` INT(1) NOT NULL DEFAULT 0,
          `signed-in` INT(1) NOT NULL DEFAULT 0,
	        `firstname` VARCHAR(255) NOT NULL,
	        `lastname`  VARCHAR(255) NOT NULL,
	        `username` 	 VARCHAR(80),
	        `email` VARCHAR(80) NOT NULL,
	        `password` VARCHAR(255) NOT NULL,
          `gender` VARCHAR(25),
          `sex-preference` VARCHAR(80),
          `biography` TEXT)";
    try
    {
      if ($conn->query($sql))
      {
        $this->report = "Users table created successfully<br>";
      }
      else
      {
        $this->report = "couldn't create table<br>";
      }
    }
    catch(PDOException $error)
    {
      $this->report = $error->getMessage();
    }
    /*$sql = ("CREATE TABLE IF NOT EXISTS images(
  				 `image_id` INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  				 `email` VARCHAR(255) NOT NULL,
  				 `image` VARCHAR(255) NOT NULL,
           `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    if ($conn->query($sql))
    {
      echo "Images table created successfully<br>";
    }
    else
    {
      echo "couldn't create table<br>";
    }
    /*$sql = ("CREATE TABLE IF NOT EXISTS likes(
           `id` INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
           `image_id` VARCHAR(8) NOT NULL,
           `email` VARCHAR(255) NOT NULL,
           `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    if ($conn->query($sql))
    {
      echo "Likes table created successfully<br>";
    }
    else
    {
      echo "couldn't create table<br>";
    }
    $sql = ("CREATE TABLE IF NOT EXISTS comments(
           `id` INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
           `image_id` VARCHAR(8) NOT NULL,
           `user_id` VARCHAR(255) NOT NULL,
           `comment` TEXT,
           `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    if ($conn->query($sql))
    {
      echo "Comments table created successfully<br>";
    }
    else
    {
      echo "couldn't create table<br>";
    }*/
    $conn = null;
  }
}

?>
