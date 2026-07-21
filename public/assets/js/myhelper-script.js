function closeOpenBootstrapModals() {
    try {
        document.querySelectorAll('.modal.show').forEach(function (modalEl) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var instance = bootstrap.Modal.getInstance(modalEl);
                if (!instance) {
                    instance = bootstrap.Modal.getOrCreateInstance
                        ? bootstrap.Modal.getOrCreateInstance(modalEl)
                        : new bootstrap.Modal(modalEl);
                }
                instance.hide();
            } else if (window.jQuery) {
                window.jQuery(modalEl).modal('hide');
            }
        });
    } catch (e) {}

    // Clear leftover backdrops so SweetAlert is not trapped behind them
    setTimeout(function () {
        document.querySelectorAll('.modal-backdrop').forEach(function (el) {
            el.parentNode && el.parentNode.removeChild(el);
        });
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
        document.body.style.removeProperty('overflow');
    }, 50);
}

function toast(msg, title, type, timer){
    closeOpenBootstrapModals();

    var opts = {
        title: title,
        html: msg,
        type: type,
        confirmButtonClass: "btn btn-confirm mt-2",
        // Keep alert above Bootstrap modal / backdrop
        customClass: {
            container: 'swal-above-modal'
        }
    };
    if(timer !== undefined){
        opts.timer = timer;
    }
    // Small delay so modal hide finishes before Swal paints
    setTimeout(function () {
        swal.fire(opts);
    }, 150);
}



function my_ajax(url,param,method,callback) {
    $("#loading-wrapper").fadeIn();
    $.ajax({
        url: url,
        method: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: param,
        contentType: false,
            processData: false,
        dataType: "json",
        complete: function () {
           
            
            $("#loading-wrapper").fadeOut();
            $('.ajaxForm button[type="submit"]').prop('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
           
            
            ajaxErrorHandling(jqXHR, errorThrown);
        },
        success: function (data) {
            var timer = 1200;

            if (data['reload'] !== undefined) {
                toast(data['success'], "Success!", 'success', timer);
                setTimeout(function () {
                    window.location.reload(true);
                }, 900);
                return false;
            }

            if (data['redirect'] !== undefined) {
                toast(data['success'], "Success!", 'success', timer);
                setTimeout(function () {
                    window.location = data['redirect'];
                }, 900);
                return false;
            }
            if (data['error'] !== undefined) {
                toast(data['error'], "Error!", 'error');
                return false;
            }

            if (data['errors'] !== undefined) {
                multiple_errors_ajax_handling(data['errors']);
            }

            if(data['next'] !== undefined){
                $('#formend').trigger('click');
                return false;
            }
            callback(data);
        }
    });
 }

function multiple_errors_ajax_handling(errors){
    $_html = "";
    for (error in errors) {
        $_html += "<p class='m-1 text-danger'><strong>" + errors[error][0] + "</strong></p>";
    }
    toast($_html, "Error!", 'error');
    return false;
}


function ajaxRequest(_self) {
    var href = $(_self).data('url');
    var nopopup = $(_self).hasClass('nopopup');
    var btn_txt = $(_self).data("btnText");
    var data_msg = $(_self).data("msg");
    if (!nopopup) {
        Swal.fire({
            title: "Are you sure?",
            text: (data_msg && data_msg != '') ? data_msg : "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: (btn_txt && btn_txt != '') ? btn_txt : "Yes, confirm it!"
        }).then(function (t) {
            if (t.value){
                run_ajax(href, _self);
            }
        });
    }else{
        run_ajax(href, _self);
    }
}


function ajaxErrorHandling(data, msg){
    if (data.hasOwnProperty("responseJSON")) {
        var resp = data.responseJSON;

        if (resp.message == 'CSRF token mismatch.') {
            toast("Page has been expired and will reload in 2 seconds", "Page Expired!", "error");
            setTimeout(function () {
                window.location.reload();
            }, 2000);
            return;
        }

        if (resp.error) {
            var msg = (resp.error == '') ? 'Something went wrong!' : resp.error;
            toast(msg, "Error!", "error");
            return;
        }

        if (resp.message != 'The given data was invalid.') {
            toast(resp.message, "Error!", "error");
            return;
        }

        multiple_errors_ajax_handling(resp.errors);
    } else {
        toast(msg + "!", "Error!", 'error');
    }
    return;
}

function multiple_errors_ajax_handling(errors){
    $_html = "";
    for (error in errors) {
        $_html += "<p class='m-1 text-danger'><strong>" + errors[error][0] + "</strong></p>";
    }
    toast($_html, "Error!", 'error');
    return false;
}

function run_ajax(href, ele){
    $("#loading-wrapper").fadeIn();
    // page_loader('show');
    // btn_loader('show');
    $.ajax({
        url: href,
        dataType: "json",
        complete: function () {
            // page_loader('hide');
            // btn_loader('hide');
            $("#loading-wrapper").fadeOut();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            ajaxErrorHandling(jqXHR, errorThrown);
        },
        success: function (data) {
            if (data['error'] !== undefined) {
                toast(data['error'], "Error!", 'error');
            } else if (data['success'] !== undefined) {
                toast(data['success'], "Success!", 'success', 1200);
            } else if (data['info'] !== undefined) {
                toast(data['info'], "Info", 'info');
            }

            if (data['errors'] !== undefined) {
                multiple_errors_ajax_handling(data['errors']);
            }

            if (data['reload'] !== undefined) {
                setTimeout(function () {
                    window.location.reload(true);
                }, 400);
            }

            if (data['redirect'] !== undefined) {
                setTimeout(function () {
                    window.location = data['redirect'];
                }, 400);
            }
        }
    });
}