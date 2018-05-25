$(document).ready(function() {
    $.ajax({
        url: "http://localhost/project/faculty/grade_graph.php",
        method: "GET",
        success: function(data) {
            console.log(data);
            var grade = [];
            var perc_of_grade = [];

            for (var i in data) {
                grade.push(data[i].grade);
                perc_of_grade.push(data[i].perc_of_grade);
            }

            var chartdata = {
                labels: grade,
                datasets: [{
                    label: 'Percentage of Students',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 185, 232, 1)',
                    data: perc_of_grade
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