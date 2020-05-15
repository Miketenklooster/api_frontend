const url = 'http://www.omdbapi.com/';
const key = 'e94fc62a';

const type = {
    all: '',
    movie: 'movie',
    series: 'series',
    episode: 'episode'
};

function getAll() {
    fetch(url + "?s=" + sessionStorage.getItem('title') + "&apikey=" + key, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((response) => response.json())
        .then((json) => {
            const data = json["Search"];
            return data.map((data) => {
                console.log(data);
            });
        })
        .catch((error) => console.error(error))
}

function getDetails(id) {
    return fetch(url + "?i=" + id + "&plot=full&apikey=" + key, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((response) => response.json())
        .catch((error) => console.error(error))
}

function searchData(title, type) {
    sessionStorage.setItem("title", title);
    return fetch(url + "?s=" + title + "&type=" + type + "&apikey=" + key, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((response) => response.json())
        .then((json) => {
            json.map(json => json["Search"]);
            console.log(json);
        })
        .catch((error) => console.error(error))
}

function getView(elementId, view) {

    sessionStorage.setItem('site', view);
    //e.preventDefault();
    return fetch(view /*, options */)
        .then((response) => response.text())
        .then((html) => {
            const content = document.getElementById(`${elementId}`);
            content.innerHTML = html;
            let scripts = content.getElementsByTagName("script");
            for (let i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerText);
            }
        })
        .catch((error) => console.error(error))
}
