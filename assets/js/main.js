import '../styles/main.css';

$(document).ready(function() {
    let trElt = $('.clickable-row');

    trElt.on("click", function() {
        let classElt = $(this).attr('class');
        let id = classElt.replace('white-space-no-wrap clickable-row ', '');

        console.log(id);

        if ($(this).hasClass('text-danger') && $(this).hasClass('clickable-row') && $(this).hasClass('white-space-no-wrap')) {
            id = classElt.replace('white-space-no-wrap text-danger clickable-row ', '');
        }

        if (id !== 'null') {
            window.open('https://localhost:8000/app/contact-view/' + id);
        }
    })

});