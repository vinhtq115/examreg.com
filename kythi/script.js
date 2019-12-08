// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_kythi = document.getElementById('tablekythi').childNodes[1];
for (var i = 0; i < tbody_kythi.childElementCount; i++) {
    _data.push([tbody_kythi.childNodes[i].childNodes[0].innerText,
                tbody_kythi.childNodes[i].childNodes[1].innerText,
                tbody_kythi.childNodes[i].childNodes[2].innerText,
                tbody_kythi.childNodes[i].childNodes[3].innerText]);
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
    // Kiểm tra
    if (nambatdau == "") { // Nếu trống năm bắt đầu
        add_form.parentNode.insertBefore(createMessage("Năm bắt đầu không được để trống.", -1), add_form.nextSibling);
    } else if (namketthuc == "") { // Nếu trống năm kết thúc
        add_form.parentNode.insertBefore(createMessage("Năm kết thúc không được để trống.", -1), add_form.nextSibling);
    } else if (ky == "") { // Nếu trống kỳ
        add_form.parentNode.insertBefore(createMessage("Kỳ không được để trống.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&nambatdau=" + nambatdau + "&namketthuc=" + namketthuc + "&ky=" + ky);
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
    // Kiểm tra
    if (makythi == "") { // Nếu trống mã kỳ thi
        edit_form.parentNode.insertBefore(createMessage("Mã kỳ thi không được để trống.", -1), edit_form.nextSibling);
    } else if (nambatdau == "") { // Nếu trống năm bắt đầu
        edit_form.parentNode.insertBefore(createMessage("Năm bắt đầu không được để trống.", -1), edit_form.nextSibling);
    } else if (namketthuc == "") { // Nếu trống năm kết thúc
        edit_form.parentNode.insertBefore(createMessage("Năm kết thúc không được để trống.", -1), edit_form.nextSibling);
    } else if (ky == "") { // Nếu trống kỳ
        edit_form.parentNode.insertBefore(createMessage("Kỳ không được để trống.", -1), edit_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("edit=" + 1 + "&makythi=" + makythi + "&nambatdau=" + nambatdau + "&namketthuc=" + namketthuc + "&ky=" + ky);
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
        // Xóa thông tin kỳ thi đang sửa
        kythidangsua.innerText = "";
    }
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
                _data = []; // Xóa hết thông tin môn học cũ để thêm lại
                for (var i = 0; i < tbody_kythi.childElementCount; i++) {
                    _data.push([tbody_kythi.childNodes[i].childNodes[0].innerText,
                        tbody_kythi.childNodes[i].childNodes[1].innerText,
                        tbody_kythi.childNodes[i].childNodes[2].innerText,
                        tbody_kythi.childNodes[i].childNodes[3].innerText]);
                }
                $('#tablekythi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // If hash match (data not changed), do nothing.
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

// Auto-complete (Tự động điền cho form sửa môn học dựa trên mã môn học)
var kythidangsua = document.getElementById("kythidangsua"); // Thông tin về kỳ thi đang sửa
document.getElementById("makythi_edit").onblur = function () {
    var nambatdau_edit = document.getElementById("nambatdau_edit");
    var namketthuc_edit = document.getElementById("namketthuc_edit");
    var ky_edit = document.getElementById("ky_edit");

    // Tìm tên môn học và tín chỉ ứng với mã môn học
    var list_size = _data.length;
    for (var i = 0; i < list_size; i++) {
        if (_data[i][0] == this.value) {
            nambatdau_edit.value = _data[i][1];
            namketthuc_edit.value = _data[i][2];
            ky_edit.value = _data[i][3];
            kythidangsua.innerText = "Mã kỳ thi đang sửa: " + this.value + "\nNăm bắt đầu: " + nambatdau_edit.value + "\nNăm kết thúc: " + namketthuc_edit.value + "\nKỳ: " + ky_edit.value + "\n\n";
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
            kythidangxoa.innerText = "Mã kỳ thi đang xóa: " + this.value + "\nNăm bắt đầu: " + _data[i][1] + "\nNăm kết thúc: " + _data[i][2] + "\nKỳ: " + _data[i][3] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về kỳ thi đang xóa khi không trùng mã kỳ thi.
    kythidangxoa.innerText = "";
};

// Tự động điền năm kết thúc sau khi điền năm bắt đầu
document.getElementById("nambatdau_add").onblur = function () {
    if (this.value !== "") {
        document.getElementById("namketthuc_add").value = parseInt(this.value) + 1;
    }
};