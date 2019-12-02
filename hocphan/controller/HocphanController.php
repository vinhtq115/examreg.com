<?php
namespace hocphan\controller;

use hocphan\model\Hocphan;
use hocphan\view\HocphanView;

require_once dirname(__FILE__)."/../model/Hocphan.php";
require_once dirname(__FILE__)."/../view/HocphanView.php";

class HocphanController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $hocphan; // Model hocphan
    private $view; // View hocphan

    /**
     * MonthiController constructor.
     */
    public function __construct() {
        $this->hocphan = new Hocphan();
        $this->data = json_encode($this->hocphan->getAll());
        $this->view = new HocphanView($this->data);
    }

    /**
     * Hiện toàn bộ học phần dưới dạng bảng.
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Hiện form thêm học phần.
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa học phần.
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Hàm thêm học phần.
     * @param $mahocphan: Mã học phần.
     * @param $mamonthi: Mã môn thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($mahocphan, $mamonthi) {
        // TODO: clean input
        return $this->hocphan->add($mahocphan, $mamonthi);
    }

    /**
     * Hàm xóa học phần.
     * @param $mahocphan: Mã học phần.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($mahocphan) {
        // TODO: clean input
        return $this->hocphan->delete($mahocphan);
    }
}