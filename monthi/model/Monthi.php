<?php


namespace monthi\model;


use PDOData;

require_once ("core/data/PDOData.php");


class Monthi extends PDOData {
    /**
     * Monthi constructor.
     */
    public function __construct() {
        parent::__construct();
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
        echo $c;
        return $c;
    }

    public function delete($mamonthi) {
        $sql = "DELETE FROM monthi WHERE monthi.mamonthi = '$mamonthi'";
        $this->doSql($sql);
    }
}