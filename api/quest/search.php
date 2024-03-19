<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/user.php";

// создание подключения к БД
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$user = new user($db);

// получаем ключевые слова
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

// запрос 
$stmt = $user->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num > 0) {
    // массив 
    $users_arr = array();
    $users_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлечём строку
        extract($row);
        $user_item = array(
            "id_user" => $id_user,
            "name_user" => $name_user,
            "balance" => $balance
        );
        array_push($users_arr["records"], $user_item);
    }
    // код ответа - 200 OK
    http_response_code(200);

    // покажем 
    echo json_encode($users_arr);
} else {
 // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что не найдены
    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}
?>
