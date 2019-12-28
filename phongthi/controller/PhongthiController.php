<?php
namespace phongthi\controller;

use phongthi\model\Phongthi;
use phongthi\view\PhongthiView;

require_once dirname(__FILE__)."/../model/Phongthi.php";
require_once dirname(__FILE__)."/../view/PhongthiView.php";
require_once dirname(__FILE__)."/../../quanlyphongthi/controller/PhongthiController.php";

class PhongthiController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $phongthi; // Model phongthi
    private $view; // View phongthi
    private $quanlyphongthictrl; // Controller quanlyphongthi

    /**
     * PhongthiController constructor.
     * @param $macathi: Mã ca thi
     */
    public function __construct($macathi) {
        $this->phongthi = new Phongthi($macathi);
        $data = $this->phongthi->getAll(); // Lấy danh sách phòng thi của ca thi
        $this->data = json_encode($data);
        $this->view = new PhongthiView($this->data); // Khởi tạo view và gán data
        $this->quanlyphongthictrl = new \quanlyphongthi\controller\PhongthiController(); // Dùng để lấy danh sách toàn bộ phòng thi
    }

    /**
     * Hiện bảng phòng thi
     * @return string
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Lấy mã phòng thi trong ca thi hiện tại.
     * @return string
     */
    public function datalist() {
        return $this->view->datalist_phongthi();
    }

    /**
     * Lấy tất cả các mã phòng thi trong hệ thống.
     * @return string
     */
    public function datalist_phongthi() {
        return $this->quanlyphongthictrl->datalist();
    }

    /**
     * Hiện form thêm phòng thi
     * @return string
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa phòng thi
     * @return string
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Thêm phòng thi
     * @param $maphongthi: Mã phòng thi
     * @return int: Số bản ghi được cập nhật
     */
    public function add($maphongthi) {
        return $this->phongthi->add($maphongthi);
    }

    /**
     * Xóa phòng thi.
     * @param $maphongthi: Mã phòng thi
     * @return int: Số bản ghi được cập nhật
     */
    public function delete($maphongthi) {
        return $this->phongthi->delete($maphongthi);
    }

    /**
     * Kiểm tra xem ca thi có phòng thi không.
     * @param $maphongthi: Mã phòng thi.
     * @return bool
     */
    public function check($maphongthi) {
        return $this->phongthi->check($maphongthi);
    }
}