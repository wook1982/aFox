/*!
 * aFox (http://afox.kr)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */

+function ($) {
  'use strict';

	$(window).on('load', function() {
		$('[web-code-run="area"]').each(function() {
			var $this = $(this);
			$this.find('[web-code-run="run"]')
				.addClass('btn btn-warning btn-lg btn-block')
				.offOn('click', function() {
				var _css, _html, _script,
					pw = pop_win('about:blank', '800', null, 'af_editor_components'),
					code = '<!doctype html><html lang="ko"><head><meta charset="utf-8"><link href="%s" rel="stylesheet"><script src="%s"></script><script src="%s"></script><style>'+"\n"+'%s'+"\n"+'</style></head><body><div style="margin:5px">'+"\n"+'%s'+"\n"+'</div> <script>'+"\n"+'%s'+"\n"+'</script></body></html>';

				if($this.find('div.syntaxhighlighter').length > 0) {
					var item;
					item = $this.find('div.syntaxhighlighter.css .container').get(0);
					_css = (item.innerText || item.textContent).replace(/\xA0/g, " ");
					item = $this.find('div.syntaxhighlighter.html .container').get(0);
					_html = (item.innerText || item.textContent).replace(/\xA0/g, " ");
					item = $this.find('div.syntaxhighlighter.jscript .container').get(0);
					_script = (item.innerText || item.textContent).replace(/\xA0/g, " ");
				} else {
					_css = $this.find('[code-type="css"]').text() || '';
					_html = $this.find('[code-type="html"]').text() || '';
					_script = $this.find('[code-type="jscript"]').text() || '';
				}

				code = code.sprintf('./common/css/bootstrap.min.css', './common/js/jquery.min.js', './common/js/bootstrap.min.js', _css, _html, _script);
				var nbsp = jQuery("<div>&nbsp;</div>").text();
				pw.document.open('text/html', 'replace');
				pw.document.write(code);
				pw.document.close();

				// 작동함, 별로 필요없어보여 안하기로...
				//<body onload="document.getElementById('preview-container').style.display='block'"><div id="preview-container" style="display:none">
				// 작동 안함
				//pw.document.getElementById("preview-container").style.display = 'block';
				//code.find('#preview-container').show();
			});
		});
	});

}(jQuery);
