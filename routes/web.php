<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Configuracao\DashboardController;
use App\Http\Controllers\Auth\AutenticacaoController;
use App\Http\Controllers\Organizacao\ClienteController;
use App\Http\Controllers\Sistema\UsuarioController;
use App\Http\Controllers\Negociacao\OportunidadeController;
use App\Http\Controllers\Negociacao\PropostaController;
use App\Http\Controllers\Negociacao\PropostaProdutoController;
use App\Http\Controllers\Negociacao\PropostaServicoController;
use App\Http\Controllers\Negociacao\PropostaGeralController;
use App\Http\Controllers\Negociacao\ContratoVendaController;
use App\Http\Controllers\Configuracao\FuncaoController;
use App\Http\Controllers\Configuracao\ConcorrenteController;
use App\Http\Controllers\Configuracao\EmpresaController;
use App\Http\Controllers\Configuracao\MotivoController;
use App\Http\Controllers\Configuracao\ProdutoController;
use App\Http\Controllers\Configuracao\ServicoController;
use App\Http\Controllers\Configuracao\PaisController;
use App\Http\Controllers\Configuracao\EstadoController;
use App\Http\Controllers\Configuracao\CidadeController;
use App\Http\Controllers\Configuracao\CdcController;
use App\Http\Controllers\Configuracao\CulturaController;
use App\Http\Controllers\Configuracao\ItensVendaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|
---------------------------------------------------------------------------
                    EXEMPLOS DE ROTAS
---------------------------------------------------------------------------
|
|   Route::get('teste', ['as'=>'teste', 'uses'=>'TesteController@teste']);
|   Route::get('/', function () {     return view('app'); });
|   Route::get('/teste', [App\Http\Controllers\TesteController::class, 'test'])->name('teste');
|
*/

Auth::routes(['verify' => true]);

//Rotas de Login / Logout
Route::post('/login/entrar', [AutenticacaoController::class, 'entrar'])->name('login.entrar');
Route::get('/login', [AutenticacaoController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/sair', [AutenticacaoController::class, 'sair'])->name('sair');
});



//Rota de alteração de idioma
Route::get('locale/{locale}', function ($locale) {
    App::setLocale($locale);
    Session::put('locale', $locale);
    return redirect()->back();
})->name('alterarIdioma');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

/** Rotas gerenciamento de clientes */
Route::get('/clientes', [ClienteController::class, 'gerenciarCliente'])->name('cliente.gerenciar');
Route::get('/clientes/cadastrar', [ClienteController::class, 'cadastrarCliente'])->name('cliente.cadastrar');
Route::post('/clientes/cadastra/submit', [ClienteController::class, 'salvarCliente'])->name('cliente.salvar');
Route::get('/clientes/editar/{id}', [ClienteController::class, 'editarCliente'])->name('cliente.editar');
Route::put('/clientes/edita', [ClienteController::class, 'atualizarCliente'])->name('cliente.atualizar');
Route::get('/clientes/remover/{id}', [ClienteController::class, 'removerCliente'])->name('cliente.remover');
Route::put('/clientes/exclui', [ClienteController::class, 'excluiCliente'])->name('cliente.exclui');
Route::get('/clientes/busca_estado_cidade/{id_pais}', [ClienteController::class, 'buscaCEP'])->name('cliente.buscaCEP');
Route::get('/clientes/cdc/{id_cliente}', [ClienteController::class, 'gerenciarClienteCdc'])->name('cliente.cdc.gerenciar');
Route::post('/clientes/cdc/cadastra', [ClienteController::class, 'cadastrarClienteCdc'])->name('cliente.cdc.cadastra');
Route::get('/clientes/cdc/editar/{id}', [ClienteController::class, 'editarClienteCdc'])->name('cliente.cdc.editar');
Route::put('/clientes/cdc/edita', [ClienteController::class, 'editaClienteCdc'])->name('cliente.cdc.edita');
Route::post('/clientes/cdc/buscaSelects', [ClienteController::class, 'buscaSelects'])->name('cliente.cdc.buscaSelects');

/** Rotas gerenciamento de colaboradores */
Route::get('/colaboradores', [UsuarioController::class, 'listarColaboradores'])->name('colaborador.listar');
Route::get('/colaboradores/cadastrar', [UsuarioController::class, 'cadastrarColaborador'])->name('colaborador.cadastrar');
Route::post('/colaboradores/cadastrar/submit', [UsuarioController::class, 'salvarColaborador'])->name('colaborador.salvar');
Route::get('/colaboradores/editar/{id}', [UsuarioController::class, 'editarColaborador'])->name('colaborador.editar');
Route::put('/colaboradores/edita', [UsuarioController::class, 'atualizarColaborador'])->name('colaborador.atualizar');
Route::get('/colaboradores/remover/{id}', [UsuarioController::class, 'removerColaborador'])->name('colaborador.remover');
Route::put('/colaboradores/exclui', [UsuarioController::class, 'excluiColaborador'])->name('colaborador.exclui');

/** Rotas gerenciamento de oportunidades */
Route::get('/oportunidade', [OportunidadeController::class, 'gerenciarOportunidade'])->name('oportunidade.gerenciar');
Route::get('/oportunidade/cadastrar', [OportunidadeController::class, 'cadastrarOportunidade'])->name('oportunidade.cadastrar');
Route::post('/oportunidade/cadastra/submit', [OportunidadeController::class, 'salvarOportunidade'])->name('oportunidade.salvar');
Route::post('/oportunidade/preencheSelecao', [OportunidadeController::class, 'preencheSelecao'])->name('oportunidade.preencheSelecao');
Route::get('/oportunidade/editar/{id}', [OportunidadeController::class, 'editarOportunidade'])->name('oportunidade.editar');
Route::put('/oportunidade/edita', [OportunidadeController::class, 'atualizarOportunidade'])->name('oportunidade.atualizar');
Route::get('/oportunidade/remover/{id}', [OportunidadeController::class, 'removerOportunidade'])->name('oportunidade.remover');
Route::put('/oportunidade/exclui', [OportunidadeController::class, 'excluiOportunidade'])->name('oportunidade.exclui');
Route::get('/oportunidade/encerrar/{id}', [OportunidadeController::class, 'encerrarOportunidade'])->name('oportunidade.encerrar');
Route::put('/oportunidade/encerra', [OportunidadeController::class, 'encerraOportunidade'])->name('oportunidade.encerra');

/** Rotas gerenciamento de negociacao */
Route::get('/oportunidade/proposta/{id_oportunidade}', [PropostaController::class, 'gerenciarProposta'])->name('proposta.gerenciar');

/** Rotas gerenciamento de proposta de produto */
Route::get('/oportunidade/proposta_produto/{id_oportunidade}', [PropostaProdutoController::class, 'gerenciarPropostaProduto'])->name('proposta.produto.gerenciar');
Route::get('/oportunidade/proposta_produto/cadastrar/{id_oportunidade}', [PropostaProdutoController::class, 'cadastrarPropostaProduto'])->name('proposta.produto.cadastrar');
Route::post('/oportunidade/proposta_produto/cadastra/submit', [PropostaProdutoController::class, 'salvarPropostaProduto'])->name('proposta.produto.salvar');
Route::get('/oportunidade/proposta_produto/duplicar/{id}', [PropostaProdutoController::class, 'duplicarPropostaProduto'])->name('proposta.produto.duplicar');
Route::get('/oportunidade/proposta_produto/gerar_contrato/{id}', [PropostaProdutoController::class, 'gerarContratoProduto'])->name('proposta.produto.gerarContrato');
Route::post('/oportunidade/proposta_produto/gera_contrato/submit', [PropostaProdutoController::class, 'salvarContratoProduto'])->name('proposta.produto.salvarContrato');

/** Rotas gerenciamento de proposta de serviço */
Route::get('/oportunidade/proposta_servico/{id_oportunidade}', [PropostaServicoController::class, 'gerenciarPropostaServico'])->name('proposta.servico.gerenciar');
Route::get('/oportunidade/proposta_servico/cadastrar/{id_oportunidade}', [PropostaServicoController::class, 'cadastrarPropostaServico'])->name('proposta.servico.cadastrar');
Route::post('/oportunidade/proposta_servico/cadastra/submit', [PropostaServicoController::class, 'salvarPropostaServico'])->name('proposta.servico.salvar');
Route::get('/oportunidade/proposta_servico/duplicar/{id}', [PropostaServicoController::class, 'duplicarPropostaServico'])->name('proposta.servico.duplicar');
Route::get('/oportunidade/proposta_servico/gerar_contrato/{id}', [PropostaServicoController::class, 'gerarContratoServico'])->name('proposta.servico.gerarContrato');
Route::post('/oportunidade/proposta_servico/gera_contrato/submit', [PropostaServicoController::class, 'salvarContratoServico'])->name('proposta.servico.salvarContrato');

// Rotas gerenciamento de propostas gerais.
Route::get('/oportunidade/propostageral/{id_oportunidade}', [PropostaGeralController::class, 'gerenciarPropostaGeral'])->name('proposta.geral.gerenciar');
Route::get('/oportunidade/propostageral/cadastrar/{id_oportunidade}', [PropostaGeralController::class, 'cadastrarPropostaGeral'])->name('proposta.geral.cadastrar');
Route::post('/oportunidade/propostageral/cadastra/submit', [PropostaGeralController::class, 'salvarPropostaGeral'])->name('proposta.geral.salvar');
Route::get('/oportunidade/propostageral/duplicar/{id}', [PropostaGeralController::class, 'duplicarPropostaGeral'])->name('proposta.geral.duplicar');
Route::get('/oportunidade/propostageral/gerar_contrato/{id}', [PropostaGeralController::class, 'gerarContratoGeral'])->name('proposta.geral.gerarContrato');
Route::post('/oportunidade/propostageral/gera_contrato/submit', [PropostaGeralController::class, 'salvarContratoGeral'])->name('proposta.geral.salvarContrato');

/** Rotas gerenciamento de contrato **/
Route::get('/contrato', [ContratoVendaController::class, 'gerenciarContrato'])->name('contrato.gerenciar');
Route::get('/contrato/visualizar/{id}', [ContratoVendaController::class, 'visualizarContrato'])->name('contrato.visualizar');

/** Rotas para profile **/
Route::get('/usuarios/perfil/{id}', [UsuarioController::class, 'getProfile'])->name('usuario.profile');
Route::post('/usuarios/perfil/alterar', [UsuarioController::class, 'alteraInfoPerfil'])->name('usuario.alterar');
Route::post('/usuarios/perfil/alterarSenha', [UsuarioController::class, 'alterarSenha'])->name('alterar.senha');

/** Rotas gerenciamento de funcoes */
Route::get('/funcoes', [FuncaoController::class, 'gerenciarFuncao'])->name('funcao.gerenciar');
Route::post('/funcoes/cadastra', [FuncaoController::class, 'cadastrarFuncao'])->name('funcao.cadastra');
Route::get('/funcoes/editar/{id}', [FuncaoController::class, 'editarFuncao'])->name('funcao.editar');
Route::put('/funcoes/edita', [FuncaoController::class, 'editaFuncao'])->name('funcao.edita');
Route::delete('/funcoes/remover/{id}', [FuncaoController::class, 'removerFuncao'])->name('funcao.remover');

/** Rotas gerenciamento de concorrentes */
Route::get('/concorrentes', [ConcorrenteController::class, 'gerenciarConcorrente'])->name('concorrente.gerenciar');
Route::post('/concorrentes/cadastra', [ConcorrenteController::class, 'cadastrarConcorrente'])->name('concorrente.cadastra');
Route::get('/concorrentes/editar/{id}', [ConcorrenteController::class, 'editarConcorrente'])->name('concorrente.editar');
Route::put('/concorrentes/edita', [ConcorrenteController::class, 'editaConcorrente'])->name('concorrente.edita');
Route::delete('/concorrentes/remover/{id}', [ConcorrenteController::class, 'removerConcorrente'])->name('concorrente.remover');

/** Rotas gerenciamento de empresas */
Route::get('/empresas', [EmpresaController::class, 'gerenciarEmpresa'])->name('empresa.gerenciar');
Route::post('/empresas/cadastra', [EmpresaController::class, 'cadastrarEmpresa'])->name('empresa.cadastra');
Route::get('/empresas/editar/{id}', [EmpresaController::class, 'editarEmpresa'])->name('empresa.editar');
Route::put('/empresas/edita', [EmpresaController::class, 'editaEmpresa'])->name('empresa.edita');
Route::delete('/empresas/remover/{id}', [EmpresaController::class, 'removerEmpresa'])->name('empresa.remover');

/** Rotas gerenciamento de movitos */
Route::get('/motivos', [MotivoController::class, 'gerenciarMotivo'])->name('motivo.gerenciar');
Route::post('/motivos/cadastra', [MotivoController::class, 'cadastrarMotivo'])->name('motivo.cadastra');
Route::get('/motivos/editar/{id}', [MotivoController::class, 'editarMotivo'])->name('motivo.editar');
Route::put('/motivos/edita', [MotivoController::class, 'editaMotivo'])->name('motivo.edita');
Route::delete('/motivos/remover/{id}', [MotivoController::class, 'removerMotivo'])->name('motivo.remover');

/** Rotas gerenciamento de produtos */
Route::get('/produtos', [ProdutoController::class, 'gerenciarProduto'])->name('produto.gerenciar');
Route::post('/produtos/cadastra', [ProdutoController::class, 'cadastrarProduto'])->name('produto.cadastra');
Route::get('/produtos/editar/{id}', [ProdutoController::class, 'editarProduto'])->name('produto.editar');
Route::put('/produtos/edita', [ProdutoController::class, 'editaProduto'])->name('produto.edita');
Route::get('/produtos/remover/{id}', [ProdutoController::class, 'removerProduto'])->name('produto.remover');
Route::put('/produtos/exclui', [ProdutoController::class, 'excluiProduto'])->name('produto.exclui');

/** Rotas gerenciamento de serviços */
Route::get('/servicos', [ServicoController::class, 'gerenciarServico'])->name('servico.gerenciar');
Route::post('/servicos/cadastra', [ServicoController::class, 'cadastrarServico'])->name('servico.cadastra');
Route::get('/servicos/editar/{id}', [ServicoController::class, 'editarServico'])->name('servico.editar');
Route::put('/servicos/edita', [ServicoController::class, 'editaServico'])->name('servico.edita');
Route::delete('/servicos/remover/{id}', [ServicoController::class, 'removerServico'])->name('servico.remover');

/** Rotas gerenciamento de paises*/
Route::get('/paises', [PaisController::class, 'gerenciarPais'])->name('pais.gerenciar');
Route::post('/paises/cadastra', [PaisController::class, 'cadastrarPais'])->name('pais.cadastra');
Route::get('/paises/editar/{id}', [PaisController::class, 'editarPais'])->name('pais.editar');
Route::put('/paises/edita', [PaisController::class, 'editaPais'])->name('pais.edita');
Route::delete('/paises/remover/{id}', [PaisController::class, 'removerPais'])->name('pais.remover');

/** Rotas gerenciamento de estados*/
Route::get('/estados', [EstadoController::class, 'gerenciarEstado'])->name('estado.gerenciar');
Route::post('/estados/cadastra', [EstadoController::class, 'cadastrarEstado'])->name('estado.cadastra');
Route::get('/estados/editar/{id}', [EstadoController::class, 'editarEstado'])->name('estado.editar');
Route::put('/estados/edita', [EstadoController::class, 'editaEstado'])->name('estado.edita');
Route::get('/estados/remover/{id}', [EstadoController::class, 'removerEstado'])->name('estado.remover');
Route::put('/estados/exclui', [EstadoController::class, 'excluiEstado'])->name('estado.exclui');

/** Rotas gerenciamento de cidades */
Route::get('/cidades', [CidadeController::class, 'gerenciarCidade'])->name('cidade.gerenciar');
Route::post('/cidades/cadastra', [CidadeController::class, 'cadastrarCidade'])->name('cidade.cadastra');
Route::get('/cidades/editar/{id}', [CidadeController::class, 'editarCidade'])->name('cidade.editar');
Route::put('/cidades/edita', [CidadeController::class, 'editaCidade'])->name('cidade.edita');
Route::delete('/cidades/remover/{id}', [CidadeController::class, 'removerCidade'])->name('cidade.remover');

/** Rotas gerenciamento de cdc */
Route::get('/cdc', [CdcController::class, 'gerenciarCdc'])->name('cdc.gerenciar');
Route::post('/cdc/cadastra', [CdcController::class, 'cadastrarCdc'])->name('cdc.cadastra');
Route::get('/cdc/editar/{id}', [CdcController::class, 'editarCdc'])->name('cdc.editar');
Route::put('/cdc/edita', [CdcController::class, 'editaCdc'])->name('cdc.edita');
Route::delete('/cdc/remover/{id}', [CdcController::class, 'removerCdc'])->name('cdc.remover');
Route::post('/cdc/buscacdc', [CdcController::class, 'buscarCdc'])->name('cdc.buscar');

/** Rotas gerenciamento de culturas */
Route::get('/cultura', [CulturaController::class, 'gerenciarCultura'])->name('cultura.gerenciar');
Route::post('/cultura/cadastra', [CulturaController::class, 'cadastrarCultura'])->name('cultura.cadastra');
Route::get('/cultura/editar/{id}', [CulturaController::class, 'editarCultura'])->name('cultura.editar');
Route::put('/cultura/edita', [CulturaController::class, 'editaCultura'])->name('cultura.edita');
Route::get('/cultura/remover/{id}', [CulturaController::class, 'removerCultura'])->name('cultura.remover');
Route::put('/cultura/exclui', [CulturaController::class, 'excluiCultura'])->name('cultura.exclui');

/** Rotas gerenciamento de usuários */
Route::get('/usuarios', [UsuarioController::class, 'listarUsuarios'])->name('usuarios.listar');
Route::post('/usuarios/cadastrar/submit', [UsuarioController::class, 'inserirUsuario'])->name('usuario.cadastra');
Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'getUsuario'])->name('usuario.ver');
Route::put('/usuarios/edita', [UsuarioController::class, 'editaUsuario'])->name('usuario.edita');
Route::get('/usuarios/remover/{id}', [UsuarioController::class, 'removerUsuario'])->name('usuario.remover');
Route::put('/usuarios/exclui', [UsuarioController::class, 'excluiUsuario'])->name('usuario.exclui');

/** Rotas de Produtos e Serviços */
Route::get('/itensVenda', [ItensVendaController::class, 'gerenciarItensVenda'])->name('itensVenda.gerenciar');
Route::get('/itensVenda/cadastrar', [ItensVendaController::class, 'cadastrarItensVenda'])->name('itensVenda.cadastrar');
Route::post('/itensVenda/cadastrar/salvar', [ItensVendaController::class, 'salvarItensVenda'])->name('itensVenda.salvar');
Route::get('/itensVenda/edita/{id}', [ItensVendaController::class, 'editarItensVenda'])->name('itensVenda.editar');
Route::put('/itensVenda/editar', [ItensVendaController::class, 'editaItensVenda'])->name('itensVenda.editar');
Route::get('/itensVenda/exclui/{id}', [ItensVendaController::class, 'excluirItensVenda'])->name('itensVenda.exclui');
Route::put('/itensVenda/excluir', [ItensVendaController::class, 'excluirItensVenda'])->name('itensVenda.excluir');

?>
