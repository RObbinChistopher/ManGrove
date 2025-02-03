// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    production: {
        apiBaseUrl: 'https://crm.visetech.org/api/'
    }
};

const environment = 'development';
export default config[environment];
