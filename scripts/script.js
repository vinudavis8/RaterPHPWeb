function searchTraders() {
    var category = $('#category').find(":selected").val();
    var location = $('#location').find(":selected").val();
    var fromDate = $('#from-date').val()
    var toDate = $('#to-date').val()
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tradersList").innerHTML = this.responseText;
        }
    };
    var formdata = new FormData();
    formdata.append("category", category);
    formdata.append("location", location);
    formdata.append("fromDate", fromDate);
    formdata.append("toDate", toDate);
    xmlhttp.open("POST", "./forms/trader_list.php");
    xmlhttp.send(formdata);
}


function checkLoginDetails() {
    var email = $('#email').val();
    var password = $('#pass').val();
    var isFormvalid = true;
    $("#error-username").text("");
    $("#error-password").text("");
    $("#alert").hide();
    if (email == '') {
        isFormvalid = false;
        $("#email").focus();
        $("#error-username").text("Please enter email address");
    }
    if (password == '') {
        isFormvalid = false;
        $("#pass ").focus();
        $("#error-password").text("Please enter password");
    }
    if (isFormvalid) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText.trim();
                if (response == "failed") {
                    $(".alert-danger").show();
                    document.getElementById("message").innerHTML = "please check username and password";
                } else {
                    $(".alert-success").show();
                    document.getElementById("message").innerHTML = "Login successful";
                    $('#myModal').modal('hide');
                    if (response == "tradesmen") {
                        window.location.href = 'forms/trader_profile_edit.php';
                    } else if (response == "customer") {
                        var redirectURL = $("#redirect_URL").val();
                        if (redirectURL != undefined)
                            window.location.href = redirectURL
                        else
                            window.location.href = '/Rater/index.php';
                    }
                    else if (response == "admin") {
                        window.location.href = 'forms/create_category.php';
                    }
                }
            }
        };
        var formdata = new FormData();
        formdata.append("email", email);
        formdata.append("pass", password);
        xmlhttp.open("POST", "forms/login.php");
        xmlhttp.send(formdata);
    }
}


function userTypeChange() {
    var type = $('#userType').find(":selected").val();
    if (type == 'tradesmen') {
        $(".select-tradesmen").show();
    } else
        $(".select-tradesmen").hide();
}

function toggle(val) {
    $("#select-dates button").removeClass("clicked");
    $(val).addClass('clicked');
}

function submitBooking() {
    var arr = document.getElementById("select-dates").querySelectorAll(".clicked");
    if (arr[0] == undefined) {
        alert("please select a date")
    } else {
        $('#bookingDates').val(arr[0].id);
        $("#bookingForm").submit();
    }
}

function saveRating() {
    var rating = $('#rating').val();
    if (rating > 0) {
        var tradesmenId = $('#tradesmen_id').val();
        var customerId = $('#customer_id').val();
        var review = $('#review').val();
        var isFormvalid = true;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText.trim();
                alert("Rating updated successfully")
                window.location.href = "trader_profile.php"
            }
        };
        var formdata = new FormData();

        formdata.append("user_rating", rating.trim());
        formdata.append("tradesmen_id", tradesmenId.trim());
        formdata.append("customer_id", customerId.trim());
        formdata.append("review", review.trim());

        xmlhttp.open("POST", "rating.php");
        xmlhttp.send(formdata);
    } else alert("please rate the tradesmen");

}

function viewTradesmen(tradesmen_id) {
    $('#myModal').modal('show');
    $("#redirect_URL").val("../forms/trader_profile.php?tradesmen_id= " + tradesmen_id + "");

}
function saveBookingStatus(bookingId) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText.trim();
            alert("Booking status updated successfully")
            window.location.href = "tradesmen_bookings.php";
        }
    };
    var formdata = new FormData();
    formdata.append("booking_id", bookingId);
    xmlhttp.open("POST", "tradesmen_bookings.php");
    xmlhttp.send(formdata);
}



