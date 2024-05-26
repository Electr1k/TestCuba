import './bootstrap';

const copyBtn = document.getElementById("copyBtn")
const searchBtn = document.getElementById("searchBtn")
var articles
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
    console.log(result)
    console.log(status_code)
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
    console.log("Click")
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
        articles = result.data
        table.innerHTML = ''
        articles.forEach(article =>{
            console.log(article)
            table.innerHTML += `<li style="list-style-type: none;" class="mt-3"><a href="#" class="search-result">${article.title}</a><span>(${article.count} вхождение)</span></li>`;
        })
        document.querySelectorAll('.search-result').forEach((item, index) => {
            item.addEventListener('click', function() {
                document.getElementById("city").innerHTML = `<p>${articles[index].plain_text}</p>`;
            });
        });
    }
    else{
        alert("Произошла ошибка");
    }
}


