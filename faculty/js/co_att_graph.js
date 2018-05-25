$(document).ready(function() {
    $.ajax({
        url: "http://localhost/project/faculty/co_att_graph.php",
        method: "GET",
        success: function(data) {
            console.log(data);
            var co = [];
            var co_per = [];

            for (var i in data) {
                co.push(data[i].co);
                co_per.push(data[i].co_per);
            }

            var chartdata = {
                labels: co,
                datasets: [{
                    label: 'Percentage of Students',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 185, 232, 1)',
                    data: co_per
                }]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});