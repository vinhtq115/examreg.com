<?php


namespace account\view;


class AccountView
{
    public function __construct() {}

    public function loginForm() {
        echo "<form method='post'>
                <input type='hidden' name='loginSubmitted' value='1'>
                Tên sử dụng: <input type='text' name='username'/><br>
                Mật khẩu: <input type='password' name='password'/><br>
                <input type='submit' value='login'/>
              </form>";
    }
}