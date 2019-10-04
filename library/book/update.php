<?php

// Прописываем необходимые заголовки

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение базы данных и обьекта
include_once 'c:/ospanel/domains/localhost/library/config/database.php';
include_once 'c:/ospanel/domains/localhost/library/objects/book.php';

// Подключаем базу данных
$database = new Database();
$db = $database->getConnection();

// Подготавливаем обьект книга
$book = new Book($db);

// Выбираем идентификатор книги для редактирования
$data = json_decode(file_get_contents("php://input"));

$book->id = $data->id;

// Задаем значения
$book->title = $data->title;
$book->author_id  = $data->author_id;
$book->publishing_house_id = $data->publishing_house_id;

// Обновляем книгу
if($book->update()) {
    //Получаем ответ 201 об успешном обновлении записи
    http_response_code(200);
    // Обьявляем пользователю
    echo  json_encode(array("message"=>"Book update Successfull!"));

}
else{
    // Устанавливаем код ответа 503
    http_response_code(503);
    // Обьявляем пользователю
    echo json_encode(array("message"=>"Unable to update"));

}