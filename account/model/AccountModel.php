<?php
namespace account\model;

require_once("core/data/PDOData.php");

class AccountModel {
    public function __contruct() {
    }

    public function newAccount($u, $p) {
        $db = new PDOData();
        $data = $db->doPreparedQuery("select * from nsd where tsd like ? and mk like password(?);", array($u, $p));

        if (count($data) > 0) return true;

        return false;
    }
}
