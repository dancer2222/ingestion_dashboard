// Ajax default settings
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: location.origin
});

// Audiobook Class
var Audiobook = {
    setStatus: function (radioBtn) {
        var self = this;

        var status = radioBtn.value;
        var id = radioBtn.dataset.audiobookId;

        self.statusPanelToggle();

        $.ajax({
            url: $.ajaxSettings.url + '/web/content/audiobooks/status',
            method: 'post',
            data: {
                id: id,
                status: status
            },
            success: function (response) {
                self.statusPanelToggle(!response.result);
            },
            error: function (error) {
                console.log(error);

                self.statusPanelToggle(true);
            }
        });
    },
    statusPanelToggle: function (rollback) {
        var statusPanel = $('#status_panel');
        var radioActive = statusPanel.find('#status_active');
        var radioInactive = statusPanel.find('#status_inactive');

        if (rollback) {
            if (radioActive.prop('checked')) {
                radioInactive.prop('checked', true);
            } else {
                radioActive.prop('checked', true);
            }
        }

        var statusPanelInputs = statusPanel.find('input');

        statusPanelInputs.prop('disabled', !statusPanelInputs.prop('disabled'));
    }
};

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
            // notify('Cannot upload your file. <b>Missed input id.</b>'); TODO: Replace with notify of new theme

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
            // notify('Cannot upload your file. <b>Missed url.</b>'); TODO: Replace with notify of new theme

            return false;
        }

        var formData = new FormData;

        if (inputFile.files.length < 1) {
            // notify('File has\'t been uploaded'); TODO: Replace with notify of new theme

            return false;
        }

        formData.append('optionData', inputFile.files[0]);

        var formClosest = $(inputFile).closest('form');
        var inputToPaste = formClosest.find('#option-' + inputFile.dataset.optionName);

        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                inputToPaste.val(response.data);

                inputFile.value = null;
            },
            error: function (error) {
                console.log(error);

                // notify('Cannot process the uploaded file.'); TODO: Replace with notify of new theme

                inputFile.value = null;
            }
        });

        return false;
    });

    // Aws notifications
    // Aws Filters
    $('.aws-notifications button#reset').on('click', function (e) {
        e.preventDefault();

        var form = $('.aws-notifications form');
        var fromDate = form.find('input[name="from_date"]');
        var toDate = form.find('input[name="to_date"]');
        var bucket = form.find('select[name="bucket"]');

        fromDate.val('');
        toDate.val('');
        bucket.val('');

        form.find('button[type="submit"]').click();
    });

    // Aws pagination
    $('.aws-notifications .pagination li.page-item a.page-link').on('click', function (e) {
        e.preventDefault();

        var form = $('.aws-notifications form');
        var inputPage = form.find('input[name="page"]');
        var page = $(this).text();

        inputPage.val(page);
        form.find('button[type="submit"]').click();

        return false;
    });

    // Audiobooks
    // Change status
    $('.audiobook_status_change').on('change', function (e) {
        Audiobook.setStatus(this);
    });
});



