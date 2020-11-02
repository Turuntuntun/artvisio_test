<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 18.10.2020
 * Time: 23:22
 */

namespace core;

use PDO;
abstract class Model
{
    public $connect;

    public function __construct()
    {
        $db = require $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
        $this->getConnect($db);
        if (!$this->tableExists('books')) {
            $this->createTable();
        }
    }

    protected function getConnect(array $db) : void
    {
        $this->connect = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'] . '', $db['user'], $db['password']);
    }

    protected function tableExists(string $table) : bool
    {
        try {
            $sth = $this->connect->prepare("SELECT 1 FROM $table LIMIT 1");
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return FALSE;
        }

        return $result !== FALSE;
    }

    public function createTable() :void
    {
        $sth = $this->connect->prepare("CREATE TABLE `books` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(128) NOT NULL , `year` INT NOT NULL , `author` VARCHAR(128) NOT NULL , PRIMARY KEY (`id`))");
        $sth->execute();
    }


}