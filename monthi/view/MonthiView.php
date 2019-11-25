<?php


namespace monthi\view;


class MonthiView {
    private $data; // Danh sách môn thi

    /**
     * Khởi tạo monthiView.
     * @param $data: Chứa danh sách môn thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Bảng các môn thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table class='table table-bordered'><thead><tr>";
        $html .= "<th>Mã môn thi</th>";
        $html .= "<th>Tên môn thi</th>";
        $html .= "<th>Tín chỉ</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value["mamonthi"] . "</td>";
                $html .= "<td>" . $value["tenmonthi"] . "</td>";
                $html .= "<td>" . $value["tinchi"] . "</td>";
                $html .= "</tr>";
            }
        } else { // Tạo ô trống nếu size = 0
            $html .= "<td colspan='3' style=\"text-align:center\">Chưa có môn thi.</td>";
        }
        $html .= "</tbody></table>";

        return $html;
    }

    /**
     * Hiện form thêm môn học. Hiển thị lỗi hoặc thông báo thành công nếu có.
     * @param $success: Thông báo thành công
     * @param $err: Thông báo lỗi
     */
    public function addForm($success = "", $err = "") {
        $html = "<h3>Thêm môn thi</h3>
                <form method=\"post\">
                  <input type=\"hidden\" name=\"add\" value=\"1\">
                  <div class=\"form-group\">
                    <label for=\"mamonthi\">Mã môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"mamonthi\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi muốn thêm\" maxlength='20' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tenmonthi\">Tên môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"tenmonthi\" name=\"tenmonthi\" placeholder=\"Tên môn thi\" maxlength='100' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"tinchi\">Tín chỉ</label>
                    <input type=\"number\" class=\"form-control\" id=\"tinchi\" name=\"tinchi\" placeholder=\"Tín chỉ\" min='0'>
                  </div>";
        if (!empty($err)) { // Có lỗi
            $html .= "<div class=\"alert alert-danger\" role=\"alert\">$err</div>";
        } elseif (!empty($success)) { // Thành công
            $html .= "<div class=\"alert alert-success\" role=\"alert\">$success</div>";
        }
        $html .= "<button type=\"submit\" class=\"btn btn-primary\">Thêm</button></form>";
        echo $html;
    }

    /**
     * Hiện form xóa môn học theo mã môn học. Hiển thị lỗi hoặc thông báo thành công nếu có.
     * @param $success: Thông báo thành công
     * @param $err: Thông báo lỗi
     */
    public function deleteForm($success = "", $err = "") {
        $html = "<h3>Xóa môn thi</h3>
                <form method=\"post\">
                  <input type=\"hidden\" name=\"delete\" value=\"1\">
                  <div class=\"form-group\">
                    <label for=\"mamonthi\">Mã môn thi</label>
                    <input type=\"text\" class=\"form-control\" id=\"mamonthi\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi cần xóa\">
                  </div>";
        if (!empty($err)) { // Có lỗi
            $html .= "<div class=\"alert alert-danger\" role=\"alert\">$err</div>";
        } elseif (!empty($success)) { // Thành công
            $html .= "<div class=\"alert alert-success\" role=\"alert\">$success</div>";
        }
        $html .= "<button type=\"submit\" class=\"btn btn-danger\">Xóa</button></form>";
        echo $html;
    }
}