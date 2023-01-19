$(document).ready(function () {
    var options = {
        max_value: 5,
        step_size: 1,
        selected_symbol_type: 'utf8_star',
        url: 'http://localhost/test.php',
        initial_value: $("#avg-rating").text(),
        update_input_field_name: $("#user_rating"),
    }
    var options2 = {
        max_value: 5,
        step_size: 1,
        selected_symbol_type: 'utf8_star',
        url: 'http://localhost/test.php',
        initial_value: 0,
        update_input_field_name: $("#rating"),
    }
    $(".rate2").rate(options2);
    $(".rate1").rate(options);
});