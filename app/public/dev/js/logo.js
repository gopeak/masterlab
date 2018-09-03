(function(window) {
	var svgSprite = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1"><symbol id="logo-svg" viewBox="0 0 126 86"><ellipse cx="0" cy="50" rx="15" ry="40" style="transform: rotate(-45deg);" fill="#ff8b04" data-active-color="#fcc07a" /><ellipse cx="90" cy="-40" rx="15" ry="40" style="transform: rotate(45deg);" fill="#ff8b04" ata-active-color="#fcc07a" /><ellipse cx="90" cy="-40" rx="15" ry="40" style="transform: rotate(45deg);" fill="#ff8b04" data-active-color="#fcc07a" /><ellipse cx="-14" cy="56" rx="15" ry="32" style="transform: rotate(-55deg);" fill="#fd9e32" data-active-color="#fcc07a" /><ellipse cx="88" cy="-48" rx="15" ry="32" style="transform: rotate(55deg);" fill="#fd9e32" data-active-color="#fcc07a" /><ellipse cx="-38" cy="50" rx="12" ry="26" style="transform: rotate(-75deg);" fill="#ffb258" data-active-color="#ff8b04"/><ellipse cx="71" cy="-73" rx="12" ry="26" style="transform: rotate(75deg);" fill="#ffb258" data-active-color="#ff8b04" /><ellipse cx="-79" cy="-2" rx="12" ry="22" style="transform: rotate(-125deg);" fill="#fcc07a" data-active-color="#ff8b04" /><ellipse cx="6" cy="-107" rx="12" ry="22" style="transform: rotate(125deg);" fill="#fcc07a" data-active-color="#ff8b04" /></symbol></svg>';
	var script = function() {
		var scripts = document.getElementsByTagName("script");
		return scripts[scripts.length - 1]
	}();
	var shouldInjectCss = script.getAttribute("data-injectcss");
	var ready = function(fn) {
		if (document.addEventListener) {
			if (~["complete", "loaded", "interactive"].indexOf(document.readyState)) {
				setTimeout(fn, 0)
			} else {
				var loadFn = function() {
					document.removeEventListener("DOMContentLoaded", loadFn, false);
					fn()
				};
				document.addEventListener("DOMContentLoaded", loadFn, false)
			}
		} else if (document.attachEvent) {
			IEContentLoaded(window, fn)
		}

		function IEContentLoaded(w, fn) {
			var d = w.document,
				done = false,
				init = function() {
					if (!done) {
						done = true;
						fn()
					}
				};
			var polling = function() {
				try {
					d.documentElement.doScroll("left")
				} catch (e) {
					setTimeout(polling, 50);
					return
				}
				init()
			};
			polling();
			d.onreadystatechange = function() {
				if (d.readyState == "complete") {
					d.onreadystatechange = null;
					init()
				}
			}
		}

	};
	var before = function(el, target) {
		target.parentNode.insertBefore(el, target)
	};
	var prepend = function(el, target) {
		if (target.firstChild) {
			before(el, target.firstChild)
		} else {
			target.appendChild(el)
		}
	};

	function appendSvg() {
		var div, svg;
		div = document.createElement("div");
		div.innerHTML = svgSprite;
		svgSprite = null;
		svg = div.getElementsByTagName("svg")[0];
		if (svg) {
			svg.setAttribute("aria-hidden", "true");
			svg.style.position = "absolute";
			svg.style.width = 0;
			svg.style.height = 0;
			svg.style.overflow = "hidden";
			prepend(svg, document.body)
			$('#logo-svg > ellipse').each( (i, el) => {
			    var activeColor = $(el).data('active-color') ? $(el).data('active-color') : '#000'
			    var color = $(el).attr('fill') ? $(el).attr('fill') : '#000'
			    $(el).css('color', color)
			    $(el).on({
			        mouseenter: function(){
			            $(this).css('fill', activeColor)
			        },
			        mouseleave: function(){
			            $(this).css('fill', color)
			        }
			    })
			})
		}
	}
	if (!window.__iconfont__svg__cssinject__) {
		window.__iconfont__svg__cssinject__ = true;
		document.write("<style>.logo {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")
	}
	ready(appendSvg)
})(window)