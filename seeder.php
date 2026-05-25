<?php
/**
 * seeder.php - Добавление 20 тестовых записей в БД
 */

require_once 'config.php';

// Инициализируем БД
initDB();
$db = getDBConnection();

// Тестовые данные
$contacts = [
    ['surname' => 'Иванов', 'name' => 'Иван', 'lastname' => 'Иванович', 'gender' => 'мужской', 'birthdate' => '1990-05-15', 'phone' => '+7(999)123-45-67', 'address' => 'Москва, ул. Пушкина, 10', 'email' => 'ivanov@example.com', 'comment' => 'Основатель компании'],
    ['surname' => 'Петров', 'name' => 'Петр', 'lastname' => 'Петрович', 'gender' => 'мужской', 'birthdate' => '1985-03-22', 'phone' => '+7(999)223-45-67', 'address' => 'Санкт-Петербург, пр. Невский, 1', 'email' => 'petrov@example.com', 'comment' => 'Финансовый директор'],
    ['surname' => 'Сидоров', 'name' => 'Сидор', 'lastname' => 'Сидорович', 'gender' => 'мужской', 'birthdate' => '1992-07-10', 'phone' => '+7(999)323-45-67', 'address' => 'Казань, ул. Кремлевская, 5', 'email' => 'sidorov@example.com', 'comment' => 'Технический руководитель'],
    ['surname' => 'Козлова', 'name' => 'Анна', 'lastname' => 'Дмитриевна', 'gender' => 'женский', 'birthdate' => '1988-11-14', 'phone' => '+7(999)423-45-67', 'address' => 'Москва, ул. Арбат, 35', 'email' => 'kozlova@example.com', 'comment' => 'Главный бухгалтер'],
    ['surname' => 'Смирнов', 'name' => 'Сергей', 'lastname' => 'Алексеевич', 'gender' => 'мужской', 'birthdate' => '1995-02-28', 'phone' => '+7(999)523-45-67', 'address' => 'Екатеринбург, ул. Малышева, 20', 'email' => 'smirnov@example.com', 'comment' => 'Менеджер по продажам'],
    ['surname' => 'Волкова', 'name' => 'Елена', 'lastname' => 'Викторовна', 'gender' => 'женский', 'birthdate' => '1991-06-05', 'phone' => '+7(999)623-45-67', 'address' => 'Новосибирск, пр. Красный, 100', 'email' => 'volkova@example.com', 'comment' => 'Директор по маркетингу'],
    ['surname' => 'Морозов', 'name' => 'Владимир', 'lastname' => 'Владимирович', 'gender' => 'мужской', 'birthdate' => '1987-09-12', 'phone' => '+7(999)723-45-67', 'address' => 'Уфа, ул. Ленина, 50', 'email' => 'morozov@example.com', 'comment' => 'Начальник отдела'],
    ['surname' => 'Лебедева', 'name' => 'Мария', 'lastname' => 'Сергеевна', 'gender' => 'женский', 'birthdate' => '1993-01-19', 'phone' => '+7(999)823-45-67', 'address' => 'Казань, ул. Чернышевского, 15', 'email' => 'lebedeva@example.com', 'comment' => 'Специалист по обучению'],
    ['surname' => 'Кузнецов', 'name' => 'Алексей', 'lastname' => 'Максимович', 'gender' => 'мужской', 'birthdate' => '1989-04-08', 'phone' => '+7(999)923-45-67', 'address' => 'Санкт-Петербург, ул. Садовая, 2', 'email' => 'kuznetsov@example.com', 'comment' => 'Системный администратор'],
    ['surname' => 'Соколова', 'name' => 'Ольга', 'lastname' => 'Ивановна', 'gender' => 'женский', 'birthdate' => '1994-08-25', 'phone' => '+7(999)033-45-67', 'address' => 'Москва, пр. Проспект Мира, 7', 'email' => 'sokolova@example.com', 'comment' => 'Менеджер проектов'],
    ['surname' => 'Ауберт', 'name' => 'Франсуа', 'lastname' => '', 'gender' => 'мужской', 'birthdate' => '1986-10-30', 'phone' => '+7(999)133-45-67', 'address' => 'Москва, ул. Тверская, 12', 'email' => 'aubert@example.com', 'comment' => 'Консультант'],
    ['surname' => 'Орлова', 'name' => 'Татьяна', 'lastname' => 'Сергеевна', 'gender' => 'женский', 'birthdate' => '1997-12-03', 'phone' => '+7(999)233-45-67', 'address' => 'Казань, ул. Королева, 25', 'email' => 'orlova@example.com', 'comment' => 'Младший аналитик'],
    ['surname' => 'Гавриков', 'name' => 'Игорь', 'lastname' => 'Борисович', 'gender' => 'мужской', 'birthdate' => '1988-03-16', 'phone' => '+7(999)333-45-67', 'address' => 'Екатеринбург, ул. 8 марта, 10', 'email' => 'gavrikov@example.com', 'comment' => 'Тестировщик'],
    ['surname' => 'Новикова', 'name' => 'Светлана', 'lastname' => 'Алексеевна', 'gender' => 'женский', 'birthdate' => '1996-05-21', 'phone' => '+7(999)433-45-67', 'address' => 'Новосибирск, ул. Бульвар, 3', 'email' => 'novikova@example.com', 'comment' => 'Координатор'],
    ['surname' => 'Завьялов', 'name' => 'Константин', 'lastname' => 'Игоревич', 'gender' => 'мужской', 'birthdate' => '1991-07-11', 'phone' => '+7(999)533-45-67', 'address' => 'Уфа, пр. Октября, 22', 'email' => 'zavyalov@example.com', 'comment' => 'Разработчик'],
    ['surname' => 'Степанова', 'name' => 'Ирина', 'lastname' => 'Юрьевна', 'gender' => 'женский', 'birthdate' => '1990-09-08', 'phone' => '+7(999)633-45-67', 'address' => 'Москва, ул. Маяковского, 42', 'email' => 'stepanova@example.com', 'comment' => 'Аналитик данных'],
    ['surname' => 'Шестаков', 'name' => 'Николай', 'lastname' => 'Евгеньевич', 'gender' => 'мужской', 'birthdate' => '1984-11-27', 'phone' => '+7(999)733-45-67', 'address' => 'Санкт-Петербург, ул. Садовая, 8', 'email' => 'shestakov@example.com', 'comment' => 'Старший разработчик'],
    ['surname' => 'Журавлева', 'name' => 'Вера', 'lastname' => 'Константиновна', 'gender' => 'женский', 'birthdate' => '1989-02-14', 'phone' => '+7(999)833-45-67', 'address' => 'Казань, ул. Авангард, 7', 'email' => 'zhuravleva@example.com', 'comment' => 'Менеджер отдела'],
    ['surname' => 'Парфенов', 'name' => 'Дмитрий', 'lastname' => 'Аркадьевич', 'gender' => 'мужской', 'birthdate' => '1992-06-19', 'phone' => '+7(999)933-45-67', 'address' => 'Екатеринбург, ул. Свердлова, 30', 'email' => 'parfenov@example.com', 'comment' => 'Архитектор ПО'],
    ['surname' => 'Волкова', 'name' => 'Юлия', 'lastname' => 'Владимировна', 'gender' => 'женский', 'birthdate' => '1995-08-30', 'phone' => '+7(999)043-45-67', 'address' => 'Новосибирск, ул. Красный пр., 50', 'email' => 'volkova.yu@example.com', 'comment' => 'Ассистент'],
];

// Очищаем существующие записи
$db->exec('TRUNCATE TABLE contacts');
echo "🗑️ Таблица очищена.\n";

// Вставляем записи
$stmt = $db->prepare('
    INSERT INTO contacts (surname, name, lastname, gender, birthdate, phone, address, email, comment)
    VALUES (:surname, :name, :lastname, :gender, :birthdate, :phone, :address, :email, :comment)
');

foreach ($contacts as $contact) {
    $stmt->execute([
        ':surname' => $contact['surname'],
        ':name' => $contact['name'],
        ':lastname' => $contact['lastname'],
        ':gender' => $contact['gender'],
        ':birthdate' => $contact['birthdate'],
        ':phone' => $contact['phone'],
        ':address' => $contact['address'],
        ':email' => $contact['email'],
        ':comment' => $contact['comment'],
    ]);
}

echo "✅ Добавлено " . count($contacts) . " записей в БД\n";
?>
