import '../styles/closingrate.css';

$(document).ready(function() {
    function personalClosingRateList() {
        $.post({
            url: 'closingrate',
            method: 'POST',
            data: { 'action': 'show' },
            success: function(responses) {
                let tab = '';

                if (responses.length > 0) {
                    for (let response of responses) {
                        let date = response.date.date;
                        tab += '<tr>';
                        tab += '<td class="separate"><b>' + date.slice(0, 10) + '</b></td>';
                        tab += '<td>' + response.fup + '</td>';
                        tab += '<td>' + response.shofup + '</td>';
                        tab += '<td>' + response.back + '</td>';
                        tab += '<td class="separate">' + response.closefup + '</td>';
                        tab += '<td>' + response.leads + '</td>';
                        tab += '<td>' + response.leads_valid + '</td>';
                        tab += '<td>' + response.leads_contact + '</td>';
                        tab += '<td>' + response.leads_offer + '</td>';
                        tab += '<td>' + response.leads_fup + '</td>';
                        tab += '<td>' + response.leads_close + '</td>';
                        tab += '<td class="separate">' + response.leads_confirm + '</td>';
                        tab += '<td><a href="edit_closing_rate/' + response.id.toString() + '" class="edit_cr"><i class="fa fa-edit text-dark"></i></a></td>';
                        //tab += '<td>' + '<a href="' + "{{ path('edit_closingRate', {'id' :" + response.id + '}) }}"><i class="fa fa-edit text-dark"></a></td>';
                        tab += '</tr>';
                    }
                } else {
                    tab += '<tr class="no-data">';
                    tab += '<td colspan="13">Aucune données à afficher vous n\'avez pas rempli votre closing rate.</td>';
                    tab += '</tr>';
                }
                $('.insert').append(tab);
            }
        }, 'json');
    }

    personalClosingRateList();

    let ClosingRatesForm = $('form[name="closing_rate"]');

    $('.add').on('click', function() {
        ClosingRatesForm.submit();
    });

    ClosingRatesForm.on('submit', function(event) {
        event.preventDefault();
        let params = 'action=add&' + $(this).serialize();

        $.post({
            url: 'closingrate',
            data: params,
            success: function(responses) {
                if (responses) {
                    let tab = '';

                    let date = responses.date.date;
                    tab += '<tr>';
                    tab += '<td class="separate"><b>' + date.slice(0, 10) + '</b></td>';
                    tab += '<td>' + responses.fup + '</td>';
                    tab += '<td>' + responses.shofup + '</td>';
                    tab += '<td>' + responses.back + '</td>';
                    tab += '<td class="separate">' + responses.closefup + '</td>';
                    tab += '<td>' + responses.leads + '</td>';
                    tab += '<td>' + responses.leads_valid + '</td>';
                    tab += '<td>' + responses.leads_contact + '</td>';
                    tab += '<td>' + responses.leads_offer + '</td>';
                    tab += '<td>' + responses.leads_fup + '</td>';
                    tab += '<td>' + responses.leads_close + '</td>';
                    tab += '<td class="separate">' + responses.leads_confirm + '</td>';
                    //tab += '<td><a href="edit_closing_rate/' + response.id.toString() + '" class="edit_cr"><i class="fa fa-edit text-dark"></i></a></td>';
                    //tab += '<td>' + '<a href="' + "{{ path('edit_closingRate', {'id' :" + response.id + '}) }}"><i class="fa fa-edit text-dark"></a></td>';
                    tab += '</tr>';
                    $('.insert').append(tab);
                }
                $('#closing_rate')[0].reset();
            }
        }, 'json');
    });


})