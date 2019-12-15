<?php
namespace sinhvien\home\controller;

use sinhvien\home\model\Sinhvien;
use sinhvien\home\view\SinhvienView;

require_once dirname(__FILE__)."/../model/Sinhvien.php";
require_once dirname(__FILE__)."/../view/SinhvienView.php";

class SinhvienController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $model; // Model Sinhvien
    private $view; // View Sinhvien

    /**
     * SinhvienController constructor.
     * @param $mssv: Mã số sinh viên
     */
    public function __construct($mssv) {
        $this->model = new Sinhvien($mssv);
        $data = $this->model->getInfo();
        $this->data = json_encode($data);
        $this->view = new SinhvienView($this->data);
    }

    /**
     * Kiểm tra xem đủ điều kiện dự thi không.
     * @return bool: true nếu đủ và ngược lại
     */
    public function isQualified() {
        $temp = json_decode($this->data, true);
        $size = sizeof($temp); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($temp as $key => $value) {
                $check = $value["dudieukienduthi"];
                break;
            }
        }
        return ($check == 1? true : false);
    }

    /**
     * Hiện lời chào.
     * @return string: HTML
     */
    public function showWelcomeMessage() {
        return $this->view->welcomeMessage();
    }

    /**
     * Hiện hướng dẫn.
     * @return string: HTML
     */
    public function showInstruction() {
        return $this->view->instruction();
    }

    public function showCurrentSemester() {
        $current_semester = $this->model->getCurrentSemester();
        return $this->view->currentSemester(json_encode($current_semester));
    }
}