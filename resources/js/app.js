/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vuex from 'Vuex';
Vue.use(Vuex);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const store = new Vuex.Store({
    state:{
      item:{},
      fazendas:{}
    },
    mutations:{
      setItem(state,obj){
        state.item = obj;
      },
      setFazendas(state,obj){
       state.fazendas = obj;
     }
    }
  });


 Vue.component('tabela-lista', require('./components/TabelaLista.vue').default);
 Vue.component('tabela-lista-new', require('./components/TabelaListaNew.vue').default);
 Vue.component('modallink', require('./components/Modal/ModalLink.vue').default);
 Vue.component('modal', require('./components/Modal/Modal.vue').default);
 Vue.component('modal-selecionar-fazenda', require('./components/Modal/ModalSelecionarFazenda.vue').default);
 Vue.component('example', require('./components/ExampleComponent.vue').default);
 Vue.component('formulario', require('./components/Formulario.vue').default);
 Vue.component('filtro', require('./components/FiltroComponent.vue').default);
 Vue.component('caixa', require('./components/Caixa.vue').default);
 Vue.component('linha-emissor', require('./components/redimensionamento/LinhaCadastroEmissor.vue').default );


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const app = new Vue({
    el: '#app',
    store,
    mounted: function(){
      //console.log("ok");
      document.getElementById('app').style.display = "block";
    }
});
