// Дожидаемся загрузки контента
document.addEventListener('DOMContentLoaded', function() {

    const copyBtn = document.getElementById('copyBtn')
    const searchBtn = document.getElementById("searchBtn")
    const spinner = document.getElementById("spinner")
    copyBtn.onclick = async function(){
        spinner.classList.remove('d-lg-none')
        const word = document.getElementById("copyInput").value
        const start = Date.now();
        await fetch("/api/import", {
            method: "POST",
            body: JSON.stringify({
                word: word,
            }),
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        }).then(async response => {
            spinner.classList.add('d-lg-none')
            if (!response.ok) {
                if (response.status === 422) alert("Статья не найдена");
                else alert("Произошла ошибка")
            } else {
                await response.json().then(result => {
                    // Добавляем блок с результатом добавления
                    const resultContainer = document.getElementById("resultImport")
                    resultContainer.classList.add('card')
                    resultContainer.classList.add('mb-4')
                    resultContainer.classList.add('p-3')
                    resultContainer.innerHTML = `
                    <span>Импорт завершен.</span><br>
                    <span>Найдена статья по адресу: <a href="${result.url}">${result.url}</a></span>
                    <span>Время обработки: ${(Date.now() - start) / 1000} мс</span>
                    <span>Размер статьи: ${result.size} КБ</span>
                    <span>Количество слов: ${result.word_count}</span>
                `

                    // Добавляем запись в таблицу
                    const tBody = document.getElementById("tableBody")
                    tBody.innerHTML +=
                        `<tr>
                        <td>${result.title}</td>
                        <td><a href=${result.url}>${result.title}</a></td>
                        <td>${result.size} КБ</td>
                        <td>${result.word_count}</td>
                    </tr>`
                })
            }
        })
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

            // Заполняем список
            articles.forEach(article =>{
                table.innerHTML += `<li style="list-style-type: none;" class="mb-3"><a href="#" class="search-result">${article.title}</a><span> (${article.count} вхождение)</span></li>`;
            })

            document.querySelectorAll('.search-result').forEach((item, index) => {
                item.addEventListener('click', function() {
                    const content = document.getElementById("articleContent")
                    content.classList.add('card')
                    content.innerHTML = `
                    <h3 class="card-title">
                        ${articles[index].title}
                    </h3>
                    <p>${articles[index].plain_text}</p>`;
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

            // Заполняем таблицу
            articles.forEach(article => {
                tBody.innerHTML +=
                    `<tr>
            <td>${article.title}</td>
            <td><a href=${article.url}>${article.title}</a></td>
            <td>${article.size} КБ</td>
            <td>${article.word_count}</td>
        </tr>`
            })
        }
    }

    getArticles()
});
