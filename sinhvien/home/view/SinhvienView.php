<?php


namespace sinhvien\home\view;


class SinhvienView {
    private $data; // Thông tin sinh viên

    /**
     * Khởi tạo SinhvienView.
     * @param $data: Thông tin sinh viên (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Hiện lời chào.
     * @return string: HTML
     */
    public function welcomeMessage() {
        $html = "<div class='alert alert-primary' role='alert'>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "Xin chào ".$value["hodem"]." ".$value["ten"]." (".$value["ngaysinh"]."). Mã số sinh viên của bạn là ".$value["id"];
                break;
            }
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * Hiện hướng dẫn.
     * @return string: HTML
     */
    public function instruction() {
        // Kiểm tra xem đủ điều kiện dự thi chưa
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $dudieukienduthi = $value["dudieukienduthi"];
                break;
            }
        }
        if (!$dudieukienduthi) { // Nếu chưa đủ điều kiện dự thi
            $html = "<div class='alert alert-danger' role='alert'>";
            $size = sizeof($this->data); // Chứa kích cỡ mảng data
            if ($size > 0) { // Trả về dữ liệu nếu size > 0
                foreach ($this->data as $key => $value) {
                    $html .= "Bạn không đủ điều kiện để dự thi. Vui lòng liên hệ phòng đào tạo để biết thêm thông tin chi tiết.";
                    break;
                }
            }
            $html .= "</div>";
            return $html;
        } else { // Nếu đủ điều kiện dự thi
            $html = "<div class='alert alert-primary' role='alert'>";
            $html .= "</div>";
            return $html;
        }
    }
}