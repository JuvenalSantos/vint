define(['./module'], function (factories) {
	'use strict';

	var VisualizationFactory = function($resource){
		return $resource(baseURL + "visualization/:id/", {id:'@id'},{
			update : {
				method : "PUT"
			},			
			getFullVisualization: {
				method : "GET",
				params: {id: '@id', aggregation: '@aggregation'},
				url: baseURL + "visualization/full/:id/:aggregation"
			},			
			getFullVisualizationMultiLine: {
				method : "GET",
				params: {id: '@id', aggregation: '@aggregation'},
				url: baseURL + "visualization/multiline/:id/:aggregation"
			},
			getFullVisCircle: {
				method : "GET",
				params: {id: '@id'},
				url: baseURL + "visualization/viscircle/:id"
			}
		});
	}

	factories.factory('VisualizationFactory', ['$resource', VisualizationFactory]);
});