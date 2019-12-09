<?php


namespace cathi\view;


class CathiView {
    private $data; // Danh sách ca thi
    private $nambatdau; // Năm bắt đầu
    private $namketthuc; // Năm kết thúc

    /**
     * CathiView constructor.
     * @param $data: Chứa danh sách ca thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Cài năm bắt đầu và năm kết thúc cho view.
     * @param $years: Mảng ánh xạ chứa năm bắt đầu và năm kết thúc
     */
    public function setYear($years) {
        $this->nambatdau = $years["nambatdau"];
        $this->namketthuc = $years["namketthuc"];
    }

    /**
     * Bảng các ca thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table id='tablecathi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã ca thi</th>";
        $html .= "<th class='th-sm'>Mã học phần</th>";
        $html .= "<th class='th-sm'>Tên môn thi</th>";
        $html .= "<th class='th-sm'>Ngày thi</th>";
        $html .= "<th class='th-sm'>Giờ bắt đầu</th>";
        $html .= "<th class='th-sm'>Giờ kết thúc</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value["macathi"] . "</td>";
                $html .= "<td>" . $value["mahocphan"] . "</td>";
                $html .= "<td>" . $value["tenmonthi"] . "</td>";
                $html .= "<td>" . $value["ngaythi"] . "</td>";
                $html .= "<td>" . $value["giobatdau"] . "</td>";
                $html .= "<td>" . $value["gioketthuc"] . "</td>";
                $html .= "</tr>";
            }
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã ca thi</th><th>Mã học phần</th><th>Tên môn thi</th><th>Ngày thi</th><th>Giờ bắt đầu</th><th>Giờ kết thúc</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist các mã ca thi
     * @return string
     */
    public function datalist_cathi() {
        $size = sizeof($this->data);
        // Hiện datalist
        $html = "<datalist id='danhsachcathi'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($this->data[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->macathi."\">Mã ca thi: ".$b->macathi." - Mã học phần: ".$b->mahocphan." (".$b->tenmonthi.") - Ngày thi: ".$b->ngaythi." - Giờ thi: ".$b->giobatdau." - ".$b->gioketthuc;
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm ca thi.
     * @return string
     */
    public function addForm() {
        $html = "<form method='post' id='form_add'>
                  <div class='form-group'>
                    <label for='mahocphan_add'>Mã học phần</label>
                    <input list='danhsachhocphan' type='text' class='form-control' id='mahocphan_add' name='mahocphan' placeholder='Nhập mã học phần' maxlength='20' minlength='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='ngaythi_add'>Ngày thi</label>
                    <input type='date' class='form-control' id='ngaythi_add' name='ngaythi' placeholder='Nhập ngày thi (YYYY-MM-DD)' min='".$this->nambatdau."-01-01' max='".$this->namketthuc."-12-31' required>
                  </div>
                  <div class='form-group'>
                    <label for='giobatdau_add'>Giờ bắt đầu</label>
                    <input type='time' class='form-control' id='giobatdau_add' name='giobatdau' placeholder='Nhập giờ bắt đầu thi' step='1' required>
                  </div>
                  <div class='form-group'>
                    <label for='gioketthuc_add'>Giờ kết thúc</label>
                    <input type='time' class='form-control' id='gioketthuc_add' name='gioketthuc' placeholder='Nhập giờ kết thúc' step='1' required>
                  </div>";
        $html .= "<button type=\"button\" id='add-button' class=\"btn btn-primary\">Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa ca thi.
     * @return string
     */
    public function deleteForm() {
        $html = "<form method='post' id='form_delete' autocomplete='off'>
                  <div class='form-group'>
                    <label for='macathi_delete'>Mã ca thi</label>
                    <input list='danhsachcathi' type='text' class='form-control' id='macathi_delete' name='macathi' placeholder='Nhập mã ca thi cần xóa' minlength='1' maxlength='11' required>
                  </div>";
        $html .= "<button type='button' id='delete-button' class='btn btn-danger'>Xóa</button></form>";
        return $html;
    }

    /**
     * Hiện form sửa ca thi.
     * @return string
     */
    public function editForm() {
        $html = "<form method='post' id='form_edit' autocomplete='off'>
                    <div class='form-group'>
                        <label for='macathi_edit'>Mã ca thi</label>
                        <input list='danhsachcathi' type='text' class='form-control' id='macathi_edit' name='macathi' placeholder='Nhập mã ca thi cần sửa' minlength='1' maxlength='11' required>
                    </div>
                    <div class='form-group'>
                        <label for='mahocphan_edit'>Mã học phần</label>
                        <input list='danhsachhocphan' type='text' class='form-control' id='mahocphan_edit' name='mahocphan' placeholder='Nhập mã học phần' maxlength='20' minlength='1' required>
                    </div>
                    <div class='form-group'>
                        <label for='ngaythi_edit'>Ngày thi</label>
                        <input type='date' class='form-control' id='ngaythi_edit' name='ngaythi' placeholder='Nhập ngày thi (YYYY-MM-DD)' min='".$this->nambatdau."-01-01' max='".$this->namketthuc."-12-31' required>
                    </div>
                    <div class='form-group'>
                        <label for='giobatdau_edit'>Giờ bắt đầu</label>
                        <input type='time' class='form-control' id='giobatdau_edit' name='giobatdau' placeholder='Nhập giờ bắt đầu' step='1' required>
                    </div>
                    <div class='form-group'>
                        <label for='gioketthuc_edit'>Giờ kết thúc</label>
                        <input type='time' class='form-control' id='gioketthuc_edit' name='gioketthuc' placeholder='Nhập giờ kết thúc' step='1' required>
                    </div>";
        $html .= "<button type=\"button\" class=\"btn btn-primary\" id='edit-button'>Sửa</button></form>";
        return $html;
    }
}