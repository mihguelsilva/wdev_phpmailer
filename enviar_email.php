<?php
require __DIR__ . DIRECTORY_SEPARATOR . "bootstrap" . DIRECTORY_SEPARATOR . "app.php";

use \App\Comunication\Email;

$addresses = "mihguelsantos404@gmail.com";
$subject = "Olá mundo :)";
$body = "<b>Olá mundo</b><br><br><i>Olá mundo</i>";
$attachements = __DIR__ . DS . "anexos.txt";

$obEmail = new Email;
$sucesso = $obEmail -> sendEmail($addresses, $subject, $body, $attachements);

echo $sucesso ? "Mensagem enviada com sucesso" : $obEmail -> getError();

?>
