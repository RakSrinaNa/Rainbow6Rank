$(document).ready(function () {
	var acc = document.getElementsByClassName('accordion');
	var i;

	for (i = 0; i < acc.length; i++)
		acc[i].onclick = function () {
			this.classList.toggle('active');
			var panel = this.nextElementSibling;
			if (this.classList.contains('active'))
			{
				panel.classList.add('active');
			}
			else
			{
				panel.classList.remove('active');
			}
		}
});