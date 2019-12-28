<?php
namespace monthi\controller;

use monthi\model\Monthi;
use monthi\view\MonthiView;

require_once dirname(__FILE__)."/../model/Monthi.php";
require_once dirname(__FILE__)."/../view/MonthiView.php";

class MonthiController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $monthi; // Model monthi
    private $view; // View monthi

    /**
     * MonthiController constructor.
     */
    public function __construct() {
        $this->monthi = new Monthi();
        $this->data = json_encode($this->monthi->getAll()); // Lấy danh sách môn thi
        $this->view = new MonthiView($this->data); // Khởi tạo view và gán dữ liệu
    }

    /**
     * Hiện toàn bộ môn thi dưới dạng bảng.
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Lấy mã môn thi
     * @return false|string
     */
    public function datalist() {
        return $this->view->datalist_monthi();
    }

    /**
     * Hiện form thêm môn thi.
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa môn thi.
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Hiện form sửa môn thi.
     */
    public function showEdit() {
        return $this->view->editForm();
    }

    /**
     * Hàm thêm môn thi.
     * @param $mamonthi: Mã môn thi.
     * @param $tenmonthi: Tên môn thi.
     * @param $tinchi: Số tín chỉ.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($mamonthi, $tenmonthi, $tinchi) {
        return $this->monthi->add($mamonthi, $tenmonthi, $tinchi);
    }

    /**
     * Hàm xóa môn thi.
     * @param $mamonthi: Mã môn thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($mamonthi) {
        return $this->monthi->delete($mamonthi);
    }

    /**
     * Hàm sửa môn thi.
     * @param $mamonthicu: Mã môn thi cũ.
     * @param $mamonthimoi: Mã môn thi mới.
     * @param $tenmonthimoi: Tên môn thi mới.
     * @param $tinchimoi: Số tín chỉ mới.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($mamonthicu, $mamonthimoi, $tenmonthimoi, $tinchimoi) {
        return $this->monthi->edit($mamonthicu, $mamonthimoi, $tenmonthimoi, $tinchimoi);
    }
}