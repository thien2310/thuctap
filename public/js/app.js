var app = angular.module('my-app',['ngSanitize', 'ui.select'],
function($interpolateProvider) {
    $interpolateProvider.startSymbol("<%");
    $interpolateProvider.endSymbol("%>");
});
