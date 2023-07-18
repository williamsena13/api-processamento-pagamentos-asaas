//window.$ = window.jQuery = require('jquery');

export default class CNPJ {

    constructor( value ){
        console.log("CONSTRUIR CNNPJ")

        try {
            this.value = value.replace(/[^0-9]/g,'')//value;
        } catch (error) {
            this.value = value;

        }

        if ( !value ){
            return false;
        }

        this.pfpj = (value.length == 11 ?  'FÍSICA' : (value.length == 14 ? 'JURÍDICA' : 'NENHUM'));
        this.tipo = (value.length == 11 ?  'CPF' : (value.length == 14 ? 'CNPJ' : 'NENHUM'));

        this.valid = this.validar();
        this.register = false;
        this.mask = this.getMask()
    }
    //**************************************************************************
    validaCpf(cpf) {
        //**********************************************************************

        if (!cpf) {
            return false;
        }

        if (cpf.length != 11) {
            return false;
        }

        switch (cpf) {
            case "00000000000" :
                return false;
            break;
            case "11111111111" :
                return false;
            break;
            case "22222222222" :
                return false;
            break;
            case "33333333333" :
                return false;
            break;
            case "44444444444" :
                return false;
            break;
            case "55555555555" :
                return false;
            break;
            case "66666666666" :
                return false;
            break;
            case "77777777777" :
                return false;
            break;
            case "88888888888" :
                return false;
            break;
            case "99999999999" :
                return false;
            break;
        }

        var soma = 0
        var resto

        for (var i = 1; i <= 9; i++) {
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i)
        }

        resto = (soma * 10) % 11

        if ((resto == 10) || (resto == 11)) {
            resto = 0
        }

        if (resto != parseInt(cpf.substring(9, 10))) {
            return false
        }

        soma = 0

        for (var i = 1; i <= 10; i++)
            soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i)
        resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)) resto = 0
        if (resto != parseInt(cpf.substring(10, 11))) return false
        return true
        //
    }// validaCpf()

    //**************************************************************************
    validaCnpj(cnpj) {

        //
        if ( !cnpj ) {
            return false;
        }

        if (  cnpj.length != 14 ) {
            return false;
        }

        switch (cnpj) {
            case "00000000000000" :
                return false;
            break;
            case "11111111111111" :
                return false;
            break;
            case "22222222222222" :
                return false;
            break;
            case "33333333333333" :
                return false;
            break;
            case "44444444444444" :
                return false;
            break;
            case "55555555555555" :
                return false;
            break;
            case "66666666666666" :
                return false;
            break;
            case "77777777777777" :
                return false;
            break;
            case "88888888888888" :
                return false;
            break;
            case "99999999999999" :
                return false;
            break;
        }//swith()

        var tamanho = cnpj.length - 2
        var numeros = cnpj.substring(0, tamanho)
        var digitos = cnpj.substring(tamanho)
        var soma = 0
        var pos = tamanho - 7

        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--
            if (pos < 2) pos = 9
        }

        var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11

        if (resultado != digitos.charAt(0)) return false;

        tamanho = tamanho + 1
        numeros = cnpj.substring(0, tamanho)
        soma = 0
        pos = tamanho - 7

        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--
            if (pos < 2) pos = 9
        }

        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11

        if (resultado != digitos.charAt(1)) return false

        return true;
    }// fim -> validaCnpj()

    validar(){
        var cnpj = this.value;
        this.value

        if ( cnpj.length < 11 ){
            return false;
        }

        if ( cnpj.length > 14 ){
            return false;
        }

        if ( cnpj.length == 11 ){
            return this.validaCpf(  cnpj );
        }

        if( cnpj.length == 14 ){
            return this.validaCnpj( cnpj );
        }

    }

    getMask(){
        var cnpj = this.value;
        if ( cnpj.length == 14 ){
          return cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5")
        } else
        if ( cnpj.length == 11 ){
          return cnpj.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
        } else {
          return cnpj
        }
    }

}
