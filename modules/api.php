<?php
require_once('db.php');

// GET /api/applications/{id}
function api_get($id = null, $request = null) {
  global $db;
  
  if ($id) {
    $stmt = $db->prepare("SELECT * FROM applications WHERE id = ?");
    $stmt->execute([(int)$id]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$app) {
      return array(
        'headers' => array('HTTP/1.1 404 Not Found', 'Content-Type: application/json'),
        'entity' => json_encode(array('error' => 'Заявка не найдена')),
      );
    }
    
    $langStmt = $db->prepare("SELECT pl.name FROM application_languages al JOIN programming_languages pl ON al.language_id = pl.id WHERE al.application_id = ?");
    $langStmt->execute([$id]);
    $app['languages'] = $langStmt->fetchAll(PDO::FETCH_COLUMN);
    
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode($app, JSON_UNESCAPED_UNICODE),
    );
  }
  
  // GET /api/applications - список всех заявок
  $applications = db_query("SELECT * FROM applications ORDER BY id DESC");
  return array(
    'headers' => array('Content-Type: application/json'),
    'entity' => json_encode($applications, JSON_UNESCAPED_UNICODE),
  );
}

// POST /api/applications - создание новой заявки
function api_post($request) {
  $data = !empty($request['post']) ? $request['post'] : array();
  
  require_once('front.php');
  $errors = validate_application($data);
  
  if (!empty($errors)) {
    return array(
      'headers' => array('HTTP/1.1 400 Bad Request', 'Content-Type: application/json'),
      'entity' => json_encode(array('errors' => $errors), JSON_UNESCAPED_UNICODE),
    );
  }
  
  $result = save_application($data);
  
  if ($result['success']) {
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode($result, JSON_UNESCAPED_UNICODE),
    );
  }
  else {
    return array(
      'headers' => array('HTTP/1.1 500 Internal Server Error', 'Content-Type: application/json'),
      'entity' => json_encode(array('error' => $result['error']), JSON_UNESCAPED_UNICODE),
    );
  }
}

// PUT /api/applications/{id} - обновление заявки
function api_put($id, $request) {
  global $db;
  
  $data = !empty($request['post']) ? $request['post'] : array();
  
  require_once('front.php');
  $errors = validate_application($data);
  
  if (!empty($errors)) {
    return array(
      'headers' => array('HTTP/1.1 400 Bad Request', 'Content-Type: application/json'),
      'entity' => json_encode(array('errors' => $errors), JSON_UNESCAPED_UNICODE),
    );
  }
  
  try {
    $db->beginTransaction();
    
    db_command("UPDATE applications SET full_name=?, phone=?, email=?, birth_date=?, gender=?, biography=?, contract_agreed=? WHERE id=?",
      $data['full_name'], $data['phone'], $data['email'], $data['birth_date'], 
      $data['gender'], $data['biography'] ?? '', isset($data['contract']) ? 1 : 0, (int)$id);
    
    db_command("DELETE FROM application_languages WHERE application_id = ?", (int)$id);
    
    foreach ($data['languages'] as $lang) {
      $lang_id = db_result("SELECT id FROM programming_languages WHERE name = ?", $lang);
      if ($lang_id) {
        db_command("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)", 
          (int)$id, $lang_id);
      }
    }
    
    $db->commit();
    
    return array(
      'headers' => array('Content-Type: application/json'),
      'entity' => json_encode(array('success' => true, 'message' => 'Данные обновлены'), JSON_UNESCAPED_UNICODE),
    );
  }
  catch (PDOException $e) {
    $db->rollBack();
    return array(
      'headers' => array('HTTP/1.1 500 Internal Server Error', 'Content-Type: application/json'),
      'entity' => json_encode(array('error' => $e->getMessage()), JSON_UNESCAPED_UNICODE),
    );
  }
}