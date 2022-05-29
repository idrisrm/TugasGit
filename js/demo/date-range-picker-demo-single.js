$(function () {
    $('input[name="birthday"]').daterangepicker(
        {
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2000,
            maxYear: parseInt(moment().format("YYYY"), 10),
        }
    );
});
