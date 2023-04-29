const days = document.querySelectorAll('.day')
const dayIndicator = document.getElementById('selectedDay')

days.forEach(day => {
    day.addEventListener('click', () => {
        dayIndicator.style.top = day.offsetTop + 'px'
        dayIndicator.style.left = (day.offsetLeft) + 'px'
    })
});