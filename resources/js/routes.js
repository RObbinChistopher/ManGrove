import signIn from './components/Auth/signIn.vue';
import login from './components/Auth/login.vue';
import Password from './components/Auth/Password.vue';
import Profile from './components/Profile/show.vue'

// user Table
import userShow from './components/Users/show.vue';
import userCreate from './components/Users/create.vue';
const routes = [
    { path: '/sign-in', component: signIn, name: 'signIn', meta: { showHeader: false, showSlideBar: false }  },
    { path: '/', component: login, name: 'login', meta: { showHeader: false, showSlideBar: false }  },
    { path: '/password', component: Password, name: 'Password', meta: { showHeader: false, showSlideBar: false }  },

    // profile
    { path: '/user-profile', component: Profile, name: 'Profile' },
    
    // user
    { path: '/users', component: userShow, name: 'userShow' },
    { path: '/user-information/:id', component: userCreate, name: 'userEdit' },

];

export default routes;
