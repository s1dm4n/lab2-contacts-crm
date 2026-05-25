<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка — Контакты</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/modules/menu.php';
require_once __DIR__ . '/modules/viewer.php';
require_once __DIR__ . '/modules/add.php';
require_once __DIR__ . '/modules/edit.php';
require_once __DIR__ . '/modules/delete.php';

// Инициализируем БД
initDB();
$GLOBALS['db'] = getDBConnection();

$page = $_GET['page'] ?? 'view';
$sortBy = $_GET['sort'] ?? 'id';
$p = (int)($_GET['p'] ?? 1);
?>

    <!-- HEADER -->
    <header>
        <div class="header-left">
            <img src="https://mospolytech.ru/local/templates/main/dist/img/logos/mospolytech-logo-white.svg" alt="МосПолитех">
        </div>
        <div class="header-center">Записная книжка - Управление контактами</div>
        <div style="width:120px;"></div>
    </header>

    <!-- MAIN -->
    <main>
        <section class="menu">
            <?php echo renderMenu($page, $sortBy); ?> 
        </section>    
        <?php
        switch ($page) {
            case 'add':
                echo renderAddForm();
                break;
            case 'edit':
                echo renderEditForm($GLOBALS['db']);
                break;
            case 'delete':
                echo renderDeleteForm($GLOBALS['db']);
                break;
            case 'view':
            default:
                echo renderViewer($GLOBALS['db'], $p, $sortBy);
        }
        ?>
    </main>

    <!-- FOOTER -->
    <footer>
        Лабораторная работа 5.1. "Notebook"
    </footer>

</body>
</html>