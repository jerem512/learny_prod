$(document).ready(function() {
    let rangeWeek = $("#formControlRangeWeek");
    let rangeMonth = $("#formControlRangeMonth");
    let rangeYear = $("#formControlRangeYear");

    rangeWeek.on("input", function() {
        $('#objWeek').text(rangeWeek.val());
    });

    rangeWeek.on("change", function() {
        $.ajax({
            url: '/app/me',
            data: { 'action': 'data', 'rangeWeek': rangeWeek.val(), 'rangeMonth': rangeMonth.val(), 'rangeYear': rangeYear.val() },
            method: 'POST',
            success: function(data) {
                console.log(data);
            }

        })
    });

    rangeMonth.on("input", function() {
        $('#objMonth').text(rangeMonth.val());
    });

    rangeMonth.on("change", function() {
        $.ajax({
            url: '/app/me',
            data: { 'action': 'data', 'rangeWeek': rangeWeek.val(), 'rangeMonth': rangeMonth.val(), 'rangeYear': rangeYear.val() },
            method: 'POST',
            success: function(data) {
                console.log(data);
            }

        })
    });

    rangeYear.on("input", function() {
        $('#objYear').text(rangeYear.val());
    });

    rangeYear.on("change", function() {
        $.ajax({
            url: '/app/me',
            data: { 'action': 'data', 'rangeWeek': rangeWeek.val(), 'rangeMonth': rangeMonth.val(), 'rangeYear': rangeYear.val() },
            method: 'POST',
            success: function(data) {
                console.log(data);
            }

        })
    });
})