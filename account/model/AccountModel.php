<?php
require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class AccountModel extends PDOData {
    /**
     * AccountModel constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * AccountModel destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Hàm login.
     * @param $id: tên đăng nhập
     * @param $password: mật khẩu
     * @return array: Mảng chứa thông tin tài khoản khớp id và mật khẩu
     */
    public function login($id , $password) {
        $sql = "SELECT * FROM account WHERE id = ? AND password = PASSWORD(?)";
        return $this->doPreparedQuery($sql, [$id, $password]);
    }

    /**
     * Hàm logout dùng để đăng xuất
     */
    public function logout(){
        session_start();
        // Xóa mọi biến trong SESSION
        session_destroy();
        header("Location:http://examreg.com/");
    }

    /**
     * Hàm đổi mật khẩu.
     * @param $password: mật khẩu mới
     * @param $id: id
     */
    public function changePass($password,$id) {
        $sql = "UPDATE account SET password = PASSWORD(?) WHERE id = ?";
        $this->doPreparedQuery($sql, [$password, $id]);
    }
};
