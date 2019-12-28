<?php
class LoginView {
    /**
     * Hiện trang login.
     */
    public function getView(){
        $html = "
        <div id='modal-login'>
            <div class='modal-dialog modal-login'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>
                            <span class = 'form-title' >Đăng nhập</span>
                        </h4>
                    </div>
                    <div class='modal-body'>
                        <form action='' method='post'>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                    <input id = 'id' type='text' class='form-control' name='id' placeholder='Tài khoản' required='required'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                    <input id = 'pass' type='password' class='form-control' name='pass' placeholder='Mật khẩu' required='required'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <button type='submit' id = 'submit-btn' class='btn btn-primary btn-block btn-lg'>ĐĂNG NHẬP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
               ";
        echo $html;
    }
}
?>