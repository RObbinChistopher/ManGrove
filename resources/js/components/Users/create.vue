<template>
    <div class="p-4">
        <div class="row mb-4">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">User Information</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text add-new-cat" style="display: flex; justify-content: flex-end;">
                    <router-link to="/users" class="import2 add-cc hover-cc">Back</router-link>
                </div>
            </div>
        </div>
        <div class="spinner2 d-flex justify-content-center" v-if="profileLoading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="table-main p-3" v-else>
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
                        <input type="text" class="form-control" placeholder="Enter Phone Number" v-model="form.phone" />
                    </div>
                </div>
                <!-- CNIC Image -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">CNIC Image*</label>
                        <input type="file" class="form-control" @change="previewImage($event, 'cnic')"
                            accept="image/*" />
                        <!-- <img :src="form.cnicPreview" class="img-preview" alt="CNIC Preview"> -->
                        <img :src="'/' + form.cnicPreview" class="img-preview" alt="CNIC Preview"
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
                        <img :src="'/' + form.drivingPreview" class="img-preview" alt="Driving Licence Preview"
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
                        <img :src="'/' + form.propertyPreview" class="img-preview" alt="Property Documents Preview"
                            @click="showFullImage(form.propertyPreview)">
                    </div>
                </div>
            </div>


            <div class="mt-3 mb-4" style="display: flex;">
                <button class="import2 add-cc hover-cc" :disabled="passwordLoading" @click="downloadFiles">
                    <span v-if="passwordLoading" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                    <span v-else>DownLoad</span>
                </button>
            </div>

        </div>
        <div v-if="fullWidthImage" class="full-width-overlay" @click="closeFullImage">
            <img :src="'/' + fullWidthImage" class="full-width-image">
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
import { saveAs } from 'file-saver';
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
            ...mapActions('auth', ['fetchSingleUsers']),

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

            downloadFiles() {
                const files = [
                    { name: 'CNIC.jpg', url: this.singleUser.cnic }, 
                    { name: 'Driving_Licence.jpg', url: this.singleUser.driving_licence }, 
                    { name: 'Property_Document.jpg', url: this.singleUser.property_documents } 
                ];

                const folderName = 'Documents'; // Simulated folder name

                // Loop through the files array and check for valid URLs
                files.forEach(file => {
                    if (file.url) {
                        // Create an anchor element to trigger download via URL
                        const link = document.createElement('a');
                        // Here, we add the folder structure to the filename
                        link.href = '/' + file.url;  // Assuming this is a valid URL path to the file on the server
                        link.download = `${folderName}/${file.name}`; // Simulated folder structure in the filename
                        link.click(); // Trigger the download
                    } else {
                        console.error(`Invalid file URL for ${file.name}:`, file.url);
                    }
                });
            }
        },
    computed: {
        ...mapState('auth', ['singleUser', 'singleUserLoading']),
    },
    watch: {
        singleUser(newDetail) {
            if (newDetail) {
                this.form.name = newDetail.name || '';
                this.form.email = newDetail.email || '';
                this.form.phone = newDetail.phone || '';
                this.form.cnicPreview = newDetail.cnic || '';
                this.form.drivingPreview = newDetail.driving_licence || '';
                this.form.propertyPreview = newDetail.property_documents || '';
            }
        },
    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleUsers(this.$route.params.id);
        }

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
