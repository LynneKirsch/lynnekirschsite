$( document ).ready(function() {
    $(".button-collapse").sideNav();
    $('.tap-target').tapTarget('open');
    $("#main-page-content").fadeIn(2000)
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
        $("#main-page-content").fadeOut(500, function() {
            $(this).html($(responseText).find("#content-inner")).fadeIn(1000);
        });
    });
}

function animate(oldContent, newContent) {
    var fadeOut = oldContent.animate({
        opacity: [1, 0]
    }, 1000);

    var fadeIn = newContent.animate({
        opacity: [0, 1]
    }, 1000);

    fadeIn.onfinish = function() {
        oldContent.parentNode.removeChild(oldContent);
    };
}

window.addEventListener('popstate', changePage);

document.addEventListener('click', function(e) {
    var el = e.target;

    while (el && !el.href) {
        el = el.parentNode;
    }

    if (el) {
        e.preventDefault();
        history.pushState(null, null, el.href);
        changePage();
    }
});