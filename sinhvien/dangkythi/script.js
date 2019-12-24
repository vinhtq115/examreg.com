var mssv = document.getElementById("mssv").innerText; // Lấy mã số sinh viên

// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash_registrable = document.getElementById("table1hash").innerText;

// table_hash dùng để chứa kết quả băm của bảng, sau này được dùng để so sánh với kết quả trên server.
var table_hash_registered = document.getElementById("table2hash").innerText;

// Container bảng đăng ký
var table_container_registrable = document.getElementById("table-container-1");
// Container bảng đã đăng ký
var table_container_registered = document.getElementById("table-container-2");

// Lấy các button và gán hành vi đăng ký
function refresh_button() {
    var reg_button = table_container_registrable.getElementsByClassName("btt");
    for (var i = 0; i < reg_button.length; i++) {
        reg_button[i].onclick = function () {
            // Xóa thông báo cũ
            if (document.getElementById("message") != null) {
                removeElement("message");
            }
            // Lấy thông tin từ form
            let macathi = this.parentNode.childNodes[0].innerText;
            let maphongthi = this.parentNode.childNodes[6].innerText;

            // Gửi thông tin lên server
            let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
            ajaxEngine.open("POST", "ajax.php", true);
            ajaxEngine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxEngine.send("register=" + 1 + "&mssv=" + mssv + "&macathi=" + macathi + "&maphongthi=" + maphongthi);
            // Xử lý sau khi Ajax trả về
            ajaxEngine.onreadystatechange = function () {
                if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
                    let response = JSON.parse(ajaxEngine.responseText);
                    refresh_table(); // Refresh lại table
                    var success;
                    var message;
                    if (response.hasOwnProperty("success_msg")) { // Học phần được thêm thành công
                        success = 1;
                        message = response["success_msg"];
                    } else { // Lỗi
                        success = -1;
                        message = response["error_msg"];
                    }
                    // Thêm vào sau form add
                    table_container_registrable.parentNode.insertBefore(createMessage(message, success), table_container_registrable.nextSibling);
                }
            };
        }
    }
}
refresh_button();

// Hàm refresh table
function refresh_table() {
    refresh_registrable();
    refresh_registered();
}

function refresh_registrable() {
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "ajax.php?hash_registrable=" + table_hash_registrable + "&mssv=" + mssv, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash_registrable != response['hash']) {
                table_hash_registrable = response['hash'];
                table_container_registrable.innerHTML = response["table"];
                refresh_button(); // Refresh lại các nút đăng ký
            }
            // Nếu trùng hash thì không làm gì
        }
    }
}

function refresh_registered() {
    let ajaxEngine = new XMLHttpRequest(); // Tạo đối tượng Ajax Engine
    ajaxEngine.open("GET", "ajax.php?hash_registered=" + table_hash_registered  + "&mssv=" + mssv, true);
    ajaxEngine.send(null);
    // Xử lý sau khi Ajax trả về
    ajaxEngine.onreadystatechange = function () {
        if (ajaxEngine.readyState == 4 && ajaxEngine.status == 200) { // OK
            let response = JSON.parse(ajaxEngine.responseText);
            if (table_hash_registered != response['hash']) {
                table_hash_registered = response['hash'];
                table_container_registered.innerHTML = response["table"];
            }
            // Nếu trùng hash thì không làm gì
        }
    }
}

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

// Hàm xóa element trong document theo id
function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

// Hành vi cho nút download
document.getElementById("download").onclick = function () {
    window.open("download.php");
};

// Hành vi cho nút xuất
document.getElementById("print").onclick = function () {
    var pdf = document.createElement("object");
    pdf.setAttribute("data", "print.php");
    pdf.setAttribute("id", "pdf");
    pdf.setAttribute("type", "application/pdf");
    var pdf_embed = document.createElement("embed");
    pdf_embed.setAttribute("src", "print.php");
    pdf_embed.setAttribute("type", "application/pdf");
    pdf.appendChild(pdf_embed);
    document.getElementById("pdfhere").appendChild(pdf);
};