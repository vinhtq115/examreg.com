<?php
namespace account\model;

require_once("core/data/PDOData.php");

class AccountModel {
    public function __contruct() {
    }

    public function newAccount($u, $p) {
        $db = new PDOData();

        if (count() > 0) return true;

        return false;
    }
}
