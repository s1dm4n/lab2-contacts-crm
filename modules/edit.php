<?php
/**
 * edit.php - Редактирование записи
 */

function handleEditContact($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $surname = trim($_POST['surname'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $gender = $_POST['gender'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $comment = trim($_POST['comment'] ?? '');
        
        if (!$surname || !$name) {
            return 'Ошибка: заполните фамилию и имя';
        }
        
        try {
            $stmt = $db->prepare("
                UPDATE `contacts` SET
                `surname`=?, `name`=?, `lastname`=?, `gender`=?, `birthdate`=?, 
                `phone`=?, `address`=?, `email`=?, `comment`=?
                WHERE `id`=?
            ");
            $stmt->execute([$surname, $name, $lastname, $gender, $birthdate, $phone, $address, $email, $comment, $id]);
            return 'Запись обновлена';
        } catch (PDOException $e) {
            return 'Ошибка: запись не обновлена';
        }
    }
    
    return null;
}

function renderEditForm($db) {
    $message = handleEditContact($db);
    $msg_class = strpos($message, 'Ошибка') !== false ? 'error' : 'success';
    
    // Получаем первый контакт или выбранный
    $selectedId = (int)($_GET['id'] ?? 0);
    
    $stmt = $db->query("SELECT `id`, `surname`, `name` FROM `contacts` ORDER BY `surname`, `name`");
    $contacts = $stmt->fetchAll();
    
    if (!$selectedId && !empty($contacts)) {
        $selectedId = $contacts[0]['id'];
    }
    
    $current = null;
    if ($selectedId) {
        $stmt = $db->prepare("SELECT * FROM `contacts` WHERE `id` = ?");
        $stmt->execute([$selectedId]);
        $current = $stmt->fetch();
    }
    
    $html = '<div class="form-container">';
    
    if ($message) {
        $html .= '<div class="message ' . $msg_class . '">' . htmlspecialchars($message) . '</div>';
    }
    
    // Список контактов
    $html .= '<div class="contacts-list">';
    $html .= '<label>Выберите контакт:</label>';
    foreach ($contacts as $contact) {
        $active = ($contact['id'] === $selectedId) ? ' class="active"' : '';
        $html .= '<a href="index.php?page=edit&id=' . $contact['id'] . '"' . $active . '>';
        $html .= htmlspecialchars($contact['surname']) . ' ' . htmlspecialchars($contact['name']);
        $html .= '</a>';
    }
    $html .= '</div>';
    
    // Форма редактирования
    if ($current) {
        $html .= '<form method="POST" class="contact-form">';
        $html .= '<input type="hidden" name="action" value="edit">';
        $html .= '<input type="hidden" name="id" value="' . (int)$current['id'] . '">';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Фамилия</label>';
        $html .= '<input type="text" name="surname" value="' . htmlspecialchars($current['surname']) . '" required>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Имя</label>';
        $html .= '<input type="text" name="name" value="' . htmlspecialchars($current['name']) . '" required>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Отчество</label>';
        $html .= '<input type="text" name="lastname" value="' . htmlspecialchars($current['lastname'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Пол</label>';
        $html .= '<select name="gender">';
        $html .= '<option value="">Выберите пол</option>';
        $html .= '<option value="мужской"' . ($current['gender'] === 'мужской' ? ' selected' : '') . '>Мужской</option>';
        $html .= '<option value="женский"' . ($current['gender'] === 'женский' ? ' selected' : '') . '>Женский</option>';
        $html .= '</select>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Дата рождения</label>';
        $html .= '<input type="date" name="birthdate" value="' . htmlspecialchars($current['birthdate'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Телефон</label>';
        $html .= '<input type="tel" name="phone" value="' . htmlspecialchars($current['phone'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Адрес</label>';
        $html .= '<textarea name="address">' . htmlspecialchars($current['address'] ?? '') . '</textarea>';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Email</label>';
        $html .= '<input type="email" name="email" value="' . htmlspecialchars($current['email'] ?? '') . '">';
        $html .= '</div>';
        
        $html .= '<div class="form-group">';
        $html .= '<label>Комментарий</label>';
        $html .= '<textarea name="comment">' . htmlspecialchars($current['comment'] ?? '') . '</textarea>';
        $html .= '</div>';
        
        $html .= '<button type="submit" class="btn-submit"><span class="btn-text">Сохранить изменения</span></button>';
        $html .= '</form>';
    }
    
    $html .= '</div>';
    
    return $html;
}