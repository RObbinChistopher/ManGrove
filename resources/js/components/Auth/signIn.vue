<template>
    <div class="container">
        <div class="signIn-page p-3">
            <div class="mb-3">
                <img src="/images/logo.png" alt="Logo" class="mangrove-logo mb-2">
                <p class="title-logo">Continue to MANGROVE</p>
            </div>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input v-model="name" type="text" class="form-control" placeholder="Enter Name" id="name"
                        required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address *</label>
                    <input v-model="email" type="email" class="form-control" placeholder="Enter Email" id="email"
                        required />
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone *</label>
                    <!-- <input v-model="phone" type="text" class="form-control" id="phone" required /> -->
                    <vue-tel-input v-model="phone" mode="international" placeholder="Enter Phone"
                        class="flag-input"></vue-tel-input>
                </div>
                <div class="d-flex flex-column gap-3 mt-3" style="text-align: center;">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    <router-link to="/" class="link-items">Already have an account? Login </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            phone: '',
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                });

                alert(response.data.message);

                // Store the cacheKey in localStorage or as a variable
                localStorage.setItem('cacheKey', response.data.cacheKey);
                this.name = '';
                this.email = '';
                this.phone = '';
            } catch (error) {
                alert(error.response.data.message || 'An error occurred.');
            }
        }


    },
};
</script>

<style scoped>
.signIn-page {
    width: 50%;
    margin: 10rem auto;
    background: #f7f8f9;
    border-radius: 10px;
}

.submit-btn {
    background: #92ba51 !important;
    border: 2px solid #92ba51 !important;
    box-shadow: none !important;
    width: 54%;
    margin: auto;
}

.mangrove-logo {
    width: 29%;
}

.title-logo {
    font-size: smaller;
    font-weight: 700;
}

.link-items {
    color: rgb(43 61 142);
}
</style>