import axios from 'axios';

const accessToken = "$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAzMjM3OTI6OiRhYWNoX2U2NjY0NDQ3LWYyYjktNGIwNy04MDNiLWYwODFlMWI5OTg5MA==";

const asaasService = axios.create({
  baseURL: "https://www.asaas.com/api",
  headers: {
    'Content-Type': 'application/json',
    'access_token': accessToken
  }
});

export default {
  install(Vue) {
    Vue.prototype.$asaas = asaasService;
  }
};
