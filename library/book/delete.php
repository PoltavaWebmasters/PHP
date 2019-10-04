<?php


// Заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение базы данных
include_once('c:/ospanel/domains/localhost/library/config/database.php');

// Подключение обьекта
include_once('c:/ospanel/domains/localhost/library/objects/book.php');

$database=new Database();
$db=$database->getConnection();

$book=new Book($db);

// Получаем опубликованные данные
$data = json_decode(file_get_contents("php://input"));

// Задаем параметр id для удаления
$book->id = $data->id;

// Удаляем запись
if($book->delete()){

    //Получаем ответ 201 об успешном удалении записи
    http_response_code(200);
    // Обьявляем пользователю
    echo json_encode(array("message"=>"Book was Deleted"));

}
// Обьявление о неуспешном удалении записи
else{
    // Устанавливаем код ответа 400 ошибка запроса
    http_response_code(503);
    // Обьявляем пользователю
    echo json_encode(array("message"=>"Unable to delete"));
}