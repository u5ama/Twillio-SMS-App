$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $("#year").val(new Date().getFullYear()).trigger('change');
})

$(document).on('change', '#year', function () {
    $.ajax({
        type: 'POST',
        async: false,
        data: {
            year: $(this).val()
        },
        url: APP_URL + '/getChart',
        success: function (data) {
            chart.resetSeries()
            chart.updateOptions({
                xaxis: {
                    categories: data.month
                },
            })
            chart.updateSeries([{
                name: userVehicle,
                data: data.data
            }])
            loaderHide();
        }, error: function (data) {
            console.log('Error:', data)
        }
    })
})

var options = {
    series: [{
        name: userVehicle,
        data: []
    }],
    chart: {
        type: 'bar',
        height: 248,
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '20%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: false,
        width: 3,
        colors: ['transparent']
    },
    xaxis: {
        categories: [],
    },
    fill: {
        opacity: 2
    },
};
var chart = new ApexCharts(document.querySelector("#userVehicleChart"), options);
chart.render();
