import '../styles/main.css';

$(document).ready(function() {
    let trElt = $('.clickable-row');

    console.log(trElt)

    trElt.on("click", function() {
        let classElt = $(this).attr('class');
        let id = classElt.replace('white-space-no-wrap clickable-row ', '');

        if (id !== 'null') {
            window.open('https://localhost:8000/app/contact-view/' + id);
        }
    })

});