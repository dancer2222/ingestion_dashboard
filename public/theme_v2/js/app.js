function redirect(t){console.log(t),location.replace(location.origin+location.pathname+t)}function changeDbConnection(n){$.ajax({url:$.ajaxSettings.url+"/changeDbConnection",method:"post",data:{connectionName:n},success:function(t){t===n&&($("#db-dropdown").text(n),$(".defaultDatabase").text(n),$.notify({message:"Database connection was changed to: <b>"+t+"</b>"}))},error:function(t){console.log(t),$.notify({message:t.responseText+". Code: "+t.status},{type:"danger"})}})}$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:location.origin}),$(document).ready(function(){$('[data-toggle="popover"]').popover(),$(".change-db").on("click",function(){changeDbConnection($(this).text())}),$("[type=submit]").on("click",function(){$("body").css({cursor:"progress"})}),$("#password-changing-enable").on("click",function(){$("input#password").attr("disabled",!1),$("input#password_confirmation").attr("disabled",!1)}),$(".tool-option-from-file").on("click",function(t){t.preventDefault();var n=$(this).data("triggerFile");return n&&$("#"+n).trigger("click"),!1}),$(".options_file_input").on("change",function(t){t.preventDefault();var n=this,e=$(this).data("url");if(!e)return!1;var o=new FormData;if(n.files.length<1)return!1;o.append("optionData",n.files[0]);var a=$(n).closest("form").find("#option-"+n.dataset.optionName);return $.ajax({url:e,method:"post",processData:!1,contentType:!1,data:o,success:function(t){a.val(t.data),n.value=null},error:function(t){console.log(t),n.value=null}}),!1}),$(".aws-notifications button#reset").on("click",function(t){t.preventDefault();var n=$(".aws-notifications form"),e=n.find('input[name="from_date"]'),o=n.find('input[name="to_date"]'),a=n.find('select[name="bucket"]');e.val(""),o.val(""),a.val(""),n.find('button[type="submit"]').click()}),$(".aws-notifications .pagination li.page-item a.page-link").on("click",function(t){t.preventDefault();var n=$(".aws-notifications form"),e=n.find('input[name="page"]'),o=$(this).text();return e.val(o),n.find('button[type="submit"]').click(),!1})});