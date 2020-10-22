"use strict";
// Class definition

var KTDatatableHtmlTableDemoOthers = function () {
	// Private functions

	// demo initializer
	var demo = function () {

		var datatable = $('#kt_datatable_others').KTDatatable({
			data: {
				saveState: { cookie: false },
			},
			search: {
				input: $('#kt_datatable_search_query_others'),
				key: 'generalSearch'
			},
			columns: [
				{
					field: 'Statut_Tingis',
					title: 'Statut Tingis',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var statutT = {
							1: {
								'title': 'Annulé',
								'class': ' label-light-success'
							},
							2: {
								'title': 'En attente',
								'class': ' label-light-warning'
							},
							3: {
								'title': 'Encodé',
								'class': ' label-light-danger'
							}
						};
						return '<span class="label font-weight-bold label-lg' + statutT[row.Statut_Tingis].class + ' label-inline">' + statutT[row.Statut_Tingis].title + '</span>';
					},
				}, {
					field: 'Statut_Proximus',
					title: 'Statut Proximus',
					autoHide: false,
					// callback function support for column rendering
					template: function (row) {
						var statutP = {
							1: {
								'title': 'Close Gagnée',
								'class': ' label-light-success'
							},
							2: {
								'title': 'Close Perdus',
								'class': ' label-light-warning'
							},
							3: {
								'title': 'En encodage',
								'class': ' label-light-danger'
							}, 
							4: {
								'title': 'NA',
								'class': ' label-light-info'
							}
						};
						return '<span class="label font-weight-bold label-lg' + statutP[row.Statut_Proximus].class + ' label-inline">' + statutP[row.Statut_Proximus].title + '</span>';
					},
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 150,
					overflow: 'visible',
					autoHide: false,
				}
			],
		});

		$('#kt_datatable_search_statut_tingis_others').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Statut_Tingis');
		});

		$('#kt_datatable_search_statut_proximus_others').on('change', function () {
			datatable.search($(this).val().toLowerCase(), 'Statut_Proximus');
		});

		$('#kt_datatable_search_statut_tingis_others', '#kt_datatable_search_statut_proximus_others').selectpicker();

	};

	return {
		// Public functions
		init: function () {
			// init dmeo
			demo();
		},
	};
}();

jQuery(document).ready(function () {
	KTDatatableHtmlTableDemoOthers.init();
});
