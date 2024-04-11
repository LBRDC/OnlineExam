// Admin Log in
$(document).on("submit","#adminLoginFrm", function() {
    $.post("./query/loginExe.php", $(this).serialize(), function(data){
       if(data.res == "invalid") {
         Swal.fire(
           'Invalid',
           'Please input valid username / password',
           'error'
         )
       }
       else if(data.res == "success") {
         $('body').fadeOut();
         window.location.href='./home.php';
       }
    },'json');
 
    return false;
 });