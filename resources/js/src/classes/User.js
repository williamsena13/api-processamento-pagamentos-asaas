import CNPJ from './cnpj';
export default class User {
  setToken( token ){
    this.apiToken = token
  }
  constructor() {
      this.name = String;
      this.cnpj = String;
      this.password = String;
      this.level = Number
      this.valid = false;
      this.apiToken = String
  }

  setCnpj( cnpj ){
      //console.log('setCnpj', this)
      this.cnpj = cnpj
  }

  setPassword( password ){
    this.password = password
  }

  setUser( cnpj , password ){
    this.setCnpj(cnpj)
    this.setCnpj(password);
  }

  setValid( value ){
    this.valid = value
  }

  validar(){
      try {

        //console.log(' estou no valid' )
        if ( !this.password ) {
            return false;
        }

        if ( this.password.length < 3 ){
          return false;
        }
        var cnpj = new CNPJ( this.cnpj );
        var valido =  cnpj.validar()
        this.setValid( valido );
      } catch (e) {
        console.log( ">> Erro ao validar User.js <<");
        console.log(e);
        this.setValid( false );
      }


  }

  find() {

  }

}
