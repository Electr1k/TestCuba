import './bootstrap';

const copyBtn = document.getElementById("copyBtn")
const searchBtn = document.getElementById("searchBtn")

copyBtn.onclick = async function(){
    const word = document.getElementById("copyInput").value
    const response = await fetch("/api/import", {
        method: "POST",
        body: JSON.stringify({
            word: word,
        }),
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    const status_code = response.status
    const result = await response.json();
    if (status_code === 422) {
        alert(result.message);
    }
    else{
        const tBody = document.getElementById("tableBody")
        const article = result.data
        tBody.innerHTML +=
        `<tr>
            <td>${article.title}</td>
            <td><a href=${article.url}>${article.url}</a></td>
            <td>${article.size} КБ</td>
            <td>${article.word_count}</td>
        </tr>`
    }

}

searchBtn.onclick = async function () {
    const word = document.getElementById("searchInput").value
    const response = await fetch(`/api/search?word=${word}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    const status_code = response.status
    const result = await response.json();

    if (status_code === 200) {
        const table = document.getElementById("resultSearch")
        const articles = result.articles
        const total_found = result.total_found
        table.innerHTML = `<li style="list-style-type: none;" class="mb-4"><span>Найдено: ${total_found} совпадений</span></li>`
        articles.forEach(article =>{
            table.innerHTML += `<li style="list-style-type: none;" class="mb-3"><a href="#" class="search-result">${article.title}</a><span> (${article.count} вхождение)</span></li>`;
        })
        document.querySelectorAll('.search-result').forEach((item, index) => {
            item.addEventListener('click', function() {
                const content = document.getElementById("articleContent")
                content.classList.add('card')
                content.innerHTML = `<p>${articles[index].plain_text}</p>`;
            });
        });
    }
    else{
        alert("Произошла ошибка");
    }
}

async function getArticles() {
    const response = await fetch(`/api/articles`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    const status_code = response.status
    const result = await response.json();
    console.log(status_code)
    if (status_code === 200){
        const tBody = document.getElementById("tableBody")
        const articles = result.data
        console.log(result.data)
        articles.forEach(article => {
            tBody.innerHTML +=
                `<tr>
            <td>${article.title}</td>
            <td><a href=${article.url}>${article.url}</a></td>
            <td>${article.size} КБ</td>
            <td>${article.word_count}</td>
        </tr>`
        })
    }
}

getArticles()
