(function( $ ) {
    document.addEventListener("DOMContentLoaded", function() {
        //defaultLanguage define before
        //falang //define before all languages info , slug , name, home_url
        var currentLanguage;//store locale
        var nextLanguage;//store locale


        $( document ).ready(function() {
            currentLanguage = $("#post_locale_choice").val() == 'all'?defaultLanguage:$("#post_locale_choice").val();
            nextLanguage = currentLanguage;
            $("#post_locale_choice").on("change", function(event) {
                nextLanguage = this.value == 'all'?defaultLanguage:this.value;
                currentLanguage = nextLanguage;
                //show/hide translation link in metabox
                if (this.value == 'all'){
                    $('#meta-post-translations').show();
                    $('#meta-select-association').hide();
                } else {
                    $('#meta-post-translations').hide();
                    $('#meta-select-association').show();
                }
            } );
        });

        function getCurrentLanguage(){
            return currentLanguage;
        }
    });
})( jQuery );