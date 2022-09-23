define([
    'ko',
    'uiComponent',
    'jquery'
], function (ko, Component, $) {
    'use strict';

    return Component.extend({

        defaults: {
            template: 'Techone_Ajaxtutorial/product/list'
        },

        productLists: ko.observableArray([]),

        initialize: function () {
            this._super();
            this.getProduct();
            return this;
        },

        getProduct: function () {
            this.productLists(JSON.parse(this.productList));
        }
    });
});