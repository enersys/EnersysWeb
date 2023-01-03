<?php

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly
use Falang\Core\Falang_Core;
use \Falang\Core\Falang_Mo;
use Falang\Factory\TranslatorFactory;
use Falang\Core\FString;

//falang_id is the term_id
//TODO need to user term or taxo more clearly
$falang_mo = new Falang_Mo();
$language = $this->model->get_language_by_locale($falang_target_language_locale);
$target_language = $this->model->get_language_by_locale($falang_target_language_locale);


$option_name = $falang_name;

if ($this->model->get_option('enable_service')){
	$translator =  TranslatorFactory::getTranslator($falang_target_language_locale);
	$target_code_iso = strtolower($translator->languageCodeToISO($falang_target_language_locale));
}

//get option name value
$option_value = get_option($option_name);
$multiple = false;
if (is_array($option_value) ) {
    $multiple = true;
}




$translations = $this->model->get_option('translations', array());

$translation = null;
if (isset($translations['option'][$falang_target_language_locale][$option_name]) && $translations['option'][$falang_target_language_locale][$option_name]) {

	$translation = $translations['option'][$falang_target_language_locale][$option_name];

}


?>
<html>
<head>
	<title><?php echo __('Options translation', 'falang'); ?></title>

    <script type="text/javascript">

        // init namespace
        if ( typeof FALANG != 'object') var FALANG = {};

        FALANG.SetOptionOptions = function () {
            var self = {};

            // this will be a public method
            var init = function () {
                self = this; // assign reference to current object to "self"

                // jobs window "close" button
                jQuery('#edit-option-translation .btn_close').click( function(event) {
                    tb_remove();
                }).hide();

            }
            var sendOptions = function(obj) {
                //console.log(obj);

                var params = jQuery('#edit-option-translation').serializeArray();

                var jqxhr = jQuery.post(ajaxurl, params,'json' )
                    .success(function (response) {

                        if (response.success) {
                            // request was successful
                            tb_remove();
                        } else {
                            //TODO display error for user
                            //var logMsg = '<div id="message" class="updated" style="display:block !important;"><p>' +
                            //    'Error during options save' +
                            //    '</p></div>';
                            //jQuery('#ajax-response').append( logMsg );
                            console.log("response", response);

                        }

                    })
                    .error(function (e, xhr, error) {
                        console.log("error", xhr, error);
                        console.log(e.responseText);
                        console.log("ajaxurl", ajaxurl);
                        //console.log("params", params);
                    });
            }

            return {
                // declare which properties and methods are supposed to be public
                init: init,
                sendOptions: sendOptions,
            }
        }();

        //add action-cancel action
        jQuery( document ).ready(function() {
            jQuery( ".action-cancel" ).on( "click", function() {
                tb_remove();
            });

            //update translator object to refer to popup windows
            if (typeof translator != "undefined") {
                translator.to = "<?php echo $target_code_iso?>";
            }
        });

    </script>

	<?php foreach ($this->model->get_languages_list() as $language) {
		if ($language->locale == $falang_target_language_locale){  ?>
            <script type="text/javascript">
                var falang = {
                            languages : {0 : {'name' : '<?php echo $language->name ;?>', 'slug' : '<?php echo $language->slug ;?>','locale' : '<?php echo $language->locale ;?>'}},
                    };
            </script>
            <?php }
	} ?>

    <script type="text/javascript">
        (function($) {

            var explorer = {
                inputKey: "option_explorer",
                isNode: function(node) {
                    return $.isPlainObject(node) || $.isArray(node);
                },
                open: function($li, path, key, node) {
                    var nodePath = path.concat([key]);
                    var nodeName = this.inputKey + "[" + nodePath.join("][") + "]";
                    if (this.isNode(node)) {
                        $li.toggleClass("open").find(".handle.dashicons").toggleClass("dashicons-arrow-right dashicons-arrow-down");
                        if ($li.children("ul").length == 0) {
                            var $ul = $("<ul></ul>");
                            jQuery.each(node, function(key, child) {
                                var val = explorer.isNode(child) ? ($.isEmptyObject(child) ? 'EMPTY' : 'DATA') : child;
                                var $handle = $("<span></span>").addClass("handle");
                                var $label = $("<label></label>").text(key);
                                var $input = $("<input/>").attr("type", "text").addClass("regular-text").attr("readonly", true).val(val);
                                // var $link = $("<a></a>").attr("href", "#").append($handle).append($label).append($input);
                                //var $li = $("<li></li>").append($handle).append($label).append($input);
                                //var $li = $("<li></li>").append($link);
                                var $li = $("<li></li>").append($handle).append($label).append($input);
                                $li.on("explorer:open", function(e) {
                                    explorer.open($li, nodePath, key, child);
                                    return false;
                                });
                                if (val !== 'EMPTY' || val === child) $handle.addClass("dashicons dashicons-arrow-right");
                                $ul.append($li);
                            });
                            $li.append($ul);
                        }
                    } else {
                        $li.trigger("explorer:open:endpoint", {
                            node: node,
                            key: key,
                            path: path,
                        });
                    }
                },
                load: function($ul, url, action) {
                    $ul = $("ul.falang-options");
                    url = ajaxurl;
                    action = "falang_export_options";
                    option_name = '<?php echo $option_name;?>';

                    return $.ajax({
                        url: url,
                        data: {action: action, option_name: option_name},
                        success: function(data) {
                            $ul.on("click", ".handle, label", function() {
                                $li = $(this).closest("li");
                                //console.log($(this).parent());
                                $li.trigger("explorer:open");
                                return false;
                            });
                            $ul.children("li").each(function() {
                                var optionName = $(this).find("label").text();
                                $(this).on("explorer:open", function(e) {
                                    explorer.open($(this), [], optionName, data[optionName]);
                                    return false;

                                });
                            });
                            $ul.addClass("loaded");
                        },
                        dataType: "json"
                    });

                },

                translation: {},
                translationbaseName: "falang_option_translation",
                formData: {action: "falang_set_option_translation"},
                send: function(input) {
                    var data = {
                        action: "falang_set_option_translation"
                    };
                    data[input.name] = input.value;
                    var $loadBar = $('<span></span>').addClass("saving").text("...");
                    $(input).parent().append($loadBar);
                    $.ajax({
                        url: ajaxurl,
                        data: data,
                        method: "POST",
                        success: function(data) {
                            $loadBar.text("saved").prepend('<span class="dashicons dashicons-yes"></span>');
                            setTimeout(function(){ $loadBar.remove() }, 1500);
                        },
                        error: function(xhr, textStatus, errorThrown){
                            console.log(xhr);
                            console.log(textStatus);
                        }
                    });
                },
                openTranslation: function($li, path, key, placeholder) {
                    $li.toggleClass("open").find(".handle").toggleClass("dashicons-arrow-right dashicons-arrow-down");
                    if (!$li.children("ul").length) {
                        var $ul = $("<ul></ul>");
                        jQuery.each(falang.languages, function(i, language) {
                            var nodePath = [language.locale].concat(path, key);
                            var id = nodePath.join("-");
                            var nodeName = explorer.translationbaseName + "[" + nodePath.join("][") + "]";
                            var val = explorer.getTranslation(nodePath);
                            var $handle = $("<span></span>").addClass("handle");
                            var $label = $("<label></label>").attr("for", id).text(language.name);
                            var $input = $("<input/>").attr("type", "text").addClass("regular-text").attr("name", nodeName).attr("placeholder", placeholder).attr("id", id);

                            var $saveBtn = $("<button></button>").html("Save").addClass("button button-small").attr("disabled", true).on("click", function(e){
                                e.preventDefault();
                                var newValue = $input.val();
                                if (val != newValue) {
                                    explorer.send($input[0]);
                                    val = newValue;
                                    $saveBtn.attr("disabled", true);
                                }
                            });
                            $input.on("change keydown paste input", function(e) {
                                var newValue = $input.val();
                                if (val != newValue) {
                                    $saveBtn.attr("disabled", false);
                                } else {
                                    $saveBtn.attr("disabled", true);
                                }
                            });

                            var $li = $("<li></li>").append($handle).append($label).append($input).append($saveBtn);
                            if (val) $input.val(val);
                            $(".handle, label", $li).on("click", function() {
                                $(this).siblings("input").focus();
                                return false;
                            });
                            $ul.append($li);

                        });
                        $li.append($ul);
                    }
                },
                findTranslation: function(path, translations) {
                    var key = path.shift();
                    if (typeof translations == 'object' && key in translations) {
                        if (path.length) {
                            return this.findTranslation(path, translations[key]);
                        } else {
                            return translations[key];
                        }
                    }
                    return false;
                },
                getTranslation: function(path) {
                    return this.findTranslation(path, this.translation);
                },
                loadTranslations: function() {
                    option_name = '<?php echo $option_name; ?>';

                    return $.ajax({
                        url: ajaxurl,
                        data: {action: "falang_option_translations", option_name: option_name },

                        success: function(translationData) {
                            explorer.translation = translationData;
                            $("ul.falang-options").on("explorer:open:endpoint", "li", function(e, args) {
                                explorer.openTranslation($(this), args.path, args.key, args.node);
                                return false;
                            });
                        },
                        dataType: "json"
                    });

                },
                init: function() {
                    $.when(
                        explorer.load()
                    ).then(function(optionData) {
                        explorer.loadTranslations();
                    });
                }
            }

            falang.explorer = explorer;

            $(document).ready(function() {
                explorer.init();
            });

        })(jQuery);
    </script>

</head>
<body>


<form id="edit-option-translation" action="#" method="POST">
	<?php wp_nonce_field('falang_action', 'falang_option_nonce', true, true); ?>

	<input type="hidden" name="action" value="falang_option_update_translation"/>
	<input type="hidden" name="target_language" value="<?php echo $falang_target_language_locale; ?>"/>
	<input type="hidden" name="name" value="<?php echo $falang_name?>">

	<h2><?php echo __('Translate: '.$option_name, 'falang'); ?></h2>
	<div class="info">
        <?php  if ($multiple) {?>
		<b><?php echo __( 'Target language: ', 'falang' ).' '.$target_language->get_flag();?></b>
        <?php } ?>
	</div>

	<?php if ($multiple) { ?>
        <ul class="falang-options">
            <li>
                <span class="handle dashicons dashicons-arrow-right"></span>
                <label for="<?php $option_name ?>"><?php echo esc_html( $option_name ); ?></label>
                <input class="regular-text all-options" type="text" name="falang_translate_options[<?php $name ?>]" id="<?php echo $option_name; ?>" value="DATA" readonly="readonly" />
            </li>
        </ul>
    <?php } else { ?>
	<div id="col-container">
		<div class="col-title">
            <div class="col-source">
                <h3><?php echo esc_html__( 'Source', 'falang' ); ?></h3>
            </div><!-- col-source -->
			<div class="col-action">
				<h3>&nbsp;</h3>
			</div><!-- col-action -->
            <div class="col-target">
                <h3><?php echo esc_html__( 'Target', 'falang' ).' '.$target_language->get_flag(); ?></h3>
            </div><!-- col-target -->
		</div>
	</div>
		<div class="row">
            <div class="col-source">
                <div id="original_value_translation" name="original_value_translation" style="display: none">
					<?php echo  $option_value; ?>
                </div>
				<?php if ($multiple) { ?>
                    <textarea name="fake_original_value" id="fake_original_value"  cols="22" rows="4" readonly><?php echo esc_textarea($option_value); ?></textarea>
				<?php } else { ?>
                    <input type="text" name="fake_original_value" id="fake_original_value" class="falang" value="<?php echo $option_value; ?>" readonly>
				<?php } ?>
            </div>
			<div class="col-action">
				<button class="button-secondary button-copy" onclick="copyToTranslation('translation','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="fas fa-copy"></i></button>
                <!-- add yandex/azure button -->
				<?php if ($this->model->get_option('enable_service') == '1' && !$multiple) { ?>
                    <?php if ($this->model->get_option('service_name') == 'yandex') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                    <?php } ?>
                    <?php if ($this->model->get_option('service_name') == 'azure') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                    <?php } ?>
                    <?php if ($this->model->get_option('service_name') == 'lingvanex') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                    <?php } ?>
				<?php } ?>
			</div>
            <div class="col-target">
				<?php if ($multiple) { ?>
                    <textarea name="translation" id="translation"  cols="22" rows="4"><?php echo esc_textarea($translation);?></textarea>
				<?php } else { ?>
					<?php if (empty($translation)) { ?>
                        <input type="text" name="translation" id="translation" placeholder="<?php echo $option_value; ?>" class="falang">
					<?php } else { ?>
                        <input type="text" name="translation" id="translation" value="<?php echo $translation; ?>" class="falang">
					<?php } ?>
				<?php } ?>
            </div>
		</div>
	<div class="row action">
		<a href="#" class="button button-primary action-cancel"><?php echo __( 'Cancel', 'falang' );?> </a>
		<a href="#" onclick="FALANG.SetOptionOptions.sendOptions(this);return false;" class="button button-primary action-save"><?php echo __('Save', 'falang'); ?></a>
	</div>
    <?php } ?>
</form>
</body>
</html>