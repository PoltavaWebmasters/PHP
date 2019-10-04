<?php
// Необходимые заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Подключение к базе данных

// -подключаем файлы обьекта и базы данных
include_once 'c:/ospanel/domains/localhost/library/config/database.php';
include_once  'c:/ospanel/domains/localhost/library/objects/publishing_house.php';


// - создаем новые обьекты базы данных и автора
$database = new Database();
$db = $database->getConnection();

$publishing_house = new PublishingHouse($db);

// Метод чтения для таблицы автора

// запрашиваем данные по авторам c пощью методов MySql
$stmt = $publishing_house->read();
$num = $stmt->rowCount();

//Проверяем наличие данных в таблице
if($num>0) {
    // преващаем в массив
    $publishing_house_arr=array();
    $publishing_house_arr["records"]=array();

    //получаем данные из таблицы с помошью функции fetch()
    // проганяя данные через цикл while и каждую запись выводя с кодом 200 в формате JSON
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        // выделяем запись
        extract($row);
        // превращаяем выделенные записи в массив
        $publishing_house_item=array(
            "id"=>$id,
            "title"=>$title,
        );

        array_push($publishing_house_arr["records"], $publishing_house_item);
    }
    // выводим код 200
    http_response_code(200);

    // выводим авторов в формате JSON
    echo json_encode($publishing_house_arr);
}

else{

    // Выдаем код ответа - 404 Not found
    http_response_code(404);

    // оповещаем пользователя о пустой таблице
    echo json_encode(
        array("message"=>"No authors found.")
    );

}
