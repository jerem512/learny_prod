/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

$(document).ready(function() {
    let btnReport = document.getElementById('reportBug');

    btnReport.addEventListener('click', function() {
        let url = this.getAttribute('data-target');

        $.ajax({
            url: url,
            success: function(data) {
                $('#reportBugModal').modal('show');
                $('#reportBugBody').html(data);
            }
        })
    })
})