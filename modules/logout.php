<?php
function logout_get($request) {
  session_start();
  session_unset();
  session_destroy();
  
  // Абсолютный редирект
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/webback-8/');
  exit();
}
?>