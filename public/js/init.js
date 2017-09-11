$( document ).ready(function() {
    $(".button-collapse").sideNav();
    $("#main-page-content").fadeIn(1000);
});

var cache = {};
function loadPage(url) {
    if (cache[url]) {
        return new Promise(function(resolve) {
            resolve(cache[url]);
        });
    }

    return fetch(url, {
        method: 'GET'
    }).then(function(response) {
        cache[url] = response.text();
        return cache[url];
    });
}

function changePage() {
    var url = window.location.href;
    $('.button-collapse').sideNav('hide');

    loadPage(url).then(function(responseText) {
        $("#main-page-content").fadeOut("slow", function() {
            var div = $(responseText).filter("#main-page-content");
            $(div).hide();
            $(this).replaceWith(div);
            $(div).fadeIn("slow");
        });
    });
}

document.addEventListener('click', function(e) {
    var el = e.target;
    var url = el.href;


    // adjust
    if(url.indexOf("localhost/")) {
         url = url.replace("localhost/", "localhost/lynnekirschsite/public/");
    }

    while (el && !url) {
        el = el.parentNode;
    }

    if (el) {
        if($(el).hasClass("internal")) {
            e.preventDefault();
            history.pushState(null, null, url);
            changePage();
        }

    }
});