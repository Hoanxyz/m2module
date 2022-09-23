define([
    'jquery'
], function ($) {
    'use strict';

    return function (config) {
        jQuery(".result").hide();
        jQuery("#form_value").submit(function(){

            var oneValue = jQuery("input[name='numone']").val();
            var twoValue = jQuery("input[name='numtwo']").val();

            var url = $("#form_value").attr("action");
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    numone:oneValue,
                    numtwo:twoValue
                },
                cache: false,
                complete: function(response){
                }
            })
                .done(function (response) {
                    if (response.success) {
                        jQuery(".result").show();
                        jQuery(".result").text(response.result);
                    } else {
                        alert(response.errorMessage);
                    }
                });
            return false;
        });
    };
});
