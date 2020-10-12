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

```js
// Good
const person = { name: 'Sebastian' };
person.name = 'Seb';

// Bad, the variable was never reassigned
let person = { name: 'Sebastian' };
person.name = 'Seb';
```

## Variable names

Variable names generally shouldn't be abbreviated.

```js
// Good
function saveUser(user) {
    localStorage.set('user', user);
}

// Bad, it's hard to reason about abbreviations in blocks as they grow.
function saveUser(u) {
    localStorage.set('user', u);
}
```

In single-line arrow functions, abbreviations are allowed to reduce noise if the context is clear enough. For example, if you're calling `map` of `forEach` on a collection of items, it's clear that the parameter is an item of a certain type, which can be derived from the collection's substantive variable name.

```js
// Good
function saveUserSessions(userSessions) {
    userSessions.forEach(s => saveUserSession(s));
}

// Ok, but pretty noisy.
function saveUserSessions(userSessions) {
    userSessions.forEach(userSession => saveUserSession(userSession));
}
```

## Comparisons

Always use a triple equal to do variable comparisons. If you're unsure of the type, cast it first.

```js
// Good
const one = 1;
const another = "1";

if (one === parseInt(another)) {
    // ...
}

// Bad
const one = 1;
const another = "1";

if (one == another) {
    // ...
}
```

## Function keyword vs. arrow functions

Function declarations should use the function keyword.

```js
// Good
function scrollTo(offset) {
    // ...
}

// Using an arrow function doesn't provide any benefits here, while the
// `function`  keyword immediately makes it clear that this is a function.
const scrollTo = (offset) => {
    // ...
};
```

Terse, single line functions may also use the arrow syntax. There's no hard rule here.

```js
// Good
function sum(a, b) {
    return a + b;
}

// It's a short and simple method, so squashing it to a one-liner is ok.
const sum = (a, b) => a + b;
```

```js
// Good
export function query(selector) {
    return document.querySelector(selector);
}

// This one's a bit longer, having everything on one line feels a bit heavy.
// It's not easily scannable unlike the previous example.
export const query = (selector) => document.querySelector(selector);
```

Higher-order functions may use arrow functions if it improves readability.

```js
function sum(a, b) {
    return a + b;
}

// Good
const adder = (a) => (b) => sum(a, b);

// Ok, but unnecessarily noisy.
function adder(a) {
    return function (b) {
        return sum(a, b);
    };
}
```

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

```js
// Good
export default {
    methods: {
        handleClick(event) {
            event.preventDefault();
        },
    },
};

// Bad, the `function` keyword serves no purpose.
export default {
    methods: {
        handleClick: function (event) {
            event.preventDefault();
        },
    },
};
```

## Object and array destructuring

Destructuring is preferred over assigning variables to the corresponding keys.

```js
// Good
const [hours, minutes] = '12:00'.split(':');

// Bad, unnecessarily verbose, and requires an extra assignment in this case.
const time = '12:00'.split(':');
const hours = time[0];
const minutes = time[1];
```

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
