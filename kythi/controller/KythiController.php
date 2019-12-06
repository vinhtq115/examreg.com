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
     * Lấy mã kỳ thi
     * @return false|string
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
     * Hàm thêm kỳ thi.
     * @param $nambatdau: Năm bắt đầu kỳ.
     * @param $namketthuc: Năm kết thúc kỳ.
     * @param $ky: Số chỉ kỳ.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($nambatdau, $namketthuc, $ky) {
        return $this->kythi->add($nambatdau, $namketthuc, $ky);
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
     * Hàm sửa kỳ thi.
     * @param $makythi: Mã kỳ thi.
     * @param $nambatdau: Năm bắt đầu kỳ.
     * @param $namketthuc: Năm kết thúc kỳ.
     * @param $ky: Số chỉ kỳ.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($makythi, $nambatdau, $namketthuc, $ky) {
        return $this->kythi->edit($makythi, $ky, $nambatdau, $namketthuc);
    }
}