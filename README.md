# Boilerplate Theme

`todo` Update set up variables

## Requirements

* `nodejs` installed

* `composer` installed
* `PHP 7.0` installed on your local machine

## Setup

1. Replace folder name **{Text_Domain}**  with the plugin folder name you are going to develop
1. Change **{Plugin_Name}**, **{Plugin_Shortname}**, **{Plugin_Description}**, and **{Plugin_Prefix}** with the appropriate information
1. Change all occurrences of namespace **Plugin_Scope** with your desire namespace
1. Change all occurrences of **{Text_Domain}** with the plugin's name which should be the same as folder name
1. Change Text_Domain.pot file's which should be the same as folder name
    
### ACF Pro
    
1. In case the plugin depends on ACF Pro plugin you should define it in the `/bootstrap.php` file
    * For enabling ACF Pro checking `define(__NAMESPACE__ . '\ACF_REQUIRED', true);`
    
### Gravity Forms
    
In case the plugin depends on Gravity Forms you should define it in the `/bootstrap.php` file
* For enabling GF support and Settings page `define(__NAMESPACE__ . '\GFORMS_ADDON', true);`
* Then replace **GF_Addon_Name** with a `One_Word` name over the project
* Then replace **GF_Class_Name** with a `GFPluginNameAddon` class name over the project

:warning: Before initially release a new plugin, please eliminate all text above.

---

# Ajax Systems [![js-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg)](http://standardjs.com)
Ajax Systems wordpress theme

The standards below are prepared for Wordpress Development. The latest version of this guide is always available in [the following repository](https://github.com/hisaveliy/coding-standards). 

**Table of contents**

1. [Requirements](#requirements)
1. [Code style](#code-style)
    1. [Commit and Pull-request standards](#commit-and-pull-request-standards)
        1. [Naming](#naming)
        1. [Pull-request description](#pull-request-description)
        1. [Pull-request example](#pull-request-example)
    1. [CSS Coding standards](#css-coding-standards)
        1. [Structure](#structure)
        1. [Selectors](#selectors)
        1. [Properties](#properties)
        1. [Property Ordering](#property-ordering)
        1. [Values](#values)
        1. [Best Practices](#best-practices)
    1. [HTML Coding Standards](#html-coding-standards)
        1. [Validation](#validation)   
        1. [Self-closing Elements](#self-closing-elements)   
        1. [Indentation](#indentation)   
    1. [JavaScript Coding Standards](#javascript-coding-standards)   
    1. [PHP Coding standards](#php-coding-standards)   
        1. [PSR-1 Basic Coding Standard](#psr-1-basic-coding-standard)   
        1. [PSR-2 Coding Style Guide](#psr-2-coding-style-guide)   
        1. [Cake PHP Coding Standards](#cake-php-coding-standards)   
        1. [Symfony Coding Standard](#symfony-coding-standard)   
        1. [WordPress Coding Standard](#wordpress-coding-standard)   
1. [Contributing](#contributing)   
    1. [Get started](#get-started)   
    1. [Bundle assets](#bundle-assets)   
    1. [How to contribute](#how-to-contribute)  
    1. [Add section](#add-section)
        1. [Add Template Part](#add-template-part)
        1. [Add JavaScript](#add-javascript)
        1. [Add CSS](#add-css)
    1. [Add Gutenberg Block](#add-gutenberg-block)
        1. [Register Block](#register-block)
        1. [Add Block JavaScript](#add-block-javascript)
        1. [Add Block CSS](#add-block-css)
    1. [Add Elementor Widget](#add-elementor-widget)
        1. [Register Widget](#register-widget)
        1. [Add Widget JavaScript](#add-widget-javascript)
        1. [Add Widget CSS](#add-widget-css)
    1. [Global parameters](#global-parameters)
    

### Requirements
A list of dependencies and their versions (could be newer).

**General**

- PHP: `7.0`
- Wordpress: `5.1`

# Code style

## Commit and Pull-request standards

### Naming
Both Commit's and Pull-request's name must meet the following rules

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...") 
- The first word must be a verb ("Add", "Fix". "Improve" etc)

### Pull-request description
In the pull-request description area the following information must be specified:
 
- a list of updates where each item is labeled either `new-feature`, `improvement`, or `bug`
- refer a trello card for this task
- it is ok if a pull-request contains several tasks completed. You have to specify the main task's name in the headline, and write down the list of all the updates in the description.

|Type|Meaning|
|:---|:---|
|`new-feature`|you added something new hadn't been existed before|
|`improvement`|you made an existing stable functionality to work better|
|`bug`|you repaired an existing functionality which didn't work properly|

### Pull-request example

**Headline**
> Update the settings fields of styling options

**Description**
> - `new-feature` - add styling settings for product page typography [Trello card](https://example.com)
> - `improvement` - add animation library [Trello card](https://example.com)
> - `bug` - fix product page mobile appearance [Trello card](https://example.com)

## CSS Coding standards
The information below is taken from Wordpress.org. [Learn more](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/)

### Structure

- Use tabs, not spaces, to indent each property.
- Add two blank lines between sections and one blank line between blocks in a section.
- Each selector should be on its own line, ending in either a comma or an opening curly brace. Property-value pairs should be on their own line, with one tab of indentation and an ending semicolon. The closing brace should be flush left, using the same level of indentation as the opening selector.
- Each component is placed to a dedicated file
- Assign the styles to the classes, tags and attributes only

**Correct**

```css
.selector-1,
.selector-2,
.selector-3 {
    background: #fff;
    color: #000;
}

```

**Incorrect**

```css
.selector-1, .selector-2, .selector-3 {
    background: #fff;
    color: #000;
    }
 
.selector-1 { background: #fff; color: #000; }
```

### Selectors

- Similar to the WordPress PHP Coding Standards for file names, use lowercase and separate words with hyphens when naming selectors. Avoid camelcase and underscores.
- Use human readable selectors that describe what element(s) they style.
- Attribute selectors should use double quotes around values
- Refrain from using over-qualified selectors, div.container can simply be stated as .container

**Correct**

```css
#comment-form {
    margin: 1em 0;
}
 
input[type="text"] {
    line-height: 1.1;
}
```

**Incorrect**

```css
#commentForm { /* Avoid camelcase. */
    margin: 0;
}
 
#comment_form { /* Avoid underscores except if it's a modifier. */
    margin: 0;
}
 
div#comment_form { /* Avoid over-qualification. */
    margin: 0;
}
 
#c1-xr { /* What is a c1-xr?! Use a better name. */
    margin: 0;
}
 
input[type=text] { /* Should be [type="text"] */
    line-height: 110% /* Also doubly incorrect */
}
```

### Properties
Similar to selectors, properties that are too specific will hinder the flexibility of the design. Less is more. Make sure you are not repeating styling or introducing fixed dimensions (when a fluid solution is more acceptable).

- Properties should be followed by a colon and a space.
- All properties and values should be lowercase, except for font names and vendor-specific properties.
- Use hex code for colors, or rgba() if opacity is needed. Avoid RGB format and uppercase, and shorten values when possible: #fff instead of #FFFFFF.
- Use shorthand (except when overriding styles) for background, border, font, list-style, margin, and padding values as much as possible. (For a shorthand reference, see CSS Shorthand.)

**Correct**

```css
#selector-1 {
    background: #fff;
    display: block;
    margin: 0;
    margin-left: 20px;
}
```

**Incorrect**

```css
#selector-1 {
    background:#FFFFFF;
    display: BLOCK;
    margin-left: 20PX;
    margin: 0;
}
```

### Property Ordering

Above all else, choose something that is meaningful to you and semantic in some way. Random ordering is chaos, not poetry. In WordPress Core, our choice is logical or grouped ordering, wherein properties are grouped by meaning and ordered specifically within those groups. The properties within groups are also strategically ordered to create transitions between sections, such as background directly before color. The baseline for ordering is:

- Display
- Positioning
- Box model
- Colors and Typography
- Other

Things that are not yet used in core itself, such as CSS3 animations, may not have a prescribed place above but likely would fit into one of the above in a logical manner. Just as CSS is evolving, so our standards will evolve with it.

Top/Right/Bottom/Left (TRBL/trouble) should be the order for any relevant properties (e.g. margin), much as the order goes in values. Corner specifiers (e.g. border-radius-*-*) should be top-left, top-right, bottom-right, bottom-left. This is derived from how shorthand values would be ordered.

**Example**

```css
#overlay {
    position: absolute;
    z-index: 1;
    padding: 10px;
    background: #fff;
    color: #777;
}
```

### Values

There are numerous ways to input values for properties. Follow the guidelines below to help us retain a high degree of consistency.

- Space before the value, after the colon.
- Do not pad parentheses with spaces.
- Always end in a semicolon.
- Use double quotes rather than single quotes, and only when needed, such as when a font name has a space or for the values of the content property.
- Font weights should be defined using numeric values (e.g. 400 instead of normal, 700 rather than bold).
- 0 values should not have units unless necessary, such as with transition-duration.
- Line height should also be unit-less, unless necessary to be defined as a specific pixel value. This is more than just a style convention, but is worth mentioning here. More information: http://meyerweb.com/eric/thoughts/2006/02/08/unitless-line-heights/
- Use a leading zero for decimal values, including in rgba().
- Multiple comma-separated values for one property should be separated by either a space or a newline. For better readability newlines should be used for lengthier multi-part values such as those for shorthand properties like box-shadow and text-shadow, including before the first value. Values should then be indented one level in from the property.
- Lists of values within a value, like within rgba(), should be separated by a space.

**Correct**

```css
.class { /* Correct usage of quotes */
    background-image: url(images/bg.png);
    font-family: "Helvetica Neue", sans-serif;
    font-weight: 700;
}
 
.class { /* Correct usage of zero values */
    font-family: Georgia, serif;
    line-height: 1.4;
    text-shadow:
        0 -1px 0 rgba(0, 0, 0, 0.5),
        0 1px 0 #fff;
}
 
.class { /* Correct usage of short and lengthier multi-part values */
    font-family: Consolas, Monaco, monospace;
    transition-property: opacity, background, color;
    box-shadow:
        0 0 0 1px #5b9dd9,
        0 0 2px 1px rgba(30, 140, 190, 0.8);
}
```

**Incorrect**

```css
.class { /* Avoid missing space and semicolon */
    background:#fff
}
 
.class { /* Avoid adding a unit on a zero value */
    margin: 0px 0px 20px 0px;
}
 
.class {
    font-family: Times New Roman, serif; /* Quote font names when required */
    font-weight: bold; /* Avoid named font weights */
    line-height: 1.4em;
}
 
.class { /* Incorrect usage of multi-part values */
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.5),
                 0 1px 0 #fff;
    box-shadow: 0 1px 0 rgba(0, 0,
        0, 0.5),
        0 1px 0 rgba(0,0,0,0.5);
}
```

### Best Practices

Stylesheets tend to get long in length. Focus slowly gets lost whilst intended goals start repeating and overlapping. Writing smart code from the outset helps us retain the overview whilst remaining flexible throughout change.

- If you are attempting to fix an issue, attempt to remove code before adding more.
- Magic Numbers are unlucky. These are numbers that are used as quick fixes on a one-off basis. Example: .box { margin-top: 37px }.
- DOM will change over time, target the element you want to use as opposed to “finding it” through its parents. Example: Use .highlight on the element as opposed to .highlight a (where the selector is on the parent)
- Know when to use the height property. It should be used when you are including outside elements (such as images). Otherwise use line-height for more flexibility.
- Do not restate default property & value combinations (for instance display: block; on block-level elements).

## HTML Coding Standards
The standards below are taken from Wordpress.org. [Learn more](https://make.wordpress.org/core/handbook/best-practices/coding-standards/html/)

### Validation

All HTML pages should be verified against the [W3C validator](http://validator.w3.org/) to ensure that the markup is well formed.

### Self-closing Elements

All tags must be properly closed. For tags that can wrap nodes such as text or other elements, termination is a trivial enough task. For tags that are self-closing, the forward slash should have exactly one space preceding it:

```html
<br />
```

rather the compact, but incorrect

```html
<br/>
```

### Indentation

As with PHP, HTML indentation should always reflect logical structure. Use tabs and not spaces.

When mixing PHP and HTML together, indent PHP blocks to match the surrounding HTML code. Closing PHP blocks should match the same indentation level as the opening block.

**Correct**

```html
<?php if ( ! have_posts() ) : ?>
    <div id="post-1" class="post">
        <h1 class="entry-title">Not Found</h1>
        <div class="entry-content">
            <p>Apologies, but no results were found.</p>
            <?php get_search_form(); ?>
        </div>
    </div>
<?php endif; ?>
```

**Incorrect**

```html
        <?php if ( ! have_posts() ) : ?>
        <div id="post-0" class="post error404 not-found">
            <h1 class="entry-title">Not Found</h1>
            <div class="entry-content">
            <p>Apologies, but no results were found.</p>
<?php get_search_form(); ?>
            </div>
        </div>
<?php endif; ?>
```

If you're working on others code which isn't sorted correctly, you should update it according to the **correct** example above.

## JavaScript Coding Standards
All the rules below are taken from StandardJS. See the whole list [on this reference](https://standardjs.com/rules.html). 

[See how to activate ESLint in PHPStorm](https://take.ms/xarUq)

### Rules

- **Use 2 spaces** for indentation.
    ```javascript
    function hello (name) {
      console.log('hi', name)
    }
    ```

- **Use single quotes for strings** except to avoid escaping.
    ```javascript
    console.log('hello there')    // ✓ ok
    console.log("hello there")    // ✗ avoid
    console.log(`hello there`)    // ✗ avoid
     
    $("<div class='box'>")        // ✓ ok
    console.log(`hello ${name}`)  // ✓ ok
    ```
- **No unused variables.**

    ```javascript
    function myFunction () {
      var result = something()   // ✗ avoid
    }
    ```
    
- **Add a space after keywords.**

    ```javascript
    if (condition) { ... }   // ✓ ok
    if(condition) { ... }    // ✗ avoid
    ```
    
- **Add a space before a function declaration's parentheses.**

    ```javascript
    function name (arg) { ... }   // ✓ ok
    function name(arg) { ... }    // ✗ avoid
     
    run(function () { ... })      // ✓ ok
    run(function() { ... })       // ✗ avoid
    ```

- **Always use** === instead of ==
    Exception: obj == null is allowed to check for null || undefined.
    
    ```javascript
    if (name === 'John')   // ✓ ok
    if (name == 'John')    // ✗ avoid
    
    if (name !== 'John')   // ✓ ok
    if (name != 'John')    // ✗ avoid
    ```
    
- **Infix operators** must be spaced.
    
    ```javascript
    // ✓ ok
    var x = 2
    var message = 'hello, ' + name + '!'
    
    // ✗ avoid
    var x=2
    var message = 'hello, '+name+'!'
    ```
    
- **Commas should have** a space after them.
    
    ```javascript
    // ✓ ok
    var list = [1, 2, 3, 4]
    function greet (name, options) { ... }
    
    // ✗ avoid
    var list = [1,2,3,4]
    function greet (name,options) { ... }
    ```
    
- **Keep else statements** on the same line as their curly braces.
    
    ```javascript
    // ✓ ok
    if (condition) {
      // ...
    } else {
      // ...
    }
    
    // ✗ avoid
    if (condition) {
      // ...
    }
    else {
      // ...
    }
    ```
    
- **For multi-line if statements,** use curly braces.
    
    ```javascript
    // ✓ ok
    if (options.quiet !== true) console.log('done')
    
    // ✓ ok
    if (options.quiet !== true) {
      console.log('done')
    }
    
    // ✗ avoid
    if (options.quiet !== true)
      console.log('done')
    ```
    
- **Always handle the err** function parameter.

    ```javascript
    // ✓ ok
    run(function (err) {
      if (err) throw err
      window.alert('done')
    })
    
    // ✗ avoid
    run(function (err) {
      window.alert('done')
    })
    ```
    
- **Declare browser globals** with a /* global */ comment.
    Exceptions are: window, document, and navigator.
    Prevents accidental use of poorly-named browser globals like open, length, event, and name.
        
    ```javascript
    /* global alert, prompt */
     
    alert('hi')
    prompt('ok?')
    ```
    
    Explicitly referencing the function or property on window is okay too, though such code will not run in a Worker which uses self instead of window.
    
    ```javascript
    window.alert('hi')   // ✓ ok
    ```
    
- **Multiple blank lines not allowed.**

    ```javascript
    // ✓ ok
    var value = 'hello world'
    console.log(value)
    
    // ✗ avoid
    var value = 'hello world'
     
     
    console.log(value)
    ```
    
- **For the ternary operator in a multi-line setting,** place ? and : on their own lines.

    ```javascript
    // ✓ ok
    var location = env.development ? 'localhost' : 'www.api.com'
     
    // ✓ ok
    var location = env.development
      ? 'localhost'
      : 'www.api.com'
     
    // ✗ avoid
    var location = env.development ?
      'localhost' :
      'www.api.com'
    ```
    
- **For var declarations,** write each declaration in its own statement.

    ```javascript
    // ✓ ok
    var silent = true
    var verbose = true
     
    // ✗ avoid
    var silent = true, verbose = true
     
    // ✗ avoid
    var silent = true,
        verbose = true
    ```
    
- **Wrap conditional assignments with additional parentheses.** This makes it clear that the expression is intentionally an assignment (=) rather than a typo for equality (===).
    
    ```javascript
    // ✓ ok
    while ((m = text.match(expr))) {
      // ...
    }
     
    // ✗ avoid
    while (m = text.match(expr)) {
      // ...
    }
    ```
    
- **Add spaces inside single line blocks.**
    
    ```javascript
    function foo () {return true}    // ✗ avoid
    function foo () { return true }  // ✓ ok
    ```
    
- **Use camelcase** when naming variables and functions.
    
    ```javascript
    function my_function () { }    // ✗ avoid
    function myFunction () { }     // ✓ ok
    
    var my_var = 'hello'           // ✗ avoid
    var myVar = 'hello'            // ✓ ok
    ```
    
- **Constructors of derived classes must call super.**

    ```javascript
    class Dog {
      constructor () {
        super()   // ✗ avoid
      }
    }
     
    class Dog extends Mammal {
      constructor () {
        super()   // ✓ ok
      }
    }
    ```

## PHP Coding standards
The rules below are taken from Wordpress.org and Blog Sideci. [Learn more](https://blog.sideci.com/5-php-coding-standards-you-will-love-and-how-to-use-them-adf6a4855696?gi=8718b68ddf03)

### PSR-1 Basic Coding Standard
The more basic parts of PHP coding standards are defined in PSR-1. For example:

- Only `<?php` or `<?=` are allowed for PHP tags
- Class names must be defined in `UpperCamelCase`
- Class variables must be defined in `UPPER_SNAKE_CASE`
- Method names must be defined in `camelCase`

Standard functions in PHP are defined in snake_case, but in PSR-1, method names must be defined in camelCase. There are no explicit rules for variable and property names, so you can use whichever style you like, but it is noted that they should be consistent. For example, defining normal properties in camelCase and static properties in UpperCamelCase like below:

```php
class Something
{
    public $normalPropterty;
    public static $StaticProperty;
}
```

### PSR-2 Coding Style Guide
PSR-2 is an extension of the PSR-1 coding standard. Some examples of its contents are:

- You must follow PSR-1 coding standards
- 4 spaces must be used for indents
- There is no limit to line length, but it should be under 120 characters, and best if under 80
- You must put a newline before curly braces for classes and methods
- Methods and properties must be defined with abstract/final first, followed with public/protected, and finally static.
- You must not put a newline before curly braces in conditional statements
- You must not put any spaces before ( and ) in conditional statements

**Defining Classes**
You must put a newline before `{` in class definitions. Also, extends and implements must be written on the same line as the class name.

```php
class ClassName extends ParentClassName implements Interface1, Interface2
{
    // Class definition
}
```

If there are too many interfaces for one line, you should put a newline after implements and write one interface per line like below.

```php
class ClassName extends ParentClassName implements
    Interface1,
    Interface2,
    Interface3,
    Interface4
{
    // Class definition
}
```

Since there are quite a few standards that recommend writing `{` on the same line like `class ClassName {`, this may be a style which you haven't seen before.

**Defining Properties**

In PSR-2, you must not omit public/protected/private modifiers. In PHP, properties become public if these are omitted, but because it is hard to tell if one purposely omitted these modifiers or they just forgot, you should always explicitly write public. The static keyword comes next. You must not use var when defining properties because you can't add any modifiers to var.

```php
class ClassName
{
    public $property1;
    
    private $property2;
    
    public static $staticProperty;
}
```

Additionally, you must not define two or more properties with one statement. You can define properties in the way shown below but it is prohibited in PSR-2.

```php
class ClassName
{
     private $property1, $property2;
}
```

**Methods**

Like properties, you must have either one of public/protected/private and abstract/final comes after them if used. static is the last modifier. You must not put any spaces before and after braces, and you must put a newline before curly braces. Also, you must not put any whitespaces before commas in arguments, and you must put one whitespace after them.

```php
class ClassName
{
    abstract protected function abstractDoSomething();
    
    final public static function doSomething($arg1, $arg2, $arg3)
    {
        // ...
    }
}
```

If there are too many arguments, you can put a newline after ( and write one argument per line. In this case, you can't write multiple variables on one line. Also, you should write ) and { on the same line, separated by a whitespace.

```php
class ClassName
{
    public function doSomething(
        TypeHint $arg1,
        $arg2,
        $arg3,
        $arg4
    ) {
        // ...
    }
}
```

Please note that you must not put a newline before `{` in closures.

```php
$closure = function ($a, $b) use ($c) {
    // Body
};
```

**Conditional Statements**

For conditional statements,

- You must put one whitespace before (
- You must not put any whitespaces after (
- You must not put any whitespaces before )
- You must put one whitespace after )
- Use elseif rather than else if

```php
if ($condition1) {
    // ...
} elseif ($condition2) {
    // ...
} else {
    // ...
}
```

For switch statements, case statements must be indented once from switch, and bodies for the cases must be indented once from case. When not breaking after any kind of operations in case, you must write a comment.

```php
switch ($condition) {
    case 0:
        echo 'First case, with a break';
        break;
    case 1:
        echo 'Second case, which falls through';
        // no break
    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;
    default:
        echo 'Default case';
        break;
}
```

### Cake PHP Coding Standards
There are only a few rules are represented. 

**Line Length**
PSR-2 recommends lines to be under 120 characters, but this was not required. However, in CakePHP coding standards, lines are recommended to be under 100 letters and are required to be under 120 letters.

**Ternary Operators**
You must not nest ternary operators.

**Correct**

```php
$variable = false;
if(isset($options['variable']) && isset($options['othervar'])) {
    $variable = true;
}
```

**Incorrect**

```php
$variable = isset($options['variable']) ? isset($options['othervar']) ? true : false : false;
```

### Symfony Coding Standard
There are the rules presented which most commonly are ignored in our projects.

**Put a Comma after the Last Element of Arrays Taking Multiple Lines**
The following two styles of writing arrays result in the same values. However, the first style is recommended.

```php
// recommended style
$array = [
    'value1',
    'value2',
    'value3', // comma at the end of last line
];

// not recommended
$array = [
    'value1',
    'value2',
    'value3'  // no comma at the last line
];
```

**The Order of Properties/Methods in a Class**
In a class, properties are defined first, and then the methods. For the order of properties and methods, public methods come first, then protected, and finally private. Among the methods, constructors (`__construct()`), `PHPUnit`, `setUp()` and `tearDown()` are defined first.

```php
class Something
{
    public $property1;
    
    protected $property2;
    
    private $property3;
    
    public function __construct()
    {
        // ...
    }
    
    public function doSomething()
    {
        // ...
    }
    
    private function doSomethingPrivate()
    {
        // ...
    }
}
```

**Prefixes and Suffixes for Classes**

You should add an `Abstract` suffix to an abstract class.

```php
abstract class AbstractDatabase
{
    // ...
}
```

You should add an `Interface` suffix to an interface.

```php
interface LoggerInterface
{
    // ...
}
```

You should add a `Trait` suffix to a trait.

```php
trait SomethingTrait
{
    // ...
}
```

You should add an `Exception` suffix to an exception.

```php
class NotFoundException extends \RuntimeException
{
    // ...
}
```

### WordPress Coding Standard

**Whitespaces in Conditional Statements and Function Calls**
You should add a whitespace before and after braces in conditional statements such as if and for.

```php
if ( $condition ) {
    // ...
}
```

You should add whitespaces as shown below for function definitions and calls.

```php
function my_function( $arg1, $arg2 ) {
    // ...
}
```

**Use Flag Values with Meaning for Function Arguments**

You must avoid function definitions such as:

```php
function my_function( $arg1, $arg2 ) {
    // ...
}
```

Calling this functions will be like:

```php
eat( 'mushrooms', true );
```

However, when looking at this call, we can’t tell what true actually means. You will have to go check the function's definition to understand the meaning of this true. So, the WordPress Coding Standard recommends styles such as:

```php
function eat( $what, $speed = 'slowly' ) {
    // ...
}
```

This definition will make the function call look like:

```php
eat( 'mushrooms', 'slowly' );
```

**Translation strings**
All static strings must be translable. 

**Correct**

```php

$cart_button_text = __('Add to cart', TEXT_DOMAIN);
<button><?php echo $cart_button_text; ?></button>

// also correct
<button><?php echo _e('Add to cart', TEXT_DOMAIN); ?></button>

// when a variable should be passed
$cart_button_text = sprintf( 
    __('Add this %s to cart', TEXT_DOMAIN), 
    $product_name // Christmas Tree
);
<button><?php echo $cart_button_text; ?></button>

Output: <button>Add this Christmas Tree to cart</button>
```

**Incorrect**

```php
<button>Add to cart</button>

// also incorrect
<button><?__('Add to cart', TEXT_DOMAIN)?></button>

// when a variable should be passed
<button>Add this<?php echo $product_name; ?> to cart</button>
```

# Contributing

## Get started

1. Clone the repository to plugins folder
    ```
    > cd wp-content/plugins
    > git clone https://github.com/hisaveliy/ginmon-2021
    ```
1. Run NPM packages installation
    ``` 
    > npm install
    ```

## Bundle assets

**Proceed with development**

* run npm watcher for development. **Note:** after the initial build, webpack will continue to watch for changes in any of the resolved files and it will sync the root folder
   ``` 
   > npm run watch
   ```
* run building command for production
   ``` 
   > npm run prod
   ```

## How to contribute

1. Each feature, improvement or bug fix should be completed in a dedicated branch, but it is possible to complete several Trello cards under the same branch if the are logically connected.
1. Iterate version
    - in `style.css` for theme development
    - in `bootstrap.php` for plugin development
1. Make sure:
    - a task is properly completed
    - a branch is fully tested
    - code written according to [Code style](#code-style)
1. Create a pull-request which must be named and described according to [Commit and Pull-request standards](#commit-and-pull-request-standards)
1. Complete merging the branch with master through Github

## Add section

### Add Template Part

1. Create a new php file in `/template-parts`
1. Include it by using a `get_template_part` method
1. Dynamic data should be passed as a third parameter
    ```php
    get_template_part('template-parts/example-section', null, [ 'variable_1' => 'Hello World!' ]);
    ```
   
### Add JavaScript

1. Create a new js file at `src/js/components` 
1. Use `example.js` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the `autoload/class-defer-js` file register the file at the `register_components` method
1. At the php template and include the javascript file by using `DeferJS` class 
    ```php
    DeferJS::enqueue('example');
    ```
1. As a result, the javascript file will be included only when the component has been used at a particular page

### Add CSS

1. Create a new js file at `src/scss/components` 
1. Use `example.scss` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the `autoload/class-defer-css` file register the file at the `register` method
1. At the php template and include the javascript file by using `DeferCSS` class 
    ```php
    DeferCSS::enqueue('example');
    ```
1. As a result, the css will be inline inserted over there, only if the section has been used

### Final look of the component

```php
<?php
use AjaxSystems\DeferCSS;
use AjaxSystems\DeferJS;

$name = isset($args['name']) ? $args['name'] : 'world';
?>

<div class="example-section">
    <?php
    DeferCSS::enqueue('example');
    DeferJS::enqueue('example');
    ?>

    <p>Hello <?php echo $name; ?></p>
</div>

```

## Add Gutenberg Block

If you're going to use a Gutenberg page builder you should enable that at functions.php file by defining true to `ACF_PRO` constant, and setting "gutenberg" to the `PAGE_BUILDER` constant. Moreover, make sure you have the latest version of Gutenberg up and running. 

There after you will get the `FieldGroups` and `OptionsPage` classes enabled. 

### Register Block

1. Create a copy of the `/includes/builders/gutenberg/class-example-block.php` file
1. Reset the variables accordingly
1. Use the `get_fields` method for creating the custom fields used in the block
1. Create a copy of `/template-parts/gutenberg/example.php` file 
1. Keep markup over there 

### Add Block JavaScript

1. Create a new js file at `src/js/gutenberg` 
1. Use `example.js` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the php template and include the javascript file by using `DeferJS` class 
    ```php
    DeferJS::enqueue('gutenberg_example');
    ```
1. As a result, the javascript file will be included only when the block has been used at a particular page

### Add Block CSS](#add-block-css)

1. Create a new js file at `src/scss/gutenberg` 
1. Use `example.scss` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the php template and include the javascript file by using `DeferCSS` class 
    ```php
    DeferCSS::enqueue('gutenberg_example');
    ```
1. As a result, the css will be inline inserted over there, only if the section has been used

## Add Elementor Widget

If you're going to use a Elementor page builder you should enable that at functions.php file by setting "elemmentor" to the `PAGE_BUILDER` constant. Moreover, make sure you have the latest version of Elementor plugin up and running.

### Register Widget

1. Duplicate the file `/includes/builders/elementor/class-exammple-widget.php`
1. Update the variables accordingly
1. Create a copy of `/template-parts/elementor/example.php` file and build up markup overr there

### Add Widget JavaScript

1. Create a new js file at `src/js/components` 
1. Use `example.js` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the `autoload/class-defer-js` file register the file at the `register_components` method
1. At the php template and include the javascript file by using `DeferJS` class 
    ```php
    DeferJS::enqueue('example');
    ```
1. As a result, the javascript file will be included only when the component has been used at a particular page

### Add Widget CSS

1. Create a new js file at `src/scss/components` 
1. Use `example.scss` as a sample. In a nutshell, you will create a jQuery instance
1. Register the file in `webpack.min.js`
1. At the `autoload/class-defer-css` file register the file at the `register` method
1. At the php template and include the javascript file by using `DeferCSS` class 
    ```php
    DeferCSS::enqueue('example');
    ```
1. As a result, the css will be inline inserted over there, only if the section has been used

## Global parameters

Check the `class-customizer.php` file for more details about how to add global variables to the website.
