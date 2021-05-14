var xhr = new XMLHttpRequest();
xhr.open("POST", 'https://scope.spatie.be/scope', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.send(JSON.stringify({
    url: window.location.href
}));
