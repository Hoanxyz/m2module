define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function (ko, Component, urlBuilder,storage) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Techone_Ajaxtutorial/test',
        },

        productList: ko.observableArray([]),

        getProduct: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('ajaxtutorial/test/product');

            return storage.post(
                serviceUrl
            ).done(
                function (response) {
                    self.productList(response);
                }
            ).fail(
                function (response) {
                    console.log(response);
                }
            );
        },

    });
});