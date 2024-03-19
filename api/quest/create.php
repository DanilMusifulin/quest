<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/quest.php";
$database = new Database();
$db = $database->getConnection();
$quest = new Quest($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->name_quest) &&
    !empty($data->description) &&
    !empty($data->cost)
) {
    // устанавливаем значения свойств товара
    $quest->name_quest = $data->name_quest;
    $quest->description = $data->description;
    $quest->created = $data->date("Y-m-d H:i:s");
    $quest->cost = $data->cost;


    // создание задания
    if ($quest->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Задание было создано"), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать задание, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать задание."), JSON_UNESCAPED_UNICODE);
    }
}
// сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать задание. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>
