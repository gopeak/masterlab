(function(){
	// type: bag | board | error | gps | id | list | off-line | search
	// direction: vertical | horizontal
	// wrap: 插入页面的DOM，不指定时可用返回的对象访问html结构，使用其他方式插入
	// showIcon: true | false 是否显示图片
	// handleHtml: 自定义提示信息下面的区域内容
	function DefineStatusHtml(opts){
		this.html = ''
		this.handle = '<a class="btn btn-default" href="#"><svg class="logo" style="font-size: 20px; opacity: .6"><use xlink:href="#logo-svg" /></svg>返回首页</a>'
		this.opts = opts
		this.type = 'board'
		this.direction = 'vertical'
		this.message = '数据为空'
		this.handleHtml = this.handle
		this.showIcon = true
		this.init()
	}

	DefineStatusHtml.prototype.setOpts = function(){
		const self = this
		return new Promise( (resolve, reject) => {
			Object.keys(self.opts).forEach( key => {
				self[key] = self.opts[key]
			})
			self.html = `<div class="status status-${self.type}" data-direction="${self.direction}">
							<div class="img ${self.showIcon ? '' : 'hidden'}"></div>
							<div class="inner">
								<div class="message">${self.message}</div>
								<div class="handle">${self.handleHtml}</div>
							</div>
						</div>`
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