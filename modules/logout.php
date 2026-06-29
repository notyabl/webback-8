<?php
function logout_get($request) {
  session_start();
  session_unset();
  session_destroy();
  
  // Принудительный редирект без использования функции redirect()
  header('Location: ' . $_SERVER['HTTP_HOST'] . '/webback-8/');
  exit();
}
?>