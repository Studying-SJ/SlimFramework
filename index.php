<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Para criar caminhos (rotas) para API, precisamos dizer qual tipo de caminho é (GET, POST, PUT, DELETE...) sendo qua cada um tem suas peculiaridades na forma como 
// tem que agir.
// As rotas são definidas os Endpoints (endereços), que vai ou não requerer parâmentros, podendo ser os parâmetros do tipo opcional ou não.

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/retorno', function( Request $request, Response $response){ // utilizando PSR-4 tipando os paramêntros da função anonima.

	$response->getBody()->write("Retorno da API"); //Forma correta de emitir um response sem o 'echo'.
    return $response; //enviando para o front.

} );
//Utilizando o verbo POST
$app->post('/inserir', function( Request $request, Response $response){ // ao utilizar o verbo post é esperado dados enviado com método POST no body da requisição.
    //recuperando o que foi mandado no body da requisição. 
    $post = $request->getParseBody();

    // code here.

    return $response->getBody()->write('Inserido com sucesso!');

} );

//Utilizando o verbo PUT
$app->put('/atualizar', function( Request $request, Response $response){ // ao utilizar o verbo post é esperado dados enviado com método POST no body da requisição.
    //recuperando o que foi mandado no body da requisição. 
    $id = $request->getAttribute0('id');

    // code here.

    return $response->getBody()->write('Deletado com sucesso!');

} );

//Utilizando o verbo DELETE
$app->put('/deletar', function( Request $request, Response $response){ // ao utilizar o verbo post é esperado dados enviado com método POST no body da requisição.
    //recuperando o que foi mandado no body da requisição. 
    $post = $request->getParseBody();

    // code here.

    return $response->getBody()->write('Atualizado com sucesso!');

} );




$app->run();

// $app->get('/postagens2', function(){ //Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint (/postagens2)

// 	echo "Listagem de postagens";

// } );

// $app->get('/usuarios[/{id}]', function($request, $response){ //Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint e um parâmentro não opcional sinalizado pelas '{}' (/usuarios/{parâmetro})
//                                                             //Tudo que estã dentro de chaves é requerido, assim se não conter não funcionará.
// 	$id = $request->getAttribute('id'); //Através do request pegamos o parâmetro enviado no Endpoint e a partir daí podemos utiliza-lo.

// 	//Verificar se ID é valido e existe no BD

// 	echo "Listagem de usuarios ou ID: " . $id;

// } );

// $app->get('/postagens[/{ano}[/{mes}]]', function($request, $response){ //Aqui estamos defininindo uma rota do tipo GET e passando seu Endpoint e um parâmentro opcional sinalizado pelas '[]' (/usuarios/{parâmetro})
//                                                                        //Tudo que estã dentro de colchetes é opcional, assim pode ou não conter que funcionará.
	
// 	$ano = $request->getAttribute('ano');
// 	$mes = $request->getAttribute('mes');

// 	//Verificar se ID é valido e existe no BD

// 	echo "Listagem de postagens Ano: " . $ano . " mes: " . $mes;

// } );

// $app->get('/lista/{itens:.*}', function($request, $response){ //Podemos tabém tipar dados que é requisitado no parâmetro, colocando o tipo após ':' , sendo assim tornando o tipo um requisito.
	
// 	$itens = $request->getAttribute('itens');

// 	//Verificar se ID é valido e existe no BD
// 	//echo $itens;
// 	var_dump(explode("/", $itens));

// } );


// /* Nomear rotas */
// $app->get('/blog/postagens/{id}', function($request, $response){ 
// 	echo "Listar postagem para um ID ";
// })->setName("blog"); // Podemos definir um nome para a rota, como um alias, afim de utiliza-la posteriormente sem precisar passar toda config.

// $app->get('/meusite', function($request, $response){
	
// 	$retorno = $this->get("router")->pathFor("blog", ["id" => "10" ] ); //Aqui estamos acessando uma rota que foi setada e passamos os parâmentros requeridos.

// 	echo $retorno;

// });


// /* Agrupar rotas */
// $app->group('/v5', function(){ // O método group permite que agrupemos rotas, afim de utilizar um endpoint padrão para acessar outras rotas do seu contexto, evitando digitar msm nome de parte de rotas em rotas diferentes
	
// 	$this->get('/usuarios', function(){
// 		echo "Listagem de usuarios";
// 	} );

// 	$this->get('/postagens', function(){
// 		echo "Listagem de postagens";
// 	} );

// } );