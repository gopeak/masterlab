// [
// 		{
// 			'key': 'c',
// 			'trigger-element': '.btn-create',
// 			'trigger': 'click'
// 		},
// 		{
// 			'key': 'd',
// 			'item-element': '.tree-item',
// 			'trigger-element': '.issue_edit_href',
// 			'trigger': 'click',
// 			'handle': fn
// 		}
// ]
// 如果item-element存在，那么被绑定的目标为一系列元素
// 如果handle为函数，那么触发该函数。
!function(window, $, _){


	if(!_) return;

	var targetElement = ''

	function KeyMaster () {
		this.currentTarget = '';
		this.valueCache = []
	}

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

		if(val['item-element']){
			this.setMultiKey(triggerKey, triggerElement, trigger, val['item-element'])
		}else{
			this.setSingleKey(triggerKey, triggerElement, trigger)
		}
	}

	KeyMaster.prototype.setMultiKey = function (triggerKey, triggerElement, trigger, item) {

		var self = this

		$(document).on('mouseover', item, function(e){
			self.currentTarget = $(e.currentTarget).find(triggerElement)
			Mousetrap.bind(triggerKey, function() {
				$(self.currentTarget).trigger(trigger)
			});
		})

	}

	KeyMaster.prototype.setSingleKey = function (triggerKey, triggerElement, trigger) {

		Mousetrap.bind(triggerKey, function() {
			$(triggerElement).trigger(trigger)
		});

	}

	window.keyMaster = new KeyMaster()

	$(function(){
		keyMaster.addKeys([
			{
				key: ['c', 'v'],
				'trigger-element': '.btn-new',
				trigger: 'click'
			},
			{
				key: 'e',
				'item-element': '.tree-item',
				'trigger-element': '.issue_edit_href',
				'trigger': 'click',
			}
		])
	})

}(window, $, _)