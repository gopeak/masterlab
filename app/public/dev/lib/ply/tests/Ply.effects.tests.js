(function (Ply) {
	module('Ply.effects');


	test('core', function () {
		Ply.effects.defaults = { duration: 300, open: {}, close: {} };


		deepEqual(Ply.effects.get(), {
			open: {
				layer: { duration: 300 },
				overlay: { duration: 300 }
			},
			close: {
				layer: { duration: 300 },
				overlay: { duration: 300 }
			},
			duration: 300
		}, 'def');


		deepEqual(Ply.effects.get(['fade-in', 'fade-out']), {
			open: {
				layer: { name: 'fade-in', duration: 300 },
				overlay: { name: 'fade-in', duration: 300 }
			},
			close: {
				layer: { name: 'fade-out', duration: 300 },
				overlay: { name: 'fade-out', duration: 300 }
			},
			duration: 300
		}, "['fade-in', 'fade-out']");


		deepEqual(Ply.effects.get(['fade-in', 'fade-out:100']), {
			open: {
				layer: { name: 'fade-in', duration: 300 },
				overlay: { name: 'fade-in', duration: 300 }
			},
			close: {
				layer: { name: 'fade-out', duration: 100 },
				overlay: { name: 'fade-out', duration: 100 }
			},
			duration: 300
		}, "['fade-in', 'fade-out:100']");


		deepEqual(Ply.effects.get('fade:100'), {
			open: {
				layer: { name: 'fade-in', duration: 100 * 0.8 },
				overlay: { name: 'fade-in', duration: 100 }
			},
			close: {
				layer: { name: 'fade-out', duration: 100 * 0.6 },
				overlay: { name: 'fade-out', duration: 100 * 0.6 }
			},
			duration: 100
		}, 'fade:100');


		deepEqual(Ply.effects.get({
			open: 'slide-in',
			close: 'slide-out'
		}), {
			open: {
				layer: { name: 'slide-in', duration: 300 },
				overlay: { duration: 300 }
			},
			close: {
				layer: { name: 'slide-out', duration: 300 },
				overlay: { duration: 300 }
			},
			duration: 300
		}, 'slide-in-out');



		Ply.effects.setup({ open: 'fade-in' });


		deepEqual(Ply.effects.get(), {
			open: {
				layer: { name: 'fade-in', duration: 300 },
				overlay: { duration: 300 }
			},
			close: {
				layer: { duration: 300 },
				overlay: { duration: 300 }
			},
			duration: 300
		}, 'open.fade-in');


		Ply.effects.setup({ open: { overlay: 'fade-in' } });


		deepEqual(Ply.effects.get({
			open: 'slide-in',
			close: 'slide-out'
		}), {
			open: {
				layer: { name: 'slide-in', duration: 300 },
				overlay: { name: 'fade-in', duration: 300 }
			},
			close: {
				layer: { name: 'slide-out', duration: 300 },
				overlay: { duration: 300 }
			},
			duration: 300
		});


		Ply.effects.setup('fade:400');


		deepEqual(Ply.effects.get({
			open: 'slide-in',
			close: 'slide-out'
		}), {
			open: {
				layer: { name: 'slide-in', duration: 400 },
				overlay: { name: 'fade-in', duration: 400 }
			},
			close: {
				layer: { name: 'slide-out', duration: 400 },
				overlay: { name: 'fade-out', duration: 400 * 0.6 }
			},
			duration: 400
		}, 'fade:400');
	});


	test('effects:args', function () {
		Ply.effects.defaults = { duration: 300, open: {}, close: {} };

		deepEqual(Ply.effects.get('scale[0.5,0.3]'), {
			open: {
				args: 0.5,
				layer: { name: 'scale-in', duration: 300 },
				overlay: { name: 'fade-in', duration: 300 }
			},
			close: {
				args: 0.3,
				layer: { name: 'scale-out', duration: 300 },
				overlay: { name: 'fade-out', duration: 300 }
			},
			duration: 300
		});


		deepEqual(Ply.effects.get(['scale["foo"]', 'fall[{"bar":"baz"}]']), {
			open: {
				args: 'foo',
				layer: { name: 'scale-in', duration: 300 },
				overlay: { name: 'fade-in', duration: 300 }
			},
			close: {
				args: {bar:'baz'},
				layer: { name: 'fall-out', duration: 300 },
				overlay: { name: 'fade-out', duration: 300 }
			},
			duration: 300
		});
	});


	test('stress', function () {
		try {
			Ply.effects.get(null);
			Ply.effects.get(void 0);
			Ply.effects.get(Math.random());
			Ply.effects.get('---');
			Ply.effects.get(123);
			Ply.effects.get('\n');
			Ply.effects.get([null, null]);
			Ply.effects.get([void 0, void 0]);
			Ply.effects.get(['\n', '\t']);
			ok(true);
		} catch (err) {
			equal([err, err.stack], null);
		}
	});


	promiseTest('fade', function () {
		var log = { open: [], close: [] },
			type = 'open',
			pid, i,
			layer = new Ply('fade', { effect: 'fade' })
		;

		pid = setInterval(function () {
			log[type].push( parseFloat(Ply.css(layer.overlayEl, 'opacity')) );
		}, 50);

		return layer.open().then(function () {
			type = 'close';
			ok(layer.layerEl.offsetHeight > 0, '> 0');
			return layer.close();
		}).then(function () {
			ok(layer.layerEl.offsetHeight == 0, '== 0');
			if (Ply.support.transition) {
				ok(log.open.length > 2, 'open');
				ok(log.close.length > 2, 'close');

				for (i = 1; i < log.open.length; i++) {
					if (log.open[i] < log.open[i-1]) {
						equal(log.open, null, 'open: ' + i);
						break;
					}
				}

				for (i = 1; i < log.close.length; i++) {
					if (log.close[i] > log.close[i-1]) {
						equal(log.close, null, 'close: ' + i);
						break;
					}
				}
			}

			clearInterval(pid);
		});
	});


	promiseTest('other', function () {
		expect(0);

		var queue = Ply.promise(function (resolve) { resolve() });

		Ply.each('scale fall slide 3d-flip 3d-sign'.split(' '), function (name) {
			queue = queue.then(function () {
				return new Ply(name, { effect: name + ':50' }).open().then(function (layer) {
					return layer.close();
				});
			});
		});

		return queue;
	});
})(Ply);
