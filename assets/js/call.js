$(document).ready(function() {
    let giveCallElt = document.getElementById('give_call');

    giveCallElt.addEventListener('click', function(e) {
        e.preventDefault();
        let url = this.getAttribute("data-target");
        console.log(url);
        let data = this.getAttribute("data");
        console.log(data);
        $.ajax({
            url: url,
            data: { 'lead_id': data },
            success: function(data) {
                $('#modal_choose').modal('show');
                $('#modal_choose_body').html(data)
            }
        })
    })

});