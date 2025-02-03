<template>
    <div class="container">
        <div class="signIn-page p-3">
            <div class="mb-3">
                <img src="/images/logo.png" alt="Logo" class="mangrove-logo mb-2">
                <p class="title-logo">Continue to MANGROVE</p>
            </div>
            <form @submit.prevent="Addpassword">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="password" required />
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmation" class="form-label">Confirm Password</label>
                    <input v-model="passwordConfirmation" type="password" class="form-control" id="passwordConfirmation"
                        required />
                </div>
                <div class="d-flex flex-column gap-3 mt-3" style="text-align: center;">
                    <button type="submit" class="btn btn-primary submit-btn">Save</button>
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
            password: '',
            passwordConfirmation: '',
        };
    },
    methods: {
        async Addpassword() {
            // Validate that the password and confirmation match
            if (this.password !== this.passwordConfirmation) {
                alert('Passwords do not match!');
                return;
            }

            try {
                const cacheKey = localStorage.getItem('cacheKey'); // Retrieve cacheKey from storage

                const response = await axios.post('/api/add-password', {
                    cacheKey: cacheKey, // Send cacheKey with the request
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                });

                alert(response.data.message);

                // Clear cacheKey from localStorage
                localStorage.removeItem('cacheKey');

                // Redirect to login or dashboard
                this.$router.push('/dasboard');
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