$(document).ready(function () {
    $("#passwd").keyup(function () {

        var strength = 0;

        /*length 5 characters or more*/
        if (this.value.length >= 8) {
            strength++;
            /*contains lowercase characters*/
            if (this.value.match(/[a-z]+/)) {
                strength++;
            }

            /*contains digits*/
            if (this.value.match(/[0-9]+/)) {
                strength++;
            }

            /*contains uppercase characters*/
            if (this.value.match(/[A-Z]+/)) {
                strength++;
            }
        }

        if (this.value.length >= 18) {
            strength = 4;
        }
        var msg = ['Mật khẩu quá ngắn', 'Mật khẩu quá yếu', 'Mật khẩu yếu', 'Mật khẩu thường', 'Mật khẩu tốt'];
        var colorBar = ['bg-danger', 'bg-danger', 'bg-warning', 'bg-warning', 'bg-success'];
        $("#passwd_strength").html('<div class="progress-bar ' + colorBar[strength] + '" style="width: ' + ((strength+1) * 20) + '%">' + msg[strength] + '</div>');
    });
});