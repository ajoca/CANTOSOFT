// Draw chart
//initial blank chart assign
//Plugin is not being initialized in use strict mode, script is added here for that reason
let dashboard_chart_color = $('#dashboard_chart_color').val();
let ctx = document.getElementById("day_week_month_chart_report").getContext('2d');
const myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: '', // Name the series
            data: [], // Specify the data values array
            fill: true,
            borderColor: '#00000000', // Add custom color border (Line)
            backgroundColor: dashboard_chart_color, // Add custom color background (Points and Fill)
            borderWidth: 3, // Specify bar border width
            animations: true
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    }
});


$(function () {
    "use strict";
    let base_url = $("#base_url_").val();
    function show_sale_report(type,action_type) {
        let csrf_name_ = $("#csrf_name_").val();
        let csrf_value_ = $("#csrf_value_").val();
        let outlet_id = $("#outlet_id_dashboard").val();
        let start_date = $("#start_date_dashboard").val();
        let end_date = $("#end_date_dashboard").val();
        $.ajax({
            url: base_url+"Dashboard/get_sale_report_charge",
            type: "POST",
            dataType: "json",
            data: {
                outlet_id: outlet_id,
                start_date: start_date,
                end_date: end_date,
                type: type,
                action_type: action_type,
                csrf_name_: csrf_value_,
            },
            success: function (response) {
                $(".set_total_1").html(response.set_total_1);
                $(".set_total_2").html(response.set_total_2);
                $(".set_total_3").html(response.set_total_3);
                $(".set_total_4").html(response.set_total_4);
                if(Number(response.set_total_3)){
                    $(".set_total_5").html((Number(response.set_total_1)/Number(response.set_total_3)).toFixed(2));
                }else{
                    $(".set_total_5").html((0).toFixed(2));
                }
                let json = (response.data_points);
                var data_chart = [];
                var data_label = [];
                var data_label_value = [];
                $.each(json, function (i, v) {
                    data_chart.push({ y: Number(v.y_value), yLabel: v.y_label,x:i, label:v.x_label, tmiLabel:v.x_label_tmp,});
                    data_label.push(v.x_label);
                    data_label_value.push(Number(v.y_value));
                });

                //chart js
                // assign programmatically the datasets again, otherwise data changes won't show
                myLineChart.data.labels = data_label;
                myLineChart.data.datasets[0].data = data_label_value;
                myLineChart.data.datasets[0].animations = true;
                myLineChart.update();

            },
        });
    }
    function show_sale_report_today() {
        let csrf_name_ = $("#csrf_name_").val();
        let csrf_value_ = $("#csrf_value_").val();
        let outlet_id = $("#outlet_id_dashboard").val();
        $.ajax({
            url: base_url+"Dashboard/get_sale_report_charge_today",
            type: "POST",
            dataType: "json",
            data: {
                outlet_id: outlet_id,
                csrf_name_: csrf_value_,
            },
            success: function (response) {
                $(".set_today_total_1").html(response.set_total_1);
                $(".set_today_total_2").html(response.set_total_2);
                $(".set_today_total_3").html(response.set_total_3);
                $(".set_today_total_4").html(response.set_total_4);
                if(Number(response.set_total_3)){
                    $(".set_today_total_5").html((Number(response.set_total_1)/Number(response.set_total_3)).toFixed(2));
                }else{
                    $(".set_today_total_5").html((0).toFixed(2));
                }

                $('.spincrement').spincrement({
                    from: 0.0,
                    decimalPlaces: 2,
                    thousandSeparator:null,
                    duration: 1000,
                });
            },
        });
    }

    setTimeout(function () {
        show_sale_report("day","revenue");
        show_sale_report_today();
    }, 2000);

    $(document).on('click', '.get_graph_data', function(e) {
        e.preventDefault();
        $('.btn-dblue').removeClass('active');
        $(this).addClass('active');
        let action_type = $(this).attr('data-action_type');
        let text = $(this).attr('data-text');
        $(".sale_report_header").html(text);
        let type = "day";

        $(".get_date_by_custom_btn").each(function() {
            if($(this).hasClass("custom_td_active")){
                type = $(this).attr('data-type');
            }
        });

        show_sale_report(type,action_type);
    });
    $(document).on('click', '.get_action_prevent', function(e) {
        e.preventDefault();
    });
    $(document).on('click', '.get_date_by_custom_btn', function(e) {
        e.preventDefault();
        $('.get_date_by_custom_btn').removeClass('custom_td_active');
        $(this).addClass('custom_td_active');
        let type = $(this).attr("data-type");
        let action_type = "revenue";

        $(".get_graph_data").each(function() {
            if($(this).hasClass("active")){
                action_type = $(this).attr('data-action_type');
            }
        });

        show_sale_report(type,action_type);

    });
});
