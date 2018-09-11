let isLoad = [];
const wrappers = jQuery('div.offer-wrapper');
for(let i = 0; i < wrappers.length; i++) {
    isLoad[i] = false;
}

let handler = function (elems) {
    const wrapps = elems.data.ws;
    for (let i = 0; i < wrapps.length; i++) {
        const childrenCount = jQuery(wrapps[i]).children('div.offer-block').length;
        if (isElementInViewport(wrapps[i]) && childrenCount === 0) {
            if (isLoad[i] === false) {
                ajaxRequest(wrapps[i]);
                isLoad[i] = true;
            }
        }
    }
};

jQuery(window).on('DOMContentLoaded resize scroll', {ws: wrappers}, handler);

function isElementInViewport(el) {

    const rect = el.getBoundingClientRect();

    return rect.bottom > 0 &&
        rect.right > 0 &&
        rect.left < (window.innerWidth || document.documentElement.clientWidth) &&
        rect.top < (window.innerHeight || document.documentElement.clientHeight)
}

function ajaxRequest(element) {
    jQuery(document).ready(function ($) {
        $.post(ajaxParams.url, {
            'action': ajaxParams.action,
            'offer_id': ajaxParams.id
        }, function (response) {
            $(element).append(response);
        }, 'text');
    });
}