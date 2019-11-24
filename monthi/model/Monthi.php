<?php


namespace monthi\model;


use PDOData;

require_once ("core/data/PDOData.php");


class Monthi extends PDOData {
    private $host = "localhost"; // SQL hostname
    private $dbname = "web"; // Database name
    private $username = "test"; // Username for connecting database
    private $password = "123456"; // Password for connecting database

    /**
     * Monthi constructor.
     */
    public function __construct() {
        try {
            $this->db = new \PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=UTF8", $this->username, $this->password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Monthi deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách môn thi
     * @return array: Mảng danh sách môn thi
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT * FROM monthi");
        return $ret;
    }

    public function add($mamonthi, $tenmonthi, $tinchi) {
        $sql = "INSERT INTO monthi(mamonthi, tenmonthi, tinchi) VALUES ('$mamonthi', '$tenmonthi', '$tinchi')";
        $c = $this->doSql($sql);
        return $c;
    }

    public function delete($mamonthi) {
        $sql = "DELETE FROM monthi WHERE monthi.mamonthi = '$mamonthi'";
        $this->doSql($sql);
    }
}