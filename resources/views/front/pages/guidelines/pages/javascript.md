---
title: JavaScript
description: Get scripty!
weight: 2
---

[Prettier](https://prettier.io) determines our code style. While Prettier's output isn't always the prettiest, it's consistent and removes all (meaningless) discussion about code style.

We try to stick to Prettier's defaults, but have a few overrides to keep our JavaScript code style consistent with PHP.

The first two rules are actually configured with `.editorconfig`. We use 4 spaces as indentation.

```txt
indent_size = 4
```

Since we use 4 spaces instead of the default 2, the default 80 character line length can be a bit short (especially when writing templates in JSX).

```json
{
    "printWidth": 120
}
```

Finally, we prefer single quotes over double quotes for consistency with PHP.

```json
{
    "singleQuote": true
}
```

## Variable assignment

Prefer `const` over `let`. Only use `let` to indicate that a variable will be reassigned. Never use `var`.

[good]
```js
const person = { name: 'Sebastian' };
person.name = 'Seb';
```
[/good]

[bad]
```js
// The variable was never reassigned
let person = { name: 'Sebastian' };
person.name = 'Seb';
```
[/bad]

## Variable names

Variable names generally shouldn't be abbreviated.

[good]
```js
function saveUser(user) {
    localStorage.set('user', user);
}
```
[/good]

[bad]
```js
// it's hard to reason about abbreviations in blocks as they grow.
function saveUser(u) {
    localStorage.set('user', u);
}
```
[/bad]

In single-line arrow functions, abbreviations are allowed to reduce noise if the context is clear enough. For example, if you're calling `map` of `forEach` on a collection of items, it's clear that the parameter is an item of a certain type, which can be derived from the collection's substantive variable name.

[good]
```js
function saveUserSessions(userSessions) {
    userSessions.forEach(s => saveUserSession(s));
}
```
[/good]

[bad]
```js
// Ok, but pretty noisy.
function saveUserSessions(userSessions) {
    userSessions.forEach(userSession => saveUserSession(userSession));
}
```
[/bad]

## Comparisons

Always use a triple equal to do variable comparisons. If you're unsure of the type, cast it first.

[good]
```js
const one = 1;
const another = "1";

if (one === parseInt(another)) {
    // ...
}
```
[/good]

[bad]
```js
const one = 1;
const another = "1";

if (one == another) {
    // ...
}
```
[/bad]

## Function keyword vs. arrow functions

Function declarations should use the function keyword.

[good]
```js
function scrollTo(offset) {
    // ...
}
```
[/good]

[bad]
```js
// Using an arrow function doesn't provide any benefits here, while the
// `function`  keyword immediately makes it clear that this is a function.
const scrollTo = (offset) => {
    // ...
};
```
[/bad]

Terse, single line functions may also use the arrow syntax. There's no hard rule here.

[good]
```js
function sum(a, b) {
    return a + b;
}

// It's a short and simple method, so squashing it to a one-liner is ok.
const sum = (a, b) => a + b;
```
[/good]

[good]
```js
export function query(selector) {
    return document.querySelector(selector);
}
```
[/good]

[bad]
```js
// This one's a bit longer, having everything on one line feels a bit heavy.
// It's not easily scannable unlike the previous example.
export const query = (selector) => document.querySelector(selector);
```
[/bad]

Higher-order functions may use arrow functions if it improves readability.

```js
function sum(a, b) {
    return a + b;
}
```
[good]
```js
const adder = (a) => (b) => sum(a, b);
```
[/good]

[bad]
```js
// okish, but unnecessarily noisy.
function adder(a) {
    return function (b) {
        return sum(a, b);
    };
}
```
[/bad]

Anonymous functions should use arrow functions.

```js
['a', 'b'].map((a) => a.toUpperCase());
```

Unless they need access to `this`.

```js
$('a').on('click', function () {
    window.location = $(this).attr('href');
});
```

Try to keep your functions pure and limit the usage of the `this` keyword.

Object methods must use the shorthand method syntax.

[good]
```js
export default {
    methods: {
        handleClick(event) {
            event.preventDefault();
        },
    },
};
```
[/good]

[bad]
```js
// the `function` keyword serves no purpose.
export default {
    methods: {
        handleClick: function (event) {
            event.preventDefault();
        },
    },
};
```
[/bad]

## Object and array destructuring

Destructuring is preferred over assigning variables to the corresponding keys.

[good]
```js
const [hours, minutes] = '12:00'.split(':');
```
[/good]

[bad]
```js
// unnecessarily verbose, and requires an extra assignment in this case.
const time = '12:00'.split(':');
const hours = time[0];
const minutes = time[1];
```
[/bad]

Destructuring is very valuable for passing around configuration-like objects.

```js
function uploader({
    element,
    url,
    multiple = false,
    beforeUpload = noop,
    afterUpload = noop,
}) {
    // ...
}
```
