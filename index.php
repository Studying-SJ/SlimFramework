<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule; //title: Utilizando lib Illuminate para criar e manusear o Banco de dados e suas configurações.

// ! Para criar caminhos (rotas) para API, precisamos dizer qual tipo de caminho é (GET, POST, PUT, DELETE...) sendo qua cada um tem suas peculiaridades na forma como 
// ! tem que agir.
// ! As rotas são definidas os Endpoints (endereçoFs), que vai ou não requerer parâmentros, podendo ser os parâmetros do tipo opcional ou não.

require 'vendor/autoload.php';

// title: ----------------------------- Configurando Banco de dados no Slim ----------------------------------
$app = new \Slim\App([ // @ Iniciando o objeto Slim para usarmos.
    'settings' => [ // @ Ativa a exibição de erros na config do objeto.
        'displayErrorDetails' => true
    ]
]);
$container = $app->getContainer();
$container['db'] = function(){
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'slim',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    // @ Tornar a instância global.
    $capsule->setAsGlobal();
    // @ Ferramenta para fazer a comunicação com o BD.
    $capsule->bootEloquent();

    return $capsule;
};
    $app->get( '/usuarios', function(Request $request, Response $response){
        // @ Obtendo o objeto BD no container.
        $db = $this->get('db');
        //@ Usando a lib illuminate pra criar a Tabela no Banco de dados.
        // $db->schema()->dropIfExists('usuarios');
        // $db->schema()->create('usuarios', function($table){
        //     $table->increments('id');
        //     $table->string('nome');
        //     $table->string('email');
        //     $table->timestamps();
        // });
        //@ Usando a lib illuminate pra inserir dados na Tabela do Banco de dados.
        // $db->table('usuarios')->insert([
        //     'nome' => 'Samuel J',
        //     'email' => 'samuel.santos@gmail.com'
        // ]);
        //@ Usando a lib illuminate pra atualizar dados na Tabela do Banco de dados.
        // $db->table('usuarios')->where('id',1)->update([
        //     'nome' => 'Samuka J',
        //     'email' => 'samukinha.santos@gmail.com'
        // ]);
        //@ Usando a lib illuminate pra deletar dados da Tabela do Banco de dados.
        // $db->table('usuarios')->where('id',1)->delete();
        //@ Usando a lib illuminate pra listar os dados da Tabela do Banco de dados.
        $listas = $db->table('usuarios')->get();
        foreach ($listas as $dado ) {
            echo $dado->nome . '<br>';
        }

    });
$app->run();
// title: ----------------------------------------------------------------------------------------------------
// title: ----------------------------- Configurando Middleware(filtro) para rotas ---------------------------

// title: Criando middleware 
// $app->add( function ($request, $response, $next){ // @ O middleware é criado oara todas as rotas e serve para filtrar antes de chegar nas rotas de fato 
//     $response->write('Inicio camada 1 +'); // @ Acessa isso ao entrar no middleware
//     $next($request, $response);
//     $response->write(' + Passando de novo no filtro 1'); // @ Acesso ao sair do middleware
//     return $response;
// });
// title: Primeira camada à ser executada.
// $app->add( function($request, $response, $next){ // @ as camadas de filtros(middlewares) é definida de baixo para cima, assim essa é a primeira.
//     $response->write(' Inicio camada 2 +'); // @ Acessa isso ao entrar no middleware
//     $next($request, $response); 
//     $response->write(' + Passando de novo filtro 2'); // @ Acesso ao sair do middleware
//     return $response;
// });

// $app->get( '/usuarios', function(Request $request, Response $response){
//     $response->write(' Ação principal usuarios');
// });
// $app->get( '/postagens', function(Request $request, Response $response){
//     $response->write(' Ação principal postagens');
// });

// title: ----------------------------------------------------------------------------------------------------

//  title: ---------------------------- Enviando informações no cabeçalho da requisição ----------------------

// title: Setando configuração do Header 
    // $app->get('/header', function(Request $request, Response $response){
    //     $response->withHeader('allow', 'PUT'); // @ Configurando o header para receber apenas requisições do tipo PUT.
    //     $response->withAddedHeader('Content-lengh', 10); // @ Configurnado o header para ter um limite de resposta em caractere.
    // });
// title: Tipo de respostas
//@ XML, Json, text
// $app->get('/response_json', function(Request $request, Response $response){
//     return $response->withJson([
//         'nome' => 'Samuel Jesus',
//         'idade' => '19'
//     ]); // @ Transformando resposta em JSON.
// });
// $app->get('/response_xml', function(Request $request, Response $response){
//     $xml = file_get_contents('arquivo');
//     $response->write($xml); // @ Transformando resposta em XML.
//     return $response->withHeader('Content-Type', 'application/xml');
// });

// title: ---------------------------------------------------------------------------------------------------

// title: -------------------------- Fazendo Injeção de dependências com container --------------------------------------

    //title:  Utilizando dependency Injection  com Container Pimple
    // $container = $app->getContainer();// @ Recupera o container do slim que utiliza o pimple.
        // @ Sua função é guardar classes e funcionalidades que iremos utilizar na aplicação.
    // $container['Home'] = function(){
    //     return new MyApp\controllers\Home(new MyApp\View);
    // };

    // $app->get('/servico', function(Request $request, Response $response){
    //     $servico = $this->get('servico');// @  Obtendo funcionalidades que guardamos no container.
    // });

        // title: Direcionando a rota pra o controller.
    // $app->get('/controller', 'Home:index'); // @ A rota aponta diretamente para o controller, e passa também o parâmetro Req, Res para ele.

// title: ---------------------------------------------------------------------------------------------------

// title: Tipando os parâmetros.
// $app->get('/retorno', function( Request $request, Response $response){ // title: utilizando PSR-4 tipando os paramêntros da função anônima.

// 	$response->getBody()->write("Retorno da API"); // @ Forma correta de emitir um response sem o 'echo'.
//     return $response; //enviando para o front.
// } );
// title: Utilizando o verbo POST
// $app->post('/inserir', function( Request $request, Response $response){ // @ ao utilizar o verbo post é esperado dados enviado com método POST no body da requisição.
//     @ recuperando o que foi mandado no body da requisição. 
//     $post = $request->getParseBody()
        // * code here.
//     return $response->getBody()->write('Inserido com sucesso!');
// } );

// title: Utilizando o verbo PUT
// $app->put('/atualizar', function( Request $request, Response $response){ // ao utilizar o verbo post é esperado dados enviado com método POST no body da requisição.
//     @ recuperando o que foi mandado no body da requisição. 
//     $id = $request->getAttribute0('id');
        // * code here.
//     return $response->getBody()->write('Deletado com sucesso!');
// } );

// title: Utilizando o verbo DELETE
// $app->delete('/deletar', function( Request $request, Response $response){ // @ ao utilizar o verbo POST é esperado dados enviado com método POST no body da requisição.
        // @ recuperando o que foi mandado no body da requisição. 
//     $post = $request->getParseBody();
        // * code here.
//     return $response->getBody()->write('Atualizado com sucesso!');
// } );

// title: Utilizando o verbo GET
// $app->get('/postagens2', function(){ // @ Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint (/postagens2) 
// 	echo "Listagem de postagens";
// } );


// title: Parâmentros no endpoint
// title: Parâmetro não OPCIONAL
// $app->get('/usuarios[/{id}]', function($request, $response){ // @ Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint e um parâmentro não opcional sinalizado pelas '{}' (/usuarios/{parâmetro})
    //! Tudo que estã dentro de chaves é requerido, assim se não conter não funcionará.
// 	$id = $request->getAttribute('id'); // @ Através do request pegamos o parâmetro enviado no Endpoint e a partir daí podemos utiliza-lo.

// 	*Verificar se ID é valido e existe no BD

// 	echo "Listagem de usuarios ou ID: " . $id;
// } );
// title: Parâmetro OPCIONAL
// $app->get('/postagens[/{ano}[/{mes}]]', function($request, $response){ // @ Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint e um parâmentro opcional sinalizado pelas '[]' (/usuarios/{parâmetro})
    //! Tudo que estã dentro de colchetes é opcional, assim pode ou não conter que funcionará.

// 	$ano = $request->getAttribute('ano');
// 	$mes = $request->getAttribute('mes');
// 	echo "Listagem de postagens Ano: " . $ano . " mes: " . $mes;
// } );
// title: Tipando dados do endpoint
// $app->get('/lista/{itens:.*}', function($request, $response){ // @ Podemos tabém tipar dados que é requisitado no parâmetro, colocando o tipo após ':' , sendo assim tornando o tipo um requisito.
	
// 	$itens = $request->getAttribute('itens');

// 	echo $itens;
// 	var_dump(explode("/", $itens));
// } );


// title: Nomeando rotas 
// $app->get('/blog/postagens/{id}', function($request, $response){ 
// 	echo "Listar postagem para um ID ";
// })->setName("blog"); // @ Podemos definir um nome para a rota, como um alias, afim de utiliza-la posteriormente sem precisar passar toda config.
   // title: utilizando rota por seu nome.
// $app->get('/meusite', function($request, $response){
// 	$retorno = $this->get("router")->pathFor("blog", ["id" => "10" ] ); // @ Aqui estamos acessando uma rota que foi setada e passamos os parâmentros requeridos.
// 	echo $retorno;
// });


// title: Agrupando rotas 
// $app->group('/v5', function(){ // @ O método group permite que agrupemos rotas, afim de utilizar um endpoint padrão para acessar outras rotas do seu contexto, evitando digitar msm nome de parte de rotas em rotas diferentes

    // title: Criando rota e exibindo dados com echo.	
// 	$this->get('/usuarios', function(){
// 		echo "Listagem de usuarios"; // ! Não é a forma correta de se fazer a exibição na view!
// 	} );

    // title: Criando rota e exibindo dados com echo.
// 	$this->get('/postagens', function(){
// 		echo "Listagem de postagens"; // ! Não é a forma correta de se fazer a exibição na view!
// 	} );

// } );