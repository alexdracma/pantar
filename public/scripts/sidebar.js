const arrows = document.querySelectorAll('.arrow')
const sideBar = document.getElementById('sidebar')
const iconTexts = document.querySelectorAll('span.d-none')
const arrowOpen = document.getElementById('arrowOpen')
const arrowClosed = document.getElementById('arrowClosed')
const links = document.querySelectorAll('a')
const icons = document.querySelectorAll('img.icon')
const active = document.querySelector('div.active')

arrows.forEach(arrow => {
    arrow.addEventListener('click', () => {
        if (arrow.src.includes('arrow-right.svg')) {
            openSidebar()
        } else {
            closeSidebar()
        }
    })
});

links.forEach(link => {
    link.addEventListener('click', () => {
        active.style.top = (link.parentElement.offsetTop - 7) + 'px'

        turnOffIcons()
        turnOnIcon(link.querySelector('img.icon'))
    })
})

function openSidebar() {
    sideBar.style.width = '280px'
    iconTexts.forEach(text => {
        text.classList.remove('d-none')
    })
    arrowClosed.classList.add('d-none')
    arrowOpen.classList.remove('d-none')
    arrowOpen.classList.add('d-flex')
}

function closeSidebar() {
    sideBar.style.width = '97px'
    
    arrowOpen.classList.remove('d-flex')
    arrowOpen.classList.add('d-none')
    arrowClosed.classList.remove('d-none')

    delay(500)
    .then(() => {
        iconTexts.forEach(text => {
            text.classList.add('d-none')
        })
    });
}
function getColoredIcon(icon) {
    if (icon.includes('_colored')) {
        return icon
    }
    return icon.replace('.svg', '_colored.svg')
}

function getBWIcon(icon) {
    if (icon.includes('_colored')) {
        return icon.replace('_colored','')
    }
    return icon
}

function turnOffIcons() {
    icons.forEach(icon => {
        icon.src = getBWIcon(icon.src)
    })
}

function turnOnIcon(icon) {
    icon.src = getColoredIcon(icon.src)
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}