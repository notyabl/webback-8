<?php
global $db;
$db = new PDO('mysql:host=' . conf('db_host') . ';dbname=' . conf('db_name') . ';charset=utf8', 
  conf('db_user'), conf('db_psw'),
  array(
    PDO::MYSQL_ATTR_FOUND_ROWS => true, 
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  )
);

function db_row($stmt) {
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function db_error() {
  global $db;
  return $db->errorInfo();
}

function db_query($query) {
  global $db;
  $r = array();
  $q = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $q->execute($args);
  if ($res) {
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
      if (isset($row['id']) && !isset($r[$row['id']])) {
        $r[$row['id']] = $row;
      }
      else {
        $r[] = $row;
      }
    }
  }
  return $r;
}

function db_result($query) {
  global $db;
  $q = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $q->execute($args);
  if ($res) {
    $row = $q->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return reset($row);
    }
    else {
      return FALSE;
    }
  }
  else {
    return FALSE;
  }
}

function db_command($query) {
  global $db;
  $q = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  return $q->execute($args);
}

function db_insert_id() {
  global $db;
  return $db->lastInsertId();
}

function db_get($name, $default = FALSE) {
  if (strlen($name) == 0) {
    return $default;
  }
  $value = db_result("SELECT value FROM variable WHERE name = ?", $name);
  if ($value === FALSE) {
    return $default;
  }
  else {
    return $value;
  }
}

function db_set($name, $value) {
  if (strlen($name) == 0) {
    return;
  }
  $v = db_get($name);
  if ($v === FALSE) {
    $q = "INSERT INTO variable VALUES (?, ?)";
    return db_command($q, $name, $value) > 0;
  }
  else {
    $q = "UPDATE variable SET value = ? WHERE name = ?";
    return db_command($q, $value, $name) > 0;
  }
}