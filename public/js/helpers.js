/**
 * simple helper for getting Laravel CSRF Token
 * @returns {string}
 */
function getCSRFToken() {
    var metaTags = document.getElementsByTagName("meta");
    var CSRFToken = "";
    for (var i = 0; i < metaTags.length; i++) {
        if (metaTags[i].getAttribute("name") == "csrf-token") {
            CSRFToken = metaTags[i].getAttribute("content");
            return CSRFToken;
        }
    }
    return CSRFToken;
}

/**
 * helps to handle toast after bad or OK response
 * @param response
 * @param status
 * @param text
 */
function handleResponseToast(response, status, text) {
    var _html = '',
        style = '';
    if (status) {
        _html = text;
        style = 'status_ok';
    } else {
        if (response.response) {
            var errors = response.response;

            _html = response.type + ': ';
            errors.forEach(function (element, index, array) {
                _html += element;
            });
        } else {
            _html = 'Something Was Wrong'
        }
        style = 'status_warning';
    }
    Materialize.toast(_html, 5000, 'rounded');
    var toasts = document.getElementById("toast-container").getElementsByClassName("toast"),
        toast = toasts[toasts.length-1];

    toast.classList.add(style);
}

/**
 * update buttons
 * for false, add disable for btns array
 * for true, remove disabled from btns array
 * @param btns
 * @param add
 */
function updateAddConfirmButtons(btns, add) {
    if (add) {
        Array.prototype.forEach.call(btns, (function (element, index, array) {
            element.classList.add('disabled');
        }));
    } else {
        Array.prototype.forEach.call(btns, (function (element, index, array) {
            element.classList.remove('disabled');
        }));
    }
}