@pushonce('scripts')
    <script defer src="scripts/sidebar.js"></script>
@endpushonce
@pushonce('styles')
    <link rel="stylesheet" href="styles/sidebar.css">
@endpushonce
<div id="sidebar" wire:ignore>
    <div class="sidebarItems">
        <div id="arrowClosed">
            <img src="assets/icons/arrow-right.svg" alt="arrow" class="arrow">
        </div>
        <div id="arrowOpen" class="d-none">
            <img src="assets/images/title.svg" id="logo">
            <img src="assets/icons/arrow-left.svg" alt="arrow" class="arrow">
        </div>
        <ul id="navIcons">
            <div class="active" wire:ignore></div>
            <li wire:click="changeMain('account')">
                <a id="account">
                    <img src="assets/icons/account_colored.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">My account</span>
                </a>
            </li>
            <li wire:click="changeMain('recipes')">
                <a id="recipes">
                    <img src="assets/icons/recipes.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">Recipes</span>
                </a>
            </li>
            <li wire:click="changeMain('userpantry')">
                <a id="pantry">
                    <img src="assets/icons/pantry.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">My pantry</span>
                </a>
            </li>
            <li wire:click="changeMain('weekly')">
                <a id="weekly">
                    <img src="assets/icons/weekly.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">Weekly plan</span>
                </a>
            </li>
            <li wire:click="changeMain('shopping')">
                <a id="shopping">
                    <img src="assets/icons/shopping.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">Shopping list</span>
                </a>
            </li>
            <li wire:click="changeMain('blog')">
                <a id="blog">
                    <img src="assets/icons/blog.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">Blog</span>
                </a>
            </li>
            <li wire:click="changeMain('favorites')">
                <a id="favorite">
                    <img src="assets/icons/favorite.svg" alt="" class="icon" wire:ignore>
                    <span class="d-none position-absolute top-0 left-16">Favorites</span>
                </a>
            </li>
        </ul>
    </div>
</div>
