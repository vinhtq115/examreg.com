<?php


namespace sinhvien\dangkythi\controller;

use sinhvien\dangkythi\model\Dangkythi;
use sinhvien\dangkythi\view\DangkythiView;

require_once dirname(__FILE__)."/../model/Dangkythi.php";
require_once dirname(__FILE__)."/../view/DangkythiView.php";

class DangkythiController {
    private $model; // Model Dangkythi
    private $view; // View Dangkythi
    private $allowedToRegister; // Dùng để kiểm tra xem có được đăng ký không
    private $registrable; // Danh sách ca thi có thể đăng ký
    private $registered; // Danh sách ca thi đã đăng ký

    /**
     * DangkythiController constructor.
     * @param $mssv: Mã số sinh viên
     */
    public function __construct($mssv) {
        $this->model = new Dangkythi($mssv); // Khởi tạo model
        $this->allowedToRegister = $this->model->checkIfAllowedToRegister(); // Kiểm tra xem đến thời gian đăng ký chưa
        $this->registrable = json_encode($this->model->getRegistrableCathi());
        $this->registered = json_encode($this->model->getRegisteredCathi());
        $this->view = new DangkythiView($this->allowedToRegister, $this->registrable, $this->registered); // Khởi tạo view
    }

    /**
     * Hàm đăng ký ca thi, phòng thi.
     * @param $macathi : Mã ca thi
     * @param $maphongthi : Mã phòng thi
     * @return int : Status code
     */
    public function register($macathi, $maphongthi) {
        return $this->model->register($macathi, $maphongthi);
    }

    /**
     * Lấy thông tin đến thời gian đăng ký thi chưa.
     * @return int: 1 nếu đã đến, 0 nếu chưa.
     */
    public function getAllowedToRegister(): int
    {
        return $this->allowedToRegister;
    }

    /**
     * Hiện thông báo khi chưa đến thời gian đăng ký thi.
     * @return string: HTML
     */
    public function showDisabled() {
        return $this->view->showDisabled();
    }

    /**
     * Hiện thông tin cảnh báo.
     * @return string: HTML
     */
    public function showWarning() {
        return $this->view->showWarning();
    }

    /**
     * Hiện bảng chứa các ca thi có thể đăng ký.
     * @return string : HTML
     */
    public function getRegistrableCathi() {
        return $this->view->registrableCathiTable();
    }

    /**
     * Hiện bảng chứa các ca thi đã đăng ký.
     * @return string : HTML
     */
    public function getRegisteredCathi() {
        return $this->view->registeredCathiTable();
    }
}