<script>
import CNPJ from "../src/classes/cnpj";
import Paginacao from "../src/classes/paginacao";
export default {
  data() {
    return {
      loading: true, // Carregar ou não
      //search : '', // Varialvel de busca
      page: 0, // Pagina dos registros
      record_page: 10, // ATIBUIR V-MODEL A UM SELECT
      dados_grid: [],
      //acessos : [],
      ordenable: "",
      checked: false,
      //array_tabela : [], // Dados da Tabela
    };
  },
  props: {
    clickHandler: { type: Function, default: function () {} },
    refreshFunction: { type: Function, default: null },
    title: "", // Define titulo do componente
    array_tabela: [],
    menus: [],
    filtros: [], // FILTRO DO HEADER DA TABLE
    header: Array,
    endpoint: String,
    localData: String,
    openModal: Boolean,
    exportarExcel: String,
    //
    urlExcel: String,
    componentName: String,
    parametroSearch: String,

    arr_funcoes: [],

    funcoes_multiplas: [], // FUNCOES QUE SERAO UTILIZADAS EM FILTROS MULTIPLOS
  },
  //
  created() {
    try {
      if (this._props.array_tabela) {
        if (this._props.array_tabela.length == 0) {
          return;
        }
        if (this._props.array_tabela.length < 1) {
          try {
            this._props.array_tabela = JSON.parse(
              localStorage.getItem(this.localData)
            );
          } catch (e) {
            this._props.array_tabela = localStorage.getItem(this.localData);
          }

          //document.getElementById('btn-recarregar-dados-' + this._props.componentName).click()
        }
        if (this._props.array_tabela.length > 0) {
          this.dados_grid = this._props.array_tabela;
          this.loading = false;
        }
      } // if
    } catch (e) {
      console.log("Erro ao criar vc-grid-padrao", e);
    }
  },
  watch: {
    page() {
      localStorage.setItem("page-" + this._props.componentName, this.page);
    },
    record_page() {
      this.carregando = true;
      this.page = 1;
      this.carregando = false;
    },
  },
  computed: {
    getLoading() {
      return this.loading;
    },
    getTitle() {
      return this.title;
    },
    getDadosTabela() {
      return this.dados_grid;
      //return this.array_tabela
    },
    getPageSize() {
      try {
        if (this.getDadosTabela == null) {
          return;
        }
        if (this.getDadosTabela.length == 0) {
          return 1;
        }
        //if ( this.getDadosTabela.length == 10  ){
        //    return this.getDadosTabela;
        //}
        return new Paginacao().getPageSize(
          this.getDadosTabela,
          this.record_page
        );
      } catch (e) {
        console.log("ERRO AO PEGAR TAMANHO", e);
      }
    }, //getPageSize
    getRecords() {
      //  Função Computed para chamar paginação
      try {
        return this.getPaginados();
      } catch (e) {
        console.log("Erro ao carregar dados");
        console.log(e);
        return [];
      }
    },
    getMenus() {
      return this.menus;
    },
    getRefreshButton() {
      return this._props.refreshFunction != null;
    },
    /*
      checked(){
        try {
            this.validarBotoesFuncoes();
        } catch (error) {
            console.log("Erro em função computed checked()");
            console.log(error);
        }
      }// checked()
      */
  },
  methods: {
    getMaskCnpj(cnpj) {
      if (!cnpj) return;
      return new CNPJ(cnpj).mask;
    },
    maskTelefone(telefone) {
      try {
        if (!telefone) return;
        var r = telefone.replace(/\D/g, "");

        r = r.replace(/^0/, "");
        if (r.length > 10) {
          r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
          r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
          r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
          r = r.replace(/^(\d*)/, "($1");
        }
        return r;
      } catch (error) {
        return r;
      }
    },
    setTitle(title) {
      this.title = title;
    },
    getPaginados() {
      try {
        if (this.getDadosTabela == null) {
          return [];
        }

        if (this.dados_grid == undefined) {
          return [];
        }

        if (this.getDadosTabela.length == 0) {
          return [];
        }
        // é valido
        if (this.getDadosTabela.length <= 10) {
          return this.getDadosTabela;
        }
        let nr_page = this.page == 0 ? this.page : this.page - 1;
        return new Paginacao().setPagination(
          this.dados_grid,
          this.record_page,
          nr_page
        );
      } catch (e) {
        console.log(
          "ERRO NO GET PAGINADOS DO COMPONENTE: " + this._props.componentName,
          e
        );
        return [];
      }
    },
    clickButton(button, record, key) {
      console.log("CLICK BUTTON");
      if (!button) {
        console.log("SEM BOTAO", button, record);
        return;
      }
      try {
        console.log(button);
        if (!button.function.name) {
          return;
        }
        if (!record && !key) {
          button.function();
        } else if (!key && !button.field) {
          button.function(record);
        } else if (button.field) {
          button.function(key, record[button.field]);
        } else if (!key) {
          button.function(record);
        } else {
          if (!button.campo) {
            button.function(key);
          }
          button.function(record);
        }
      } catch (e) {
        console.log("ERRO AO CLICK NO TESTE");
        console.log(e);
      }

      if (button.refresh) {
        setTimeout(() => {
          this.limparFiltro();
          this.loading = false;
        }, 3000);
      }
    },
    searchValue(cabecalho) {
      var input =
        this.$refs[
          this._props.componentName + "-" + cabecalho.field + "-search"
        ][0];
      if (!input) {
        alert("Não foi possível fazer pesquisa");
        return;
      }

      var search = input.value;

      try {
        if (search.length == 0) {
          localStorage.removeItem(
            this._props.componentName + "_filtro_" + cabecalho.field
          );
          this.page = 1;
        }
        if (search.length > 0) {
          localStorage.setItem(
            this._props.componentName + "_filtro_" + cabecalho.field,
            search
          );
          this.page =
            Number(localStorage.getItem("page-" + this._props.componentName)) >
            0
              ? Number(
                  localStorage.getItem("page-" + this._props.componentName)
                )
              : 1;
        }
      } catch (e) {
        console.log("ERRO AO MONTAR STORAGE");
        console.log(e);
      }

      this.dados_grid = JSON.parse(localStorage.getItem(this.localData));
      var array_dados = JSON.parse(localStorage.getItem(this.localData));
      localStorage.setItem(
        "header_grid_" + this._props.componentName,
        JSON.stringify(this._props.header)
      );
      let header_aux = JSON.stringify(this._props.header);
      let pro_header = JSON.parse(header_aux);
      for (var i = 0; i < pro_header.length; i++) {
        console.log(pro_header[i]);
        if (pro_header[i].title == "[ ]" || pro_header[i].title == "Opções") {
          pro_header.splice(i, 1);
        }
      }
      var inputs = document.getElementsByClassName(
        "input-pesquisa-" + this._props.componentName
      );
      try {
        //
        for (var i = 0; i < inputs.length; i++) {
          if (!inputs[i]) {
          } else if (!inputs[i].value) {
          } else if (inputs[i].value.length > 0) {
            search = inputs[i].value;

            array_dados = array_dados.filter((record) => {
              if (record[pro_header[i].field] == null) return false;
              //
              if (
                pro_header[i].title == "Opções" ||
                pro_header[i].title == "OPÇÕES" ||
                pro_header[i].title == "[ ]"
              ) {
                return;
              }

              if (pro_header[i].condition) {
                vazio = false;
                let condicao = (
                  record[pro_header[i].field] == pro_header[i].condition
                    ? pro_header[i].verdade
                    : pro_header[i].falso
                ).toUpperCase();
                return condicao.indexOf(search.toUpperCase()) != -1;
              } // if

              if (pro_header[i].datetime || pro_header[i].date) {
                let data_banco = new Date(record[pro_header[i].field]);
                let data_input = new Date(search);

                if (!pro_header[i].menor) {
                  return data_banco >= data_input;
                }
                return data_banco <= data_input;
              }

              if (pro_header[i].cnpj) {
                let buscar = search.toUpperCase();
                if (record[pro_header[i].field].length == 14) {
                  buscar = buscar
                    .replace(".", "")
                    .replace(".", "")
                    .replace("/", "")
                    .replace("-", "");
                } else if (record[pro_header[i].field].length == 11) {
                  buscar = buscar
                    .replace(".", "")
                    .replace(".", "")
                    .replace("-", "");
                }
                return record[pro_header[i].field].indexOf(buscar) != -1;
              }
              return (
                record[pro_header[i].field]
                  .toUpperCase()
                  .indexOf(search.toUpperCase()) != -1
              );
            });
          } // if
        } // for
        //
      } catch (e) {
        console.log("ERRO AO FILTRAR DADOS");
        console.log(e);
        array_dados = JSON.parse(localStorage.getItem(this.localData));
      }

      this.dados_grid = array_dados;
      return this.getPaginados();
    },
    chamarLimparFiltro() {
      this.limparStorage();
      this.limparFiltro();
    },
    limparFiltro() {
      var inputs = document.getElementsByClassName(
        "input-pesquisa-" + this._props.componentName
      );
      this.dados_grid = [];
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
      } // for
      this.dados_grid = JSON.parse(localStorage.getItem(this.localData));
    },
    carregaDados() {
      var objeto = JSON.parse(localStorage.getItem(this.localData));
      this.loading = true;
      this.dados_grid = [];
      try {
        //
        setTimeout(() => {
          this.dados_grid = JSON.parse(localStorage.getItem(this.localData));
          this.loading = false;
          setTimeout(() => {
            this.popularStorage();

            this.validarBotoesFuncoes();
          }, 500);
        }, 1000);
        //
      } catch (error) {
        console.log("Erro ao carregar dados da grid padrão");
        console.log(error);
      }
    },
    buscarDados() {
      if (!this._props.refreshFunction) {
        alert("Não foi possível carregar dados!");
      }
      this.loading = true;
      this._props.refreshFunction();
    },
    exportarParaExecel(parans) {
      let parametro = JSON.parse(localStorage.getItem("parametro_companies"));
      try {
        let entidades = Object.entries(parametro);
        var p_parametro = [];
        for (var i = 0; i < entries.length; i++) {
          p_parametro.push({ entidades: entidades[1] });
        }
      } catch (e) {
        console.log("Erro ao da foreach");
        console.log(e);
      }
      return;
      this.$http
        .get(this.endPoint, {
          params: parametro,
        })
        .then((response) => {
          this.response = response.data;
          if (response.data.data) {
            this.$store.commit("setResponse", response.data);
            this.empresas = response.data.data;
            localStorage.setItem(
              "search_companies",
              JSON.stringify(response.data.data)
            );
          } else {
            this.empresas = response.data;
            localStorage.setItem(
              "search_companies",
              JSON.stringify(response.data)
            );
          }
          $("#btn-recarregar-dados-" + this._props.componentName).click();
        })
        .catch((error) => {
          console.log("Erro ao buscar empresas");
          console.log(error);
          this.error = error;
        });
    },
    sortTable(field) {
      //
      var campo = field.field;

      var ordenacao =
        this.ordenable == ""
          ? "DESC"
          : this.ordenable == "DESC"
          ? "ASC"
          : "DESC";
      this.ordenable = ordenacao;
      var array = this.dados_grid; //JSON.parse(localStorage.getItem(this.localData));//this.dados_grid;
      this.loading = true;
      try {
        array.sort((a, b) => {
          if (field.float) {
            try {
              if (ordenacao == "DESC") {
                if (Number(a[campo]) < Number(b[campo])) {
                  return 1;
                } else if (Number(a[campo]) > Number(b[campo])) {
                  return -1;
                } else {
                  return 0;
                } // else
              } else {
                if (Number(a[campo]) > Number(b[campo])) {
                  return 1;
                } else if (Number(a[campo]) < Number(b[campo])) {
                  return -1;
                } else {
                  return 0;
                } // else
              } // else
            } catch (e) {
              return 0;
            } // catch
          } else {
            try {
              if (ordenacao == "DESC") {
                if (a[campo].toLowerCase() < b[campo].toLowerCase()) {
                  return 1;
                } else if (a[campo].toLowerCase() > b[campo].toLowerCase()) {
                  return -1;
                } else {
                  return 0;
                }
              } else {
                if (a[campo].toLowerCase() > b[campo].toLowerCase()) {
                  return 1;
                } else if (a[campo].toLowerCase() < b[campo].toLowerCase()) {
                  return -1;
                } else {
                  return 0;
                }
              }
            } catch (e) {
              return 0;
            }
          } // else
          //return a.toLowerCase() > b.toLowerCase() ? 1 : -1
        });
        this.array = array;
        this.dados_grid = array;
      } catch (e) {
        console.log("Erro ao ordenar grid padrão!");
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    getTitleRecord(cabecalho, record) {
      if (!cabecalho.tooltip) {
        return "";
      }
      return record[cabecalho.tooltip];
    },
    getIdInputSelect(cabecalho, record) {
      if (!cabecalho.field) {
        return !cabecalho.editId ? "" : cabecalho.editId;
      }
      return !cabecalho.editId
        ? record[cabecalho.field]
        : cabecalho.editId + "-" + record[cabecalho.field];
    },
    changeInput(input, record, key) {
      //console.log(input, record, key);
      try {
        if (!input.function) {
          return;
        }
        if (input.field) {
          input.function(key, record[input.field]);
        } else if (!key) {
          input.function(record);
        } else {
          input.function(key);
        } // else
      } catch (e) {
        console.log("errro ao alterar input");
        console.log(e);
      }
      if (input.refresh) {
        setTimeout(() => {
          this.limparFiltro();
          this.loading = false;
        }, 3000);
      }
    },
    getCondition(button, record) {
      if (
        !button.opcoes &&
        !button.show &&
        button.condition &&
        button.operador &&
        button.valor
      ) {
        if (button.operador == "==") {
          if (record[button.campo] == button.valor) {
            return true;
          } else {
            return false;
          } // else
        } else if (button.operador == "!=") {
          if (String(record[button.campo]) != String(button.valor)) {
            return true;
          } else {
            return false;
          } // else
        } // if
      }
      return false;
    },
    getClassAtributo(header, record) {
      if (header.functionClass && header.campo) {
        return header.functionClass(record[header.campo]);
      }
      if (header.functionClass) {
        return header.functionClass(record);
      }
      return "";
    },
    mudaCheckBox(filtro) {
      filtro.value = !filtro.value;
      if (filtro.function) {
        filtro.function(filtro.value);
      } // if
    },
    changeFiltro(filtro) {
      filtro.value = filtro.value;
      if (filtro.function) {
        filtro.function(filtro.value);
      }
    },
    functionFiltro(filtro) {
      console.log("Função do filtro", filtro);
      if (filtro.function) {
        filtro.function();
      }
    },
    clickBotao(header, register) {
      console.log("Click Botão");
      console.log(header);
      console.log(register);
      if (header.function) {
        header.function(register);
      }
    },
    limparStorage() {
      let header = this._props.header;
      for (var i = 0; i < header.length; i++) {
        localStorage.removeItem(
          this._props.componentName + "_filtro_" + header[i].field
        );
      }
    },
    popularStorage() {
      try {
        let header = this._props.header;
        let refs = this.$refs;
        var cabeca = null;

        for (var i = 0; i < header.length; i++) {
          let nome =
            this._props.componentName + "-" + header[i].field + "-search"; //this._props.componentName + '-' + header[i].field + '-search';
          let imput = document.getElementById(nome);
          let storage = localStorage.getItem(
            this._props.componentName + "_filtro_" + header[i].field
          );
          if (imput && storage) {
            imput.value = storage;
            cabeca = header[i];
          }
        }
        if (cabeca != null) {
          this.searchValue(cabeca);
        }
      } catch (e) {
        console.log("ERRO AO BUSCAR STORAGE");
        console.log(e);
      }
    },
    selecionar() {
      this.validarBotoesFuncoes();
    },
    selecionarTodos() {
      try {
        let selecionados = $("input:checked");
        let todos = document.getElementsByClassName("form-check-input");
        for (let index = 0; index < todos.length; index++) {
          let boolean = Number(todos.length) != Number(selecionados.length);
          todos[index].checked = boolean;
        }
        this.validarBotoesFuncoes();
      } catch (error) {
        console.log("erro ao selecionar!", error);
      }
    },
    validarBotoesFuncoes() {
      console.log("Mostrar ou esconder");
      var selects = document.getElementsByClassName("form-check-input");
      try {
        let nr_input_check = Number($("input:checked").length);
      } catch (error) {
        return;
      }

      if (this._props.funcoes_multiplas && !this._props.arr_funcoes) {
        this._props.arr_funcoes = this._props.funcoes_multiplas;
      }

      if (selects.length > 0 && document.getElementById("div-card-selct")) {
        let o_c = nr_input_check > Number(0) > Number(0);
        document.getElementById("div-card-selct").className = o_c
          ? "card-tools card-tools float-left"
          : "card-tools card-tools float-left d-none";
      }
    },
  },
  mounted() {
    try {
      if (document.getElementById("modal-padrao")) {
        $("#modal-padrao").on("hidden.bs.modal", (event) => {
          if (!this._props.openModal) {
            this.carregaDados();
            this.page = 0;
          } //if
        });
        $("#modal-padrao").on("shown.bs.modal", (event) => {
          if (this._props.openModal) {
            this.carregaDados();
            this.page = 0;
          } //if
        });
      } // if

      try {
        this.page =
          Number(localStorage.getItem("page-" + this._props.componentName)) > 0
            ? Number(localStorage.getItem("page-" + this._props.componentName))
            : 1;
      } catch (e) {
        console.log("Erro ao setar pagina");
        console.log(e);
        this.page = 1;
      }

      if (this._props.funcoes_multiplas && !this._props.arr_funcoes) {
        this._props.arr_funcoes = this._props.funcoes_multiplas;
      }
    } catch (error) {
      console.log("ERRO AO MONTAR GRID PADRÃO");
      console.log(error);
    }
  }, // mounted()
}; //
</script>

<template>
  <div>
    <!--
    <div class="text-center" v-if="getLoading == true">
        <h3>
            <div class="spinner-border" role="status"></div>
            &nbsp;Carregando...
        </h3>
    </div>
    -->
    <button
      @click="carregaDados()"
      style="display: none"
      :id="'btn-recarregar-dados-' + componentName"
    ></button>
    <div class="card">
      <div
        class="card-header border-0"
        style="float: right; padding-bottom: 1px; padding-top: 1px"
      >
        <h3 class="card-title" v-if="title">{{ title }}</h3>
        <div
          class="card-tools"
          style="float: right; padding-bottom: 1px; padding-top: 1px"
        >
          <div class="btn btn-sm btn-tool">
            <div class="input-group.input-group-sm row" style="padding: 12px">
              <select
                placeholder="Número de Registros por página"
                v-model="record_page"
                class="form-control form-control-sm"
                style="font-size: 12px"
              >
                <option value="10" selected="selected">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
            </div>
          </div>
          <div class="btn btn-sm btn-tool" v-for="filtro in filtros">
            <div
              class="custom-control custom-checkbox justify-content-center align-items-center text-center"
              v-if="filtro.type == 'checkbox'"
              @click="mudaCheckBox(filtro)"
            >
              <input
                class="custom-control-input input-sm"
                type="checkbox"
                v-model="filtro.value"
              />
              <label class="custom-control-label" style="padding-top: 2px">{{
                filtro.caption
              }}</label>
            </div>
            <div
              class="input-group input-group-sm"
              v-if="filtro.type == 'input'"
            >
              <input
                type="text"
                :class="
                  'form-control ' + (!filtro.uppercase ? '' : 'text-uppercase')
                "
                :placeholder="filtro.caption"
                v-model="filtro.value"
                @change="changeFiltro(filtro)"
              />
              <span class="input-group-append">
                <button
                  type="button"
                  class="btn btn-outline-secondary btn-flat"
                  @click="changeFiltro(filtro)"
                >
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>

            <div
              class="input-group.input-group-sm row"
              v-if="filtro.type == 'select'"
              style="padding: 12px"
            >
              <label class="col-4 col-form-label">{{ filtro.caption }}:</label>
              <div class="col-8" style="padding-top: 4px">
                <select
                  placeholder="Selecione um Status"
                  class="form-control input-sm"
                  v-model="filtro.value"
                  @change="changeFiltro(filtro)"
                >
                  <option :value="opcao.value" v-for="opcao in filtro.options">
                    {{ opcao.caption }}
                  </option>
                </select>
              </div>
            </div>
            <button
              :class="'btn btn-sm btn-tool ' + filtro.class"
              @click="functionFiltro(filtro)"
              v-if="filtro.type == 'button'"
            >
              <i :class="filtro.icon"></i> {{ filtro.caption }}
            </button>
          </div>

          <a
            type="button"
            :href="urlExcel"
            target="_blank"
            class="btn btn-sm btn-outline-success btn-tool"
            v-if="urlExcel"
            title="Exportar dados para o Excel"
          >
            <i class="fa fa-file-excel"></i> Exportar
          </a>
          <button
            class="btn btn-outline-secondary btn-sm btn-tool"
            title="Recarregar dados"
            @click="buscarDados()"
            v-if="getRefreshButton == true"
          >
            <i class="fa fa-sync"></i>
          </button>

          <button
            class="btn btn-sm btn-tool"
            @click="exportarParaExecel(excel)"
            v-if="exportarExcel == 'true'"
          >
            <i class="fa fa-table"></i> Exportar
          </button>

          <button class="btn btn-sm btn-tool" @click="chamarLimparFiltro()">
            <i class="fa fa-clear"></i> Limpar Filtro
          </button>
        </div>
        <!-- card-tools -->
        <!-- --->
        <div
          class="card-tools card-tools float-left d-none"
          id="div-card-selct"
          style="float: right; padding-bottom: 1px; padding-top: 1px"
        >
          <div class="btn btn-sm btn-tool" v-for="func in arr_funcoes">
            <button
              :class="
                'btn btn-sm btn-tool ' +
                (!func.class ? 'btn-secondary' : func.class)
              "
              @click="func.function(func)"
              :title="func.caption"
            >
              <i :class="func.icon"></i>
            </button>
          </div>
        </div>
        <!-- card-tools -->
        <!--  -->
      </div>
      <!-- div-header -->
      <div class="card-body" style="padding-bottom: 1px; padding-top: 1px">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th v-for="cabecalho in header" :class="cabecalho.class">
                  <!-- TEXTO PADRÃO -->
                  <div
                    v-if="cabecalho.selecionar == undefined"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                    @click="sortTable(cabecalho)"
                  >
                    {{ cabecalho.title }}
                  </div>
                  <!-- BOTÃO DE SELEÇÃO DE REGISTROS -->
                  <button
                    v-if="cabecalho.selecionar == true"
                    class="btn btn-outline-secondary btn-sm"
                    @click="selecionarTodos()"
                  >
                    <i class="fa fa-check-circle"></i>
                  </button>
                  <div
                    class="input-group-sm"
                    v-if="
                      cabecalho.title != 'Opções' &&
                      cabecalho.title != '[ ]' &&
                      cabecalho.nosearch == undefined
                    "
                  >
                    <input
                      :type="
                        !cabecalho.datetime && !cabecalho.date ? 'text' : 'date'
                      "
                      :class="
                        'form-control input-pesquisa-' +
                        componentName +
                        ' input-sm  text-uppercase'
                      "
                      :ref="componentName + '-' + cabecalho.field + '-search'"
                      :id="componentName + '-' + cabecalho.field + '-search'"
                      @keyup="searchValue(cabecalho)"
                    />
                  </div>
                </th>
              </tr>
            </thead>
            <tbody v-if="getLoading == false">
              <tr v-for="record in getRecords">
                <td v-for="cabecalho in header" :class="cabecalho.class">
                  <!-- INPUT DE SELECAO -->
                  <div v-if="cabecalho.selecionar && !cabecalho.input">
                    <input
                      v-if="record[cabecalho.campo] == cabecalho.valor"
                      type="checkbox"
                      data-toggle="tooltip"
                      data-placement="top"
                      :id="getIdInputSelect(cabecalho, record)"
                      :class="
                        'form-check-input ' +
                        (!cabecalho.classInput ? '' : cabecalho.classInput)
                      "
                      title="Selecionar todos!"
                      @click="selecionar()"
                    />
                    <input
                      v-if="!cabecalho.valor"
                      type="checkbox"
                      data-toggle="tooltip"
                      data-placement="top"
                      :id="getIdInputSelect(cabecalho, record)"
                      :class="
                        'form-check-input ' +
                        (!cabecalho.classInput ? '' : cabecalho.classInput)
                      "
                      title="Selecionar todos!"
                      @click="selecionar()"
                    />
                  </div>
                  <!-- PASSA UMA CONDIÇÃO - COMPARATIVO COM CAMPO, CONDIÇÃO DE COMPARAÇÃO , SE FOR VERDADE , SE FOR FALSO  -->
                  <div
                    v-if="
                      cabecalho.condition &&
                      cabecalho.verdade &&
                      cabecalho.falso
                    "
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      record[cabecalho.field] == cabecalho.condition
                        ? cabecalho.verdade
                        : cabecalho.falso
                    }}
                  </div>
                  <!-- DATETIME -->
                  <div
                    v-if="cabecalho.datetime && !cabecalho.input"
                    :class="getClassAtributo(cabecalho, record)"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                    data-toggle="tooltip"
                    data-placement="top"
                  >
                    {{
                      record[cabecalho.field] != null
                        ? new Date(
                            record[cabecalho.field].replace(" ", "T")
                          ).toLocaleDateString("pt-BR") +
                          " " +
                          new Date(
                            record[cabecalho.field].replace(" ", "T")
                          ).toLocaleTimeString("pt-BR")
                        : "-"
                    }}
                  </div>
                  <!-- DATE -->
                  <div
                    v-if="cabecalho.date && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      record[cabecalho.field] != null
                        ? new Date(
                            record[cabecalho.field].replace(" ", "T")
                          ).toLocaleDateString("pt-BR")
                        : "-"
                    }}
                  </div>
                  <!-- VALOR DEFAULT QUANDO NÃO TIVER CONTEUDO -->
                  <div
                    v-if="cabecalho.empty && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      !record[cabecalho.field]
                        ? cabecalho.empty
                        : record[cabecalho.field]
                    }}
                  </div>
                  <!-- EXIBIR CÓDIGOS || TAMANHO DA STRING, QUAL CARACTER SERÁ ADICIONADO -->
                  <div
                    v-if="cabecalho.codigo && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      !cabecalho.tamanho_codigo
                        ? String(record[cabecalho.field]).padStart(
                            6,
                            cabecalho.caracter
                          )
                        : String(record[cabecalho.field]).padStart(
                            cabecalho.tamanho_codigo,
                            cabecalho.caracter
                          )
                    }}
                  </div>
                  <!-- CNPJ -->
                  <div
                    v-if="cabecalho.cnpj && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      !record[cabecalho.field]
                        ? ""
                        : getMaskCnpj(record[cabecalho.field])
                    }}
                  </div>
                  <!-- TELEFONE -->
                  <div
                    v-if="cabecalho.telefone && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      !record[cabecalho.field]
                        ? ""
                        : maskTelefone(record[cabecalho.field])
                    }}
                  </div>
                  <!-- FLOAT -->
                  <div
                    v-if="
                      cabecalho.float &&
                      !cabecalho.input &&
                      !cabecalho.complemento &&
                      !cabecalho.reais
                    "
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                    data-toggle="tooltip"
                    data-placement="top"
                  >
                    {{
                      !record[cabecalho.field]
                        ? ""
                        : !cabecalho.decimais
                        ? Number(record[cabecalho.field])
                        : Number(record[cabecalho.field]).toFixed(
                            cabecalho.decimais
                          )
                    }}
                  </div>
                  <!-- COMPLEMENTOS EX: 'R$', 'pts', '' -->
                  <div
                    v-if="
                      cabecalho.complemento &&
                      (cabecalho.inicio || cabecalho.fim) &&
                      !cabecalho.float
                    "
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                    data-toggle="tooltip"
                    data-placement="top"
                  >
                    {{
                      cabecalho.inicio
                        ? cabecalho.complemento + record[cabecalho.field]
                        : record[cabecalho.field] + cabecalho.complemento
                    }}
                  </div>
                  <!-- complemento : 'R$ ', inicio : true , float: true -->
                  <div
                    v-if="
                      cabecalho.complemento &&
                      (cabecalho.inicio || cabecalho.fim) &&
                      cabecalho.float
                    "
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                    data-toggle="tooltip"
                    data-placement="top"
                  >
                    {{
                      cabecalho.inicio
                        ? cabecalho.complemento +
                          Number(record[cabecalho.field]).toFixed(2)
                        : Number(record[cabecalho.field]).toFixed(2) +
                          cabecalho.complemento
                    }}
                  </div>
                  <!-- DINHEIRO -->
                  <div
                    v-if="cabecalho.reais && !cabecalho.input"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    {{
                      Number(record[cabecalho.field]).toLocaleString("pt-br", {
                        style: "currency",
                        currency: "BRL",
                      })
                    }}
                  </div>
                  <!-- link -->
                  <div
                    v-if="
                      cabecalho.link &&
                      !cabecalho.input &&
                      condition !== undefined
                    "
                    :class="
                      getClassAtributo(cabecalho, record) + ' text-center'
                    "
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    <a
                      class="btn btn-sm btn btn-outline-secondary"
                      :href="record[cabecalho.field]"
                      target="_blank"
                      v-if="record[cabecalho.field] != null"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="record[cabecalho.field]"
                    >
                      <i class="fa fa-eye"></i>
                    </a>
                    <button
                      class="btn btn-sm btn btn-outline-secondary"
                      v-if="record[cabecalho.field] == null"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Nehum link para exibir"
                      disable="true"
                      disabled
                    >
                      <i class="fa fa-ban"></i>
                    </button>
                  </div>

                  <!-- SHOW ARQUIVO -->
                  <div
                    v-if="cabecalho.showarquivo && !cabecalho.input"
                    :class="
                      getClassAtributo(cabecalho, record) + ' text-center'
                    "
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    <button
                      class="btn btn-sm btn btn-outline-secondary"
                      v-if="record[cabecalho.field] != null"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="record[cabecalho.field]"
                      @click="clickBotao(cabecalho, record)"
                    >
                      <i class="fa fa-eye"></i>
                    </button>
                    <button
                      class="btn btn-sm btn btn-outline-secondary"
                      v-if="record[cabecalho.field] == null"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Não existe arquivo anexado"
                      disabled
                    >
                      <i class="fa fa-ban"></i>
                    </button>
                  </div>

                  <!-- EXIBIR CONTEUDO SEM NENHUMA OUTRA CONDICAO -->
                  <div
                    v-if="
                      !cabecalho.condition &&
                      !cabecalho.time &&
                      !cabecalho.datetime &&
                      !cabecalho.date &&
                      !cabecalho.empty &&
                      !cabecalho.codigo &&
                      !cabecalho.cnpj &&
                      !cabecalho.input &&
                      !cabecalho.telefone &&
                      !cabecalho.float &&
                      !cabecalho.decimal &&
                      !cabecalho.complemento &&
                      !cabecalho.complemento &&
                      !cabecalho.reais &&
                      !cabecalho.selecionar &&
                      !cabecalho.link &&
                      !cabecalho.showarquivo
                    "
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    :style="!cabecalho.style ? '' : cabecalho.style"
                  >
                    <div
                      v-if="cabecalho.functionClass"
                      :class="getClassAtributo(cabecalho, record)"
                    >
                      {{
                        !record[cabecalho.field] ? "" : record[cabecalho.field]
                      }}
                    </div>
                    <div v-else>
                      {{
                        !record[cabecalho.field] ? "" : record[cabecalho.field]
                      }}
                    </div>
                  </div>
                  <!-- RENDERIZAR INPUT    -->
                  <div v-if="cabecalho.hidden">
                    <input
                      :type="cabecalho.hidden.type"
                      :class="cabecalho.hidden.class"
                      :value="record[cabecalho.field]"
                      v-if="cabecalho.hidden"
                    />
                  </div>
                  <div v-if="cabecalho.input">
                    <!-- -->
                    <input
                      :type="cabecalho.input.type"
                      :class="cabecalho.input.class"
                      :disable="cabecalho.input.disable"
                      :value="getMaskCnpj(record[cabecalho.field])"
                      v-if="cabecalho.cnpj"
                    />
                    <input
                      :type="cabecalho.input.type"
                      :class="cabecalho.input.class"
                      :disable="cabecalho.input.disable"
                      :value="maskTelefone(record[cabecalho.field])"
                      v-if="cabecalho.telefone"
                    />
                    <input
                      :type="cabecalho.input.type"
                      :class="cabecalho.input.class"
                      :disable="cabecalho.input.disable"
                      :value="maskTelefone(record[cabecalho.field])"
                      v-if="cabecalho.float"
                    />
                    <input
                      :type="cabecalho.input.type"
                      :class="cabecalho.input.class"
                      :disable="cabecalho.input.disable"
                      :value="record[cabecalho.field]"
                      v-if="
                        !cabecalho.cnpj &&
                        !cabecalho.telefone &&
                        !cabecalho.float &&
                        !cabecalho.input.id
                      "
                      @change="cabecalho.input.function"
                    />
                    <input
                      :type="cabecalho.input.type"
                      :class="
                        cabecalho.input.class + record[cabecalho.input.key]
                      "
                      :disable="cabecalho.input.disable"
                      :id="cabecalho.input.id + record[cabecalho.input.key]"
                      :value="record[cabecalho.field]"
                      @change="changeInput(cabecalho.input, record, null)"
                      v-if="
                        !cabecalho.cnpj &&
                        !cabecalho.telefone &&
                        !cabecalho.float &&
                        cabecalho.input.id &&
                        !cabecalho.input.select
                      "
                    />

                    <select
                      :class="
                        cabecalho.input.class + record[cabecalho.input.key]
                      "
                      :id="cabecalho.input.id + record[cabecalho.input.key]"
                      :value="record[cabecalho.field]"
                      @change="
                        changeInput(
                          cabecalho.input,
                          record,
                          record[cabecalho.input.id]
                        )
                      "
                      v-if="cabecalho.input.select"
                    >
                      <option
                        :value="select.value"
                        v-for="select in cabecalho.input.options"
                      >
                        {{ select.caption }}
                      </option>
                    </select>
                  </div>
                  <span
                    class="icon-menu"
                    v-for="botao in cabecalho.buttons"
                    data-toggle="tooltip"
                    data-placement="top"
                    :title="getTitleRecord(cabecalho, record)"
                    v-if="cabecalho.button == true"
                  >
                    <!-- BOTAO EXISTENTE EM SETORES DA META DE VENDA -->
                    <button
                      style="width: 35px"
                      v-if="
                        !botao.opcoes &&
                        !botao.show &&
                        !botao.operador &&
                        botao.condition &&
                        botao.field &&
                        record[botao.key]
                      "
                      type="button"
                      :class="
                        record[botao.field] == botao.condition
                          ? botao.class_verdade
                          : botao.class_falso
                      "
                      @click="clickButton(botao, record, record[botao.key])"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="
                        record[botao.field] == botao.condition
                          ? botao.caption_verdade
                          : botao.caption_falso
                      "
                    >
                      <i
                        :class="
                          record[botao.field] == botao.condition
                            ? botao.icon_verdade
                            : botao.icon_falso
                        "
                      ></i>
                    </button>
                    <!-- BOTÃO PADRÃO A SER EXIBIDO -->
                    <button
                      style="width: 35px"
                      v-if="
                        !botao.opcoes &&
                        !botao.show &&
                        !botao.condition &&
                        !botao.operador
                      "
                      type="button"
                      :class="botao.class"
                      @click="clickButton(botao, record, record[botao.key])"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="!botao.caption ? '' : botao.caption"
                    >
                      <i :class="botao.icon" v-if="botao.icon != null"></i>
                    </button>
                    <!-- -->
                    <button
                      style="width: 35px"
                      v-if="!botao.opcoes && !botao.condition && botao.show"
                      v-show="record[botao.key]"
                      type="button"
                      :class="botao.class"
                      @click="clickButton(botao, record, record[botao.key])"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="!botao.caption ? '' : botao.caption"
                    >
                      <i :class="botao.icon" v-if="botao.icon != null"></i>
                    </button>
                    <!-- VALIDAR INFORMAÇÕES DOS REGISTROS PARA EXIBIRO O BOTÃO -->

                    <button
                      style="width: 35px"
                      v-if="getCondition(botao, record) == true"
                      type="button"
                      :class="botao.class"
                      @click="clickButton(botao, record, record[botao.key])"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="!botao.caption ? '' : botao.caption"
                    >
                      <i :class="botao.icon" v-if="botao.icon != null"></i>
                    </button>

                    <!-- RENDERIZAR DROPDOWN COM MAIS OPÇÕES -->
                    <button
                      class="btn btn-sm btn-outline-secondary dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                      v-if="botao.opcoes"
                      @click="clickButton(botao, record, record[botao.key])"
                    >
                      Opções
                    </button>
                    <div class="dropdown-menu" v-if="botao.opcoes">
                      <span v-for="menu in botao.opcoes">
                        <button
                          class="dropdown-item"
                          data-toggle="tooltip"
                          data-placement="top"
                          :title="
                            !menu.acesso
                              ? !cabecalho.tooltip
                                ? ''
                                : record[cabecalho.tooltip]
                              : menu.acesso
                          "
                          v-if="!menu.rota"
                        >
                          {{ menu.caption }}
                        </button>
                        <router-link
                          class="dropdown-item"
                          data-toggle="tooltip"
                          data-placement="top"
                          :to="{ name: menu.rota }"
                          :title="
                            !menu.acesso
                              ? !cabecalho.tooltip
                                ? ''
                                : record[cabecalho.tooltip]
                              : menu.acesso
                          "
                          v-if="menu.rota && !menu.paramName"
                        >
                          {{ menu.caption }}!
                        </router-link>
                        <router-link
                          class="dropdown-item"
                          data-toggle="tooltip"
                          data-placement="top"
                          :to="{
                            name: menu.rota,
                            params: { cnpj: record[menu.paramName] },
                          }"
                          :title="
                            !menu.descricao
                              ? !cabecalho.tooltip
                                ? ''
                                : record[cabecalho.tooltip]
                              : menu.descricao
                          "
                          v-if="menu.rota && menu.paramName"
                        >
                          {{ menu.caption }}
                        </router-link>
                      </span>
                    </div>
                    <!-- -->
                  </span>
                </td>
              </tr>
              <tr>
                <td v-for="cabecalho in header"></td>
              </tr>
            </tbody>
          </table>
          <div
            v-if="getLoading == true"
            class="div-carregando"
            style="float: right; padding-bottom: 1px; padding-top: 1px"
          >
            <h3>
              <div class="spinner-border" role="status"></div>
              &nbsp;Carregando...
            </h3>
          </div>
        </div>
        <!-- table-responsive -->
      </div>
      <!-- card-body -->
      <div class="card-footer">
        <paginate
          v-model="page"
          :page-count="getPageSize"
          :click-handler="getPaginados"
          :page-range="3"
          :margin-pages="2"
          :prev-text="'<<'"
          :next-text="'>>'"
          prev-link-class="page-link paginate-button"
          page-link-class="page-link paginate-button"
          next-link-class="page-link paginate-button"
          container-class="pagination justify-content-center"
          break-view-link-class="page-link paginate-button"
          page-class="page-link paginate-button"
          :page-class="'page-item'"
        >
        </paginate>
      </div>
      <!-- .card-footer -->
    </div>
  </div>
</template>

<style>
.card-header {
  background-color: transparent;
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  padding: 0.75rem 1.25rem;
  position: relative;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}
.div-carregando {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 50px;
  text-align: center;
  margin-top: 50px; /* para afastar um pouco da tabela */
}
</style>
