<?php
/**
 * delete.php - Удаление записи
 */

function handleDeleteContact($db) {
    if (isset($_GET['delete_id'])) {
        $id = (int)$_GET['delete_id'];
        
        try {
            $stmt = $db->prepare("SELECT `surname` FROM `contacts` WHERE `id` = ?");
            $stmt->execute([$id]);
            $contact = $stmt->fetch();
            
            if ($contact) {
                $stmt = $db->prepare("DELETE FROM `contacts` WHERE `id` = ?");
                $stmt->execute([$id]);
                return 'Запись с фамилией ' . htmlspecialchars($contact['surname']) . ' удалена';
            }
        } catch (PDOException $e) {
            return 'Ошибка: не удалось удалить запись';
        }
    }
    
    return null;
}

function renderDeleteForm($db) {
    $message = handleDeleteContact($db);
    $msg_class = strpos($message, 'Ошибка') !== false ? 'error' : 'success';
    
    $stmt = $db->query("SELECT `id`, `surname`, `name` FROM `contacts` ORDER BY `surname`, `name`");
    $contacts = $stmt->fetchAll();
    
    $html = '<div class="form-container">';
    
    if ($message) {
        $html .= '<div class="message ' . $msg_class . '">' . htmlspecialchars($message) . '</div>';
    }
    
    $html .= '<div class="contacts-list">';
    $html .= '<label>Выберите контакт для удаления:</label>';
    
    if (empty($contacts)) {
        $html .= '<p class="no-data">Нет контактов</p>';
    } else {
        foreach ($contacts as $contact) {
            $html .= '<a href="index.php?page=delete&delete_id=' . $contact['id'] . '" ';
            $html .= 'onclick="return confirm(\'Вы уверены?\');" class="contact-link">';
            $html .= htmlspecialchars($contact['surname']) . ' ' . htmlspecialchars($contact['surname']);
            $html .= '</a>';
        }
    }
    
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}