import '../styles/contact.css'

$(document).ready(function() {
    let search = document.getElementById('SearchContact');
    var divClone = document.getElementsByClassName('insert')[0].cloneNode(true);


    search.addEventListener('input', function(e) {
        let inputLenght = search.value.length;

        $.ajax({
            url: '/app/search/contact',
            method: 'POST',
            data: { 'value': search.value },
            success: function(datas) {
                if (datas.length > 0 && datas.length < 1000) {
                    let tab = '';
                    for (const data of datas) {
                        tab += '<tr class="white-space-no-wrap">';
                        tab += '<td class="pr-0 "><div class="custom-control custom-checkbox custom-control-inline"><input type="checkbox" class="custom-control-input m-0" id="customCheck"><label class="custom-control-label" for="customCheck"></label></div></td>';
                        tab += '<td><div class="active-project-1 d-flex align-items-center mt-0 "><div class="data-content"><div><span class="font-weight-bold">' + data.first_name + ' ' + data.last_name + '</span></div></div></div></td>';
                        tab += '<td>' + data.email + '</td>';
                        tab += '<td><a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="/app/find/appointment?email=' + data.email + '"><svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></a></div></td>';
                        tab += '</tr>';
                    };
                    $('.insert').html('');
                    $('.insert').append(tab);
                }
            }
        }, 'json')

        if (inputLenght === 0) {
            console.log(divClone);
            $('.insert').html('');
            $('.insert').append(divClone);
        }
    });
})