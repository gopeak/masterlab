(function(){
	function DefineValidate(data){
		this.data = data
		this.init()
	}

	DefineValidate.prototype.init = function(){
		if(this.data.length){
			this.data.forEach( (val, i) => {
				var selector = val.id ? '#' + val.id : '*[name="' + val.name + '"]'
				var parentNode = $(selector).closest('.form-group')
				var element = $("<div class='define-validate'></div>")
				var lastChildNode = parentNode.children().last()
				lastChildNode.append(element.append(val.key))
			})
		}
	}

	DefineValidate.prototype.clear = function(){
		if(this.data.length){
			this.data.forEach( (val, i) => {
				var selector = val.id ? '#' + val.id + ' ~ .define-validate' :'*[name="' + val.name + '"] ~ .define-validate'
				$(selector).remove()
			})
		}
	}

	window.defineValidate = function(data){
		return new DefineValidate(data)
	}

})(window)