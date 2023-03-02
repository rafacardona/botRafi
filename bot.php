<?php

$token = '6094274678:AAGXpcPqDIfQ9sju8canKuUthddyeKblC1c';
$website = 'https://api.telegram.org/bot' . $token;

//lo que el bot recibe
$input = file_get_contents('php://input');

//descodifico json recibido
$update = json_decode($input, true);

$chatId = $update['message']['chat']['id'];
//mensaje recibido
$message = $update['message']['text'];

//en funcion del mensage recibido hago una respuesta.
switch ($message) {
    case '/start':
        $response = 'Hola! Estas en el bot de Rafi! Escribe pokemon y te traere informacion de ciertos pokemon';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'SIII!, correcto estas en el bot de Rafi!';
        sendMessage($chatId, $response);
        break;
    case '/pokemon':
        // url de la api de pokemon
        $url_pokemon = "https://pokeapi.co/api/v2/pokemon/";

        //solicitud HTTP 
        $responseHttp = file_get_contents($url_pokemon);

        //decodifico respuesta
        $pokemons = json_decode($responseHttp);
        $response = 'Mi top 20 de pokemon:';
        foreach($pokemons['results'] as $pokemon){
            $response +="\n".'-'.$pokemon->name;
        }
        sendMessage($chatId, $response);
        break;
    default:
        $response = 'No entiendo :( ';
        sendMessage($chatId, $response);
        break;
}


//funcion para enviar un mensaje de respuesta que recibe el id del chat y el mensaje.
function sendMessage($chatId, $response)
{

    $url = $GLOBALS['website'] . '/sendMessage?chat_id=' . $chatId . '&parse_mode=HTML&text=' . urlencode($response);

    file_get_contents($url);
}
