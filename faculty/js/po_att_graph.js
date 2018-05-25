$(document).ready(function() {
    $.ajax({

        url: "http://localhost/project/faculty/po_att_graph.php?",
        method: "GET",
        success: function(data) {
            console.log(data);
            var po = [];
            var po_per = [];

            for (var i in data) {
                po.push(data[i].po);
                po_per.push(data[i].po_per);
            }

            var chartdata = {
                labels: po,
                datasets: [{
                    label: 'Percentage of Students',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 185, 232, 1)',
                    data: po_per
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