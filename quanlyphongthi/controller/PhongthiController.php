<?php
namespace quanlyphongthi\controller;

use quanlyphongthi\model\Phongthi;
use quanlyphongthi\view\PhongthiView;

require_once dirname(__FILE__)."/../model/Phongthi.php";
require_once dirname(__FILE__)."/../view/PhongthiView.php";

class PhongthiController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $phongthi; // Model phongthi
    private $view; // View phongthi

    /**
     * PhongthiController constructor.
     */
    public function __construct() {
        $this->phongthi = new Phongthi();
        $this->data = json_encode($this->phongthi->getAll()); // Lấy dữ liệu phòng thi
        $this->view = new PhongthiView($this->data); // Khởi tạo view và gán dữ liệu
    }

    /**
     * Hiện toàn bộ phòng thi dưới dạng bảng.
     * @return string
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Lấy datalist mã phòng thi
     * @return string
     */
    public function datalist() {
        return $this->view->datalist_phongthi();
    }

    /**
     * Hiện form thêm phòng thi.
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa phòng thi.
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Hiện form sửa phòng thi.
     */
    public function showEdit() {
        return $this->view->editForm();
    }

    /**
     * Hàm thêm phòng thi.
     * @param $maphongthi: Mã phòng thi.
     * @param $diadiem: Địa điểm.
     * @param $soluongmay: Số lượng máy.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($maphongthi, $diadiem, $soluongmay) {
        return $this->phongthi->add($maphongthi, $diadiem, $soluongmay);
    }

    /**
     * Hàm xóa phòng thi.
     * @param $maphongthi: Mã phòng thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($maphongthi) {
        return $this->phongthi->delete($maphongthi);
    }

    /**
     * Hàm sửa phòng thi.
     * @param $maphongthicu: Mã phòng thi cũ.
     * @param $maphongthimoi: Mã phòng thi mới.
     * @param $diadiem: Địa điểm mới.
     * @param $soluongmay: Số lượng máy mới.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($maphongthicu, $maphongthimoi, $diadiem, $soluongmay) {
        return $this->phongthi->edit($maphongthicu, $maphongthimoi, $diadiem, $soluongmay);
    }
}