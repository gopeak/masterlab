(function(){
	function DefineValidate(data){
		this.data = data
		this.init()
	}

	DefineValidate.prototype.init = function(){
		const self = this
		if(typeof this.data == 'object'){
			Object.keys(this.data).forEach(key => {
				var selector = '#' + key
				if(!$(selector).length){
					selector = '*[name="' + key +'"]'
				}
				var parentNode = $(selector).closest('.form-group')
				var element = $("<div class='define-validate'></div>")
				var lastChildNode = parentNode.children().last()
				if(typeof self.data[key] == 'object'){
					var text = self.data[key].join('，')
				}else{
					var text = self.data[key]
				}
				lastChildNode.append(element.append(text))
			})
		}
	}

	DefineValidate.prototype.clear = function(){
		Object.keys(this.data).forEach(key => {
			var selector = '#' + key + ' ~ .define-validate'
			if(!$(selector).length){
				selector = '*[name="' + key +'"] ~ .define-validate'
			}
			$(selector).remove()
		})
	}

	window.defineValidate = function(data){
		return new DefineValidate(data)
	}

})(window)