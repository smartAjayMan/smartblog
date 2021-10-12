$(document).ready(function () {
    //   notification controller
    $('#notification-icon').click(function (e) {
        e.preventDefault();
        $('#notification-alert-show').show();
        $('.text-main').hide();
        $('#notification-all-hidden').on('click', function (e) {
            e.preventDefault();
            $('#notification-alert-show').hide();
            $('.text-main').show();
        });
    });
    //   notification searchbar on controller
    $('#search-show').click(function (e) {
        e.preventDefault();
        $(this).hide();
        $('.user-controller').hide();
        $('.nav-secondary').hide();
        $('.search-bar-wrapper').show();
        $('.search-exists-icon').on('click', function () {
            $('#search-show').show();
            $('.user-controller').show();
            $('.nav-secondary').show();
            $('.search-bar-wrapper').hide();
        });

    });

    // footer form click event  for input    
    $('.form-input').click(function (e) {
        e.preventDefault();
        $(this).css('padding', '7px');
        $(this).css('border-bottom', '1px solid aqua');
    });

    // form body resizing height
    $('.form-body').on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    // time and date show 
    let current;
    let date;
    let time;
    let timeshow = document.getElementById("show-text");
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    setInterval(function () {
        current = new Date();
        date = current.toLocaleDateString(undefined, options);
        time = current.toLocaleTimeString();
        if (timeshow) {
            timeshow.innerHTML = 'Current Time: ' + time + ' On ' + date;
        }

    }, 1000);

    //  Login And Signup Password Show Hide Attribute 
    let passCheck = document.getElementById('show-pass');
    if (passCheck) {
        document.getElementById('show-pass').addEventListener('click', myPass);
        let checked = document.getElementById('cpassword');
        let statement = false;
        function myPass() {
            if (statement) {
                document.getElementById('password').setAttribute('type', 'password');

                if (checked) {
                    document.getElementById('cpassword').setAttribute('type', 'password');
                }
                statement = false;
            } else {
                document.getElementById('password').setAttribute('type', 'text');
                if (checked) {
                    document.getElementById('cpassword').setAttribute('type', 'text');
                }
                statement = true;
            }
        }
    }
    // image upload and edit preview
    $('.previewImage').click(checked);
    function checked() {
        $('.profileImage').click();
        $('.profileImage').change(function (event) {
            let x = URL.createObjectURL(event.target.files[0]);
            $('.previewImage').attr('src', x);
        });
    }

});