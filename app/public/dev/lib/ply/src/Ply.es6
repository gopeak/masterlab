/**
 * @author   RubaXa  <trash@rubaxa.org>
 * @licence  MIT
 * Обязательно нужен JSON и Promise
 */

/*global define, window */
((factory) => {
	window['Ply'] = factory(window);
})((window) => {
	'use strict';


	var gid = 1,
		noop = (() => {}),

		document = window.document,
		setTimeout = window.setTimeout,

		$ = window.jQuery
				|| /* istanbul ignore next */ window.Zepto
				|| /* istanbul ignore next */ window.ender
				|| /* istanbul ignore next */ window.$,

		Promise = window.Promise,


		/**
		 * Разбор строки "tag#id.foo.bar"
		 * @const {RegExp}
		 */
		R_SELECTOR = /^(\w+)?(#\w+)?((?:\.[\w_-]+)*)/i,


		/**
		 * Поддерживаемые css-свойства
		 * @type {Object}
		 */
		support = (() => {
			var props = {},
				style = _buildDOM().style,
				names = 'opacity transition transform perspective transformStyle transformOrigin backfaceVisibility'.split(' '),
				prefix = ['Webkit', 'Moz', 'O', 'MS']
			;

			_each(names, (name, i) => {
				props[name] = (name in style) && /* istanbul ignore next */ name;

				/* istanbul ignore else */
				if (!props[name]) {
					for (i = 0; i < 4; i++) {
						var pname = prefix[i] + name.charAt(0).toUpperCase() + name.substr(1);
						/* istanbul ignore else */
						if (props[name] = (pname in style) && pname) {
							break;
						}
					}
				}
			});

			return props;
		})(),


		/**
		 * Коды кнопок
		 * @type {Object}
		 */
		keys = {
			esc: 27
		},


		/**
		 * Хуки для css
		 * @type {Object}
		 */
		_cssHooks = {
		},

		array_core = [],
		array_push = array_core.push,
		array_splice = array_core.splice,

		_plyAttr = 'data-ply',

		_resolvedPromise = _promise((resolve) => resolve())
	;


	//
	//           Определяем css-хуки
	//
	if (!support.opacity) {
		_cssHooks.opacity = function (style, value) {
			style.zoom = 1;
			style.filter = 'alpha(opacity=' + (value * 100) + ')';
		};
	}


	//
	//           Вспомогательные методы
	//


	/**
	 * Функция?
	 * @param   {*}  fn
	 * @returns {Boolean}
	 */
	function isFn(fn) {
		return typeof fn === 'function';
	}


	/**
	 * Создать «Обещание»
	 * @param   {Function}  executor
	 * @returns {Promise}
	 * @private
	 */
	function _promise(executor) {
		/* istanbul ignore if */
		if (Promise) {
			return new Promise(executor);
		} else {
			var dfd = $.Deferred();
			executor(dfd.resolve, dfd.reject);
			return dfd;
		}
	}


	/**
	 * Дождаться разрешения всех «Обещаний»
	 * @param   {Promise[]}  iterable
	 * @returns {Promise}
	 * @private
	 */
	function _promiseAll(iterable) {
		// @todo: Поткрыть тестами `Promise.all`
		return Promise
			? /* istanbul ignore next */ Promise.all(iterable)
			: $.when.apply($, iterable);
	}


	/**
	 * Выполнить действие в следующем тике
	 * @param   {Function}  fn
	 * @returns {Function}
	 * @private
	 */
	function _nextTick(fn) {
		return () => {
			setTimeout(fn, 1);
		};
	}


	/**
	 * Object iterator
	 * @param  {Object|Array}  obj
	 * @param  {Function}      iterator
	 * @private
	 */
	function _each(obj, iterator) {
		if (obj) {
			for (var key in obj) {
				/* istanbul ignore else */
				if (obj.hasOwnProperty(key)) {
					iterator(obj[key], key, obj);
				}
			}
		}
	}


	/**
	 * Глубокое клонирование
	 * @param   {*} obj
	 * @returns {*}
	 * @private
	 */
	function _deepClone(obj) {
		var result = {};

		_each(obj, (val, key) => {
			if (isFn(val)) {
				result[key] = val;
			}
			else if (val instanceof Object) {
				result[key] = _deepClone(val);
			}
			else {
				result[key] = val;
			}
		});

		return result;
	}


	/**
	 * Перенос свойств одного объект к другому
	 * @param   {Object}     dst
	 * @param   {...Object}  src
	 * @returns {Object}
	 * @private
	 */
	function _extend(dst, ...src) {
		var i = 0, n = src.length;
		for (; i < n; i++) {
			_each(src[i], (val, key) => {
				dst[key] = val;
			});
		}

		return dst;
	}


	/**
	 * Выбрать элементы по заданному селектору
	 * @param   {String}       selector
	 * @param   {HTMLElement}  [ctx]
	 * @returns {HTMLElement}
	 */
	function _querySelector(selector, ctx) {
		try {
			return (ctx || document).querySelector(selector);
		} catch (err) {
			/* istanbul ignore next */
			return $(selector, ctx)[0];
		}
	}


	/**
	 * Найти элементы по имени
	 * @param   {HTMLElement}  el
	 * @param   {String}       name
	 * @returns {NodeList}
	 */
	function _getElementsByTagName(el, name) {
		return el.getElementsByTagName(name);
	}


	/**
	 * Присоединить элемент
	 * @param  {HTMLElement}  parent
	 * @param  {HTMLElement}  el
	 * @private
	 */
	function _appendChild(parent, el) {
		try {
			parent && el && parent.appendChild(el);
		} catch (e) {}
	}


	/**
	 * Удалить элемент
	 * @param  {HTMLElement}  el
	 * @private
	 */
	function _removeElement(el) {
		/* istanbul ignore else */
		if (el && el.parentNode) {
			el.parentNode.removeChild(el);
		}
	}


	/**
	 * Добавить слуашетеля
	 * @param    {HTMLElement}  el
	 * @param    {String}   name
	 * @param    {Function} fn
	 * @private
	 */
	function _addEvent(el, name, fn) {
		var handle = fn.handle = fn.handle || ((evt) => {
			/* istanbul ignore if */
			if (!evt.target) {
				evt.target = evt.srcElement || document;
			}

			/* istanbul ignore if */
			if (evt.target.nodeType === 3) {
				evt.target = evt.target.parentNode;
			}

			/* istanbul ignore if */
			if (!evt.preventDefault) {
				evt.preventDefault = () => {
					evt.returnValue = false;
				};
			}

			/* istanbul ignore if */
			if (!evt.stopPropagation) {
				evt.stopPropagation = () => {
					evt.cancelBubble = true;
				};
			}

			fn.call(el, evt);
		});

		/* istanbul ignore else */
		if (el.addEventListener) {
			el.addEventListener(name, handle, false);
		} else {
			el.attachEvent('on' + name, handle);
		}
	}


	/**
	 * Удалить слуашетеля
	 * @param    {HTMLElement}  el
	 * @param    {String}   name
	 * @param    {Function} fn
	 * @private
	 */
	function _removeEvent(el, name, fn) {
		var handle = fn.handle;
		if (handle) {
			/* istanbul ignore else */
			if (el.removeEventListener) {
				el.removeEventListener(name, handle, false);
			} else {
				el.detachEvent('on' + name, handle);
			}
		}
	}


	/**
	 * Установка или получение css свойства
	 * @param   {HTMLElement}    el
	 * @param   {Object|String}  prop
	 * @param   {String}         [val]
	 * @returns {*}
	 * @private
	 */
	function _css(el, prop, val) {
		if (el && el.style && prop) {
			if (prop instanceof Object) {
				for (var name in prop) {
					_css(el, name, prop[name]);
				}
			}
			else if (val === void 0) {
				/* istanbul ignore else */
				if (document.defaultView && document.defaultView.getComputedStyle) {
					val = document.defaultView.getComputedStyle(el, '');
				}
				else if (el.currentStyle) {
					val = el.currentStyle;
				}

				return prop === void 0 ? val : val[prop];
			} else if (_cssHooks[prop]) {
				_cssHooks[prop](el.style, val);
			} else {
				el.style[support[prop] || prop] = val;
			}
		}
	}


	/**
	 * Создание DOM структуры по спецификации
	 * @param   {String|Object|HTMLElement}  [spec]
	 * @returns {HTMLElement}
	 * @private
	 */
	function _buildDOM(spec) {
		if (spec == null) {
			spec = 'div';
		}

		if (spec.appendChild) {
			return spec;
		}
		else if (spec.skip) {
			return document.createDocumentFragment();
		}

		if (typeof spec === 'string') { // selector
			spec = { tag: spec };
		}

		var el,
			children = spec.children,
			selector = R_SELECTOR.exec(spec.tag || '')
		;

		// Это нам больше не нужно
		delete spec.children;

		// Разбираем селектор
		spec.tag = selector[1] || 'div';
		spec.id = spec.id || (selector[2] || '').substr(1);

		// Собираем className
		selector = (selector[3] || '').split('.');
		selector[0] = (spec.className || '');
		spec.className = selector.join(' ');

		// Создаем элемент, теперь можно
		el  = document.createElement(spec.tag);
		delete spec.tag;

		// Определяем свойсва
		_each(spec, (value, name) => {
			if (value) {
				if (name === 'css') {
					// Определяем CSS свойства
					_css(el, spec.css);
				}
				else if (name === 'text') {
					(value != null) && _appendChild(el, document.createTextNode(value));
				}
				else if (name === 'html') {
					(value != null) && (el.innerHTML = value);
				}
				else if (name === 'ply') {
					// Ply-аттрибут
					el.setAttribute(_plyAttr, value);
				}
				else if (name in el) {
					try {
						el[name] = value;
					} catch (e) {
						el.setAttribute(name, value);
					}
				}
				else if (/^data-/.test(name)) {
					el.setAttribute(name, value);
				}
			}
		});

		// Детишки
		if (children && children.appendChild) {
			_appendChild(el, children);
		}
		else {
			_each(children, (spec, selector) => {
				if (spec) {
					if (typeof spec === 'string') {
						spec = { text: spec };
					}
					else if (typeof spec !== 'object') {
						spec = {};
					}

					/* istanbul ignore else */
					if (typeof selector === 'string') {
						spec.tag = spec.tag || selector;
					}

					_appendChild(el, _buildDOM(spec));
				}
			});
		}

		return el;
	}


	/**
	 * Выбрать первый не заполненый элемент
	 * @param   {HTMLElement}  parentNode
	 * @private
	 */
	function _autoFocus(parentNode) {
		var items = _getElementsByTagName(parentNode, 'input'),
			i = 0,
			n = items.length,
			el,
			element
		;

		for (; i < n; i++) {
			el = items[i];

			/* istanbul ignore else */
			if (el.type === 'submit') {
				!element && (element = el);
			}
			else if (!/hidden|check|radio/.test(el.type) && el.value == '') {
				element = el;
				break;
			}
		}

		if (!element) {
			element = _getElementsByTagName(parentNode, 'button')[0];
		}

		try { element.focus(); } catch (err) { }
	}


	/**
	 * Предзагрузить все изображения
	 * @param   {HTMLElement}  parentNode
	 * @returns {Promise}
	 * @private
	 */
	function _preloadImage(parentNode) {
		_loading(true);

		return _promise((resolve) => {
			var items = _getElementsByTagName(parentNode, 'img'),
				i = items.length,
				queue = i,
				img,
				complete = () => {
					/* istanbul ignore else */
					if (--queue <= 0) {
						i = items.length;
						while (i--) {
							img = items[i];
							_removeEvent(img, 'load', complete);
							_removeEvent(img, 'error', complete);
						}
						_loading(false);
						resolve();
					}
				}
			;

			while (i--) {
				img = items[i];
				if (img.complete) {
					queue--;
				} else {
					_addEvent(img, 'load', complete);
					_addEvent(img, 'error', complete);
				}
			}

			!queue && complete();
		});
	}


	/**
	 * «Загрузка»
	 * @param  {Boolean}  state
	 * @private
	 */
	function _loading(state) {
		var el = _loading.get();

		clearTimeout(_loading.pid);
		if (state) {
			_loading.pid = setTimeout(() => {
				_appendChild(document.body, el);
			}, 100);
		} else {
			_loading.pid = setTimeout(() => {
				_removeElement(el);
			}, 100);
		}
	}


	/**
	 * Получить ссылку на элемент loading
	 * @returns {HTMLElement}
	 */
	_loading.get = () => {
		return _loading.el || (_loading.el = _buildDOM({ tag: '.ply-loading', children: { '.ply-loading-spinner': true } }));
	};


	/**
	 * Создать слой с контентом
	 * @param   {HTMLElement} contentEl
	 * @param   {Object}      options
	 * @returns {HTMLElement}
	 * @private
	 */
	function _createLayer(contentEl, options) {
		return _buildDOM({
			css: {
				padding: '20px 20px 40px', // Сницу в два раза больше, так лучше
				display: 'inline-block',
				position: 'relative',
				textAlign: 'left',
				whiteSpace: 'normal',
				verticalAlign: 'middle',
				transform: 'translate3d(0, 0, 0)'
			},
			children: options.baseHtml ? [{
				ply: ':layer',
				tag: '.ply-layer',
				className: options.mod,
				css: _extend({
					overflow: 'hidden',
					position: 'relative',
					backfaceVisibility: 'hidden'
				}, options.layer),
				children: [options.flags.closeBtn && {
					ply: ':close',
					tag: '.ply-x',
					text: Ply.lang.cross
				}, {
					tag: '.ply-inside',
					children: contentEl
				}]
			}] : contentEl
		});
	}


	/**
	 * Создать затемнение
	 * @param   {Object}   style
	 * @returns {HTMLElement}
	 * @private
	 */
	function _createOverlay(style) {
		return _buildDOM({
			ply: ':overlay',
			tag: '.ply-overlay',
			css: {
				top: 0,
				left: 0,
				right: 0,
				bottom: 0,
				position: 'fixed'
			},
			children: [{ tag: 'div', css: _extend({ width: '100%', height: '100%' }, style) }]
		});
	}


	/**
	 * Создать ply—объвязку
	 * @param   {Object}   target
	 * @param   {Object}   options
	 * @param   {Boolean}  [onlyLayer]
	 * @returns {Object}
	 * @private
	 */
	function _createPly(target, options, onlyLayer) {
		// Корневой слой
		target.wrapEl = _buildDOM({
			tag: 'form',
			css: { whiteSpace: 'nowrap', zIndex: options.zIndex }
		});


		// Затемнение
		if (!onlyLayer) {
			target.overlayEl = _createOverlay(options.overlay);
			target.overlayBoxEl = target.overlayEl.firstChild;
			_appendChild(target.wrapEl, target.overlayEl);
		}


		// Пустышка для центрирования по вертикали
		var dummyEl = _buildDOM();
		_css(dummyEl, {
			height: '100%',
			display: 'inline-block',
			verticalAlign: 'middle'
		});
		_appendChild(target.wrapEl, dummyEl);


		// Контент
		var el = options.el;
		target.el = (el && el.cloneNode) ? el.cloneNode(true) : _buildDOM({ html: el || '' });


		// Содержит контент
		target.layerEl = _createLayer(target.el, options);
		target.contentEl = _getContentEl(target.layerEl);
		target.context = new Context(target.layerEl);

		_appendChild(target.wrapEl, target.layerEl);


		// Родительский элемент
		target.bodyEl = options.body && _querySelector(options.body) || document.body;


		target.wrapEl.tabIndex = -1; // для фокуса
		_css(target.wrapEl, {
			top: 0,
			left: 0,
			right: 0,
			bottom: 0,
			position: 'fixed',
			textAlign: 'center',
			overflow: 'auto',
			outline: 0
		});

		return target;
	}


	/**
	 * Получить ссылку на контент
	 * @param   {HTMLElement}  layerEl
	 * @returns {HTMLElement}
	 * @private
	 */
	function _getContentEl(layerEl) {
		return layerEl.firstChild.lastChild.firstChild;
	}



	//
	//       Настройки по умолчанию
	//
	var _defaults = {
		zIndex: 10000,

		layer: {}, // css

		overlay: {
			opacity: .6,
			backgroundColor: 'rgb(0, 0, 0)'
		},

		flags: {
			closeBtn: true,
			bodyScroll: false,
			closeByEsc: true,
			closeByOverlay: true,
			hideLayerInStack: true,
			visibleOverlayInStack: false
		},

		baseHtml: true,

		// Callback's
		init: noop,
		open: noop,
		close: noop,
		destroy: noop,
		callback: noop
	};




	//
	//       Основной код
	//




	/**
	 * @class   Ply
	 * @param   {HTMLElement|Object}   el  слой или опции
	 * @param   {Object}               [options]   опции слоя
	 */
	function Ply(el, options) {
		options = (el instanceof Object) ? el : (options || {});
		options.el = options.el || el;


		var _this = this;

		// Локальный идентификатор
		_this.cid = 'c' + gid++;


		// Увеличиваем глобальный zIndex
		_defaults.zIndex++;


		// Опции
		_this.options = options = _extend({}, _defaults, options);


		// Флаги
		options.flags = _extend({}, _defaults.flags, options.flags);


		// Создаем Ply-элементы
		_createPly(_this, options);


		// Установим эффекты
		_this.setEffect(options.effect);


		// Очередь эффектов
		_this.fx = (executor) => {
			/* jshint boss:true */
			return !(_this.fx.queue = _this.fx.queue.then(executor, executor).then(() => {
				return _this;
			}));
		};
		_this.fx.queue = _resolvedPromise;


		// Клик по затемнению
		_this.on('click', ':overlay', () => {
			_this.hasFlag('closeByOverlay') && _this.closeBy('overlay');
		});


		// Подписываемся кнопку «отмена» и «крестик»
		_this.on('click', ':close', (evt, el) => {
			evt.preventDefault();
			_this.closeBy(el.nodeName === 'BUTTON' ? 'cancel' : 'x');
		});


		// Событие инициализации
		_this.options.init(this);
	}


	// Методы
	Ply.fn = Ply.prototype = /** @lends Ply.prototype */ {
		constructor: Ply,


		/** @private */
		_activate: function () {
			if (!this.hasFlag('bodyScroll')) {
				var bodyEl = this.bodyEl,
					dummyEl = _buildDOM({
						css: { overflow: 'scroll', visibility: 'hidden' },
						children: [{ tag: 'div' }]
					})
				;

				// @todo: Покрыть тестами
				// Сохраняем оригинальные значения
				this.__overflow = _css(bodyEl, 'overflow');
				this.__paddingRight = _css(bodyEl, 'paddingRight');

				_appendChild(bodyEl, dummyEl);
				_css(bodyEl, {
					overflow: 'hidden',
					paddingRight: (dummyEl.offsetWidth - dummyEl.firstChild.offsetWidth) + 'px'
				});
				_removeElement(dummyEl);
			}

			_addEvent(this.wrapEl, 'submit', this._getHandleEvent('submit'));
		},


		/** @private */
		_deactivate: function () {
			if (!this.hasFlag('bodyScroll')) {
				_css(this.bodyEl, {
					overflow: this.__overflow,
					paddingRight: this.__paddingRight
				});
			}

			_removeEvent(this.layerEl, 'submit', this._getHandleEvent('submit'));
		},


		/**
		 * Получить обработчик события
		 * @param   {String}  name  событие
		 * @returns {*}
		 * @private
		 */
		_getHandleEvent: function (name) {
			var _this = this,
				handleEvent = _this.__handleEvent || (_this.__handleEvent = {})
			;

			if (!handleEvent[name]) {
				handleEvent[name] = (evt) => {
					_this._handleEvent(name, evt);
				};
			}

			return handleEvent[name];
		},


		/**
		 * Центральный обработчик события
		 * @param   {String}  name
		 * @param   {Event}   evt
		 * @private
		 */
		_handleEvent: function (name, evt) {
			evt.preventDefault();
			this.closeBy(name);
		},


		/**
		 * Применить эффект к элементу
		 * @param   {HTMLElement}    el
		 * @param   {String}         name
		 * @param   {String|Object}  [effects]
		 * @returns {Promise}
		 */
		applyEffect: function (el, name, effects) {
			el = this[el] || el;

			if (!el.nodeType) {
				effects = name;
				name = el;
				el = this.layerEl;
			}

			effects = Ply.effects.get(effects || this.effects);
			return Ply.effects.apply.call(effects, el, name);
		},


		/**
		 * Закрыть «по»
		 * @param  {String}  name  прчина закрытия
		 */
		closeBy: function (name) {
			var result = this.options.callback({
				by: name,
				state: name === 'submit',
				layer: this,
				context: this.context
			});

			if (result !== false) {
				this.close();
			}
		},


		/**
		 * Подписаться на ply-событие
		 * @param   {String}    event   событие
		 * @param   {String}    target  ply-selector
		 * @param   {Function}  handle
		 * @returns {Ply}
		 */
		on: function (event, target, handle) {
			var _this = this;

			if (!handle) {
				handle = target;
				target = ':layer';
			}

			handle['_' + target] = (evt) => {
				var el = evt.target;
				do {
					if (el.nodeType === 1) {
						if (el.getAttribute(_plyAttr) === target) {
							return handle.call(_this, evt, el);
						}
					}
				}
				while ((el !== _this.wrapEl) && (el = el.parentNode));
			};

			_addEvent(_this.wrapEl, event, handle['_' + target]);
			return _this;
		},


		/**
		 * Отписаться от ply-событие
		 * @param   {String}    event   событие
		 * @param   {String}    target  ply-selector
		 * @param   {Function}  handle
		 * @returns {Ply}
		 */
		off: function (event, target, handle) {
			if (!handle) {
				handle = target;
				target = 'layer';
			}

			_removeEvent(this.wrapEl, event, handle['_' + target] || noop);
			return this;
		},


		/**
		 * Проверить наличие флага
		 * @param   {String}  name  имя флага
		 * @returns {Boolean}
		 */
		hasFlag: function (name) {
			return !!this.options.flags[name];
		},


		/**
		 * Установить effect
		 * @param   {String|Object}  name
		 * @returns {Ply}
		 */
		setEffect: function (name) {
			this.effects = Ply.effects.get(name);
			return this;
		},


		/**
		 * Открыть/закрыть слой
		 * @param   {Boolean}  state
		 * @param   {*}  effect
		 * @returns {Promise}
		 * @private
		 */
		_toggleState: function (state, effect) {
			var _this = this,
				mode = state ? 'open' : 'close',
				prevLayer = Ply.stack.last
			;

			/* istanbul ignore else */
			if (_this.visible != state) {
				_this.visible = state;
				_this[state ? '_activate' : '_deactivate']();

				// Добавить или удалить слой из стека
				Ply.stack[state ? 'add' : 'remove'](_this);

				// Очередь эффектов
				_this.fx(() => {
					return _preloadImage(_this.wrapEl).then(() => {
						var isFirst = Ply.stack.length === (state ? 1 : 0),
							hideLayer = prevLayer && prevLayer.hasFlag('hideLayerInStack'),
							hasOverlay = isFirst || _this.hasFlag('visibleOverlayInStack');

						if (state) {
							// Убрать «затемнение» если мы не первые в стеке
							!hasOverlay && _removeElement(_this.overlayBoxEl);

							_appendChild(_this.bodyEl, _this.wrapEl);
							_this.wrapEl.focus();
							_autoFocus(_this.layerEl);

							if (hideLayer) {
								// Скрыть слой «под»
								prevLayer.applyEffect('close.layer', effect).then(() => {
									_removeElement(prevLayer.layerEl);
								});
							}
						} else if (prevLayer = Ply.stack.last) {
							// Слой мог быть скрыт, нужно вернуть его
							_appendChild(prevLayer.wrapEl, prevLayer.layerEl);
							prevLayer.hasFlag('hideLayerInStack') && prevLayer.applyEffect('open.layer', effect);
						}

						// Применяем основные эффекты
						return _promiseAll([
							_this.applyEffect(mode + '.layer', effect),
							hasOverlay && _this.applyEffect('overlayEl', mode + '.overlay', effect)
						]).then(() => {
							if (!state) {
								_removeElement(_this.wrapEl);
								_appendChild(_this.overlayEl, _this.overlayBoxEl);
							}
							_this.options[mode](_this);
						});
					});
				});
			}

			return _this.fx.queue;
		},


		/**
		 * Открыть слой
		 * @param   {*}  [effect]
		 * @returns {Promise}
		 */
		open: function (effect) {
			return this._toggleState(true, effect);
		},


		/**
		 * Закрыть слой
		 * @param   {*}  [effect]
		 * @returns {Promise}
		 */
		close: function (effect) {
			return this._toggleState(false, effect);
		},


		/**
		 * @param   {HTMLElement}  closeEl
		 * @param   {HTMLElement}  openEl
		 * @param   {Object}    effects
		 * @param   {Function}  prepare
		 * @param   {Function}  [complete]
		 * @returns {*}
		 * @private
		 */
		_swap: function (closeEl, openEl, effects, prepare, complete) {
			var _this = this;

			if (_this.visible) {
				_this.fx(() => {
					return _preloadImage(openEl).then(() => {
						prepare();

						return _promiseAll([
							_this.applyEffect(closeEl, 'close.layer', effects),
							_this.applyEffect(openEl, 'open.layer', effects)
						]).then(() => {
							_removeElement(closeEl);
							complete();
							_this.wrapEl.focus();
							_autoFocus(openEl);
						});
					});
				});
			} else {
				complete();
			}

			return _this.fx.queue;
		},


		/**
		 * Заменить слой
		 * @param   {Object}  options
		 * @param   {Object}  [effect]  эффект замены
		 * @returns {Promise}
		 */
		swap: function (options, effect) {
			options = _extend({}, this.options, options);

			var _this = this,
				ply = _createPly({}, options, true),
				effects = (effect || options.effect) ? Ply.effects.get(effect || options.effect) : _this.effects,
				closeEl = _this.layerEl,
				openEl = ply.layerEl
			;

			return _this._swap(closeEl, openEl, effects,
				() => {
					_appendChild(_this.bodyEl, _this.wrapEl);
					_appendChild(_this.bodyEl, ply.wrapEl);
				},
				() => {
					_removeElement(ply.wrapEl);
					_appendChild(_this.wrapEl, openEl);

					_this.el = ply.el;
					_this.layerEl = openEl;
					_this.contentEl = _getContentEl(openEl);
					_this.context.el = openEl;
				})
			;
		},


		/**
		 * Заменить внутренности слоя
		 * @param   {Object}  options
		 * @param   {Object}  [effect]  эффект замены
		 * @returns {Promise}
		 */
		innerSwap: function (options, effect) {
			options = _extend({}, this.options, options);

			var _this = this,
				ply = _createPly({}, options, true),
				effects = (effect || options.effect) ? Ply.effects.get(effect || options.effect) : _this.effects,

				inEl = _querySelector('.ply-inside', ply.layerEl),
				outEl = _querySelector('.ply-inside', _this.layerEl)
			;

			return _this._swap(outEl, inEl, effects, () => {
				_css(outEl, { width: outEl.offsetWidth + 'px', position: 'absolute' });
				_appendChild(outEl.parentNode, inEl);
			}, noop);
		},


		/**
		 * Уничтожить слой
		 */
		destroy: function () {
			_removeElement(this.wrapEl);

			this._deactivate();
			Ply.stack.remove(this);

			this.visible = false;
			this.options.destroy(this);
		}
	};


	// Ply-стек
	Ply.stack = {
		_idx: {},


		/**
		 * Последний Ply в стеке
		 * @type {Ply}
		 */
		last: null,


		/**
		 * Длинна стека
		 * @type {Number}
		 */
		length: 0,


		/**
		 * Удаить последний ply-слой из стека
		 * @param  {Event}  evt
		 * @private
		 */
		_pop: function (evt) {
			var layer = Ply.stack.last;

			if (evt.keyCode === keys.esc && layer.hasFlag('closeByEsc')) {
				layer.closeBy('esc');
			}
		},


		/**
		 * Добавить ply в стек
		 * @param  {Ply}  layer
		 */
		add: function (layer) {
			var idx = array_push.call(this, layer);

			this.last = layer;
			this._idx[layer.cid] = idx - 1;

			if (idx === 1) {
				_addEvent(document, 'keyup', this._pop);
			}
		},


		/**
		 * Удалить ply из стека
		 * @param  {Ply}  layer
		 */
		remove: function (layer) {
			var idx = this._idx[layer.cid];

			if (idx >= 0) {
				array_splice.call(this, idx, 1);

				delete this._idx[layer.cid];
				this.last = this[this.length-1];

				if (!this.last) {
					_removeEvent(document, 'keyup', this._pop);
				}
			}
		}
	};



	//
	// Эффекты
	//
	Ply.effects = {
		// Установки по умолчанию
		defaults: {
			duration: 300,

			open: {
				layer: null,
				overlay: null
			},

			close: {
				layer: null,
				overlay: null
			}
		},


		/**
		 * Настройти эффекты по умолчанию
		 * @static
		 * @param  {Object}  options
		 */
		setup: function (options) {
			this.defaults = this.get(options);
		},



		/**
		 * Получить опции на основе переданных и по умолчанию
		 * @static
		 * @param   {Object}  options  опции
		 * @returns {Object}
		 */
		get: function (options) {
			var defaults = _deepClone(this.defaults);

			// Функция разбора выражения `name:duration[args]`
			function parseKey(key) {
				var match = /^([\w_-]+)(?::(\d+%?))?(\[[^\]]+\])?/.exec(key) || [];
				return {
					name: match[1] || key,
					duration: match[2] || null,
					args: JSON.parse(match[3] || 'null') || {}
				};
			}


			function toObj(obj, key, def) {
				var fx = parseKey(key),
					val = (obj[fx.name] || def || {}),
					duration = (fx.duration || val.duration || obj.duration || options.duration)
				;

				if (typeof val === 'string') {
					val = parseKey(val);
					delete val.args;
				}

				if (/%/.test(val.duration)) {
					val.duration = parseInt(val.duration, 10) / 100 * duration;
				}

				val.duration = (val.duration || duration) | 0;

				return val;
			}


			if (typeof options === 'string') {
				var fx = parseKey(options);
				options = _deepClone(this[fx.name] || { open: {}, close: {} });
				options.duration = fx.duration || options.duration;
				options.open.args = fx.args[0];
				options.close.args = fx.args[1];
			}
			else if (options instanceof Array) {
				var openFx = parseKey(options[0]),
					closeFx = parseKey(options[1]),
					open = this[openFx.name],
					close = this[closeFx.name]
				;

				options = {
					open: _deepClone(open && open.open || { layer: options[0], overlay: options[0] }),
					close: _deepClone(close && close.close || { layer: options[1], overlay: options[1] })
				};

				options.open.args = openFx.args[0];
				options.close.args = closeFx.args[0];
			}
			else if (!(options instanceof Object)) {
				options = {};
			}

			options.duration = (options.duration || defaults.duration) | 0;

			for (var key in {open: 0, close: 0}) {
				var val = options[key] || defaults[key] || {};
				if (typeof val === 'string') {
					// если это строка, то только layer
					val = { layer: val };
				}
				val.layer = toObj(val, 'layer', defaults[key].layer);
				val.overlay = toObj(val, 'overlay', defaults[key].overlay);

				if(val.args === void 0){
					// clean
					delete val.args;
				}

				options[key] = val;
			}

			return options;
		},


		/**
		 * Применить эффекты
		 * @static
		 * @param   {HTMLElement}  el    элемент, к которому нужно применить эффект
		 * @param   {String}       name  название эффекта
		 * @returns {Promise|undefined}
		 */
		apply: function (el, name) {
			name = name.split('.');

			var effects = this[name[0]], // эффекты open/close
				firstEl = el.firstChild,
				oldStyle = [el.getAttribute('style'), firstEl && firstEl.getAttribute('style')],
				fx,
				effect
			;


			if (effects && (effect = effects[name[1]]) && (fx = Ply.effects[effect.name])) { // layer/overlay
				if (fx['to'] || fx['from']) {
					// Клонируем
					fx = _deepClone(fx);

					// Выключаем анимацию
					_css(el, 'transition', 'none');
					_css(firstEl, 'transition', 'none');

					// Определяем текущее css-значения
					_each(fx['to'], (val, key, target) => {
						if (val === '&') {
							target[key] = _css(el, key);
						}
					});

					// Выставляем initied значения
					if (isFn(fx['from'])) {
						fx['from'](el, effects.args);
					} else if (fx['from']) {
						_css(el, fx['from']);
					}

					return _promise((resolve) => {
						// Принудительный repaint/reflow
						fx.width = el.offsetWidth;

						// Включаем анимацию
						_css(el, 'transition', 'all ' + effect.duration + 'ms');
						_css(firstEl, 'transition', 'all ' + effect.duration + 'ms');

						// Изменяем css
						if (isFn(fx['to'])) {
							fx['to'](el, effects.args);
						}
						else {
							_css(el, fx['to']);
						}

						// Ждем завершения анимации
						setTimeout(resolve, support.transition && effect.duration);
					}).then(_nextTick(() => {
						// Возвращаем стили, именно на "then" с разрывом, т.к. «Обещания» могу быть ассинхронными
						el.setAttribute('style', oldStyle[0]);
						firstEl && firstEl.setAttribute('style', oldStyle[1]);
						return el;
					}));
				}
			}

			return _resolvedPromise;
		},


		//
		// Комбинированный эффекты
		//

		'fade': {
			open:  { layer: 'fade-in:80%', overlay: 'fade-in:100%' },
			close: { layer: 'fade-out:60%', overlay: 'fade-out:60%' }
		},

		'scale': {
			open:  { layer: 'scale-in', overlay: 'fade-in' },
			close: { layer: 'scale-out', overlay: 'fade-out' }
		},

		'fall': {
			open:  { layer: 'fall-in', overlay: 'fade-in' },
			close: { layer: 'fall-out', overlay: 'fade-out' }
		},

		'slide': {
			open:  { layer: 'slide-in', overlay: 'fade-in' },
			close: { layer: 'slide-out', overlay: 'fade-out' }
		},

		'3d-flip': {
			open:  { layer: '3d-flip-in', overlay: 'fade-in' },
			close: { layer: '3d-flip-out', overlay: 'fade-out' }
		},

		'3d-sign': {
			open:  { layer: '3d-sign-in', overlay: 'fade-in' },
			close: { layer: '3d-sign-out', overlay: 'fade-out' }
		},

		'inner': {
			open:  { layer: 'inner-in' },
			close: { layer: 'inner-out' }
		},


		//
		// Описание эффекта
		//

		'fade-in': {
			'from': { opacity: 0 },
			'to':   { opacity: '&' }
		},

		'fade-out': {
			'to': { opacity: 0 }
		},

		'slide-in': {
			'from': { opacity: 0, transform: 'translateY(20%)' },
			'to':   { opacity: '&', transform: 'translateY(0)' }
		},

		'slide-out': {
			'to': { opacity: 0, transform: 'translateY(20%)' }
		},

		'fall-in': {
			'from': { opacity: 0, transform: 'scale(1.3)' },
			'to':   { opacity: '&', transform: 'scale(1)' }
		},

		'fall-out': {
			'to': { opacity: 0, transform: 'scale(1.3)' }
		},

		'scale-in': {
			'from': { opacity: 0, transform: 'scale(0.7)' },
			'to':   { opacity: '&', transform: 'scale(1)' }
		},

		'scale-out': {
			'to': { opacity: 0, 'transform': 'scale(0.7)' }
		},

		'rotate3d': (el, opacity, axis, deg, origin) => {
			_css(el, { perspective: '1300px' });
			_css(el.firstChild, {
				opacity: opacity,
				transform: 'rotate' + axis + '(' + deg + 'deg)',
				transformStyle: 'preserve-3d',
				transformOrigin: origin ? '50% 0' : '50%'
			});
		},

		'3d-sign-in': {
			'from': (el) => {
				Ply.effects.rotate3d(el, 0, 'X', -60, '50% 0');
			},
			'to': (el) => {
				_css(el.firstChild, { opacity: 1, transform: 'rotateX(0)' });
			}
		},

		'3d-sign-out': {
			'from': (el) => {
				Ply.effects.rotate3d(el, 1, 'X', 0, '50% 0');
			},
			'to': (el) => {
				_css(el.firstChild, { opacity: 0, transform: 'rotateX(-60deg)' });
			}
		},

		'3d-flip-in': {
			'from': (el, args) => {
				Ply.effects.rotate3d(el, 0, 'Y', args || -70);
			},
			'to': (el) => {
				_css(el.firstChild, { opacity: 1, transform: 'rotateY(0)' });
			}
		},

		'3d-flip-out': {
			'from': (el) => {
				Ply.effects.rotate3d(el, 1, 'Y', 0);
			},
			'to': (el, args) => {
				_css(el.firstChild, { opacity: 0, transform: 'rotateY(' + (args || 70) + 'deg)' });
			}
		},

		'inner-in': {
			'from': (el) => { _css(el, 'transform', 'translateX(100%)'); },
			'to': (el) => { _css(el, 'transform', 'translateX(0%)'); }
		},
		'inner-out': {
			'from': (el) => { _css(el, 'transform', 'translateX(0%)'); },
			'to': (el) => { _css(el, 'transform', 'translateX(-100%)'); }
		}
	};



	//
	//       Ply-контекст
	//


	/**
	 * @class  Ply.Context
	 * @param  {HTMLElement}  el
	 */
	function Context(el) {
		this.el = el;
	}

	Context.fn = Context.prototype = /** @lends Ply.Context */{
		constructor: Context,


		/**
		 * Получить элемент по имени
		 * @param   {String}  name
		 * @returns {HTMLElement|undefined}
		 */
		getEl: function (name) {
			if (this.el) {
				var items = _getElementsByTagName(this.el, '*'), i = items.length;
				while (i--) {
					if (items[i].getAttribute(_plyAttr + '-name') === name) {
						return items[i];
					}
				}
			}
		},


		/**
		 * Получить или установить значение по имени
		 * @param   {String}  name
		 * @param   {String}  [value]
		 * @returns {String}
		 */
		val: function (name, value) {
			var el = this.getEl(name);

			if (el && (el.value == null)) {
				el = _getElementsByTagName(el, 'input')[0]
				  || _getElementsByTagName(el, 'textarea')[0]
				  || _getElementsByTagName(el, 'select')[0]
				;
			}

			if (el && value != null) {
				el.value = value;
			}

			return el && el.value || "";
		}
	};



	// Export
	Ply.lang = {
		ok: 'OK',
		cancel: 'Cancel',
		cross: '✖'
	};

	Ply.css = _css;
	Ply.cssHooks = _cssHooks;

	Ply.keys = keys;
	Ply.noop = noop;
	Ply.each = _each;
	Ply.extend = _extend;
	Ply.promise = _promise;
	Ply.support = support;
	Ply.defaults = _defaults;
	Ply.attrName = _plyAttr;
	Ply.Context = Context;

	Ply.dom = {
		build: _buildDOM,
		append: _appendChild,
		remove: _removeElement,
		addEvent: _addEvent,
		removeEvent: _removeEvent
	};

	return Ply;
});
