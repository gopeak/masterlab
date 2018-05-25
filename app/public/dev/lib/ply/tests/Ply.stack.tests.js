(function (Ply) {
	module('Ply.stack');

	function hasParent(el) {
		return !!(el && el.parentNode && el.parentNode.nodeType !== 11);
	}


	asyncTest('2x', function () {
		new Ply('foo', { effect: 'slide' }).open().then(function (foo) {
			new Ply('bar', { effect: 'fall' }).open().then(function (bar) {
				ok(!hasParent(foo.layerEl), 'foo.parent == null');
				ok(!hasParent(bar.overlayBoxEl), 'bar.parent == null');

				Ply.stack.last.close().then(function () {
					ok(hasParent(foo.layerEl), 'foo.parent != null');
					ok(hasParent(bar.overlayBoxEl), 'bar.parent != null');

					Ply.stack.last.close().then(function () {
						start();
					});
				});
			});
		});
	});
})(Ply);
