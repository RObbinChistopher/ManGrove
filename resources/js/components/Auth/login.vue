<template>
    <div class="container">
        <div class="signIn-page p-3">
            <div class="mb-3">
                <img src="/images/logo.png" alt="Logo" class="mangrove-logo mb-2">
                <p class="title-logo">Continue to MANGROVE</p>
            </div>
            <div v-if="step === 1">
                <form @submit.prevent="sendVerificationCode">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input v-model="email" type="email" class="form-control" placeholder="Enter Email" id="email"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input v-model="password" type="password" class="form-control" placeholder="Enter Password"
                            id="password" />
                    </div>
                    <div class="d-flex flex-column gap-3 mt-3" style="text-align: center;">
                        <button type="submit" class="btn btn-primary submit-btn">Send Verification Code</button>
                        <router-link to="/sign-in" class="link-items">Don't have an account? Sign Up </router-link>
                    </div>
                </form>
            </div>
            <div v-if="step === 2">
                <form @submit.prevent="verifyCode">
                    <div class="mb-3">
                        <label for="verificationCode" class="form-label">Verification Code</label>
                        <input v-model="verificationCode" type="text" class="form-control"
                            placeholder="Enter Verification Code" id="verificationCode" required />
                    </div>
                    <div class="d-flex flex-column gap-3 mt-3" style="text-align: center;">
                        <button type="submit" class="btn btn-primary submit-btn">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            verificationCode: '',
            password: '',
            passwordConfirmation: '',
            step: 1,
        };
    },
    methods: {
        async sendVerificationCode() {
            try {
                const response = await axios.post('/api/send-verification-code', { email: this.email, password: this.password });
                alert(response.data.message);
                this.step = 2; // Move to verification code step
            } catch (error) {
                alert(error.response.data.message || 'An error occurred.');
            }
        },
        async verifyCode() {
            try {
                const response = await axios.post('/api/verify-code', {
                    email: this.email,
                    verification_code: this.verificationCode,
                });
                const { token, user } = response.data;
                localStorage.setItem('token', token);
                localStorage.setItem('userRole', user.role);

                alert(response.data.message);
                this.$router.push('/dashboard');
            } catch (error) {
                alert(error.response.data.message || 'Verification failed.');
            }
        },
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