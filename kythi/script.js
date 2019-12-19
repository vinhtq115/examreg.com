// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_kythi = document.getElementById('tablekythi').childNodes[1];
for (var i = 0; i < tbody_kythi.childElementCount; i++) {
    _data.push([tbody_kythi.childNodes[i].childNodes[0].innerText,
                tbody_kythi.childNodes[i].childNodes[1].innerText,
                tbody_kythi.childNodes[i].childNodes[2].innerText,
                tbody_kythi.childNodes[i].childNodes[3].innerText,
                tbody_kythi.childNodes[i].childNodes[4].innerText,
                tbody_kythi.childNodes[i].childNodes[5].innerText]);
}

// Bật pagination
$(document).ready(function () {
    $('#tablekythi').DataTable();
    $('.dataTables_length').addClass('bs-select');
});

let table = document.getElementById("table-container");

let datalist = document.getElementById("datalistcontainer");

// Hành vi cho nút thêm
let add_button = document.getElementById('add-button');
let add_form = document.getElementById("form_add");
add_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let nambatdau = document.getElementById("nambatdau_add").value; // Lấy năm bắt đầu
    let namketthuc = document.getElementById("namketthuc_add").value; // Lấy năm kết thúc
    let ky = document.getElementById("ky_add").value; // Lấy chỉ số kỳ
    let ngaybatdau = document.getElementById("ngaybatdau_add").value; // Lấy ngày bắt đầu
    let ngaykettthuc = document.getElementById("ngayketthuc_add").value; // Lấy ngày kết thúc
    // Kiểm tra
    if (nambatdau == "") { // Nếu trống năm bắt đầu
        add_form.parentNode.insertBefore(createMessage("Năm bắt đầu không được để trống.", -1), add_form.nextSibling);
    } else if (namketthuc == "") { // Nếu trống năm kết thúc
        add_form.parentNode.insertBefore(createMessage("Năm kết thúc không được để trống.", -1), add_form.nextSibling);
    } else if (ky == "") { // Nếu trống kỳ
        add_form.parentNode.insertBefore(createMessage("Kỳ không được để trống.", -1), add_form.nextSibling);
    } else if (ngaybatdau == "") { // Nếu trống ngày bắt đầu
        add_form.parentNode.insertBefore(createMessage("Ngày bắt đầu thi không được để trống.", -1), add_form.nextSibling);
    } else if (ngaykettthuc == "") { // Nếu trống ngày kết thúc
        add_form.parentNode.insertBefore(createMessage("Ngày kết thúc thi không được để trống.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&nambatdau=" + nambatdau + "&namketthuc=" + namketthuc + "&ky=" + ky + "&ngaybatdau=" + ngaybatdau + "&ngayketthuc=" + ngaykettthuc);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được thêm thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form add
                add_form.parentNode.insertBefore(createMessage(message, success), add_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("nambatdau_add").value = "";
        document.getElementById("namketthuc_add").value = "";
        document.getElementById("ky_add").value = "";
        document.getElementById("ngaybatdau_add").value = "";
        document.getElementById("ngayketthuc_add").value = "";
    }
};

// Hành vi cho nút xóa
let delete_button = document.getElementById('delete-button');
let delete_form = document.getElementById("form_delete");
delete_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let makythi = document.getElementById("makythi_delete").value; // Lấy mã kỳ thi
    // Kiểm tra
    if (makythi == "") { // Nếu trống mã môn thi
        delete_form.parentNode.insertBefore(createMessage("Mã kỳ thi không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&makythi=" + makythi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được xóa thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form delete
                delete_form.parentNode.insertBefore(createMessage(message, success), delete_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("makythi_delete").value = "";
        // Xóa thông tin về môn đang xóa
        kythidangxoa.innerText = "";
    }
};

// Hành vi cho nút sửa
let edit_button = document.getElementById('edit-button');
let edit_form = document.getElementById("form_edit");
edit_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let makythi = document.getElementById("makythi_edit").value; // Lấy mã kỳ thi
    let nambatdau = document.getElementById("nambatdau_edit").value; // Lấy năm bắt đầu
    let namketthuc = document.getElementById("namketthuc_edit").value; // Lấy năm kết thúc
    let ky = document.getElementById("ky_edit").value; // Lấy chỉ số kỳ
    let ngaybatdau = document.getElementById("ngaybatdau_edit").value; // Lấy ngày bắt đầu
    let ngaykettthuc = document.getElementById("ngayketthuc_edit").value; // Lấy ngày kết thúc
    // Kiểm tra
    if (makythi == "") { // Nếu trống mã kỳ thi
        edit_form.parentNode.insertBefore(createMessage("Mã kỳ thi không được để trống.", -1), edit_form.nextSibling);
    } else if (nambatdau == "") { // Nếu trống năm bắt đầu
        edit_form.parentNode.insertBefore(createMessage("Năm bắt đầu không được để trống.", -1), edit_form.nextSibling);
    } else if (namketthuc == "") { // Nếu trống năm kết thúc
        edit_form.parentNode.insertBefore(createMessage("Năm kết thúc không được để trống.", -1), edit_form.nextSibling);
    } else if (ky == "") { // Nếu trống kỳ
        edit_form.parentNode.insertBefore(createMessage("Kỳ không được để trống.", -1), edit_form.nextSibling);
    } else if (ngaybatdau == "") { // Nếu trống ngày bắt đầu
        edit_form.parentNode.insertBefore(createMessage("Ngày bắt đầu thi không được để trống.", -1), edit_form.nextSibling);
    } else if (ngaykettthuc == "") { // Nếu trống ngày kết thúc
        edit_form.parentNode.insertBefore(createMessage("Ngày kết thúc thi không được để trống.", -1), edit_form.nextSibling);
    }  else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("edit=" + 1 + "&makythi=" + makythi + "&nambatdau=" + nambatdau + "&namketthuc=" + namketthuc + "&ky=" + ky + "&ngaybatdau=" + ngaybatdau + "&ngayketthuc=" + ngaykettthuc);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Môn học được thêm thành công
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form add
                edit_form.parentNode.insertBefore(createMessage(message, success), edit_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("makythi_edit").value = "";
        document.getElementById("nambatdau_edit").value = "";
        document.getElementById("namketthuc_edit").value = "";
        document.getElementById("ky_edit").value = "";
        document.getElementById("ngaybatdau_edit").value = "";
        document.getElementById("ngayketthuc_edit").value = "";
        // Xóa thông tin kỳ thi đang sửa
        kythidangsua.innerText = "";
    }
};

// Hành vi cho nút chọn kỳ thi hiện tại
let active_button = document.getElementById('active-button');
let active_form = document.getElementById("form_active");
active_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Kiểm tra xem form có trống không. Nếu có thì hiện thông báo lỗi.
    // Lấy thông tin từ form
    let makythi = document.getElementById("makythi_active").value; // Lấy mã kỳ thi
    // Kiểm tra
    if (makythi == "") { // Nếu trống mã môn thi
        active_form.parentNode.insertBefore(createMessage("Mã kỳ thi không được để trống.", -1), active_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("active=" + 1 + "&makythi=" + makythi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) {
                    success = 1;
                    message = response["success_msg"];
                } else { // Lỗi
                    success = -1;
                    message = response["error_msg"];
                }
                // Thêm vào sau form active
                active_form.parentNode.insertBefore(createMessage(message, success), active_form.nextSibling);
            }
        };
        // Làm trống form
        document.getElementById("makythi_active").value = "";
        // Xóa thông tin về môn đang xóa
        kythidangchon.innerText = "";
    }
};

// Hành vi cho nút tắt kỳ thi hiện tại
let disable_active_button = document.getElementById('disable-active-button');
disable_active_button.onclick = function () {
    // Xóa thông báo cũ
    if (document.getElementById("message") != null) {
        removeElement("message");
    }
    // Bắt đầu Ajax Engine và gửi request
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("POST", "ajax.php", true);
    ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxEngine.send("disable=" + 1);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            refresh_table();
            var success;
            var message;
            if (response.hasOwnProperty("success_msg")) {
                success = 1;
                message = response["success_msg"];
            } else { // Lỗi
                success = -1;
                message = response["error_msg"];
            }
            // Thêm vào sau form active
            active_form.parentNode.insertBefore(createMessage(message, success), active_form.nextSibling);
        }
    };
};

// Hàm tạo thông báo
function createMessage(_message, success) {
    var message = document.createElement("div");
    message.classList.add("alert");
    message.setAttribute("id", "message");
    message.setAttribute('role', "alert");
    message.innerHTML = _message;
    if (success == 1) { // Thông báo thành công
        message.classList.add("alert-success");
    } else if (success == -1) { // Thông báo thất bại
        message.classList.add("alert-danger");
    } else if (success == 0) { // Cảnh báo
        message.classList.add("alert-warning");
    }
    return message;
}

// Hàm dùng để refresh lại table sau khi sửa, xóa, thêm
function refresh_table() {
    // Bắt đầu Ajax
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "ajax.php?hash=" + table_hash, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash != response['hash']) {
                table_hash = response['hash'];
                table.innerHTML = response["table"];
                // Refresh lại datalist
                datalist.innerHTML = response["datalist"];
                tbody_kythi = document.getElementById('tablekythi').childNodes[1];
                _data = []; // Xóa hết thông tin kỳ thi cũ để thêm lại
                for (var i = 0; i < tbody_kythi.childElementCount; i++) {
                    _data.push([tbody_kythi.childNodes[i].childNodes[0].innerText,
                        tbody_kythi.childNodes[i].childNodes[1].innerText,
                        tbody_kythi.childNodes[i].childNodes[2].innerText,
                        tbody_kythi.childNodes[i].childNodes[3].innerText,
                        tbody_kythi.childNodes[i].childNodes[4].innerText,
                        tbody_kythi.childNodes[i].childNodes[5].innerText]);
                }
                $('#tablekythi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // Nếu trùng hash, không làm gì cả.
        }
    }
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table, 5000);

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Auto-complete (Tự động điền cho form sửa kỳ thi dựa trên mã kỳ thi)
var kythidangsua = document.getElementById("kythidangsua"); // Thông tin về kỳ thi đang sửa
document.getElementById("makythi_edit").onblur = function () {
    var nambatdau_edit = document.getElementById("nambatdau_edit");
    var namketthuc_edit = document.getElementById("namketthuc_edit");
    var ky_edit = document.getElementById("ky_edit");
    var ngaybatdau_edit = document.getElementById("ngaybatdau_edit");
    var ngayketthuc_edit = document.getElementById("ngayketthuc_edit");

    // Tìm thông tin ứng với mã kỳ thi
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][0] == this.value) {
            nambatdau_edit.value = _data[i][1];
            namketthuc_edit.value = _data[i][2];
            ky_edit.value = _data[i][3];
            ngaybatdau_edit.value = _data[i][4];
            ngayketthuc_edit.value = _data[i][5];

            kythidangsua.innerText = "Mã kỳ thi đang sửa: " + this.value + "\nNăm bắt đầu: " + nambatdau_edit.value + "\nNăm kết thúc: " + namketthuc_edit.value + "\nKỳ: " + ky_edit.value + "\nNgày bắt đầu thi: " + ngaybatdau_edit.value + "\nNgày kết thúc thi: " + ngayketthuc_edit.value + "\n\n";
            return;
        }
    }
};

// Hiện thông tin kỳ thi đang xóa
var kythidangxoa = document.getElementById("kythidangxoa"); // Thông tin về kỳ thi đang xóa
document.getElementById("makythi_delete").onblur = function () {
    // Tìm thông tin ứng với mã kỳ thi
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            kythidangxoa.innerText = "Mã kỳ thi đang xóa: " + this.value + "\nNăm bắt đầu: " + _data[i][1] + "\nNăm kết thúc: " + _data[i][2] + "\nKỳ: " + _data[i][3] + "\nNgày bắt đầu thi: " + _data[i][4] + "\nNgày kết thúc thi: " + _data[i][5] +  "\n\n";
            return;
        }
    }
    // Xóa thông tin về kỳ thi đang xóa khi không trùng mã kỳ thi.
    kythidangxoa.innerText = "";
};

// Hiện thông tin kỳ thi định chọn làm kỳ hiện tại
var kythidangchon = document.getElementById("kythidangchon"); // Thông tin về kỳ thi
document.getElementById("makythi_active").onblur = function () {
    // Tìm thông tin ứng với mã kỳ thi
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            kythidangchon.innerText = "Mã kỳ thi: " + this.value + "\nNăm bắt đầu: " + _data[i][1] + "\nNăm kết thúc: " + _data[i][2] + "\nKỳ: " + _data[i][3] + "\nNgày bắt đầu thi: " + _data[i][4] + "\nNgày kết thúc thi: " + _data[i][5] +  "\n\n";
            return;
        }
    }
    // Xóa thông tin khi không trùng mã kỳ thi.
    kythidangchon.innerText = "";
};

document.getElementById("nambatdau_add").onblur = function () {
    if (this.value !== "") {
        // Tự động điền năm kết thúc
        document.getElementById("namketthuc_add").value = parseInt(this.value) + 1;
        // Giới hạn ngày bắt đầu thi
        document.getElementById("ngaybatdau_add").setAttribute("min", this.value + "-01-01");
        document.getElementById("ngaybatdau_add").setAttribute("max", document.getElementById("namketthuc_add").value + "-12-31");
        // Giới hạn ngày kết thúc thi
        if (document.getElementById("ngaybatdau_add").value === "") {
            document.getElementById("ngayketthuc_add").setAttribute("min", this.value + "-01-01");
        }
        document.getElementById("ngayketthuc_add").setAttribute("max", document.getElementById("namketthuc_add").value + "-12-31");
    }
};

document.getElementById("namketthuc_add").onblur = function () {
    if (this.value !== "") {
        // Giới hạn ngày bắt đầu thi
        document.getElementById("ngaybatdau_add").setAttribute("max", this.value + "-12-31");
        // Giới hạn ngày kết thúc thi
        document.getElementById("ngayketthuc_add").setAttribute("max", this.value + "-12-31");
    }
};

document.getElementById("ngaybatdau_add").onblur = function () {
    if (this.value !== "") {
        // Giới hạn ngày kết thúc thi
        document.getElementById("ngayketthuc_add").setAttribute("min", this.value);
    }
};

document.getElementById("nambatdau_edit").onblur = function () {
    if (this.value !== "") {
        // Tự động điền năm kết thúc
        document.getElementById("namketthuc_edit").value = parseInt(this.value) + 1;
        // Giới hạn ngày bắt đầu thi
        document.getElementById("ngaybatdau_edit").setAttribute("min", this.value + "-01-01");
        document.getElementById("ngaybatdau_edit").setAttribute("max", document.getElementById("namketthuc_edit").value + "-12-31");
        // Giới hạn ngày kết thúc thi
        if (document.getElementById("ngaybatdau_edit").value === "") {
            document.getElementById("ngayketthuc_edit").setAttribute("min", this.value + "-01-01");
        }
        document.getElementById("ngayketthuc_edit").setAttribute("max", document.getElementById("namketthuc_edit").value + "-12-31");
    }
};

document.getElementById("namketthuc_edit").onblur = function () {
    if (this.value !== "") {
        // Giới hạn ngày bắt đầu thi
        document.getElementById("ngaybatdau_edit").setAttribute("max", this.value + "-12-31");
        // Giới hạn ngày kết thúc thi
        document.getElementById("ngayketthuc_edit").setAttribute("max", this.value + "-12-31");
    }
};

document.getElementById("ngaybatdau_edit").onblur = function () {
    if (this.value !== "") {
        // Giới hạn ngày kết thúc thi
        document.getElementById("ngayketthuc_edit").setAttribute("min", this.value);
    }
};