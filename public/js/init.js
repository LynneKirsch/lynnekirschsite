$( document ).ready(function() {
    $(".button-collapse").sideNav();
    $('.tap-target').tapTarget('open');

    setTimeout(function(){
        $("#main-page-content").fadeTo( "slow" , 1, function() {
            // Animation complete.
        });
    }, 500);
});
