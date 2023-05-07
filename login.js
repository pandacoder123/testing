$(document).ready(function() {
  $('#login-form').on('submit', function(e) {
    e.preventDefault();
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
      url: 'login.php',
      type: 'POST',
      data: { email: email, password: password },
      dataType: 'json',
      success: function(response) {
        if (response.status == 'error') {
          alert(response.message);
        } else if (response.status == 'success') {
          alert('Please check your email for a confirmation code.');
          window.location.href = 'confirm.php?email=' + email;
        }
      }
    });
  });
});
