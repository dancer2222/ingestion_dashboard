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

            var bucket = $("input#bucket").val();
            var object = $("input#object").val();
            var title = $("input#title").val();
            var batchTitle = $("input#batchTitle").val();
            var id = $("input#id").val();
        $.ajax({
            url: '/show',
            type: "POST",
            dataType: 'json',
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
            success: function (messages) {
                var message = JSON.stringify(messages.message[0]);
                $('#myModal').modal('show');
                $('#myModal .modal-body').html(message);

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