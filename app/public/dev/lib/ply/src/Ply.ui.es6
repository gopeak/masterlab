/*global define, Ply */
((factory) => {
	factory(Ply);
})((Ply) => {
	'use strict';


	var _plyAttr = Ply.attrName,
		noop = Ply.noop,
		_each = Ply.each,
		_extend = Ply.extend,
		_promise = Ply.promise,
		_buildDOM = Ply.dom.build,
		_appendChild = Ply.dom.append,
		_lang = Ply.lang,

		_toBlock = (block, name) => {
			if (block == null) {
				return { skip: true };
			}

			if (typeof block === 'string') {
				block = { text: block };
			}

			if (typeof block === 'object') {
				block.name = block.name || name;
			}

			return block;
		}
	;



	/**
	 * Управление рендером UI
	 * @param  {String}  name
	 * @param  {Object}  [data]
	 * @param  {String}  [path]
	 * @returns {HTMLElement}
	 */
	function ui(name, data, path) {
		var fn = ui[name], el;

		if (!fn) {
			name = name.split(/\s+/).slice(0, -1).join(' ');
			fn = data && (
					   ui[name + ' [name=' + data.name + ']']
					|| ui[name + ' [type=' + data.type + ']']
				)
				|| ui[name + ' *']
				|| ui[':default'];
		}

		el = _buildDOM(fn(data, path));
		if (data && data.name) {
			el.setAttribute(_plyAttr + '-name', data.name);
		}
		el.className += ' ply-ui';

		return el;
	}


	/**
	 * Назначение визуализатор
	 * @param {String}    name  имя фабрики
	 * @param {Function}  renderer
	 * @param {Boolean}  [simpleMode]
	 */
	ui.factory = function (name, renderer, simpleMode) {
		ui[name.replace(/^\s+|\s+$/g, '').replace(/\s+/g, ' ')] = function (data, path) {
			var fragment = document.createDocumentFragment();

			if ((data != null) || name === ':root') {
				data = simpleMode ? data : _toBlock(data);

				_each(simpleMode ? data : data.children, function (block, key) {
					var abs = ((path || name) + ' ' + key).replace(/^:\w+\s+/, '');
					var el = ui(abs, _toBlock(block, key), abs);

					_appendChild(fragment, el);
				});

				if (!simpleMode) {
					delete data.children;
				}

				var result = renderer(data, fragment);

				/* istanbul ignore else */
				if (!result.appendChild) {
					_extend(result, data);
				}

				return result;
			}

			return fragment;
		};
	};


	// Элемент по умолчанию
	ui.factory(':default', (data, children) => {
		data.children = children;
		return data;
	});


	// Ply-слой - корневой элемент
	ui.factory(':root', function (data) {
		return {
			tag: '.ply-form',
			className: data.mod,
			children: [
				ui(':header', data.header),
				ui(':content', data.content),
				data.ctrls && ui(':default', {
					tag: 'div.ply-footer',
					children: data.ctrls
				})
			]
		};
	});


	// «Заголовк» слоя
	ui.factory(':header', function (data, children) {
		return { tag: '.ply-header', text: data.text, children: children };
	});


	// «Содержимое» слоя
	ui.factory(':content', function (data, children) {
		return { tag: '.ply-content', children: children };
	}, true);


	// Кнопка «ОК»
	ui.factory('ok', function (data) {
		return {
			ply: ':ok',
			tag: 'button.ply-ctrl.ply-ok',
			text: data === true ? _lang.ok : data
		};
	});


	// Кнопка «Отмена»
	ui.factory('cancel', function (data) {
		return {
			ply: ':close',
			tag: 'button.ply-ctrl.ply-cancel',
			type: 'reset',
			text: data === true ? _lang.cancel : data
		};
	});


	/**
	 * Фабрика слоев
	 * @param {String}   name
	 * @param {Function} renderer
	 */
	function factory(name, renderer) {
		factory['_' + name] = renderer;

		factory[name] = (options, data) => {
			return _promise((resolve, reject) => {
				renderer(options, data, resolve, reject);
			}).then((el) => {
				/* istanbul ignore else */
				if (!el.appendChild) {
					el = ui(':root', el);
				}

				return el;
			});
		};
	}


	/**
	 * Использовать фабрику
	 * @param {String}   name
	 * @param {Object}   options
	 * @param {Object}   data
	 * @param {Function} resolve
	 * @param {Function} [reject]
	 */
	factory.use = (name, options, data, resolve, reject) => {
		factory['_' + name](options, data, resolve, reject);
	};


	/**
	 * Абстрактный диалог
	 * @param   {String}  mod  модификатор
	 * @param   {Object}  options
	 * @param   {Object}  data
	 * @param   {Object}  defaults
	 * @returns {Object}
	 * @private
	 */
	function _dialogFactory(mod, options, data, defaults) {
		options.mod = mod;
		options.effect = options.effect || 'slide';
		options.flags = _extend({ closeBtn: false }, options.flags);

		return {
			header: data.title,
			content: data.form
				? { 'dialog-form': { children: data.form } }
				: { el: data.text || data },
			ctrls: {
				ok: data.ok || defaults.ok,
				cancel: data.cancel || defaults.cancel
			}
		};
	}


	// Фабрика по умолчанию
	factory('default', (options, data, resolve) => {
		resolve(data || /* istanbul ignore next */ {});
	});


	// Диалог: «Предупреждение»
	factory('alert', (options, data, resolve) => {
		resolve(_dialogFactory('alert', options, data, { ok: true }));
	});


	// Диалог: «Подтверждение»
	factory('confirm', (options, data, resolve) => {
		resolve(_dialogFactory('confirm', options, data, {
			ok: true,
			cancel: true
		}));
	});


	// Диалог: «Запросить данные»
	factory('prompt', (options, data, resolve) => {
		resolve(_dialogFactory('prompt', options, data, {
			ok: true,
			cancel: true
		}));
	});


	// Элемент формы
	ui.factory('dialog-form *', (data) => {
		return {
			tag: 'input.ply-input',
			type: data.type || 'text',
			name: data.name,
			value: data.value,
			required: true,
			placeholder: data.hint || data.text
		};
	});


	/**
	 * Создать Ply-слой на основе фабрики
	 * @param   {String}  name       название фабрики
	 * @param   {Object}  [options]  опции
	 * @param   {Object}  [data]     данные для фабрики
	 * @returns {Promise}
	 */
	Ply.create = (name, options, data) => {
		if (!data) {
			data = options;
			options = {};
		}

		var renderer = (factory[name] || factory['default']);
		return renderer(options, data).then((el) => {
			return new Ply(_extend(options, { el: el }));
		});
	};


	/**
	 * Открыть Ply-слой
	 * @param   {String}  name
	 * @param   {Object}  [options]
	 * @param   {Object}  [data]
	 * @returns {Promise}
	 */
	Ply.open = (name, options, data) => {
		return Ply.create(name, options, data).then((layer) => {
			return layer.open();
		});
	};


	/**
	 * Создать диалог или систему диалогов
	 * @param   {String|Object}  name
	 * @param   {Object}         [options]
	 * @param   {Object}         [data]
	 * @returns {Promise}
	 */
	Ply.dialog = (name, options, data) => {
		if (name instanceof Object) {
			options = options || /* istanbul ignore next */ {};

			return _promise((resolve, reject) => {
				var first = options.initState,
					current,
					rootLayer,
					interactive,
					stack = name,
					dialogs = {},

					_progress = (ui, layer) => {
						(options.progress || /* istanbul ignore next */ noop)(_extend({
							name:		current.$name,
							index:		current.$index,
							length:		length,
							stack:		stack,
							current:	current,
							layer:		layer
						}, ui), dialogs);
					},

					changeLayer = (spec, effect, callback) => {
						// Клонирование данных
						var data = JSON.parse(JSON.stringify(spec.data));

						current = spec; // текущий диалог
						interactive = true; // идет анимация
						(spec.prepare || noop)(data, dialogs);

						Ply.create(spec.ui || 'alert', spec.options || {}, data).then((layer) => {
							var promise;

							if (rootLayer) {
								promise = rootLayer[/^inner/.test(effect) ? 'innerSwap' : 'swap'](layer, effect);
							} else {
								rootLayer = layer;
								promise = rootLayer.open();
							}

							promise.then(() => {
								dialogs[spec.$name].el = rootLayer.layerEl;
								interactive = false;
							});

							callback(rootLayer);
						});
					}
				;


				var length = 0;
				_each(stack, (spec, key) => {
					first = first || key;
					spec.effects = spec.effects || {};
					spec.$name   = key;
					spec.$index  = length++;
					dialogs[key] = new Ply.Context();
				});
				stack.$length = length;


				changeLayer(stack[first], null, (layer) => {
					_progress({}, layer);

					//noinspection FunctionWithInconsistentReturnsJS
					rootLayer.options.callback = (ui) => {
						if (interactive) {
							return false;
						}

						var isNext = ui.state || (current.back === 'next'),
							swap = stack[current[isNext ? 'next' : 'back']]
						;

//						console.log(current.$name, stack[current[isNext ? 'next' : 'back']]);

						if (swap) {
							changeLayer(swap, current[isNext ? 'nextEffect' : 'backEffect'], (layer) => {
								_progress(ui, layer);
							});

							return false;
						} else {
							(ui.state ? resolve : /* istanbul ignore next */ reject)(ui, dialogs);
						}
					};
				});
			});
		}
		else {
			if (!data) {
				data = options || {};
				options = {};
			}

			return Ply.open(name, options, data).then((layer) => {
				return _promise((resolve) => {
					layer.options.callback = resolve;
				});
			});
		}
	};


	// Export
	Ply.ui = ui;
	Ply.factory = factory;
});
