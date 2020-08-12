(function(){
	// opts.type: string | image
	// opts.name: image类型 computer | moon | book
	// opts.wrap: 插入页面的DOM，不指定时可用返回的对象访问html结构，使用其他方式插入
	// opts.handleHtml: 自定义提示信息下面的区域内容
	function DefineStatusHtml(opts){
		this.html = ''
		this.opts = opts
		this.message = '数据为空'
		this.handleHtml = this.handle
		this.symbol = '<span class="symbol">/</span>'
		this.init()
	}

	DefineStatusHtml.prototype.setOpts = function(){
		const self = this
		return new Promise( (resolve, reject) => {
			Object.keys(self.opts).forEach( key => {
				self[key] = self.opts[key]
			})
			if(self.opts.type === 'string'){
				//noinspection JSAnnotator
                self.html = `<div class="notfound">
					<svg class="logo" style="font-size: 20px; opacity: .6">
						<use xlink:href="#logo-svg" />
					</svg>
					<div class="text">
						${self.message}
						${self.opts.handleHtml ? self.symbol + self.opts.handleHtml : ''}
					</div>
				</div>`
			}else{
				//noinspection JSAnnotator
                self.html = `<div class="empty" type="${self.opts.name || 'general'}">
					<div class="inner">
						<div class="img"></div>
						<div class="info">${self.message}</div>
						<div class="text">
							${self.opts.handleHtml || ''}
						</div>
					</div>
				</div>`
			}
			resolve(true)
		})
	}

	DefineStatusHtml.prototype.init = function(){
		const self = this
		this.setOpts().then( res => {
			if(self.wrap){
				$(self.wrap).html(self.html)
			}
		})
	}

	window.defineStatusHtml = function(opts){
		return new DefineStatusHtml(opts)
	}
})(window)