<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class PlayTimeRankedGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['ranked']['playtime'];
			return $point;
		}

		function getTitle()
		{
			return 'Playtime Ranked';
		}

		function getID()
		{
			return 'PTR';
		}

		function getParser()
		{
			return /** @lang JavaScript 1.8 */
				'function(data){
	function getDurationAsMillisec(d) {
		if (!d) return 0;
		return (((((d.days || 0) * 24 + (d.hours || 0)) * 60 + (d.minutes || 0)) * 60 + (d.seconds || 0)) * 1000 + (d.milliseconds || 0)) || 0;
	}
	
	function getValidDuration(d) {
		let temp;
		if (!d) return {};
		if (getDurationAsMillisec(d) <= 0) return {};
		if (d.days) {
			//noinspection JSDuplicatedDeclaration
			temp = d.days - Math.floor(d.days);
			d.days = Math.floor(d.days);
			d.hours = (d.hours || 0) + temp * 24;
		}
		if (d.hours) {
			//noinspection JSDuplicatedDeclaration
			temp = d.hours - Math.floor(d.hours);
			d.hours = Math.floor(d.hours);
			d.minutes = (d.minutes || 0) + temp * 60;
		}
		if (d.minutes) {
			//noinspection JSDuplicatedDeclaration
			temp = d.minutes - Math.floor(d.minutes);
			d.minutes = Math.floor(d.minutes);
			d.secondes = (d.secondes || 0) + temp * 60;
		}
		if (d.secondes) {
			//noinspection JSDuplicatedDeclaration
			temp = d.secondes - Math.floor(d.secondes);
			d.secondes = Math.floor(d.secondes);
			d.milliseconds = (d.milliseconds || 0) + temp * 1000;
		}
		if (d.milliseconds) {
			d.milliseconds = Math.floor(d.milliseconds);
		}
		return d;
	}
	
	function addDurations(d1, d2) {
		d1 = getValidDuration(d1);
		d2 = getValidDuration(d2);
		const d = {
			milliseconds: 0,
			seconds: 0,
			minutes: 0,
			hours: 0,
			days: 0
		};
		d.milliseconds += (d1.milliseconds || 0) + (d2.milliseconds || 0);
		d.seconds += (d1.seconds || 0) + (d2.seconds || 0) + parseInt(d.milliseconds / 1000);
		d.milliseconds %= 1000;
		d.minutes = (d1.minutes || 0) + (d2.minutes || 0) + parseInt(d.seconds / 60);
		d.seconds %= 60;
		d.hours = (d1.hours || 0) + (d2.hours || 0) + parseInt(d.minutes / 60);
		d.minutes %= 60;
		d.days = (d1.days || 0) + (d2.days || 0) + parseInt(d.hours / 24);
		d.hours %= 24;
		return d;
	}
	
	function getDurationString(duration, showMillisec) {
		if (!duration)
			return \'0S\';
		duration = addDurations(duration, {});
		let text = \'\';
		if (duration.days)
			text += duration.days + \'D \';
		if (duration.hours)
			text += duration.hours + \'H \';
		if (duration.minutes)
			text += duration.minutes + \'M \';
		if (duration.seconds)
			text += duration.seconds + \'S \';
		if (showMillisec)
			text += duration.milliseconds + \'MS\';
		if (text === \'\')
			return \'0S\';
		return text;
	}
	
	return getDurationString({seconds: data})
}';
		}
	}
