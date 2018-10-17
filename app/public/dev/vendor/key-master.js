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
			if('.' + e.currentTarget.className === item){
				var currentItem = $(e.target).closest(item)
				Mousetrap.bind(triggerKey, function() {
					currentItem.find(triggerElement).trigger(trigger)
				});
			}
		})

		$(document).on('mouseout', item, function(e){
			Mousetrap.unbind(triggerKey);
		})

	}

	KeyMaster.prototype.setSingleKey = function (triggerKey, triggerElement, trigger) {

		Mousetrap.bind(triggerKey, function() {
			$(triggerElement).trigger(trigger)
		});

	}

	window.keyMaster = new KeyMaster()

	$(function(){
		// key: 绑定的快捷键，字符串或数组。
		// trigger-element: 被触发的DOM，选择器名。
		// trigger: 触发方法，字符串。
		// item-element: 数据列表时的item选择器名
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
			},
			{
				key: 'd',
				'item-element': '.tree-item',
				'trigger-element': '.issue_delete_href',
				'trigger': 'click',
			}
		])
	})

}(window, $, _)