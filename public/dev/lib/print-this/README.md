
<a href="https://badge.fury.io/js/print-this"><a href="https://opencollective.com/printThis" ><img src="https://opencollective.com/printThis/all/badge.svg?label=financial+contributors" alt="Financial Contributors on Open Collective"/></a> <img src="https://badge.fury.io/js/print-this.svg" alt="npm version" height="18" align="right"></a>

# printThis
Printing plug-in for jQuery
#### [Try the Demo](https://jasonday.github.io/printThis/)


## Features
* Print specific & multiple DOM elements
* Preserve page CSS/styling
** or add new CSS; the world is your oyster!
* Preserve form entries
* Canvas support


## Usage
### Basic
```javascript
$('selector').printThis();
```

### Advanced Features
```javascript
$('#kitty-one, #kitty-two, #kitty-three').printThis({
    importCSS: false,
    loadCSS: "",
    header: "<h1>Look at all of my kitties!</h1>"
});
```

### Troubleshooting
[Check the printThis wiki for common issues and questions](https://github.com/jasonday/printThis/wiki)

*Covers common issues related to styling and printing limitations regarding page breaks*


### Options
Now with TypeScript definitions.

#### debug
Debug leaves the iframe visible on the page after `printThis` runs, allowing you to inspect the markup and CSS.

#### importCSS
Copy CSS `<link>` tags to the printThis iframe. On by default.

#### importStyle
Copy CSS `<style>` tags to the printThis iframe. Off by default.

#### printContainer
Includes the markup of the selected container, not just its contents. On by default.

#### loadCSS
Provide a URL for an additional stylesheet to the printThis iframe. Empty string (off) by default.

#### pageTitle
Use a custom page title on the iframe. This may be reflected on the printed page, depending on settings. Blank by default.

#### removeInline
Eliminates any inline style attributes from the content. Off by default.

#### removeInlineSelector
Filter which inline style attributes to remove. Requires `removeInline` to be true.
Accepts custom CSS/jQuery selectors. Default is `"*"`

#### printDelay
The amount of time to wait before calling `print()` in the printThis iframe. Defaults to 333 milliseconds.
Appropriate values depend heavily on the content and network performance. Graphics heavy, slow, or uncached content may need extra time to load.

#### header & footer
A string or jQuery object to prepend or append to the printThis iframe content. `null` by default.

```javascript
$('#mySelector').printThis({
    header: "<h1>Amazing header</h1>"
});

$('#mySelector').printThis({
    footer: $('.hidden-print-header-content')
});
```

As of 1.9.1, jQuery objects are cloned rather than moved.

#### base
The `base` option allows several behaviors.
By default it is `false`, meaning a the current document will be set as the base URL.  

If set to `true`, a `<base>` attribute will be set if one exists on the page.
If none is found, the tag is omitted, which may be suitable for pages with Fully Qualified URLs.

When passed as a string, it will be used as the `href` attribute of a `<base>` tag.

#### formValues
This setting copies the current values of form elements into the printThis iframe. On by default.

#### canvas
As of 1.9.0 you may be able to duplicate canvas elements to the printThis iframe. Disabled by default.
This has received only limited testing and so may not work in all browsers and situations.

As of 1.12.2 you can call printThis directly on a canvas element.

#### doctypeString
A doctype string to use on the printThis iframe. Defaults to the HTML5 doctype.

#### removeScripts
Deletes script tags from the content to avoid errors or unexpected behavior during print. Disabled by default.

#### copyTagClasses: false
Copies classes from the body and html tags into the printThis iframe.  
Accepts `true` or test for the strings `"b"` and `"h"` for the body and html tags, respectively.  
Disabled by default. 

#### beforePrintEvent: null
Function to run inside the iframe before the print occurs.  
*This function has not been validated on all browsers.*

#### beforePrint: null
Function called before the iframe is populated with content.

#### afterPrint: null
Function called after the print and before the iframe is removed from the page.  
This is called even if `debug: true`, which does not remove the iframe.

### All Options
```javascript
$("#mySelector").printThis({
    debug: false,               // show the iframe for debugging
    importCSS: true,            // import parent page css
    importStyle: false,         // import style tags
    printContainer: true,       // print outer container/$.selector
    loadCSS: "",                // path to additional css file - use an array [] for multiple
    pageTitle: "",              // add title to print page
    removeInline: false,        // remove inline styles from print elements
    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
    printDelay: 333,            // variable print delay
    header: null,               // prefix to html
    footer: null,               // postfix to html
    base: false,                // preserve the BASE tag or accept a string for the URL
    formValues: true,           // preserve input/form values
    canvas: false,              // copy canvas content
    doctypeString: '...',       // enter a different doctype for older markup
    removeScripts: false,       // remove script tags from print content
    copyTagClasses: false,      // copy classes from the html & body tag
    beforePrintEvent: null,     // function for printEvent in iframe
    beforePrint: null,          // function called before iframe is filled
    afterPrint: null            // function called before iframe is removed
});
```

## Please read
* "It's not working" without any details is not a valid issue and will be closed
* A url, or html file, is necessary to debug. Due to the complexities of printing and this plugin, an example is the best way to debug
* When troubleshooting, set `debug: true` and inspect the iframe. Please report your findings when reporting an issue
* Every user should be active in the debugging process

## ToDo:
* Look at alternative to setTimeout ($.deferred?)

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="https://github.com/jasonday/printThis/graphs/contributors"><img src="https://opencollective.com/printThis/contributors.svg?width=890&button=false" /></a>

### Financial Contributors

Become a financial contributor and help us sustain our community. [[Contribute](https://opencollective.com/printThis/contribute)]

#### Individuals

<a href="https://opencollective.com/printThis"><img src="https://opencollective.com/printThis/individuals.svg?width=890"></a>

#### Organizations

Support this project with your organization. Your logo will show up here with a link to your website. [[Contribute](https://opencollective.com/printThis/contribute)]

<a href="https://opencollective.com/printThis/organization/0/website"><img src="https://opencollective.com/printThis/organization/0/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/1/website"><img src="https://opencollective.com/printThis/organization/1/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/2/website"><img src="https://opencollective.com/printThis/organization/2/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/3/website"><img src="https://opencollective.com/printThis/organization/3/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/4/website"><img src="https://opencollective.com/printThis/organization/4/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/5/website"><img src="https://opencollective.com/printThis/organization/5/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/6/website"><img src="https://opencollective.com/printThis/organization/6/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/7/website"><img src="https://opencollective.com/printThis/organization/7/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/8/website"><img src="https://opencollective.com/printThis/organization/8/avatar.svg"></a>
<a href="https://opencollective.com/printThis/organization/9/website"><img src="https://opencollective.com/printThis/organization/9/avatar.svg"></a>
