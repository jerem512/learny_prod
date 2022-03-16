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
                            tab += '<tr id="' + response.id + '">';
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
                            tab += '<td><a href="edit_closing_rate/' + response.id.toString() + '" class="edit_cr"><i class="fa fa-edit text-warning"></i></a></td>';
                            tab += '<td><a data-id="' + response.id + '" class="delete"><i class="fa fa-times-circle text-danger text-center"></i></a></td>';
                            //tab += '<td>' + '<a href="' + "{{ path('edit_closingRate', {'id' :" + response.id + '}) }}"><i class="fa fa-edit text-warning text-center"></a></td>';
                            tab += '</tr>';
                        }
                    } else {
                        tab += '<tr>';
                        tab += '<td id="no-data" colspan="13">Aucune données à afficher vous n\'avez pas rempli votre closing rate.</td>';
                        tab += '</tr>';
                    }
                    $('.insert').append(tab);
                }
            },
            'json');

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

                    let tdElt = document.getElementById('no-data');

                    if (document.body.contains(tdElt)) {
                        $('.insert').html('');
                    }

                    let date = responses.date.date;

                    tab += '<tr id="' + responses.id + '">';
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
                    tab += '<td><a href="edit_closing_rate/' + responses.id.toString() + '" class="edit_cr"><i class="fa fa-edit text-warning"></i></a></td>';
                    tab += '<td class="delete isDisabled"><a><i class="fa fa-times-circle text-danger text-center" disabled></i></a></td>';
                    //tab += '<td><a href="edit_closing_rate/' + response.id.toString() + '" class="edit_cr"><i class="fa fa-edit text-dark"></i></a></td>';
                    //tab += '<td>' + '<a href="' + "{{ path('edit_closingRate', {'id' :" + response.id + '}) }}"><i class="fa fa-edit text-dark"></a></td>';
                    tab += '</tr>';
                    $('.insert').append(tab);
                    setTimeout(closingrate_delete, 1000);
                }
                $('#closing_rate')[0].reset();
            }
        }, 'json');
    });

    function closingrate_delete() {
        let deleteBtns = document.body.getElementsByClassName('delete');
        console.log('ici');
        for (let i = 0; i < deleteBtns.length; i++) {
            deleteBtns[i].addEventListener('click', function(e) {
                e.preventDefault();
                console.log('là');
                $('#modal_delete').modal('show');
                let trElt = document.getElementById(deleteBtns[i].dataset.id);
                $('#save_delete').on("click", function() {

                    $.post({
                        url: 'delete_closingrate',
                        data: { 'lign_id': deleteBtns[i].dataset.id },
                        success: function(del) {
                            trElt.remove();
                            console.log(del);
                            if (del == 0) {

                                let tab;

                                tab += '<tr>';
                                tab += '<td id="no-data" colspan="13">Aucune données à afficher vous n\'avez pas rempli votre closing rate.</td>';
                                tab += '</tr>';

                                $('.insert').append(tab);
                            }
                        }
                    })
                })
            })
        }
    }

    setTimeout(closingrate_delete, 1000);

})