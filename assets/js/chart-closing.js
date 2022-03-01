window.onload = () => {
    let chartCustomElt = document.getElementById('chart-closing');

    $.post({
        url: 'show-stats',
        method: 'POST',
        data: { 'action': 'show' },
        success: function(data) {

            Highcharts.chart(chartCustomElt, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Rates (en nombre de personnes)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Rates : <b>{point.y:.0f}</b>'
                },
                series: [{
                    name: 'Rates',
                    data: [
                        ['Follow Up', data.fup],
                        ['Show', data.show_fup],
                        ['Back', data.back],
                        ['Close', data.close_fup],
                        ['Leads', data.leads],
                        ['Validés', data.leads_valid],
                        ['Contacts', data.leads_contact],
                        ['Offres', data.leads_offer],
                        ['Leads en FUP', data.leads_fup],
                        ['Leads closés', data.leads_close],
                        ['Confirmés', data.leads_confirm],
                    ],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.0f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        }
    });
}