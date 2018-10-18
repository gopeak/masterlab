
!function(window, $){

	function KeyMaster () {
		this.currentTarget = '';
		this.valueCache = []
		Mousetrap.reset()
	}

	// params value
	// key: 绑定的快捷键，字符串或数组。
	// trigger-element: 被触发的DOM，选择器名。
	// trigger: 触发方法，字符串。
	// item-element: 存在该字段时，数据列表的列表项选择器名
	// handle: 存在该字段时，触发快捷键后会执行该方法，函数。
	KeyMaster.prototype.addKeys = function (value) {
		var self = this
		if(!value.length || value.length === 0){
			return
		}
		this.valueCache = this.valueCache.concat(value)
		value.forEach(function (val) {
			self.examine(val)
		})
	}

	KeyMaster.prototype.examine = function (val) {
		var triggerKey = val['key'],
			triggerElement = val['trigger-element'],
			trigger = val['trigger'];

		var handle = val.handle || false

		if(val['item-element'] && typeof val['item-element'] === 'string'){
			this.setMultiKey(triggerKey, triggerElement, trigger, val['item-element'], handle)
		}else{
			this.setSingleKey(triggerKey, triggerElement, trigger, handle)
		}
	}

	KeyMaster.prototype.setMultiKey = function (triggerKey, triggerElement, trigger, item, handle) {

		var self = this

		$(document).on('mouseover', item, function(e){
			if('.' + e.currentTarget.className === item){
				var currentItem = $(e.target).closest(item)
				Mousetrap.bind(triggerKey, function() {
					currentItem.find(triggerElement).trigger(trigger);
					if(handle) handle()
				});
			}
		})

		$(document).on('mouseout', item, function(e){
			Mousetrap.unbind(triggerKey);
		})

	}

	KeyMaster.prototype.setSingleKey = function (triggerKey, triggerElement, trigger, handle) {

		Mousetrap.bind(triggerKey, function() {
			if(triggerElement) $(triggerElement).trigger(trigger)
			if(handle) handle()
		});

	}

	window.keyMaster = new KeyMaster()

}(window, $)