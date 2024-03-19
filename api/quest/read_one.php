<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once "../config/database.php";
include_once "../objects/quest.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$quest = new Quest($db);

// установим свойство ID записи для чтения
$quest->id_quest = isset($_GET["id_quest"]) ? $_GET["id_quest"] : die();

// получим детали задания
$quest->readOne();

if ($quest->name != null) {

    // создание массива
    $quest_arr = array(
        "id_quest" =>  $quest->id_quest,
        "name_quest" => $quest->name_quest,
        "description" => $quest->description,
        "created" => $quest->created,
        "cost" => $quest->cost
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($quest_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой задания не существует
    echo json_encode(array("message" => "Задания не существует"), JSON_UNESCAPED_UNICODE);
}
?>
