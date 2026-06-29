<?php
// Обработчик GET - выход из системы
function logout_get($request) {
  session_start();
  session_destroy();
  return redirect('');
}