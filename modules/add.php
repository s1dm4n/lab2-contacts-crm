<?php
/**
 * add.php - Добавление новой записи
 */

function handleAddContact($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
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
                INSERT INTO `contacts` 
                (`surname`, `name`, `lastname`, `gender`, `birthdate`, `phone`, `address`, `email`, `comment`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$surname, $name, $lastname, $gender, $birthdate, $phone, $address, $email, $comment]);
            return 'Запись добавлена';
        } catch (PDOException $e) {
            return 'Ошибка: запись не добавлена';
        }
    }
    
    return null;
}

function renderAddForm() {
    $message = handleAddContact($GLOBALS['db']);
    $msg_class = strpos($message, 'Ошибка') !== false ? 'error' : 'success';
    
    $html = '<div class="form-container">';
    
    if ($message) {
        $html .= '<div class="message ' . $msg_class . '">' . htmlspecialchars($message) . '</div>';
    }
    
    $html .= '<form method="POST" class="contact-form">';
    $html .= '<input type="hidden" name="action" value="add">';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Фамилия</label>';
    $html .= '<input type="text" name="surname" placeholder="Фамилия" required>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Имя</label>';
    $html .= '<input type="text" name="name" placeholder="Имя" required>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Отчество</label>';
    $html .= '<input type="text" name="lastname" placeholder="Отчество">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Пол</label>';
    $html .= '<select name="gender">';
    $html .= '<option value="">Выберите пол</option>';
    $html .= '<option value="мужской">Мужской</option>';
    $html .= '<option value="женский">Женский</option>';
    $html .= '</select>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Дата рождения</label>';
    $html .= '<input type="date" name="birthdate">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Телефон</label>';
    $html .= '<input type="tel" name="phone" placeholder="Телефон">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Адрес</label>';
    $html .= '<textarea name="address" placeholder="Адрес"></textarea>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Email</label>';
    $html .= '<input type="email" name="email" placeholder="Email">';
    $html .= '</div>';
    
    $html .= '<div class="form-group">';
    $html .= '<label>Комментарий</label>';
    $html .= '<textarea name="comment" placeholder="Комментарий"></textarea>';
    $html .= '</div>';
    
    $html .= '<button type="submit" class="btn-submit">Добавить контакт</button>';
    $html .= '</form>';
    $html .= '</div>';
    
    return $html;
}
