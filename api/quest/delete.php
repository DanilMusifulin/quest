<?php

  // HTTP-заголовки
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Reusered-With");

  // подключим файл для соединения с базой и объектом user
  include_once "../config/database.php";
  include_once "../objects/user.php";

  // получаем соединение с БД
  $database = new Database();
  $db = $database->getConnection();

  // подготовка объекта
  $product = new User($db);

  // получаем id товара
  $data = json_decode(file_get_contents("php://input"));

  // установим id товара для удаления
  $user->id_user = $data->id_user;

  // удаление товара
  if ($user->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Пользователь не был удален"), JSON_UNESCAPED_UNICODE);
  }
  // если не удается удалить товар
  else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить пользователя"));
  }
?>
