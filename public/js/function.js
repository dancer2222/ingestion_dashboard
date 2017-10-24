function loaderOn()
{
    $('.loader').fadeIn();
}

function loaderOff()
{
    $('.loader').fadeOut();
}

$(document).ready(function () {

    $('#form button').click(function () {
        // var button;
            loaderOn();
            var url = $('#form').attr('action');
            var bucket = $("input#bucket").val();
            var object = $("input#object").val();
            var title = $("input#title").val();
            var batchTitle = $("input#batchTitle").val();
            var id = $("input#id").val();
        $.ajax({
            url: url,
            type: "POST",
            // dataType: 'json',
            data: {
                bucket: bucket,
                object: object,
                title: title,
                batchTitle: batchTitle,
                id: id
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            accepts: {
                xml: 'text/xml',
                text: 'text/plain'
            },
            success: function (messages) {
                $('#myModal').modal('show');
                $('#myModal .modal-body').text(messages);
                loaderOff();
            },
            timeout: 500000,

            error: function (msg) {
                console.log(msg);
                loaderOff();
            }

        });

        return false;
    });
});