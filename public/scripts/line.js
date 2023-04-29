
window.addEventListener('load', init)

function init() {

    const checks = document.querySelectorAll('input[type="checkbox"]')

    checks.forEach(check => {

        editCheck(check)

        this.addEventListener('change', function() {
            editCheck(check)
        })
    })
}

function editCheck(check) {
    const line = check.parentElement.parentElement.parentElement.querySelector('span.line')

    if (check.checked) {
        line.style.width = '100%'
    } else {
        line.style.width = '0%'
    }
}