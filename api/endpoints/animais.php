<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface;

require '_class/animalDao.php';
require '_genesis/ImageFactory.php';

$app->get('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
    $ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::selectByIdForm($animal);
    $code = count($data) > 0 ? 200 : 404;

    return $response->withJson($data, $code);
});

$app->post('/animais/upload', function (Request $request, Response $response) {
    $files = $request->getUploadedFiles();
       $files = $request->getUploadedFiles();
    if (empty($files['argus'])) {
        throw new Exception('Expected a newfile');
    }
    
    $roots=dirname(dirname(__FILE__));
    $pasta = substr($roots, 0,strrpos($roots, "\\")); 
    $pasta .= "\\fotos\\";
    
    $newfile = $files['argus'];
    
    if ($newfile->getError() === UPLOAD_ERR_OK) {
        $uploadFileName = $newfile->getClientFilename();
        $newfile->moveTo($pasta.$uploadFileName);
        
        $imageFactory = new ImageFactory();
        $imageFactory->resize_crop_image(200, 200, $pasta.$uploadFileName, $pasta.$uploadFileName);
        
        $nameFile = explode(".", $uploadFileName);
        $thumb = $nameFile[0] . ".thumb." . $nameFile[1];
        $imageFactory->resize_crop_image(50, 50, $pasta.$uploadFileName, $pasta.$thumb);
    }
    
    return $response->withJson("http://$_SERVER[HTTP_HOST]/simplesvet/fotos/$thumb", 200);
});


$app->post('/animais', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $animal = new Animal();
    $animal->setAni_var_nome($body['ani_var_nome']);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso($body['ani_dec_peso']);
 	$animal->setAni_var_raca($body['ani_var_raca']);
        $animal->setAni_var_foto($body['ani_var_foto']);
        $proprietario = new Proprietario();
        $proprietario->setPro_int_codigo($body['pro_int_codigo']);
        $animal->setProprietario($proprietario);

    $data = AnimalDao::insert($animal);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});


$app->put('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    var_dump('teste');
    $animal = new Animal();

    $animal->setAni_int_codigo($ani_int_codigo);
    $animal->setAni_var_nome($body['ani_var_nome']);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso($body['ani_dec_peso']);
 	$animal->setAni_var_raca($body['ani_var_raca']);
        $animal->setAni_var_foto($body['ani_var_foto']);
        $proprietario = new Proprietario();
        $proprietario->setPro_int_codigo($body['pro_int_codigo']);
        $animal->setProprietario($proprietario);

    $data = AnimalDao::update($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});


$app->delete('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::delete($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});
?>