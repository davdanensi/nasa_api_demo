$(function () {

    // INITIALIZE DATEPICKER PLUGIN
    $('.datepicker').datepicker({
        clearBtn: true,
        format: "yyyy-mm-dd"
    });

    $('#startDate').on('change', function () {
        var pickedDate = $('input').val();
        $('#pickedDate').html(pickedDate);
    });

    $('#endDate').on('change', function () {
        var pickedDate = $('input').val();
        $('#pickedDate').html(pickedDate);
    });

    const ctx = document.getElementById('myChart');

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: '# of Astroids',
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Line Chart'
                }
            }
        }
    });

    $('#submit').on('click', function () {
        $(this).text('Fetching Data...');
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        $.ajax({
            url: 'get-astroid-data-by-date-range',
            type: 'POST',
            data: {
                'startDate': startDate,
                'endDate': endDate,
                "_token": $('#token').val()
            },
            success: function (data) {
                $('#submit').text('Submit');
                if (data.data.error_message) {
                    alert(data.data.error_message);
                    return;
                }
                $('#chartComponent').removeClass('d-none');
                $('#fastest_aseroid_id').text(data.result.fastest_aseroid_id);
                $('#fastest_aseroid').text(data.result.fastest_aseroid + " km/h");
                $('#closest_aseroid_id').text(data.result.closest_aseroid_id);
                $('#closest_aseroid').text(data.result.closest_aseroid + " kilometers");
                $('#avarage_size_aseroid').text(data.result.avarage_size_aseroid + " kilometers");
                chart.data.labels = [];
                chart.data.datasets[0].data = [];
                $.each(data.data.near_earth_objects, function (key, val) {
                    chart.data.labels.push(key);
                    chart.data.datasets[0].data.push(val.length);
                });
                chart.update();
            },
            error: function (error) {
                $('#submit').text('Submit');
                alert(error.data.error_message);
            }
        });
    });
});
