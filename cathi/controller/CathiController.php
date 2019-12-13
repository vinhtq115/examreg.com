<?php
namespace cathi\controller;

use cathi\model\Cathi;
use cathi\view\CathiView;
use hocphan\controller\HocphanController;

require_once dirname(__FILE__)."/../model/Cathi.php";
require_once dirname(__FILE__)."/../view/CathiView.php";
require_once dirname(__FILE__)."/../../hocphan/controller/HocphanController.php";

class CathiController {
    private $data; // Chứa dữ liệu cho view (JSON)
    private $cathi; // Model Cathi
    private $view; // View của Cathi
    private $hocphanctrl; // Controller hocphan

    /**
     * CathiController constructor.
     * @param $kythi: Mã kỳ thi
     */
    public function __construct($kythi) {
        $this->cathi = new Cathi($kythi);
        $data = $this->cathi->getAll();;
        $this->data = json_encode($data);
        $this->view = new CathiView($this->data);
        $this->view->setYear($this->getYear()[0]);
        $this->hocphanctrl = new HocphanController();
    }

    /**
     * Hiện bảng ca thi
     */
    public function table() {
        return $this->view->tableView();
    }

    /**
     * Lấy mã ca thi.
     * @return string
     */
    public function datalist() {
        return $this->view->datalist_cathi();
    }

    /**
     * Lấy danh sách học phần
     * @return string
     */
    public function datalist_hocphan() {
        return $this->hocphanctrl->datalist_hocphan();
    }

    /**
     * Hiện form thêm ca thi
     * @return string
     */
    public function showAdd() {
        return $this->view->addForm();
    }

    /**
     * Hiện form xóa ca thi
     * @return string
     */
    public function showDelete() {
        return $this->view->deleteForm();
    }

    /**
     * Hiện form xóa ca thi
     * @return string
     */
    public function showEdit() {
        return $this->view->editForm();
    }

    /**
     * Lấy năm bắt đầu, năm kết thúc và kỳ
     * @return mixed
     */
    public function getYear() {
        $years = json_encode($this->cathi->getYear());
        return json_decode($years, true);
    }

    /**
     * Thêm ca thi
     * @param $mahocphan: Mã học phần
     * @param $ngaythi: Ngày thi (YYYY-MM-DD)
     * @param $giobatdau: Giờ bắt đầu (HH:MM:SS)
     * @param $gioketthuc: Giờ kết thúc (HH:MM:SS)
     * @return int: Số bản ghi được cập nhật
     */
    public function add($mahocphan, $ngaythi, $giobatdau, $gioketthuc) {
        return $this->cathi->add($mahocphan, $ngaythi, $giobatdau, $gioketthuc);
    }

    /**
     * Xóa ca thi
     * @param $macathi: Mã ca thi
     * @return int: Số bản ghi được cập nhật
     */
    public function delete($macathi) {
        return $this->cathi->delete($macathi);
    }

    /**
     * Sửa ca thi
     * @param $macathi: Mã ca thi
     * @param $mahocphan: Mã học phần
     * @param $ngaythi: Ngày thi (YYYY-MM-DD)
     * @param $giobatdau: Giờ bắt đầu (HH:MM:SS)
     * @param $gioketthuc: Giờ kết thúc (HH:MM:SS)
     * @return int: Số bản ghi được cập nhật
     */
    public function edit($macathi, $mahocphan, $ngaythi, $giobatdau, $gioketthuc) {
        return $this->cathi->edit($macathi, $mahocphan, $ngaythi, $giobatdau, $gioketthuc);
    }
}