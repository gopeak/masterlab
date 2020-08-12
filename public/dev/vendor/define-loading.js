(function(){
	function Loading(){
		this.spinner = '<div class="spinner"><div class="spinner-container spinner-container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container spinner-container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container spinner-container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>'
	}

	Loading.prototype.show = function(element, text){
		var $el = $(element)
		var text = text ? text : ''
		$el.css('position', 'relative')
		var mask = '<div class="define-loading"><div class="define-loading-inner"><div class="define-loading-spinner">' + this.spinner + '</div><div class="define-loading-text">' + text + '</div></div></div>'
		$el.append(mask)
	}

	Loading.prototype.hide = function(element){
		var $el = $(element)
		if($el.children('.define-loading').length){
			$el.children('.define-loading').remove()
		}
	}

	var l = new Loading()

	window.loading = {
		show: function(element, text){
			l.show(element, text)
		},
		hide: function(element){
			l.hide(element)
		},
		closeAll: function(){
			$('.define-loading').remove()
		}
	}
})(window)