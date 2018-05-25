# Ply
Amazing layer/modal/dialog system. Wow!



## Features
 * Support browsers Chrome 20+, FireFox 20+, Safari 6+, Opera 12+, IE8+ (#1: in progress)
 * No jQuery (but then need [Promise](https://gist.github.com/RubaXa/8501359) polyfill)
 * More than 90% [test code coverage](http://rubaxa.github.io/Ply/tests/)
 * Preloading content before displaying
 * Smart focus on form elements
 * [ES6 syntax](https://github.com/termi/es6-transpiler)



## Base usage

Include [ply.css](ply.css) in `<head/>` (optional)
```html
<link href="./ply.css" rel="stylesheet" type="text/css"/>
```

Create a dialog:
```js
Ply.dialog("alert", "Wow!").then(function (ui) {
	ui.by; // submit, overlay, esc, "x"
	ui.state; // true — "OK", false — "cancel"
});
```


---


## Dialogs

```js
Ply.dialog({
	"init-state": {
		ui: "alert",
		data: "Wow!",
		next: "other-step"
		nextEffect: "3d-flip[180,-180]"
	},

	"other-step": {
		ui: "confirm",
		data: {
			text: "What's next?",
			ok: "Exit",     // button text
			cancel: "Back"
		},
		back: "init-state",
		backEffect: "3d-flip[-180,180]"
	}
}).then(function (ui) {
	// ...
})
```



---


## Low-level

##### new Ply(el[, options])
 * el:`String|HTMLElement` — content of layer
 * options:`Object` — layer options


##### new Ply(options)
 * options:`Object` — layer options


```js
var ply = new Ply({
	el: "...", // HTML-content

	effect: "fade", // or ["open-effect:duration", "close-effect:duration"]

	layer: {}, // default css

	overlay: { // defaults css
		opacity: 0.6,
		backgroundColor: "#000"
	},

	flags: { // defaults
		closeBtn: true, // presence close button "✖"
		bodyScroll: false, // disable scrollbar at body
		closeByEsc: true, // close by press on `Esc` key
		closeByOverlay: true // close by click on the overlay
	},

	// Callback
	init: function () {},
	open: function (ply) {},
	close: function (ply) {},
	destory: function (ply) {},
	callback: function (ui) {},
});


// And
ply.open().then(function () {
	ply.swap({ el: ".." }, "3d-flip").then(function () {
		ply.close();
	});
});
```

##### open([effect]):`Promise`

##### close(effect):`Promise`

##### swap(layer[, effect]):`Promise`
Swapping one layer to another

##### innerSwap(layer[, effect]):`Promise`
Swapping the content of one layer to another

##### destroy()
Destroy layer

---


## Preset effects
 - fade
 - scale
 - fall
 - slide
 - 3d-flip
 - 3d-sign



### Combined effects
```js
Ply.dialog("alert", { effect: ["fade", "scale"] }, "Fade & scale");
```


### Custom effects
```js
Ply.effects["my-effect"] = {
	open:  { layer: "fade-in", overlay: "background-in" },
	close: { layer: "fade-out", overlay: "background-out" }
};

Ply.effects["background-in"] = {
	"from": { opacity: 0, backgroundColor: "red" },
	"to":   { opacity: 1, backgroundColor: "white" }
};

Ply.effects["background-out"] = {
	"from": { opacity: 1, backgroundColor: "white" },
	"to":   { opacity: 0, backgroundColor: "green" }
};
```

---


## Ply.stack
 * last:`Ply|null`
 * length:`Number`


---


## Ply.support
 * transition:`String|Boolean`
 * transform:`String|Boolean`
 * perspective:`String|Boolean`
 * transformStyle:`String|Boolean`
 * transformOrigin:`String|Boolean`
 * backfaceVisibility:`String|Boolean`


---


## Ply.lang (localization)
 * ok:`String` — "OK"
 * cancel:`String` — "Cancel"
 * cross:`String` — "✖"


---


## Ply.defaults
 * layer:`Object` — css
 * overlay:`Object` — style overlay
  * opacity:Number — default `0.6`
  * backgroundColor:String — default `rgb(0, 0, 0)'`
 * flags:`Object`
  * bodyScroll:Boolean — disable scrollbars, default `false`
  * closeByEsc:`Boolean` — closing the layer by pressing the `esc` key, default `true`
  * closeByOverlay:`Boolean` — closing the layer by clicking on the overlay, default `true`


---


## Ply.dom

##### build(tag:`String|Object`):`HTMLElement`
```js
Ply.build(); // <div/>
Ply.build("input"); // <input/>
Ply.build(".foo"); // <div class="foo"/>
Ply.build(".foo.bar"); // <div class="foo bar"/>
Ply.build({  // <input type="password" class="foo" style="padding: 10px" maxlength="32"/>
	tag: "input.foo",
	type: "password",
	css: { padding: "10px" },
	maxlength: 32
});
Ply.build({ text: "<i>?</i>" }); // <div>&lt;i&gt;?&lt;/i&gt;</div>
Ply.build({ html: "<i>!</i>" }); // <div><i>!</i></div>
```

##### append(parent:`HTMLElement`, el:`HTMLElement`)

##### remove(el:`HTMLElement`)

##### addEvent(el:`HTMLElement`, name:`String`, fn:`Function`)

##### removeEvent(el:`HTMLElement`, name:`String`, fn:`Function`)



---


## Create a dialog template


##### Ply.ui(name):`HTMLElement`
 * name:`String` — ui-element name

```js
var el = Ply.ui("btn", {
	title: "click me",
	value: "Wow!"
})
```


##### Ply.ui.factory(name, factory)
 * name:`String` — ui-element name
 * factory:`Function` — callback

```js
Ply.ui.factory("btn", function (data, children) {
	// data:`Object`
	// children:`HTMLElement`

	return {
		"tag": ".btn",
		"text": data.value
	};
});

// or button with icon (optional)
Ply.ui.factory("btn", function (data, children) {
	return {
		"tag": ".btn",
		"title": data.title
		"children": [
			data.icon && { "tag": "span.glyphicon.glyphicon-" + data.icon },
			{ "tag": "span", "text": data.value }
		]
	};
});
```


##### Ply.factory(name, factory)
 * name:`String` — template name
 * factory:`Function` — callback

```js
Ply.factory("subscribe", function (options, data, resolve) {
	// options — ply options
	// data — user data
	// resolve — done function
	resolve({
		"header": "Spam subscribe",
		"content": {
			"fieldset": {
				"name": { label: "Username", value: data.name },
				"email": { label: "E-mail", value: data.email },
				"agree": true
			}
		},
		ctrls: {
			"ok": true,
			"cancel": "abort" // for example
		}
	});

	// OR
	var element = template(data);
	resolve(element);
});


Ply.ui.factory("fieldset", function (data, children) {
	return {
		tag: ".fieldset",
		children: children
	};
});


// Default element in `fieldset`
Ply.ui.factory("fieldset *", function (data) {
	var uid = Math.round(Math.random() * 1e9).toString(36);
	return {
		tag: ".field",
		children: [
			{ tag: "label", forHtml: uid, text: data.label },
			{ tag: "input", id: uid, name: data.name, value: data.value }
		]
	};
});


Ply.ui.factory("fieldset agree", function (data) {
	var uid = Math.round(Math.random() * 1e9).toString(36);
	return {
		tag: ".field",
		children: [
			{ tag: "input", type: "checkbox", id: uid, name: "agree", value: "Y" },
			{ tag: "label", forHtml: uid, text: "I agree." }
		]
	};
});


// Usage
Ply.dialog("subscribe", {
	"name": "RubaXa",
	"email": "trash@rubaxa.org",
});
```

---


## Development
 * `grunt watch` — dev mode
 * `grunt build` — assembly project


---


## Changelog

##### 0.3.0
 * #1: Testing and documentation
 * #3: Stack features
