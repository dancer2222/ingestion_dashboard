// Ajax default settings
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: location.origin
});


// Notify default settings
// http://bootstrap-notify.remabledesigns.com/
$.notifyDefaults({
    element: 'body',
    position: null,
    type: "info",
    allow_dismiss: true,
    newest_on_top: false,
    showProgressbar: false,
    placement: {
        from: "bottom",
        align: "right"
    },
    offset: 20,
    spacing: 10,
    z_index: 1031,
    delay: 5000,
    timer: 1000,
    url_target: '_blank',
    mouse_over: null,
    animate: {
        enter: 'animated fadeInRight', // Animate css https://daneden.github.io/animate.css/
        exit: 'animated fadeOutDown' // Animate css https://daneden.github.io/animate.css/
    },
    onShow: null,
    onShown: null,
    onClose: null,
    onClosed: null,
    icon_type: 'class'
});

function notify(message)
{
    $.notify({
        message: message
    });
}

/**
 * Redirect using current pathname
 *
 * @param link
 */
function redirect(link) {
    console.log(link);
    location.replace(location.origin + location.pathname + link);
}

/**
 * Send ajax request to change db connection
 *
 * @param connectionName
 */
function changeDbConnection(connectionName) {
    $.ajax({
      url: $.ajaxSettings.url + '/changeDbConnection',
      method: 'post',
      data: {
          connectionName: connectionName
      },
      success: function (data) {
          if (data === connectionName) {
            $('#db-dropdown').text(connectionName);
            $('.defaultDatabase').text(connectionName);
            $.notify({
              message: 'Database connection was changed to: <b>' + data + '</b>'
            });
          }
      },
      error: function (error) {
          console.log(error);
        $.notify({
          message: error.responseText + '. Code: ' + error.status
        }, {type: 'danger'});
      }
    });
}

$(document).ready(function () {
    // Enable popovers
    $('[data-toggle="popover"]').popover();

    // Register event listener to change db connection button
    $('.change-db').on('click', function () {
        changeDbConnection($(this).text());
    });

    $('[type=submit]').on('click', function () {
       $('body').css({'cursor': 'progress'});
    });

    // Admin Area
    $('#password-changing-enable').on('click', function () {
        $('input#password').attr('disabled', false);
        $('input#password_confirmation').attr('disabled', false);
    });

    // Tools
    // Trigger input file
    $('.tool-option-from-file').on('click', function (e) {
        e.preventDefault();

        var inputFileId = $(this).data('triggerFile');

        if (!inputFileId) {
            notify('Cannot upload your file. <b>Missed input id.</b>');

            return false;
        }

        $('#'+inputFileId).trigger('click');

        return false;
    });

    // Load option value from file
    $('.options_file_input').on('change', function (e) {
        e.preventDefault();

        var inputFile = this;
        var url = $(this).data('url');

        if (!url) {
            notify('Cannot upload your file. <b>Missed url.</b>');

            return false;
        }

        var formData = new FormData;

        if (inputFile.files.length < 1) {
            notify('File has\'t been uploaded');

            return false;
        }

        formData.append('optionData', inputFile.files[0]);

        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                var formClosest = $(inputFile).closest('form');
                var inputToPaste = formClosest.find('#option-' + inputFile.dataset.optionName);

                inputToPaste.val(response.data);
            },
            error: function (error) {
                console.log(error);

                notify('Cannot process the uploaded file.');

                inputFile.files = [];
            }
        });

       return false;
    });
});



