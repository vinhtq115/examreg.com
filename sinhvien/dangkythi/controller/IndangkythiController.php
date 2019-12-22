<?php


namespace sinhvien\dangkythi\controller;

use sinhvien\dangkythi\model\Indangkythi;

require_once dirname(__FILE__)."/../model/Indangkythi.php";
require_once dirname(__FILE__).'/../../../vendor/phpoffice/phpword/src/PhpWord/TemplateProcessor.php';
require dirname(__FILE__).'/../../../vendor/autoload.php';

class IndangkythiController {
    private $model; // Model Indangkythi
    private $thongtinsinhvien;
    private $thongtinhocky;
    private $cathidadangky;

    /**
     * IndangkythiController constructor.
     * @param $mssv: Mã số sinh viên
     */
    public function __construct($mssv) {
        $this->model = new Indangkythi($mssv);
        $this->thongtinsinhvien = json_encode($this->model->getStudentInfo());
        $this->thongtinhocky = json_encode($this->model->getSemesterInfo());
        $this->cathidadangky = json_encode($this->model->getRegisteredCathi());
    }

    /**
     * Xử lý file template.
     */
    public function process() {
        $sinhvien = json_decode($this->thongtinsinhvien, true);
        $hocky = json_decode($this->thongtinhocky, true);
        $cathi = json_decode($this->cathidadangky, true);
        // Lấy file template làm mẫu
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__)."/Sample_PBDT.docx");
        // Thay thông tin sinh viên
        foreach ($sinhvien as $key => $value) {
            $templateProcessor->setValue("hodem", $value["hodem"]); // Thay họ đệm
            $templateProcessor->setValue("ten", $value["ten"]); // Thay tên
            $templateProcessor->setValue("mssv", $value["id"]); // Thay mssv
            $templateProcessor->setValue("ngaysinh", $value["ngaysinh"]); // Thay ngày sinh
            break;
        }
        // Thay thông tin kỳ thi
        foreach ($hocky as $key => $value) {
            $templateProcessor->setValue("ky", $value["ky"]); // Thay kỳ
            $templateProcessor->setValue("nam", $value["nambatdau"]."-".$value["namketthuc"]); // Thay năm
            break;
        }
        // Thay thông tin ca thi đã đăng ký
        $templateProcessor->cloneRow('stt', sizeof($cathi));
        $i = 1;
        foreach ($cathi as $key => $value) {
            $templateProcessor->setValue('stt#'.$i, $i); // Thay số thứ tự
            $templateProcessor->setValue('mahocphan#'.$i, $value["mahocphan"]); // Thay mã học phần
            $templateProcessor->setValue('tenmonthi#'.$i, $value["tenmonthi"]); // Thay tên môn thi
            $templateProcessor->setValue('ngaythi#'.$i, $value["ngaythi"]); // Thay ngày thi
            $templateProcessor->setValue('giobatdau#'.$i, $value["giobatdau"]); // Thay giờ bắt đầu
            $templateProcessor->setValue('gioketthuc#'.$i, $value["gioketthuc"]); // Thay giờ kết thúc
            $templateProcessor->setValue('maphongthi#'.$i, $value["maphongthi"]); // Thay mã phòng thi
            $i = $i + 1;
        }
        $templateProcessor->setValue('day', date('d')); // Thay ngày
        $templateProcessor->setValue('month', date('m')); // Thay tháng
        $templateProcessor->setValue('year', date('Y')); // Thay năm
        return $templateProcessor;
    }
}