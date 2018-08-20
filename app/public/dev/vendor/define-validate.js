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
				lastChildNode.append(element.append(self.data[key]))
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