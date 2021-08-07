const form = document.querySelector('#needs-validation')
const info = document.querySelector('.info-msg')
const url = '/backend/ajaxHandler.php'

form.addEventListener('submit', function (event) {

    event.preventDefault()
    event.stopPropagation()
    this.classList.add('was-validated');

    if (!this.checkValidity()) return false

    const data = Object.fromEntries(new FormData(this))

    antiSpam(this)

    request(url, 'POST', data).then(data => {
        animationInfoBlock(data)
        addNewCard(data)
    })

}, false)


function antiSpam(form) {
    const button = document.getElementById('send')
    button.setAttribute("disabled", "true")
    const textArea = document.getElementById('comments')

    let sec = 5
    const timer = setInterval(() => {
        if (sec === 0) {
            button.removeAttribute('disabled')
            button.removeAttribute('style')
            textArea.value = ''
            form.classList.remove('was-validated')
            clearInterval(timer)
        }
        button.textContent = sec > 0 ? `Доступно будет через ${sec}` : button.textContent = `Записать`
        sec--
    }, 1000)

}


function addNewCard(response) {
    const object = response['card']
    const card = `<article class="card">
                    <h3>${object['name']}</h3>
                    <div class="container">    
                        <p class="email">${object['email']}</p>
                        <p class="msg">${object['comment']}</p>
                    </div>
            </article>`
    const cards = document.querySelector('.cards')
    cards.insertAdjacentHTML('afterbegin',card)
}

function animationInfoBlock(response) {

    const icon = parseInt(response.code) === 201 ? '<span style="color:#13d26c">&#10003;</span>'
        : '<span style="color:#ef5656">&#128683;</span>'
    info.innerHTML = `${icon} ${response.msg}`

    const handler = () => {
        info.classList.remove('info-enter-active')

        info.style.display = 'none'
        info.removeEventListener('animationend', handler)
    }

    info.style.display = 'block'
    info.classList.add('info-enter')

    raf(function () {
        info.classList.add('info-enter-active')
        info.classList.remove('info-enter')
    })

    info.addEventListener('animationend', handler)

}

function raf(fn) {
    window.requestAnimationFrame(() => {
        window.requestAnimationFrame(() => {
            fn()
        })
    })
}


async function request(url, method, data) {
    return (await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })).json();
}