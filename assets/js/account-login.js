import '../styles/account-login.css';

$(document).ready(function() {

    $('#input_calendly').on("click", function(e) {
        let tokenElt = $('#calendly_token');
        let token = tokenElt.val();

        $.ajax({
            url: 'token/calendly/',
            method: 'POST',
            data: { 'token': token },
            success: function(success) {

                let card_body = '';

                if (success == 'done') {
                    $('#calendly_card').html('');
                    $('#calendly').addClass('border border-success');
                    card_body += '<h4 class="card-title text-success">Calendly <i class="fas fa-check text-success"></i></h4>';
                    card_body += '<p class="text-success">Calendly est connecté.</p>';
                    $('#calendly_card').html(card_body);
                } else {
                    $('#echec').html('');
                    card_body += '<div class="input-group-prepend">';
                    card_body += '<span class="input-group-text border border-danger rounded" id="basic-addon1">';
                    card_body += '<i class="fas fa-code"></i>';
                    card_body += '</span>';
                    card_body += '</div>'
                    card_body += '<input id="calendly_token" type="text" class="form-control border border-danger rounded" placeholder="Token Calendly" aria-label="Username" aria-describedby="basic-addon1">';
                    card_body += '<p class="text-danger mt-2">Le token n\'est pas bon ou ne correspond pas. <i class="fas fa-times text-danger"></i></p>'
                    $('#echec').html(card_body);
                    tokenElt.val('');
                }
            }
        });
    });

    $('#input_learnybox').on('click', function() {
        let subdomainElt = $('#subdomain_learnybox');
        let apiKeyElt = $('#api_key_learnybox');

        let subdomain = subdomainElt.val();
        let apiKey = apiKeyElt.val();

        $.ajax({
            url: '/app/account/learnybox/',
            method: 'POST',
            data: { 'subdomain': subdomain, 'api_key': apiKey },
            success: function(success) {
                let card_body = '';

                if (success == 'done') {
                    $('#learnybox_card').html('');
                    $('#learnybox').addClass('border border-success');
                    card_body += '<h4 class="card-title text-success">Learnybox <i class="fas fa-check text-success"></i></h4>';
                    card_body += '<p class="text-success">Learnybox est connecté.</p>';
                    $('#learnybox_card').html(card_body);
                } else {
                    $('#echec_learnycal').html('');
                    card_body += '<div class="input-group-prepend">';
                    card_body += '<span class="input-group-text border border-danger rounded" id="basic-addon1">';
                    card_body += '<i class="fas fa-code"></i>';
                    card_body += '</span>';
                    card_body += '</div>'
                    card_body += '<input id="calendly_token" type="text" class="form-control border border-danger rounded" placeholder="Token Calendly" aria-label="Username" aria-describedby="basic-addon1">';
                    card_body += '<p class="text-danger mt-2">Le token n\'est pas bon ou ne correspond pas. <i class="fas fa-times text-danger"></i></p>'
                    $('#echec_learnycal').html(card_body);
                    tokenElt.val('');
                }
            }
        })
    })
})