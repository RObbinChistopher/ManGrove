<template>
    <div class="px-4 py-2 flex-between">
        <!-- <h1 class="header">
            Welcome Back <span class="s-text">Christopher</span>
        </h1> -->
        <div class="search-container">
            <input type="search" id="search-input" class="form-control ds-input" placeholder="Search..."
                autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false"
                aria-owns="autocomplete-listbox" dir="auto">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
        <div class="flex-between">
            <div class="d-flex gap-3">
                <img src="../../../../public/svg/user.jpg" class="profile" alt="">
                <div class="" style="margin-top: 17px;">
                    <p class="text mb-0">Christopher</p>
                    <p class="s-text">Administrator</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile {
    width: 41px;
    border-radius: 50%;
    height: 40px;
    margin-top: 17px;
}
.search-container {
    position: relative;
    width: 35%;
}

#search-input {
    padding-left: 50px;
    border: 2px solid var(--pBackground) !important;
    box-shadow: none;
}
#search-input::placeholder{
    font-size: 14px;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #888;
}
</style>