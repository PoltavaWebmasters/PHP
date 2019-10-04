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
include_once ('c:/ospanel/domains/localhost/library/objects/book.php');

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

// Устанавливаем приоритет вывода по Айди
$book->id = isset($_GET['id'])? $_GET['id']:die();
// Выводим данные полей книги
$book->readOne();

if ($book->title!=null) {

    $book_arr=array(
        "id"=>$book->id,
        "title"=>$book->title,
        "author_id"=>$book->author_id,
        "publishing_house_id"=>$book->publishing_house_id
    );

    // Устанавливаем код ответа 200
    http_response_code(200);

    // Выводим в формате json
    echo json_encode($book_arr);

}
// Устанавливаем код ответа 400
else {
    http_response_code(400);

}