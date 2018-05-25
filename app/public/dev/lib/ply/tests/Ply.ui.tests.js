(function (Ply) {
	module('Ply.ui');


	promiseTest('dialog("unknown")', function () {
		setTimeout(function () {
			simulateEvent(Ply.stack.last.overlayEl, 'click');
		}, 50);

		return Ply.dialog('unknown').then(function (ui) {
			equal(ui.by, 'overlay', 'ui.by');
			equal(ui.state, false, 'ui.state');
		});
	});


	promiseTest('dialog("alert")', function () {
		setTimeout(function () {
			var el = Ply.stack.last.wrapEl;
			el.getElementsByTagName('button')[0].click();
		}, 50);

		return Ply.dialog('alert', { effect: 'none:1' }, 'msg').then(function (ui) {
			equal(ui.by, 'submit', 'ui.by');
			equal(ui.state, true, 'ui.state');
		});
	});


	promiseTest('dialog("confirm")', function () {
		setTimeout(function () {
			var el = Ply.stack.last.wrapEl;
			el.getElementsByTagName('button')[1].click();
		}, 50);

		return Ply.dialog('confirm', { effect: 'none:1' }, {
			title: "???",
			text: "!!!"
		}).then(function (ui) {
			equal(ui.by, 'cancel', 'ui.by');
			equal(ui.state, false, 'ui.state');
		});
	});


	promiseTest('dialog("prompt")', function () {
		setTimeout(function () {
			var el = Ply.stack.last.wrapEl;
			Ply.stack.last.context.val('email', 'xx@yy.zz');
			el.getElementsByTagName('button')[0].click();
		}, 50);

		return Ply.dialog('prompt', { effect: 'none:1' }, {
			title: "???",
			form: { email: "E-mail" }
		}).then(function (ui) {
			equal(ui.by, 'submit', 'ui.by');
			equal(ui.state, true, 'ui.state');
			equal(ui.context.val('email'), 'xx@yy.zz');
		});
	});


	promiseTest('dialog("confirm") with YES/NO', function () {
		setTimeout(function () {
			var el = Ply.stack.last.wrapEl;
			el.getElementsByTagName('button')[0].click();
		}, 50);

		return Ply.dialog("confirm", { effect: 'none:1' }, { ok: 'YES', cancel: 'NO' }).then(function (ui) {
			equal(ui.layer.layerEl.getElementsByTagName('button')[0].innerHTML, 'YES', 'ok');
			equal(ui.layer.layerEl.getElementsByTagName('button')[1].innerHTML, 'NO', 'cancel');
		});
	});


	promiseTest('dialog({ steps })', function () {
		var log = [];

		return Ply.dialog({
			'foo': {
				data: { text: 'foo' },
				options: { effect: 'none:1' },
				prepare: function (data) {
					data.text += '!';
				},
				next: 'baz'
			},
			'bar': {
				data: { text: 'bar' }
			},
			'baz': {
				ui: 'confirm',
				data: { text: 'baz' },
				back: 'bar'
			}
		}, {
			progress: function (ui) {
				log.push(ui.name + ':' + ui.state);

				setTimeout(function () {
					var el = ui.layer.layerEl;
					(el.getElementsByTagName('button')[1] || el.getElementsByTagName('button')[0]).click();
				}, 10);
			}
		}).then(function () {
			equal(log.join('\n'), [
				'foo:undefined',
				'baz:true',
				'bar:false'
			].join('\n'));
		});
	});


	promiseTest('factory.use()', function () {
		Ply.factory('test', function (options, data, resolve) {
			Ply.factory.use('alert', options, {
				text: '!?',
				ok: 'Y'
			}, resolve);
		});

		return Ply.create("test").then(function (layer) {
			equal(layer.context.getEl('el').innerHTML, '!?');
			equal(layer.layerEl.getElementsByTagName('button')[0].innerHTML, 'Y');
		});
	});
})(Ply);
