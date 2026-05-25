<?php
/**
 * viewer.php - Просмотр контактов с пагинацией и сортировкой
 */

function renderViewer($db, $page = 1, $sortBy = 'id') {
    $perPage = 10;
    $offset = ($page - 1) * $perPage;
    
    // Определяем порядок сортировки
    $orderBy = 'id';
    if ($sortBy === 'surname') {
        $orderBy = 'surname, name';
    } elseif ($sortBy === 'birthdate') {
        $orderBy = 'birthdate';
    }
    
    // Получаем всех контактов
    $stmt = $db->query("SELECT COUNT(*) as count FROM `contacts`");
    $total = $stmt->fetch()['count'];
    $pages = ceil($total / $perPage);
    
    // Получаем контакты на текущей странице
    $query = "SELECT * FROM `contacts` ORDER BY {$orderBy} LIMIT " . (int)$perPage . " OFFSET " . (int)$offset;
    $stmt = $db->query($query);
    $contacts = $stmt->fetchAll();
    
    $html = '<div class="viewer-container">';
    
    if (empty($contacts)) {
        $html .= '<p class="no-data">Нет контактов</p>';
    } else {
        $html .= '<table class="contacts-table">';
        $html .= '<thead><tr>';
        $html .= '<th>Фамилия</th>';
        $html .= '<th>Имя</th>';
        $html .= '<th>Отчество</th>';
        $html .= '<th>Пол</th>';
        $html .= '<th>Дата рождения</th>';
        $html .= '<th>Телефон</th>';
        $html .= '<th>Адрес</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Комментарий</th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        
        foreach ($contacts as $contact) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['lastname'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['gender'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['birthdate'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['phone'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['address'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['email'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars(mb_strimwidth($contact['comment'] ?? '', 0, 50, '...')) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        // Пагинация
        if ($pages > 1) {
            $html .= '<div class="pagination">';
            for ($i = 1; $i <= $pages; $i++) {
                $active = ($i === $page) ? ' class="active"' : '';
                $html .= '<a href="index.php?page=view&sort=' . $sortBy . '&p=' . $i . '"' . $active . '>' . $i . '</a>';
            }
            $html .= '</div>';
        }
    }
    
    $html .= '</div>';
    
    return $html;
}