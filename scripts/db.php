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

function db_query($query) {
  global $db;
  $q = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $q->execute($args);
  $r = array();
  if ($res) {
    while ($row = db_row($res)) {
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
    if ($row = db_row($res)) {
      return $row[0];
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
  return $res = $q->execute($args);
}

function db_insert_id() {
  global $db;
  return $db->lastInsertId();
}