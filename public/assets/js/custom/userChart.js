$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $("#userYear").val(new Date().getFullYear()).trigger('change');
})

$(document).on('change', '#userYear', function () {
    $.ajax({
        type: 'POST',
        async: false,
        data: {
            year: $(this).val()
        },
        url: APP_URL + '/getUserChart',
        success: function (data) {
            charts.resetSeries()
            charts.updateOptions({
                xaxis: {
                    categories: data.month
                },
            })
            charts.updateSeries([{
                name: user,
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
        name: user,
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
var charts = new ApexCharts(document.querySelector("#userChart"), options);
charts.render();
