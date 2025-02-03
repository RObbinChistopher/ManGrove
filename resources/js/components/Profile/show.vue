<template>
    <div class="p-4">
        <div class="row mb-4">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Profile</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text add-new-cat" style="display: flex; justify-content: flex-end;">
                    <router-link to="/model" class="import2 add-cc hover-cc">Back</router-link>
                </div>
            </div>
        </div>
        <div class="spinner2 d-flex justify-content-center" v-if="profileLoading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="table-main p-3" v-else>
            <form @submit.prevent="UpdateProfile()" novalidate>
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Name*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" v-model="form.name"
                                :class="{ 'is-invalid': errors.includes('Your Name Is Required') }" />
                            <span v-if="errors.includes('Your Name Is Required')" class="invalid-feedback">Your Name
                                Is Required</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email*</label>
                            <input type="text" class="form-control" placeholder="Enter Email" v-model="form.email"
                                :class="{ 'is-invalid': errors.includes('Your Email Is Required') }" />
                            <span v-if="errors.includes('Your Email Is Required')" class="invalid-feedback">Your Email
                                Is Required</span>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number*</label>
                            <input type="text" class="form-control" placeholder="Enter Phone Number"
                                v-model="form.phone" />
                        </div>
                    </div>
                    <!-- Profile Image Upload -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Profile Image*</label>
                            <input type="file" class="form-control" @change="previewImage($event, 'profile')"
                                accept="image/*" />
                            <!-- <img :src="form.profilePreview" class="img-preview" alt="Profile Preview"> -->
                            <img :src="form.profilePreview" class="img-preview" alt="Profile Preview"
                                @click="showFullImage(form.profilePreview)">
                        </div>
                    </div>

                    <!-- CNIC Image -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">CNIC Image*</label>
                            <input type="file" class="form-control" @change="previewImage($event, 'cnic')"
                                accept="image/*" />
                            <!-- <img :src="form.cnicPreview" class="img-preview" alt="CNIC Preview"> -->
                            <img :src="form.cnicPreview" class="img-preview" alt="CNIC Preview"
                                @click="showFullImage(form.cnicPreview)">
                        </div>
                    </div>

                    <!-- Driving Licence Image -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Driving Licence Image*</label>
                            <input type="file" class="form-control" @change="previewImage($event, 'driving')"
                                accept="image/*" />
                            <!-- <img :src="form.drivingPreview" class="img-preview" alt="Driving Licence Preview"> -->
                            <img :src="form.drivingPreview" class="img-preview" alt="Driving Licence Preview"
                                @click="showFullImage(form.drivingPreview)">
                        </div>
                    </div>

                    <!-- Property Documents Image -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Property Documents Image*</label>
                            <input type="file" class="form-control" @change="previewImage($event, 'property')"
                                accept="image/*" />
                            <!-- <img :src="form.propertyPreview" class="img-preview" alt="Property Documents Preview"> -->
                            <img :src="form.propertyPreview" class="img-preview" alt="Property Documents Preview"
                                @click="showFullImage(form.propertyPreview)">
                        </div>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="mt-3 mb-4" style="display: flex;">
                    <button class="import2 add-cc hover-cc" :disabled="passwordLoading">
                        <span v-if="passwordLoading" class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        <span v-else>Update</span>
                    </button>
                </div>
            </form>

            <p class="s-text">Update Your Password</p>
            <form @submit.prevent="updatePasswordUser()" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password" class="form-control" placeholder="Enter Password"
                                v-model="new_password" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" placeholder="Enter Confirm Password"
                                v-model="confirm_password">
                        </div>
                    </div>
                </div>

                <!-- Update Password Button -->
                <div class="mt-3" style="display: flex;">
                    <button class="import2 add-cc hover-cc" :disabled="passwordLoading">
                        <span v-if="passwordLoading" class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        <span v-else>Update</span>
                    </button>
                </div>
            </form>
        </div>
        <div v-if="fullWidthImage" class="full-width-overlay" @click="closeFullImage">
            <img :src="fullWidthImage" class="full-width-image">
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import config from '../../config.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                profile: null,
                profilePreview: '',
                cnic: null,
                cnicPreview: '',
                driving: null,
                drivingPreview: '',
                property: null,
                propertyPreview: '',
            },
            errors: [],
            loading: false,
            fullWidthImage: '', // Store clicked image
        };
    },
    methods: {
        ...mapActions('auth', ['fetchloginUser', 'updatePassword']),
        previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                this.form[type] = file;
                const reader = new FileReader();
                reader.onload = () => {
                    this.form[type + 'Preview'] = reader.result; // Set preview for image
                };
                reader.readAsDataURL(file);
            }
        },
        showFullImage(imageSrc) {
            this.fullWidthImage = imageSrc;
        },
        closeFullImage() {
            this.fullWidthImage = '';
        },
        async UpdateProfile() {
            this.errors = [];
            if (!this.form.name) this.errors.push('Your Name Is Required');
            if (!this.form.email) this.errors.push('Your Email Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('email', this.form.email);
            formData.append('phone', this.form.phone);

            if (this.form.profile) formData.append('profile', this.form.profile);
            if (this.form.cnic) formData.append('cnic', this.form.cnic);
            if (this.form.driving) formData.append('driving', this.form.driving);
            if (this.form.property) formData.append('property', this.form.property);

            let url = config.apiBaseUrl + `user-profile-update`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('Your Profile Update Successfully');
                this.loading = false;
                this.fetchloginUser();
            } catch (error) {
                console.error("API call error:", error);
                toast.error('There was an error updating your profile.');
                this.loading = false;
            }
        },
        updatePasswordUser() {
            if (this.new_password !== this.confirm_password) {
                console.log('password not match')
                toast.error('Passwords Are Not Match!');
                return;
            }
            if (!this.new_password || !this.confirm_password) {
                toast.error('Please enter both new and confirm passwords.');
                return;
            }
            this.updatePassword(this.new_password);
            toast.success('Your Password Update Successfully');
        },
    },

    computed: {
        ...mapState('auth', ['profile', 'profileLoading', 'passwordLoading']),
    },

    watch: {
        profile(newDetail) {
            if (newDetail) {
                this.form.name = newDetail.name || '';
                this.form.email = newDetail.email || '';
                this.form.phone = newDetail.phone || '';
                this.form.profilePreview = newDetail.profile || '';
                this.form.cnicPreview = newDetail.cnic || '';
                this.form.drivingPreview = newDetail.driving_licence || '';
                this.form.propertyPreview = newDetail.property_documents || '';
            }
        },
    },

    mounted() {
        this.fetchloginUser();
    }
};
</script>



<style>
/* Style for Image Preview */
.img-preview {
    margin-top: 10px;
    max-width: 150px;
    max-height: 150px;
    display: block;
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 5px;
    cursor: pointer;
}

.full-width-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.full-width-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    cursor: pointer;
}
</style>
