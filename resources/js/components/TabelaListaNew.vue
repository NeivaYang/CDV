<template>
    <div class="col-md-12 container">
        <div class="form-group d-flex">
            <div class="align-items-end col-8 col-md-4">
                <div v-if="pesquisa" class="form-group">
                  <input type="search"  class="form-control pl-5"  v-model="buscar" aria-describedby="search"/>
                  <span class="input-symbol-left"><i class='fa fa-search'> </i></span>
                </div>
                
            </div>
            <div class="align-content-start col-4 col-md-8 text-right">
                <a v-if="criar && !modal_criar" v-bind:href="criar" id="btn-tbl-adicionar" class="btn btn-confirmacao btn-lg" data-toggle="tooltip" v-bind:title="titulo_criar">
                    <i class="fas fa-fw fa-lg fa-plus"></i>
                </a>
                <modallink class="col-2" v-if="criar && modal_criar" tipo="link" nome="adicionar" data-toggle="tooltip" v-bind:title="titulo_criar" icone="fas fa-fw fa-lg fa-plus" css="btn btn-primary btn-lg"></modallink>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead id='tbHead'>
                    <tr class='text-light'>
                        <th style="cursor:pointer; vertical-align: middle"  v-on:click="ordenaColuna(index)" v-for="(titulo,index) in titulos" v-bind:key="index">
                        {{titulo}}<i class='fas fa-fw fa-lg fa-sort'></i> 
                        </th>

                        <th style="vertical-align: middle" v-if="detalhe || editar || deletar || outro1 || outro2 || outro3">
                        {{titulo_acoes}}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(item,index) in lista" v-bind:key="index">
                        <td v-for="(i,index) in item" v-bind:key="index">{{i | formataData}}</td>

                        <td v-if="detalhe || editar || deletar || outro1 || outro2 || outro3" class="td-acoes">
                            <span>
                                <a v-if="detalhe && !modal_detalhe" v-bind:href="detalhe + '/' + item.id" data-toggle="tooltip" v-bind:title="titulo_detalhe"><i class='fas fa-fw fa-sm fa-eye'></i> </a>
                                <modallink v-if="detalhe && modal_detalhe" v-bind:item="item" v-bind:url="detalhe" data-toggle="tooltip" v-bind:title="titulo_detalhe" tipo="link" nome="detalhe" icone=" fas fa-fw fa-sm fa-eye"></modallink>

                                <a v-if="editar && !modal_editar" v-bind:href="editar + '/' + item.id" data-toggle="tooltip" v-bind:title="titulo_editar"><i class='fas fa-fw fa-sm fa-pencil-alt'></i> </a>
                                <modallink v-if="editar && modal_editar" v-bind:item="item" v-bind:url="editar" data-toggle="tooltip" v-bind:title="titulo_editar" tipo="link" nome="editar" icone='fas fa-fw fa-sm fa-pencil-alt'></modallink>

                                <a v-if="deletar && !modal_deletar" v-bind:href="deletar + '/' + item.id" data-toggle="tooltip" v-bind:title="titulo_deletar"><i class='fas fa-fw fa-sm fa-trash-alt'></i> </a>
                                <modallink v-if="deletar && modal_deletar" v-bind:item="item" v-bind:url="deletar" data-toggle="tooltip" v-bind:title="titulo_deletar" tipo="link" nome="deletar" icone='fas fa-fw fa-sm fa-trash-alt'></modallink>

                                <a v-if="outro1 && !modal_outro1" v-bind:href="outro1 + '/' + item.id" data-toggle="tooltip" v-bind:title="titulo_outro1"><i v-bind:class="icone_outro1" ></i> </a>
                                <modallink v-if="outro1 && modal_outro1" v-bind:item="item" v-bind:url="outro1" data-toggle="tooltip" v-bind:title="titulo_outro1" tipo="link" nome="outro1" v-bind:icone="icone_outro1"></modallink>

                                <a v-if="outro2 && !modal_outro2" v-bind:href="outro2 + '/' + item.id"><i v-bind:class="icone_outro2" data-toggle="tooltip" v-bind:title="titulo_outro2"></i> </a>
                                <modallink v-if="outro2 && modal_outro2" v-bind:item="item" v-bind:url="outro2" data-toggle="tooltip" v-bind:title="titulo_outro2" tipo="link" nome="outro2" v-bind:icone="icone_outro2"></modallink>

                                <a v-if="outro3 && !modal_outro3" v-bind:href="outro3 + '/' + item.id" data-toggle="tooltip" v-bind:title="titulo_outro3"><i v-bind:class="icone_outro3" ></i> </a>
                                <modallink v-if="outro3 && modal_outro3" v-bind:item="item" v-bind:url="outro3" data-toggle="tooltip" v-bind:title="titulo_outro3" tipo="link" nome="outro3" v-bind:icone="icone_outro3"></modallink>

                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

</template>

<script>
    export default {
      /* usar outro1 botão:  outro1="{{route('fazenda.teste')}}" icone_outro1="fa-user-plus" */
      props:['titulos','titulo_acoes','titulo_adicionar','itens','ordem','ordemcol','pesquisa',
             'criar','titulo_criar','modal_criar',
             'detalhe','titulo_detalhe','modal_detalhe',
             'editar','titulo_editar','modal_editar',
             'deletar','titulo_deletar','modal_deletar',
             'outro1','modal_outro1','titulo_outro1','icone_outro1',
             'outro2','modal_outro2','titulo_outro2','icone_outro2',
             'outro3','modal_outro3','titulo_outro3','icone_outro3',
             'txt_btn_novo'],
      data: function(){
        return {
          buscar:'',
          ordemAux: this.ordem || "asc",
          ordemAuxCol: this.ordemcol || 0
        }
      },
      methods:{
        ordenaColuna: function(coluna){
          this.ordemAuxCol = coluna;
          if(this.ordemAux.toLowerCase() == "asc"){
            this.ordemAux = 'desc';
          }else{
            this.ordemAux = 'asc';
          }
        }
      },
      filters: {
        formataData: function(valor){
          if(!valor) return '';
          
          if((valor instanceof Date) && !isNaN(valor)){
            valor = valor.toString();
            if(valor.split('-').length == 3){
              valor = valor.split('-');
              return valor[2] + '/' + valor[1]+ '/' + valor[0];
            }
          }

          return valor;
        }
      },
      computed:{
        lista:function(){
          let lista = this.itens.data;
          let ordem = this.ordemAux;
          let ordemCol = this.ordemAuxCol;
          ordem = ordem.toLowerCase();
          ordemCol = parseInt(ordemCol);

          if(ordem == "asc"){
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }else{
            lista.sort(function(a,b){
              if (Object.values(a)[ordemCol] < Object.values(b)[ordemCol] ) { return 1;}
              if (Object.values(a)[ordemCol] > Object.values(b)[ordemCol] ) { return -1;}
              return 0;
            });
          }

          if(this.buscar){
            return lista.filter(res => {
              res = Object.values(res);
              for(let k = 0;k < res.length; k++){
                if((res[k] + "").toLowerCase().indexOf(this.buscar.toLowerCase()) >= 0){
                  return true;
                }
              }
              return false;

            });
          }


          return lista;
        }
      }
    }
</script>

<style media="screen">
  #tbHead{
    background-color: #1782B6;
  }
</style>