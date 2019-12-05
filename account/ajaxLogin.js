function do_login()
{
    var id=$("#id").val().trim();
    var pass=$("#pass").val().trim();
    if(email!="" && pass!="")
    {
        //$("#loading_spinner").css({"display":"block"});
        $.ajax
        ({
            type:'post',
            url:'do_login.php',
            data:{
                do_login:"do_login",
                email:email,
                password:pass
            },
            success:function(response) {
                if(response=="success")
                {
                    window.location.href="index.php";
                }
                else
                {
                    $("#loading_spinner").css({"display":"none"});
                    alert("Wrong Details");
                }
            }
        });
    }

    else
    {
        alert("Please Fill All The Details");
    }

    return false;
}