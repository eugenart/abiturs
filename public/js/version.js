// window.onload = () => {
//     requireCSS(document.location.origin + '/css/style.css', false)
// };


let ovzBtn = document.getElementById('ovz_version');

document.getElementById('ovz_version').addEventListener('click', () => {
    setCookie();
    console.log(getCookie('isOVZ'))
});


function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}


// $('#ovz_version').click(() => {
//     requireCSS(document.location.origin + '/css/style.css', false)
// });
//
//
function requireCSS(url, isOvz) {
    document.getElementById('#ovzCSSLink') ? document.getElementById('#ovzCSSLink').remove() : null;
    var cssLink = document.createElement("link");
    cssLink.href = url;
    cssLink.id = 'ovzCSSLink';
    cssLink.type = "text/css";
    cssLink.rel = "stylesheet";
    cssLink.setAttribute('data-ovz', isOvz);
    document.getElementsByTagName("head")[0].appendChild(cssLink);
}

function setCookie() {
    document.cookie = 'isOVZ=true; expires=; path=/'
}
