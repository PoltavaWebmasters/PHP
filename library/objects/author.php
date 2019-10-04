<?php

class Author{

    //Параметры базы данных и имя таблицы
 private $conn;
 private $table_name = "author";

   // Свойства обьекта
    public $id;
    public $first_name;
    public $second_name;
    public $book_id;

    // Используем  конструктор __construct($db) для передачи параметров в базу данных

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Чтение данных таблицы авторов

    function read()
    {
        // запрос SELECT ALL для всех данных таблицы
        $query = "SELECT * 
                  from ".$this->table_name."
                  ";

        // подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        //выполняем запрос
        $stmt->execute();

        return $stmt;
                       
    }

    // Создаем новую запись в таблицу авторов

    function create()
    {
        //Запрос для добавления записи
        $query="INSERT INTO
                   " . $this->table_name . "
                 SET
                  first_name=:first_name, second_name=:second_name, book_id=:book_id";

        // Подготавливаем запрос
        $stmt=$this->conn->prepare($query);

        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->second_name=htmlspecialchars(strip_tags($this->second_name));
        $this->book_id=htmlspecialchars(strip_tags($this->book_id));

        //Связываем значения
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":second_name", $this->second_name);
        $stmt->bindParam(":book_id", $this->book_id);

        //Выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    // Просмотр данных по одной записи
    function readOne()
    {
        $query = "SELECT *
                  From
                    " . $this->table_name . " 
                  WHERE
                   id = ?
                 ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name = $row['first_name'];
        $this->second_name = $row['second_name'];
        $this->book_id = $row['book_id'];

    }

    // Обноляем запись в таблицу авторов
    function update()
    {
        // Запрос на обновление
        $query = "UPDATE 
                   ". $this->table_name . "
                   SET
                    first_name = :first_name,
                    second_name = :second_name,
                    book_id = :book_id
                   WHERE
                    id = :id";

        // Подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->second_name=htmlspecialchars(strip_tags($this->second_name));
        $this->book_id=htmlspecialchars(strip_tags($this->book_id));

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':second_name', $this->second_name);
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':id', $this->id);

        // Выполняем запрос
        if($stmt->execute()){
            return true;
        }
        return false;
    }


    // Удаление записи из таблицы авторов
    function delete()
    {
        // Запрос на удаление
        $query = "Delete 
                  From
                    " . $this->table_name . " 
                  WHERE
                   id = ?
                 ";

        // Подготавливаем запрос
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        // Выполняем запрос
        if($stmt->execute()){
            return true;
        }
        return false;

    }

}