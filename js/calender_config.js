(function($) {

    //"use strict";
	var options = {
		events_url: 'agenda.json.php',
		view: 'month',
		tmpl_path: 'css/calender-template/',
		
		/*holidays: {
			'08-03': 'International Women\'s Day',
			'25-12': 'Christmas\'s',
			'01-05': "International labor day"
		}, */
		first_day: 1,
		/*onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		}, */
		onAfterViewLoad: function(view) {
			$('.kalender-title').text(this.getTitle());
			$('.btn-group button').removeClass('btn-info');
			$('button[data-calendar-view="' + view + '"]').addClass('btn-info');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	var	 calendar = $('#agendacalendar').calendar(options);

	calendar.setLanguage('id-ID');
    calendar.view();
	
	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});
}(jQuery));