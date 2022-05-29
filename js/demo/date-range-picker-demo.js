$(function () {
    var start = moment().subtract(29, "hari");
    var end = moment();

    function cb(start, end) {
        $("#reportrange span").html(
            start.format("MMMM YYYY") + " - " + end.format("MMMM YYYY")
        );
    }

    $("#reportrange").daterangepicker(
        {
            startDate: start,
            endDate: end,
            ranges: {
                "Hari Ini": [moment(), moment()],
                "Kemarin": [
                    moment().subtract(1, "hari"),
                    moment().subtract(1, "hari"),
                ],
                "7 Hari Terakhir": [moment().subtract(6, "hari"), moment()],
                "30 Hari Terakhir": [moment().subtract(29, "hari"), moment()],
                "Bulan Ini": [
                    moment().startOf("bulan"),
                    moment().endOf("bulan"),
                ],
                "Bulan Lalu": [
                    moment().subtract(1, "bulan").startOf("bulan"),
                    moment().subtract(1, "bulan").endOf("bulan"),
                ],
            },
        },
        cb
    );
    cb(start, end);
});
