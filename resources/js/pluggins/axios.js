import axios from 'axios';


axios.defaults.withCredentials = true;
axios.defaults.baseURL = window.location.protocol + '//' + window.location.host;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default axios;
