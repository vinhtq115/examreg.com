<?php


namespace sinhvien\dangkythi\view;


class DangkythiView {
    private $allowedToRegister; // 0 nếu chưa đến thời gian đăng ký và 1 nếu đã đến.
    private $registrable; // Chứa các ca thi có thể đăng ký
    private $registered; // Chứa các ca thi đã đăng ký

    /**
     * DangkythiView constructor.
     * @param $allowedToRegister : 0 nếu chưa đến thời gian đăng ký và 1 nếu đã đến.
     * @param $registrable : Danh sách ca thi có thể đăng ký
     * @param $registered : Danh sách ca thi đã đăng ký
     */
    public function __construct($allowedToRegister, $registrable, $registered) {
        $this->allowedToRegister = $allowedToRegister;
        $this->registrable = json_decode($registrable, true);
        $this->registered = json_decode($registered, true);
    }

    /**
     * Hiện thông báo khi chưa đến thời gian đăng ký thi.
     */
    public function showDisabled() {
        return "<div class='alert alert-primary' role='alert'>
                Hiện tại chưa đến thời gian đăng ký thi. Thí sinh vui lòng quay lại sau.
              </div>";
    }

    /**
     * Hiện thông báo khi chưa đến thời gian đăng ký thi.
     */
    public function showWarning() {
        return "<div class='alert alert-warning' role='alert'>
                Thí sinh chú ý: Khi đã đăng ký ca thi rồi thì sẽ <strong>không thể xóa được</strong>. Vui lòng kiểm tra kỹ trước khi nhấn đăng ký.
              </div>";
    }

    /**
     * Hiện các ca thi có thể đăng ký dưới dạng bảng.
     * @return string: HTML
     */
    public function registrableCathiTable() {
        $html = "<table id='tabledangkythi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã ca thi</th>";
        $html .= "<th class='th-sm'>Mã học phần</th>";
        $html .= "<th class='th-sm'>Tên môn thi</th>";
        $html .= "<th class='th-sm'>Ngày thi</th>";
        $html .= "<th class='th-sm'>Giờ bắt đầu</th>";
        $html .= "<th class='th-sm'>Giờ kết thúc</th>";
        $html .= "<th class='th-sm'>Phòng thi</th>";
        $html .= "<th class='th-sm'>Đăng ký</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->registrable);
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->registrable as $key => $value) {
                $html .= "<tr>";
                $html .= "<td class='align-middle macathi'>" . $value["macathi"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["mahocphan"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["tenmonthi"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["ngaythi"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["giobatdau"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["gioketthuc"] . "</td>";
                $html .= "<td class='align-middle'>" . $value["maphongthi"] . "</td>";
                $html .= "<td class='align-middle btt'><button class='btn btn-sm btn-indigo btn-primary m-0'>Đăng ký</button></td>";
                $html .= "</tr>";
            }
        } else { // Tạo ô trống nếu size = 0
            $html .= "<td colspan='8' class='empty'>Hết/Chưa có ca thi để đăng ký.</td>";
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã ca thi</th><th>Mã học phần</th><th>Tên môn thi</th><th>Ngày thi</th><th>Giờ bắt đầu</th><th>Giờ kết thúc</th><th>Phòng thi</th><th>Đăng ký</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Hiện các ca thi đã đăng ký dưới dạng bảng.
     * @return string: HTML
     */
    public function registeredCathiTable() {
        $html = "<table id='tabledadangkythi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm macathi'>Mã ca thi</th>";
        $html .= "<th class='th-sm'>Mã học phần</th>";
        $html .= "<th class='th-sm'>Tên môn thi</th>";
        $html .= "<th class='th-sm'>Ngày thi</th>";
        $html .= "<th class='th-sm'>Giờ bắt đầu</th>";
        $html .= "<th class='th-sm'>Giờ kết thúc</th>";
        $html .= "<th class='th-sm'>Phòng thi</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->registered);
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->registered as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value["macathi"] . "</td>"; // Mã ca thi
                $html .= "<td>" . $value["mahocphan"] . "</td>";
                $html .= "<td>" . $value["tenmonthi"] . "</td>";
                $html .= "<td>" . $value["ngaythi"] . "</td>";
                $html .= "<td>" . $value["giobatdau"] . "</td>";
                $html .= "<td>" . $value["gioketthuc"] . "</td>";
                $html .= "<td>" . $value["maphongthi"] . "</td>";
                $html .= "</tr>";
            }
        }
        else { // Tạo ô trống nếu size = 0
            $html .= "<td colspan='7' class='empty'>Bạn chưa đăng ký ca thi nào.</td>";
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã ca thi</th><th>Mã học phần</th><th>Tên môn thi</th><th>Ngày thi</th><th>Giờ bắt đầu</th><th>Giờ kết thúc</th><th>Phòng thi</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }
}