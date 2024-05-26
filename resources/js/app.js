import './bootstrap';

const copyBtn = document.getElementById("copyBtn")
copyBtn.onclick = async function(){
    const word = document.getElementById("copyInput").value
    console.log( JSON.stringify({
        word: word,
    }))
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
            <td>${article.words_count}</td>
        </tr>`
    }

}
