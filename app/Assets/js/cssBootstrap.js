var test = document.createElement("div")
test.className = "hidden d-none"

document.head.appendChild(test)
var cssLoaded = window.getComputedStyle(test).display === "none"
document.head.removeChild(test)

if (!cssLoaded) { // verificar se o css bootstrap via CDN foi carregado
    var link = document.createElement("link");

    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = "http://localhost/mercearia/app/Assets/bootstrap/css/bootstrap.css";

    document.head.appendChild(link);
}

