<div class="container-xxl">

    <link rel="stylesheet" href="styles/weekly.css">

    <div class="row d-flex flex-column-reverse flex-md-row pt-4 pt-lg-5 pt-xl-8">

        <!-- Calendar section -->
        <section class="col p-4">
            <div id="calendar" class="row">
                <div id="hangers"></div>
                <div id="calendarHeader" class="pt-4 pb-3">
                    <h3>January</h3>
                </div>
                <div id="calendarBody" class="px-2 py-4">
                    <div id="selectedDay"></div>
                    <div class="row row-cols-7 g-0">
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day">1</div>
                        <div class="col day">2</div>
                        <div class="col day">3</div>
                        <div class="col day">4</div>
                        <div class="col day">5</div>
                        <div class="col day">6</div>
                        <div class="col day">7</div>
                        <div class="col day">8</div>
                        <div class="col day">9</div>
                        <div class="col day">10</div>
                        <div class="col day">11</div>
                        <div class="col day">12</div>
                        <div class="col day">13</div>
                        <div class="col day">14</div>
                        <div class="col day">15</div>
                        <div class="col day">16</div>
                        <div class="col day">17</div>
                        <div class="col day">18</div>
                        <div class="col day">19</div>
                        <div class="col day">20</div>
                        <div class="col day">21</div>
                        <div class="col day">22</div>
                        <div class="col day">23</div>
                        <div class="col day">24</div>
                        <div class="col day">25</div>
                        <div class="col day">26</div>
                        <div class="col day">27</div>
                        <div class="col day">28</div>
                        <div class="col day">29</div>
                        <div class="col day">30</div>
                        <div class="col day">31</div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                        <div class="col day"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pad section -->
        <section class="col p-3">
            <div id="pad" class="text-center">
                <div id="clip"></div>
                <h2 class="pt-7 mb-4 pb-2">
                    Friday Jan 13th
                    <span class="ms-3"><img src="assets/icons/edit.svg" id="edit"></span>
                </h2>
                <div class="row mb-3">
                    <h3>Breakfast</h3>
                    <div class="recipe row p-0 g-0 overflow-hidden">
                        <div class="col-5">
                            <img src="assets/images/Recipe1.png" class="w-100 h-100">
                        </div>
                        <div class="col-7 text-start py-1 px-2">
                            <h4>Simple chicken salad</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <h3>Lunch</h3>
                    <div class="recipe row p-0 g-0 overflow-hidden">
                        <div class="col-5">
                            <img src="assets/images/Recipe2.png" class="w-100 h-100">
                        </div>
                        <div class="col-7 text-start py-1 px-2">
                            <h4>Brined Chicken Breast with Sautéed Onion Dipping Sauce</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <h3>Dinner</h3>
                    <div class="recipe d-flex align-items-center justify-content-center">
                        <img src="assets/icons/add.svg" class="add">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        const days = document.querySelectorAll('.day')
        const dayIndicator = document.getElementById('selectedDay')

        days.forEach(day => {
            day.addEventListener('click', () => {
                dayIndicator.style.top = day.offsetTop + 'px'
                dayIndicator.style.left = (day.offsetLeft) + 'px'
            })
        });

    </script>
</div>
