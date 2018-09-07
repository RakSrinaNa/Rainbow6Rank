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

am4core.useTheme(am4themes_animated);
am4core.useTheme(am4themes_dark);

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
