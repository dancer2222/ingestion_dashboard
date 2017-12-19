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
  // Register event listener to change db connection button
   $('.change-db').on('click', function () {
        changeDbConnection($(this).text());
    });

   $('[type=submit]').on('click', function () {
       console.log('ssssss');
       $('body').css({'cursor': 'progress'});
   })
});
