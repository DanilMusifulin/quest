<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request_usered-With");

// подключаем файл для работы с БД и объектом quest_user
include_once "../config/database.php";
include_once "../objects/quest_user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$quest_user = new Quest_user($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

$quest_user->id_quest = $data->id_quest;
$quest_user->id_user = $data->id_user;
$quest_user->date_5 = date("Y-m-d H:i:s");



// обновление 
if ($quest_user->control_passed()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Задание не было обновлёно"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить задание, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить задание"), JSON_UNESCAPED_UNICODE);
}
?>
