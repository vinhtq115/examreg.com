<?php


namespace hocphan\view;


class HocphanView {
    private $data; // Danh sách học phần
    private $monthi; // Danh sách môn thi

    /**
     * Khởi tạo HocphanView.
     * @param $data: Chứa danh sách học phần (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
        $monthi = [];
        foreach ($this->data as $key => $value) {
            array_push($monthi, $value['mamonthi']);
        }
        $this->monthi = array_unique($monthi);
    }

    /**
     * Bảng các học phần
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table id='tablehocphan' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class=\"th-sm\">Mã môn thi</th>";
        $html .= "<th class=\"th-sm\">Tên môn thi</th>";
        $html .= "<th class=\"th-sm\">Mã học phần</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td class='mamonthi'>" . $value["mamonthi"] . "</td>";
                $html .= "<td class='tenmonthi'>" . $value["tenmonthi"] . "</td>";
                $html .= "<td class='mahocphan'>" . $value["mahocphan"] . "</td>";
                $html .= "</tr>";
            }
        } else { // Tạo ô trống nếu size = 0
            $html .= "<td colspan='3' style=\"text-align:center\">Chưa có học phần.</td>";
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã môn thi</th><th>Tên môn thi</th><th>Mã học phần</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist môn thi
     * @param $json
     * @return string
     */
    public function datalist_monthi($json) {
        $ds = json_decode($json, true);
        $size = sizeof($ds);
        // Hiện datalist
        $html = "<datalist id='danhsachmonhoc'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($ds[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->mamonthi."\">".$b->tenmonthi." --- ".$b->mamonthi;
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Datalist học phần
     * @return string
     */
    public function datalist_hocphan() {
        $size = sizeof($this->data);
        // Hiện datalist
        $html = "<datalist id='danhsachhocphan'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($this->data[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->mahocphan."\">".$b->tenmonthi." --- ".$b->mahocphan;
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm học phần.
     */
    public function addForm() {
        $html = "<form method=\"post\" id='form_add' autocomplete='off'>
                  <div class=\"form-group\">
                    <label for=\"mamonthi_add\">Mã môn thi</label>
                    <input type=\"text\" list='danhsachmonhoc' class=\"form-control\" id=\"mamonthi_add\" name=\"mamonthi\" placeholder=\"Nhập mã môn thi muốn thêm học phần\" maxlength='20' minlength='1' required>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"mahocphan_add\">Mã học phần</label>
                    <input type=\"text\" class=\"form-control\" id=\"mahocphan_add\" name=\"mahocphan\" placeholder=\"Nhập mã học phần muốn thêm\" maxlength='20' minlength='1' required>
                  </div>";
        $html .= "<button type=\"button\" id='add-button' class=\"btn btn-primary\">Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa học phần theo mã học phần.
     */
    public function deleteForm() {
        $html = "<form method='post' id='form_delete' autocomplete='off'>
                  <div class='form-group'>
                    <label for='mahocphan_delete'>Mã học phần</label>
                    <input list='danhsachhocphan' type='text' class='form-control' id=\"mahocphan_delete\" name=\"mahocphan\" placeholder=\"Nhập mã học phần cần xóa\" required>
                  </div>";
        $html .= "<button type=\"button\" id='delete-button' class=\"btn btn-danger\">Xóa</button></form>";
        return $html;
    }
}