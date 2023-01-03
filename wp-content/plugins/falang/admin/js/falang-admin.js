(function( $ ) {
	'use strict';
    // languages form
    // fills the fields based on the language dropdown list choice
    jQuery( document ).ready(function( $ ) {
        $( '#language_list' ).on ('change',function() {
            var value = $( this ).val().split( ':' );
            var selected = $( "option:selected", this ).text().split( ' - ' );
            $( '#language_slug' ).val( value[0] );
            $( '#language_locale' ).val( value[1] );
            $( 'input[name="rtl"]' ).val( [value[2]] );
            $( '#language_name' ).val( selected[0] );
            $( '#flag_list option[value="' + value[3] + '"]' ).attr( 'selected', 'selected' );

        });
    });


})( jQuery );

function copyToTranslation(value,action) {
    try {
        if (document.getElementById('edit-translation')
            || document.getElementById('edit-term-translation')
            || document.getElementById('edit-string-translation')
            || document.getElementById('edit-option-translation')) {
            $local_doc =
            innerHTML="";
            if (action=="copy") {
                srcEl = document.getElementById("original_value_"+value);
                innerHTML = srcEl.innerHTML;
            }
            if (action=="translate") {
                srcEl = document.getElementById("original_value_"+value);
                innerHTML = translateService(srcEl.innerHTML);
            }

            srcEl = document.getElementById(value);
            if (srcEl != null) {
                srcEl.value = innerHTML.trim();
                //srcEl.select();
            }

        }
    }
    catch(e){
        console.log('error in copyToTranslation');
        console.log(e);
    }
}

//add delete ajax action for post,menu,term
jQuery( document ).ready(function($) {
    jQuery(".ajax-delete-action").on("click", function (e) {

        var result = confirm('You are about to permanently delete this translation. Are you sure?');
        if (result != true) {
            return false;
        }

        var ajaxurl = $(this).attr('href');

        $('html, body').css("cursor", "wait");

        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {},
            success: function (response) {
                $('html, body').css("cursor", "auto");
                if (response.success) {
                    //display toast message

                    alert(response.message);
                } else {
                    //display toast error
                    //TODO display error for user
                    //var logMsg = '<div id="message" class="updated" style="display:block !important;"><p>' +
                    //    'Error during options save' +
                    //    '</p></div>';
                    //jQuery('#ajax-response').append( logMsg );
                    console.log("response", response);

                }

            },
            error: function (e, xhr, error) {
                $('html, body').css("cursor", "auto");
                console.log("error", xhr, error);
                console.log(e.responseText);
                console.log("ajaxurl", ajaxurl);
                //console.log("params", params);
            }
        })
        return false;
    });
});

jQuery( document ).ready(function($) {

    // Attach behaviour to toggle button.
    jQuery(document).on('click', '#toogle-source-panel', function()
    {
        var referenceHide = this.getAttribute('data-hide-reference');
        var referenceShow = this.getAttribute('data-show-reference');

        if ($(this).text() === referenceHide)
        {
            $(this).text(referenceShow);
        }
        else
        {
            $(this).text(referenceHide);
        }

        $('.col-source').toggle();
        $('.col-action').toggle();
        $('.col-target').toggleClass('full-width');

        return false;
    });
});

//add ajax hide notice system
jQuery( document ).ready(function($) {
    $('.falang-notice--dismissible').on('click', '.falang-notice__dismiss, .falang-notice-dismiss', function (event) {
        event.preventDefault();
        var $wrapperElm = $(this).closest('.falang-notice--dismissible');
        $.post(ajaxurl, {
            action: 'falang_set_admin_notice_viewed',
            plugin_id: $wrapperElm.data('plugin_id'),
            notice_id: $wrapperElm.data('notice_id')
        });
        $wrapperElm.fadeTo(100, 0, function () {
            $wrapperElm.slideUp(100, function () {
                $wrapperElm.remove();
            });
        });
    });
});