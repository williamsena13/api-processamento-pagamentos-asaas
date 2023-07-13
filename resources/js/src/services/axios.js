import Vue from 'vue';
import axios from "axios";
function  getToken() {
  document.getElementById('edit-api-key')
  if ( !document.getElementById('edit-api-key').value ){ 
    setTimeout( () => {
      this.getToken();
    } , 1000)    
  } else {
     return document.getElementById('edit-api-key').value;
  }
}

Vue.use({
  install(Vue){
    Vue.prototype.$http = axios.create({      
      baseURL: "/api",
      contentType: 'application/json',
      headers :  {
        Authorization: "Bearer " + getToken(),
    }
    })

    Vue.prototype.$http.interceptors.request.use( request => {
        return request;
    }, error => {
        return error
    });

    Vue.prototype.$http.interceptors.response.use( response =>{
      return response
    } , error => {
      return error
    });

    
  }
})
