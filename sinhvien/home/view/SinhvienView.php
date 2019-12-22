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
                $html .= "Xin chào ".$value["hodem"]." ".$value["ten"]." (".$value["ngaysinh"]."). Mã số sinh viên của bạn là ".$value["id"].".";
                break;
            }
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * Hiện kỳ thi hiện tại.
     * @param $semester: Mảng kỳ thi hiện tại.
     * @return string: HTML
     */
    public function currentSemester($semester) {
        $processed = json_decode($semester, true);
        $size = sizeof($processed); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            $html = "<div class='alert alert-primary' role='alert'>";
            foreach ($processed as $key => $value) {
                $html .= "Kỳ thi hiện tại sẽ diễn ra từ ngày ".$value["ngaybatdau"]." đến ngày ".$value["ngayketthuc"].".";
                break;
            }
            $html .= "</div>";
            return $html;
        } else {
            return null;
        }
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
            $html = "<div>";
            $html .= "<h1>Thông tin về hệ thống ExamReg</h1>";
            $html .= "<p>Quy trình đăng ký thi:<ol>";
            $html .= "<li>Đăng ký ca thi tương ứng với học phần đã học.</li>";
            $html .= "<li>Xuất lịch thi ra phiếu báo dự thi.</li>";
            $html .= "<li>In phiếu báo dự thi để mang đi hôm thi.</li>";
            $html .= "</ol></p></div>";
            return $html;
        }
    }
}