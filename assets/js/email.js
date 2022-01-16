import '../styles/email.css'


$(document).ready(function() {
    $('#btn_modal_mail').click(function(e) {
        e.preventDefault();
        //On récupère l'url depuis la propriété "Data-target" de la balise html a
        let url = $(this).attr('data-target');
        //on fait un appel ajax vers l'action symfony qui nous renvoie la vue
        console.log(document.getElementsByClassName('mail_type'));
        $.post({
            url: url,
            success: function(data) {
                $('#modal_mail').modal('show');
                $('#modal_mail_body').html(data);
            }
        })
    });

    $('#btn_modal_sms').click(function(e) {
        e.preventDefault();
        //On récupère l'url depuis la propriété "Data-target" de la balise html a
        let url = $(this).attr('data-target');
        //on fait un appel ajax vers l'action symfony qui nous renvoie la vue
        $.post({
            url: url,
            success: function(data) {
                $('#modal_sms').modal('show');
                $('#modal_sms_body').html(data);
            }
        })
    });

    $('#add_notif').click(function(e) {
        e.preventDefault();
        $('#form_notif').slideDown(1500);
        $('#add_notif').addClass('d-none');
    });

    $('#close_form_notif').click(function(e) {
        e.preventDefault();
        $('#form_notif').slideToggle(1500);
        setTimeout(function() {
            $('#add_notif').removeClass('d-none');
        }, 1250);

    })

    $('.a_modal_notif').click(function(e) {
        e.preventDefault();
        let url = $(this).attr('data-target');
        $.post({
            url: url,
            success: function(data) {

                $('#modal_notif').modal('show');
                $('#modal_notif_body').html(data);
            }
        })
    })

    $('.a_modal_seq').click(function(e) {
        e.preventDefault();
        let url = $(this).attr('data-target');
        $.post({
            url: url,
            success: function(data) {

                $('#modal_seq').modal('show');
                $('#modal_seq_body').html(data);
            }
        })
    })

    $(document).change(function() {
        let data = document.getElementById('mail_type').value;
        let object = document.getElementById('mail_object');
        let body = document.getElementById('mail_body_mail');

        $.post({
            url: '/app/preselect',
            data: { 'name': data },
            success: function(data) {
                object.value = data.model_object;
                body.value = data.model_body;
            }
        })
    })

});