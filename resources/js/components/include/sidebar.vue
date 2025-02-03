<template>
    <div class="Sidebar p-4">
        <div>
            <img src="/images/logo.png" alt="Logo" class="mangrove-logo mb-2">
        </div>
        <div class="d-flex flex-column flex-shrink-0 py-3">
            <ul class="nav nav-pills flex-column mb-auto">
                <router-link to="/dashboard"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/dashboard') }" active-class="active"
                    aria-current="page" class="link-items mt-3 mb-2 common-side-item">
                    <li class="nav-item mb-2 mt-1">
                        <i class="fa-solid fa-gauge  common-icon"></i>
                        Dashboard
                    </li>
                </router-link>
                <router-link to="/users"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/users') || isActive('/user-information') }"
                    active-class="active" class="link-items mb-2 common-side-item">
                    <li class="nav-item mb-2 mt-1">
                        <i class="fa-solid fa-users common-icon"></i>
                        Users
                    </li>
                </router-link>

                <router-link to="/user-profile"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/user-profile') }" active-class="active"
                    aria-current="page" class="link-items mb-2 common-side-item">
                    <li class="nav-item mb-2 mt-1">
                        <i class="fa-solid fa-user common-icon"></i>
                        Profile
                    </li>
                </router-link>
                <router-link to="/" @click="logoutUser" aria-current="page" class="link-items mb-2 common-side-item">
                    <li class="nav-item mb-2 mt-1">
                        <i class="fa-solid fa-right-from-bracket common-icon"></i>
                        Logout
                    </li>
                </router-link>
            </ul>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    methods: {
        ...mapActions('auth', ['logout', 'fetchloginUser']),
        isActive(route) {
            const path = this.$route.path;
            const basePath = route.split('/').filter(part => !part.startsWith(':')).join('/');
            console.log(`Checking if ${path} starts with ${basePath}`);
            return path.startsWith(basePath);
        },
        logoutUser() {
            this.logout();
            this.$router.push('/');
        },
    },
}
</script>

<style scoped>
.link-items {
    color: black;
    font-size: 15px;
    text-decoration: none;
    padding: 1px 13px !important;

}

.nav-item {
    font-weight: 700 !important;
}

.Sidebar {
    background-color: #f7f8f9;
    height: 100vh;
    color: white !important;
    overflow-y: auto;
    /* Enable vertical scrolling */
}


.common-icon {
    width: 21px;
}

.active {
    background-color: var(--pBackground) !important;
    border-radius: 10px;
    color: white;
}

.mangrove-logo {
    width: 90%;
}
</style>