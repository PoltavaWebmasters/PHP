<?php
// Необходимые заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Подключение базы данных
include_once ('c:/ospanel/domains/localhost/library/config/database.php');

// Подключение обьекта
include_once ('c:/ospanel/domains/localhost/library/objects/author.php');

$database = new Database();
$db = $database->getConnection();

$author = new Author($db);

// Устанавливаем приоритет вывода по Айди
$author->id = isset($_GET['id'])? $_GET['id']:die();
// Выводим данные полей автора
$author->readOne();

if ($author->first_name!=null) {

    $author_arr=array(
        "id"=>$author->id,
        "first_name"=>$author->first_name,
        "second_name"=>$author->second_name,
        "book_id"=>$author->book_id
    );

    // Устанавливаем код ответа 200
    http_response_code(200);

    // Выводим в формате json
    echo json_encode($author_arr);

}
// Устанавливаем код ответа 400
else {
 http_response_code(400);

}