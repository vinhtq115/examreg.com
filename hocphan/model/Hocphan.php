<?php


namespace hocphan\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Hocphan extends PDOData {
    /**
     * Hocphan constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Hocphan deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}