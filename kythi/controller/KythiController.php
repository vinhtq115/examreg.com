<?php
namespace kythi\controller;

use kythi\model\Kythi;
use kythi\view\KythiView;

require_once dirname(__FILE__)."/../model/Kythi.php";
require_once dirname(__FILE__)."/../view/KythiView.php";

class KythiController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $kythi; // Model kythi
    private $view; // View kythi

    /**
     * KythiController constructor.
     */
    public function __construct() {
        $this->kythi = new Kythi();
        $this->data = json_encode($this->kythi->getAll());
        $this->view = new KythiView($this->data);
    }

    /**
     * Hiện toàn bộ kỳ thi dưới dạng bảng.
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Lấy mã kỳ thi.
     * @return string
     */
    public function datalist() {
        return $this->view->datalist_kythi();
    }

    /**
     * Hiện form thêm kỳ thi.
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa kỳ thi.
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Hiện form sửa kỳ thi.
     */
    public function showEdit() {
        return $this->view->editForm();
    }

    /**
     * Hiện form chọn kỳ thi hiện tại.
     */
    public function showSetActive() {
        return $this->view->chooseActiveSemester();
    }

    /**
     * Hàm thêm kỳ thi.
     * @param $nambatdau : Năm bắt đầu kỳ.
     * @param $namketthuc : Năm kết thúc kỳ.
     * @param $ky : Số chỉ kỳ.
     * @param $ngaybatdau : Ngày bắt đầu thi.
     * @param $ngayketthuc : Ngày kết thúc thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($nambatdau, $namketthuc, $ky, $ngaybatdau, $ngayketthuc) {
        return $this->kythi->add($nambatdau, $namketthuc, $ky, $ngaybatdau, $ngayketthuc);
    }

    /**
     * Hàm xóa kỳ thi.
     * @param $makythi: Mã kỳ thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($makythi) {
        return $this->kythi->delete($makythi);
    }

    /**
     * Hàm kiểm tra xem kỳ thi có tồn tại hay không.
     * @param $makythi: Mã kỳ thi.
     * @return mixed
     */
    public function check($makythi) {
        $data = json_decode(json_encode($this->kythi->getAll()), true);
        foreach ($data as $key => $value) {
            if ($value["id"] == $makythi) {
                return true;
            }
        }
        return false;
    }

    /**
     * Hàm sửa kỳ thi.
     * @param $makythi : Mã kỳ thi.
     * @param $nambatdau : Năm bắt đầu kỳ.
     * @param $namketthuc : Năm kết thúc kỳ.
     * @param $ky : Số chỉ kỳ.
     * @param $ngaybatdau : Ngày bắt đầu thi.
     * @param $ngayketthuc : Ngày kết thúc thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($makythi, $nambatdau, $namketthuc, $ky, $ngaybatdau, $ngayketthuc) {
        return $this->kythi->edit($makythi, $ky, $nambatdau, $namketthuc, $ngaybatdau, $ngayketthuc);
    }

    /**
     * Chọn kỳ thi hiện tại.
     * @param $makythi : Mã kỳ thi
     * @return int : Số bản ghi được cập nhật
     */
    public function setActive($makythi) {
        return $this->kythi->setActive($makythi);
    }

    public function disableActive() {
        return $this->kythi->disableActive();
    }
}