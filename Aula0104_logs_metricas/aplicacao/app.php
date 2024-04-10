<?php

require_once __DIR__ . '/src/Usuario.php';
require_once __DIR__ . '/src/CalculadoraImc.php';
require_once __DIR__ . '/src/SexoEnum.php';
require_once __DIR__ . '/src/ClassificacaoImcEnum.php';
require_once __DIR__ . '/src/CalculadoraImcMasculino.php';
require_once __DIR__ . '/src/CalculadoraImcFeminino.php';



$usuario = new Usuario( nome: $_POST['nome'], 
                        peso: $_POST['peso'], 
                        altura: $_POST['altura'],
                        sexo: SexoEnum::from($_POST['sexo']),
                         dataNascimento: new DateTimeImmutable($_POST['data_nascimento'])
);

$calculadora = new CalculadoraImc($usuario);
$resultado = ClassificacaoImcEnum::classifica($calculadora->calcular());



if (!isset($_POST['tipo_calculadora'])) {
    throw new Exception('Tipo de calculadora não fornecido.');
}

$tipo_calculadora = $_POST['tipo_calculadora'];

if (!isset($_POST['sexo'])) {
    throw new Exception('Valor de sexo não fornecido.');
}

$sexo = $_POST['sexo'];
if ($sexo === 'Masculino') {
    $sexoEnum = SexoEnum::M;
} elseif ($sexo === 'Feminino') {
    $sexoEnum = SexoEnum::F;
} else {
    throw new Exception('Valor de sexo inválido.');
}



if ($tipo_calculadora === 'Normal') {
    $calculadora = new CalculadoraImc($usuario);
} elseif ($tipo_calculadora === 'Masculina') {
    $calculadora = new CalculadoraImcMasculino($usuario);
} elseif ($tipo_calculadora === 'Feminina') {
    $calculadora = new CalculadoraImcFeminino($usuario);
} else {
    throw new Exception('Tipo de calculadora não reconhecido.');
}


// Ler o template de resposta
$template = file_get_contents(__DIR__ . '/src/templates/resultado.html');

// Trocar cada valor estático pelo valor do script
$template = str_replace(
    [
        '{{USUARIO}}',
        '{{PESO}}',
        '{{ALTURA}}',
        '{{IDADE}}',
        '{{SEXO}}',
        '{{ICM}}',
        '{{CLASSIFICACAO}}'
    ],
    [
        $usuario->getNome(),
        $usuario->getPeso(),
        $usuario->getAltura(),
        $usuario->getIdadeAtual(),
        $usuario->getSexo()->value,
        $resultado,
        $classificacao
    ],
    $template);

echo $template;