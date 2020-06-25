jQuery(document).ready(function ($) {
    $('.site-header .header-b .tools .btn-search').click(function(){
        $('.site-header .header-b .tools .btn-search .search-form-holder').slideToggle();
        $('.site-header .header-b .tools .btn-search .search-form-holder').click(function(event) {
            event.stopPropagation();
        });
    }) ;

    $('body').click(function(){
        $('.site-header .header-b .tools .btn-search .search-form-holder').hide();
        $('.site-header .header-b .tools .btn-search').click(function(event) {
            event.stopPropagation();
        });
    }) ;                              
});
