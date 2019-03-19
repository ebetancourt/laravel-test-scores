
function wkhtmltopdf_vars() {
    
    var vars = {};
    var query_strings_from_url = document.location.search.substring(1).split('&');
    for (var query_string in query_strings_from_url) {
        if (query_strings_from_url.hasOwnProperty(query_string)) {
            var temp_var = query_strings_from_url[query_string].split('=', 2);
            vars[temp_var[0]] = decodeURI(temp_var[1]);
        }
    }
    var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
    for (var css_class in css_selector_classes) {
        if (css_selector_classes.hasOwnProperty(css_class)) {
            var element = document.getElementsByClassName(css_selector_classes[css_class]);
            for (var j = 0; j < element.length; ++j) {
                element[j].textContent = vars[css_selector_classes[css_class]];
            }
        }
    }

    return vars;
}

function set_classes(vars) {
    var body = document.body,
        page = typeof vars.page != "undefined" && vars.page,
        topage = typeof vars.topage != "undefined" && vars.topage;
    
    if(page == 1) {
        body.className += ' first-page';
    }

    if(page == topage) {
        body.className += ' last-page';        
    }
}


function init() {
    var vars = wkhtmltopdf_vars();
    set_classes(vars);
}

document.addEventListener("DOMContentLoaded", init);
