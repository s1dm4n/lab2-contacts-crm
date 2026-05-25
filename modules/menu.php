<?php
/**
 * menu.php - Функция для вывода меню
 */

function renderMenu($currentPage = 'view', $sortBy = 'id') {
    $menuItems = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];
    
    $sortOptions = [
        'id' => 'По дате добавления',
        'surname' => 'По фамилии',
        'birthdate' => 'По дате рождения',
    ];
    
    $html = '<div class="menu-main">';
    
    foreach ($menuItems as $page => $label) {
        $active = ($currentPage === $page) ? ' class="active"' : '';
        $html .= '<a href="index.php?page=' . $page . '"' . $active . '>' . $label . '</a>';
    }
    
    $html .= '</div>';
    
    // Подменю для просмотра (сортировка)
    if ($currentPage === 'view') {
        $html .= '<div class="menu-sort">';
        foreach ($sortOptions as $key => $label) {
            $active = ($sortBy === $key) ? ' class="active"' : '';
            $html .= '<a href="index.php?page=view&sort=' . $key . '"' . $active . '>' . $label . '</a>';
        }
        $html .= '</div>';
    }
    
    return $html;
}
