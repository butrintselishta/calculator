import axios from "axios";
import { getAuthToken } from '../helpers/authHelper';

export default {
    endpoint(path) {
        return 'http://127.0.0.1:8000/api/' + path;
    },
    defaultHeaders() {
        return {
            Authorization: `Bearer ${getAuthToken()}`,
        };
    },

    async PostCalculation(expression) {
        const httpHeaders = this.defaultHeaders();
        return axios.post(this.endpoint(`calculate`), { expression: expression },
            { headers: httpHeaders }
        );
    },
}
