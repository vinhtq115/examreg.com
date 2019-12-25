<?php


namespace phongthi\controller;

use phongthi\model\Inphongthi;

require_once dirname(__FILE__)."/../model/Inphongthi.php";
require_once dirname(__FILE__).'/../../vendor/phpoffice/phpword/src/PhpWord/TemplateProcessor.php';
require dirname(__FILE__).'/../../vendor/autoload.php';

class InphongthiController {
    private $model; // Model Inphongthi
    private $danhsachsinhvien; // Danh sách sinh viên
    private $cathi; // Thông tin ca thi
    private $phongthi; // Thông tin phòng thi

    /**
     * InphongthiController constructor.
     * @param $cathi: Mã ca thi
     * @param $phongthi: Mã phòng thi
     */
    public function __construct($cathi, $phongthi) {
        $this->model = new Inphongthi($cathi, $phongthi);
        $this->phongthi = json_encode($this->model->getPhongthi()); // Lấy thông tin phòng thi
        $this->cathi = json_encode($this->model->getCathi()); // Lấy thông tin ca thi
        $this->danhsachsinhvien = json_encode($this->model->getAll()); // Lấy danh sách sinh viên
    }

    /**
     * Xử lý file template.
     */
    public function process() {
        $sinhvien = json_decode($this->danhsachsinhvien, true);
        $phongthi = json_decode($this->phongthi, true);
        $cathi = json_decode($this->cathi, true);
        // Lấy file template làm mẫu
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__)."/Sample_DSPT.docx");
        // Thay thông tin bên ngoài bảng
        foreach ($cathi as $key => $value) {
            $templateProcessor->setValue("tenmonthi", $value["tenmonthi"]); // Thay tên môn thi
            $templateProcessor->setValue("mahocphan", $value["mahocphan"]); // Thay mã học phần
            $templateProcessor->setValue("ngaythi", $value["ngaythi"]); // Thay ngày thi
            $templateProcessor->setValue("thoigianthi", $value["giobatdau"]."-".$value["gioketthuc"]); // Thay giờ thi
            break;
        }
        foreach ($phongthi as $key => $value) {
            $templateProcessor->setValue("maphong", $value["maphongthi"]); // Thay mã phòng
            $templateProcessor->setValue("diadiem", $value["diadiem"]); // Thay địa điểm
            break;
        }
        // Thay thông tin sinh viên đăng ký
        $templateProcessor->cloneRow('stt', sizeof($sinhvien));
        $i = 1;
        foreach ($sinhvien as $key => $value) {
            $templateProcessor->setValue('stt#'.$i, $i); // Thay số thứ tự
            $templateProcessor->setValue('mssv#'.$i, $value["masinhvien"]); // Thay mssv
            $templateProcessor->setValue('hoten#'.$i, $value["hodem"]." ".$value["ten"]); // Thay họ tên
            $templateProcessor->setValue('ngaysinh#'.$i, $value["ngaysinh"]); // Thay ngày sinh
            $i = $i + 1;
        }

        return $templateProcessor;
    }
}