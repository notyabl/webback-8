<?php
require_once('db.php');

// GET /admin - список всех заявок
function admin_get($request) {
  global $db;
  
  $applications = db_query("SELECT * FROM applications ORDER BY id DESC");
  
  foreach ($applications as &$app) {
    $stmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
    $stmt->execute([$app['id']]);
    $app['languages'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  
  return theme('admin', ['applications' => $applications]);
}

// POST /admin/{id} - удаление заявки
function admin_post($id, $request) {
  global $db;
  
  if ($id) {
    $id = (int)$id;
    db_command("DELETE FROM application_languages WHERE application_id = ?", $id);
    db_command("DELETE FROM applications WHERE id = ?", $id);
  }
  
  return redirect('admin');
}