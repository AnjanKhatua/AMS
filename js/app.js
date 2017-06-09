$(document).ready(function () {
    $.ajax({
        url: "index.php?r=admin/ShiftManagementForHospital/valueForBar",
        method: "GET",
        success: function (data) {
            data = jQuery.parseJSON(data);
            console.log(data);
            var dateTime = [];
            var percentage = [];

            for (var i in data) {
                dateTime.push("Date : " + data[i].shift_start_datetime);
                percentage.push(data[i].percentage);
            }
            console.log(dateTime);
            var chartdata = {
                labels: dateTime,
                datasets: [
                    {
                        label: 'Allocation Percentage',
                        backgroundColor: 'rgba(0, 0, 112, 0.5)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(0, 0, 112, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: percentage
                    }
                ]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});