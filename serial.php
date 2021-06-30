<?php
//rotinas para habilitar a exibicao de erros na pagina. Tire se nao quiser.
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', '1');

include "PhpSerial.php"; //import da biblioteca de serial com php
$read = "";

$serial = new phpSerial(); //Cria um novo objeto para comunicacao serial
$serial->deviceSet("/dev/ttyACM0"); //associa esse objeto com a serial do Arduino
$serial->confBaudRate(9600); //configura baudrate em 9600
$serial->confParity("none"); //sem paridade
$serial->confCharacterLength(8); //8 bits de mensagem
$serial->confStopBits(1); //1 bit de parada
$serial->confFlowControl("none"); //sem controle de fluxo
$serial->deviceOpen(); //abre o dispositivo serial para comunicacao

//Se receber 'a' via GET na Pagina
if(isset($_GET['a'])){
	//sleep(2);
	$serial->sendMessage("a"); //envia o caractere 'a' via Serial pro Arduino
	sleep(1); //delay para o Arduino enviar a resposta.
	$read = $serial->readPort(); //faz a leitura da resposta na variavel $read
	echo $read; //echo para mostrar a resposta recebida do Arduino
}

//Se receber 'd' via GET na pagina
if(isset($_GET['d'])){
	//sleep(2);
	$serial->sendMessage("d"); //envia o caractere 'd' via Serial pro Arduino
	sleep(1); //delay para o Arduino enviar a resposta
	$read = $serial->readPort(); //faz a leitura da resposta na variavel $read
	echo $read; //echo para mostrar a resposta recebida do Arduino
}
$serial->deviceClose(); //encerra a conexao serial

?>


<html>
<head></head>

<body>
<h1> Raspi + Arduino </h1>

<input type="button" 
	onclick="location.href='/serial.php?a=1'"
	value="Acende LED" />

<input type="button"
	onclick="location.href='/serial.php?d=1'"
	value="Apaga LED" />
	
<? 
$resultado = explode(",",$read);
echo "<p> Estado do botao: " . $resultado[1] . "</p>";
echo "<p> Estado do LED: " . $resultado[2] . "</p>";
?>

</body>
</html>
