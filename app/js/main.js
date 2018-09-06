$(function () {
	$('.nav-link[data-toggle="pill"]').click(function (e) {
		const elem = $(this);
		if (elem.is('.active')) {
			e.stopImmediatePropagation();
			elem.removeClass('active');
			$(elem.attr('href')).removeClass('active');
			$(elem.attr('href')).find('.nav-link.active').removeClass('active');
			$(elem.attr('href')).find('.tab-pane.active').removeClass('active');
			return false;
		}
		return true;
	});
});

function roundDate(date) {
	const coeff = 1000 * 60 * 60;
	return new Date(Math.floor(date.getTime() / coeff) * coeff)
}

const chartColors = {
	theme: 'dark',
	selectedBackgroundColor: '#3c5077',
	gridColor: '#999999',
	color: '#111111',
	scrollBarBackgroundColor: '#3d5e77',
	labelColor: '#000000',
	backgroundColor: '#2b3e50',
	ratioLineColor: '#196E1F',
	countLineColor: '#214DD1',
	handDrawn: false
};

// const SmartScroll = (function () {
// 	const SmartScroll = function (scrollElement, containers, callback) {
// 		this.$scroll = $(scrollElement);
// 		this.$containers = $(containers);
// 		this.whenVisible = callback;
// 		this.scrollTimeout = null;
//
// 		this.bind();
//
// 		// Start rendering
// 		this.$scroll.trigger('scroll.smart');
// 	};
//
// 	SmartScroll.prototype = {
// 		bind: function () {
// 			const that = this;
// 			that.$scroll.on('scroll.smart', function () {
// 				if (that.scrollTimeout)
// 					clearTimeout(that.scrollTimeout);
//
// 				// Execute at the end of scroll
// 				that.scrollTimeout = setTimeout(function () {
// 					const html = document.documentElement;
// 					const clientHeight = html.clientHeight;
// 					const visibleContainers = [];
// 					let clientRect;
// 					let visibleHeight;
//
// 					that.$containers.each(function () {
// 						clientRect = this.getBoundingClientRect();
// 						visibleHeight = (clientRect.height - 20);
// 						// Show if at least 20 pixels of the container height is visible
// 						if (clientRect.top >= visibleHeight * -1 && clientRect.bottom <= clientHeight + visibleHeight)
// 							visibleContainers.push(this);
// 					});
//
// 					if (visibleContainers.length)
// 						that.whenVisible(visibleContainers);
// 				}, 250);
// 			});
// 		}
// 	};
// 	return SmartScroll;
// })();
//
// const createChart = function (containerElement, index) {
// 	const id = ["chart", index].join("-");
// 	const columnElement = document.createElement("div");
// 	const loaderElement = document.createElement("div");
//
// 	loaderElement.setAttribute("class", "ui active loader");
// 	columnElement.setAttribute("class", "column");
// 	columnElement.setAttribute("id", id);
// 	columnElement.appendChild(loaderElement);
// 	containerElement.appendChild(columnElement);
//
// 	const info = {
// 		id: id,
// 		containerElement: columnElement,
// 		isDrawn: false,
// 		draw: function (callback) {
// 			info.isDrawn = true;
// 			AmCharts.makeChart(id, {
// 				"type": "serial",
// 				"theme": "light",
// 				"categoryField": "year",
// 				"rotate": true,
// 				// Disable animations
// 				"startDuration": 0,
// 				"categoryAxis": {
// 					"gridPosition": "start",
// 					"position": "left"
// 				},
// 				"trendLines": [],
// 				"graphs": [{
// 					"balloonText": "Income:[[value]]",
// 					"fillAlphas": 0.8,
// 					"id": "AmGraph-1",
// 					"lineAlpha": 0.2,
// 					"title": "Income",
// 					"type": "column",
// 					"valueField": "income"
// 				}, {
// 					"balloonText": "Expenses:[[value]]",
// 					"fillAlphas": 0.8,
// 					"id": "AmGraph-2",
// 					"lineAlpha": 0.2,
// 					"title": "Expenses",
// 					"type": "column",
// 					"valueField": "expenses"
// 				}],
// 				"guides": [],
// 				"valueAxes": [{
// 					"id": "ValueAxis-1",
// 					"position": "top",
// 					"axisAlpha": 0
// 				}],
// 				"allLabels": [],
// 				"balloon": {},
// 				"titles": [],
// 				"dataProvider": [{
// 					"year": 2005,
// 					"income": 23.5,
// 					"expenses": 18.1
// 				}, {
// 					"year": 2006,
// 					"income": 26.2,
// 					"expenses": 22.8
// 				}, {
// 					"year": 2007,
// 					"income": 30.1,
// 					"expenses": 23.9
// 				}, {
// 					"year": 2008,
// 					"income": 29.5,
// 					"expenses": 25.1
// 				}, {
// 					"year": 2009,
// 					"income": 24.6,
// 					"expenses": 25
// 				}],
// 				"listeners": [{
// 					"event": "init",
// 					"method": callback
// 				}],
// 				"export": {
// 					"enabled": true
// 				}
// 			});
// 		}
// 	};
// 	return info;
// };
//
// const chartReferences = {};
//
// const scroll = new SmartScroll(document, '.chartHolder', function (elements) {
// 	let index = 0;
// 	let info;
// 	const draw = function (element) {
// 		const id = element.getAttribute('id');
// 		const whenReady = function () {
// 			setTimeout(function () {
// 				index++;
// 				// Draw next
// 				if (elements[index])
// 					draw(elements[index]);
// 			}, 0);
// 		};
//
// 		info = chartReferences[id];
// 		if (info.isDrawn)
// 			whenReady();
// 		else
// 			info.draw(whenReady);
// 	};
//
// 	// Start drawing
// 	draw(elements[index]);
// });