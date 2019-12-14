// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash = document.getElementById("tablehash").innerText;

// Lấy mã ca thi, kỳ thi
let makythi = document.getElementById("kythi").innerText;
let macathi = document.getElementById("cathi").innerText;

// Lấy dữ liệu từ bảng ban đầu
var _data = [];
var tbody_phongthi = document.getElementById('tablephongthi').childNodes[1];
for (var i = 0; i < tbody_phongthi.childElementCount; i++) {
    _data.push([tbody_phongthi.childNodes[i].childNodes[0].innerText, // Mã phòng thi
                tbody_phongthi.childNodes[i].childNodes[1].innerText, // Địa điểm
                tbody_phongthi.childNodes[i].childNodes[2].innerText]); // Số lượng máy
}

// Bật pagination
$(document).ready(function () {
    $('#tablephongthi').DataTable();
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
    let maphongthi = document.getElementById("maphongthi_add").value; // Lấy mã phòng thi
    // Kiểm tra
    if (maphongthi == "") { // Nếu trống mã môn thi
        add_form.parentNode.insertBefore(createMessage("Mã phòng thi không được để trống.", -1), add_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "/phongthi/ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("add=" + 1 + "&kythi=" + makythi + "&cathi=" + macathi + "&maphongthi=" + maphongthi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Phòng thi được thêm thành công
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
        document.getElementById("maphongthi_add").value = "";
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
    let maphongthi = document.getElementById("maphongthi_delete").value; // Lấy mã phòng thi
    // Kiểm tra
    if (maphongthi == "") { // Nếu trống mã ca thi
        delete_form.parentNode.insertBefore(createMessage("Mã phòng thi không được để trống.", -1), delete_form.nextSibling);
    } else {
        // Bắt đầu Ajax Engine và gửi request
        let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
        ajaxEngine.open("POST", "/phongthi/ajax.php", true);
        ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxEngine.send("delete=" + 1 + "&kythi=" + makythi + "&cathi=" + macathi + "&maphongthi=" + maphongthi);
        // Xử lý sau khi Ajax trả về
        ajaxEngine.onreadystatechange = function () {
            if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                let response = JSON.parse(ajaxEngine.responseText);
                refresh_table();
                var success;
                var message;
                if (response.hasOwnProperty("success_msg")) { // Ca thi được xóa thành công
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
        document.getElementById("maphongthi_delete").value = "";
        // Xóa thông tin về ca thi đang xóa
        phongthidangxoa.innerText = "";
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

// Hàm dùng để refresh lại table sau khi xóa, thêm
function refresh_table() {
    // Bắt đầu Ajax
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/phongthi/ajax.php?hash=" + table_hash + "&kythi=" + makythi + "&cathi=" + macathi, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash != response['hash']) {
                table_hash = response['hash'];
                table.innerHTML = response["table"];
                // Refresh lại datalist
                let datalist = document.getElementById("danhsachphongthidangco");
                datalist.innerHTML = response["danhsachphongthidangco"];
                tbody_phongthi = document.getElementById('tablephongthi').childNodes[1];
                _data = []; // Xóa hết thông tin phòng thi cũ để thêm lại
                for (var i = 0; i < tbody_phongthi.childElementCount; i++) {
                    _data.push([tbody_phongthi.childNodes[i].childNodes[0].innerText, // Mã phòng thi
                        tbody_phongthi.childNodes[i].childNodes[1].innerText, // Địa điểm
                        tbody_phongthi.childNodes[i].childNodes[2].innerText]); // Số lượng máy
                }
                $('#tablephongthi').DataTable();
                $('.dataTables_length').addClass('bs-select');
            }
            // Nếu trùng hash, không làm gì cả.
        }
    }
}

// Tự động refresh lại table sau 5 giây để dữ liệu đúng với trên database
setInterval(refresh_table, 5000);

// Hàm dùng để refresh lại datalist học phần
function refresh_datalist_phongthi() {
    var datalist = document.getElementById('danhsachphongthi');
    // Bắt đầu Ajax Engine và gửi request
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "/quanlyphongthi/ajax.php?danhsachphongthi=1", true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            datalist.innerHTML = response['phongthi'];
        }
    };
}
setInterval(refresh_datalist_phongthi, 5000);

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Hiện thông tin ca thi đang xóa
var phongthidangxoa = document.getElementById("phongthidangxoa"); // Thông tin về phòng thi đang xóa
document.getElementById("maphongthi_delete").onblur = function() {
    // Tìm thông tin ứng với mã phòng thi
    for (var i = 0; i < _data.length; i++) {
        if (_data[i][0] == this.value) {
            phongthidangxoa.innerText = "Mã phòng thi đang xóa: " + this.value + "\nĐịa điểm: " + _data[i][1] + "\nSố lượng máy: " + _data[i][2] + "\n\n";
            return;
        }
    }
    // Xóa thông tin về phòng thi đang xóa khi không trùng mã phòng thi.
    phongthidangxoa.innerText = "";
};