<?php


namespace phongthi\view;


class PhongthiView {
    private $data; // Danh sách phòng thi

    /**
     * PhongthiView constructor.
     * @param $data: Chứa danh sách phòng thi (JSON).
     */
    public function __construct($data) {
        $this->data = json_decode($data, true);
    }

    /**
     * Bảng các phòng thi
     * @return string: Code HTML
     */
    public function tableView() {
        $html = "<table id='tablephongthi' class='table table-bordered table-striped table-hover table-sm'><thead><tr>";
        $html .= "<th class='th-sm'>Mã phòng thi</th>";
        $html .= "<th class='th-sm'>Địa điểm</th>";
        $html .= "<th class='th-sm'>Số lượng máy</th>";
        $html .= "</tr></thead><tbody>";
        $size = sizeof($this->data); // Chứa kích cỡ mảng data
        if ($size > 0) { // Trả về dữ liệu nếu size > 0
            foreach ($this->data as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value["maphongthi"] . "</td>";
                $html .= "<td>" . $value["diadiem"] . "</td>";
                $html .= "<td>" . $value["soluongmay"] . "</td>";
                $html .= "</tr>";
            }
        }
        $html .= "</tbody><tfoot><tr>";
        $html .= "<th>Mã phòng thi</th><th>Địa điểm</th><th>Số lượng máy</th>";
        $html .= "</tr></tfoot></table>";

        return $html;
    }

    /**
     * Datalist các phòng thi hiện tại của ca thi
     * @return string
     */
    public function datalist_phongthi() {
        $size = sizeof($this->data);
        // Hiện datalist
        $html = "<datalist id='danhsachphongthidangco'>";
        for ($i = 0; $i < $size; $i++) {
            $a = json_encode($this->data[$i]);
            $b = json_decode($a);
            $html .= "<option value=\"".$b->maphongthi."\">Mã phòng thi: ".$b->maphongthi." - Địa điểm: ".$b->diadiem." - Số lượng máy: ".$b->soluongmay;
        }
        $html .= "</datalist>";
        return $html;
    }

    /**
     * Hiện form thêm phòng thi.
     * @return string
     */
    public function addForm() {
        $html = "<form method='post' id='form_add'>
                  <div class='form-group'>
                    <label for='maphongthi_add'>Mã phòng thi</label>
                    <input list='danhsachphongthi' type='text' class='form-control' id='maphongthi_add' name='maphongthi' placeholder='Nhập mã phòng thi' maxlength='20' minlength='1' required>
                  </div>";
        $html .= "<button type=\"button\" id='add-button' class=\"btn btn-primary\">Thêm</button></form>";
        return $html;
    }

    /**
     * Hiện form xóa phòng thi.
     * @return string
     */
    public function deleteForm() {
        $html = "<form method='post' id='form_delete' autocomplete='off'>
                  <div class='form-group'>
                    <label for='maphongthi_delete'>Mã phòng thi</label>
                    <input list='danhsachphongthidangco' type='text' class='form-control' id='maphongthi_delete' name='maphongthi' placeholder='Nhập mã phòng thi cần xóa' maxlength='20' minlength='1' required>";
        $html .= "<button type='button' id='delete-button' class='btn btn-danger'>Xóa</button></form>";
        return $html;
    }
}