<h1>👑 Админ-панель</h1>

<?php if (!empty($c['applications'])): ?>
  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Дата рождения</th>
        <th>Пол</th>
        <th>Языки</th>
        <th>Контракт</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($c['applications'] as $app): ?>
        <tr>
          <td><?php echo htmlspecialchars($app['id']); ?></td>
          <td><?php echo htmlspecialchars($app['full_name']); ?></td>
          <td><?php echo htmlspecialchars($app['phone']); ?></td>
          <td><?php echo htmlspecialchars($app['email']); ?></td>
          <td><?php echo htmlspecialchars($app['birth_date']); ?></td>
          <td><?php echo $app['gender'] == 'male' ? 'М' : 'Ж'; ?></td>
          <td>
            <?php foreach ($app['languages'] as $lang): ?>
              <span class="lang-badge"><?php echo htmlspecialchars($lang); ?></span>
            <?php endforeach; ?>
          </td>
          <td><?php echo $app['contract_agreed'] ? '✅' : '❌'; ?></td>
          <td>
            <form action="/admin/<?php echo $app['id']; ?>" method="POST" style="display: inline;">
              <button type="submit" class="btn-delete" onclick="return confirm('Удалить заявку #<?php echo $app['id']; ?>?')">🗑️</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p class="empty-message">Нет данных</p>
<?php endif; ?>