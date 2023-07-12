import axios from 'axios';

const asaasApi = axios.create({
  baseURL: 'https://sandbox.asaas.com/api/v3/customers', // URL base da API do Asaas
  headers: {
    'Content-Type': 'application/json',
    'X-Api-Key': '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNTg3NTM6OiRhYWNoX2QwNjE4MjQ0LTk3ODMtNGRiMi1iMzljLTAyYmUyNDI4MGQ2Ng==', // Sua chave de API do Asaas
  },
});

export default asaasApi;
