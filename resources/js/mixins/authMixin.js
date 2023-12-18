export default {
    methods: {
        setAuthToken(token) {
            localStorage.setItem('authToken', token);
        },
        getAuthToken() {
            return localStorage.getItem('authToken');
        },
    },
};
