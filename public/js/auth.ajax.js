$(document).ready(function () {

    $('#loginForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/post-login',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    $('#loginMessage').html('<p style="color:green;">Login Successful</p>');
                    window.location.href = response.redirect;
                } else {
                    $('#loginMessage').html('<p style="color:red;">' + response.message + '</p>');
                }
            },
            error: function (xhr) {
                $('#loginMessage').html('<p style="color:red;">' + xhr.responseJSON.message + '</p>');
            }
        });
    });

    $('#signupForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/post-signup',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    $('#signupMessage').html('<p style="color:red;">' + response.message + '</p>');
                }
            },
            error: function (xhr) {
                let response = xhr.responseJSON;

                let messageHtml = '';
                if (response.errors) {
                    $.each(response.errors, function (key, value) {
                        messageHtml += '<p style="color:red;">' + value[0] + '</p>';
                    });
                } else {
                    messageHtml = '<p style="color:red;">' + response.message + '</p>';
                }

                $('#signupMessage').html(messageHtml);
            }
        });
    });

    $('#adminLoginForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/post-login-admin',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    $('#adminLoginMessage').html('<p style="color:green;">Login Successful</p>');
                    window.location.href = response.redirect;
                } else {
                    $('#adminLoginMessage').html('<p style="color:red;">' + response.message + '</p>');
                }
            },
            error: function (xhr) {
                $('#adminLoginMessage').html('<p style="color:red;">' + xhr.responseJSON.message + '</p>');
            }
        });
    });

});

