(function (Ply) {
	module('Ply.dom');


	function elementEqual(actual, expected, msg) {
		msg = msg || 'el';
		expected.tagName = (expected.tagName || 'div').toUpperCase();

		Ply.each(expected, function (value, attr) {
			var attrVal = actual[attr] || actual.getAttribute(attr);
			if (attr === 'innerHTML') {
				attrVal = attrVal.toLowerCase();
			}
			equal(attrVal, value, msg + '.' + attr);
		});
	}


	test('build()', function () {
		elementEqual(Ply.dom.build(), { });
		ok(!Ply.dom.build().parentNode, 'parent');
	});


	test('build("string")', function () {
		Ply.each({
			'div': { },
			'div#xxx': { id: 'xxx' },
			'div.foo': { className: ' foo' },
			'div#xxx.foo': { id: 'xxx', className: ' foo' },
			'b.foo.bar': { tagName: 'B', className: ' foo bar' },
			'span#xxx.foo.bar': { tagName: 'SPAN', id: 'xxx', className: ' foo bar' },
			'#xxx': { id: 'xxx' },
			'#xxx.foo': { id: 'xxx', className: ' foo' },
			'#xxx.foo.bar': { id: 'xxx', className: ' foo bar' }
		}, function (data, selector) {
			elementEqual(Ply.dom.build(selector), data, selector);
		});
	});


	test('build({ })', function () {
		elementEqual(Ply.dom.build({
			id: 'baz',
			tag: 'input.foo',
			className: 'bar',
			ply: 'baz',
			'data-prop': 'qux'
		}), {
			id: 'baz',
			tagName: 'INPUT',
			className: 'bar foo',
			'data-ply': 'baz',
			'data-prop': 'qux'
		}, '{}');

		elementEqual(Ply.dom.build({ text: '<b>foo</b>' }), { innerHTML: '&lt;b&gt;foo&lt;/b&gt;' }, 'text');
		elementEqual(Ply.dom.build({ html: '<b>bar</b>' }), { innerHTML: '<b>bar</b>' }, 'html');
	});


	test('build(element)', function () {
		var el = Ply.dom.build(Ply.dom.build('b.foo'));
		elementEqual(el, { tagName: 'b', className: ' foo' });
	});


	test('build({ children: {} })', function () {
		var el = Ply.dom.build({
			tag: 'form',
			children: {
				'input': {
					type: 'password'
				},
				'hr': true,
				'br': false,
				'button': 'enter'
			}
		});

		equal(el.childNodes.length, 3);

		elementEqual(el, { tagName: 'form' });
		elementEqual(el.childNodes[0], { tagName: 'input', type: 'password' });
		elementEqual(el.childNodes[1], { tagName: 'hr' });
		elementEqual(el.childNodes[2], { tagName: 'button', innerHTML: 'enter' });
	});


	test('build({ children: [] })', function () {
		var el = Ply.dom.build({
			tag: 'form',
			children: [
				{
					tag: 'input',
					type: 'checkbox',
					disabled: true
				},
				{ tag: 'hr', skip: true },
				false && { tag: bar },
				{ tag: 'button', text: "enter" }
			]
		});

		equal(el.childNodes.length, 2);

		elementEqual(el, { tagName: 'form' });
		elementEqual(el.childNodes[0], { tagName: 'input', type: 'checkbox', disabled: true });
		elementEqual(el.childNodes[1], { tagName: 'button', innerHTML: 'enter' });
	});
	

	test('build({ children: el })', function () {
		var el = Ply.dom.build({
			children: Ply.dom.build({ tag: 'b', text: '!' })
		});

		elementEqual(el, { innerHTML: '<b>!</b>' });
	});
})(Ply);
