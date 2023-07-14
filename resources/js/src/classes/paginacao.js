export default class Paginacao {

    getCurrentPage(ppage){
        try {
          console.log("por page", ppage);
            var query = location.search.slice(1);
            var paginate = null;
            if ( query != '' ){
              query = query.replace( 'page=' , '' );
              if ( query != ppage ){
                return query;
              } else {
                return 1;
              }
            } else {
              return 1;
            }
        } catch (e) {
          console.log("Erro recuperar paginação ", e);
          var paginate = null;
        }
    }

    setPagination(array, page_size, page_number) {
      try {
        return array.slice(page_number * page_size, page_number * page_size + page_size);
      } catch (e) {
        return array
      }
    }

    getPageSize(array, recordsPage){
        console.log("array")
        console.log(array);
        console.log(recordsPage);
        try {
          return Math.ceil(array.length / recordsPage)
        } catch (e) {
          console.log("ERRO AO CARREGAR PAGE SIZE");
          console.log(e);
          return 0;
        }
    }

}
