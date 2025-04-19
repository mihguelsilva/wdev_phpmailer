<?php
namespace App\Comunication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailException;

class Email
{
    /*
      Mensagem de erro
      @var string
     */
    private $error;

    /*
      Método responsável por retornar erros de envio
      @return string
     */
    public function getError()
    {
        return $this -> error;
    }

    /*
      Método responsável por enviar mensagens de email
      @param string array $addresses
      @param string $subject
      @param string $body
      @param string array $attachements
      @param string array $ccs
      @param string array $bccs
      @return boolean
     */
    public function sendEmail($addresses, $subject, $body, $attachements = array(), $ccs = array(), $bccs = array())
    {
        // LIMPAR MENSAGEM DE ERRO
        $this -> error = '';

        // INSTANCIAR PHPMAILER
        $obMail = new PHPMailer(true);
        try
        {
            // CREDENCIAIS DE EMAIL
            $obMail -> Host = getenv('SMTP_HOST');
            $obMail -> SMTPAuth = true;
            $obMail -> Username = getenv('SMTP_USER');
            $obMail -> Password = getenv('SMTP_PASS');
            $obMail -> SMTPSecure = getenv('SMTP_SECURE');
            $obMail -> Port = getenv('SMTP_PORT');
            $obMail -> Charset = getenv('SMTP_CHARSET');

            // REMETENTE
            $obMail -> setFrom(getenv('SMTP_FROM_EMAIL'), getenv('SMTP_FROM_NAME'));

            // DESTINATARIO
            $addresses = is_array($addresses) ? $addresses : array($addresses);
            foreach($addresses as $address)
            {
                $obMail -> addAddress($address);
            }

            // ANEXOS
            $attachements = is_array($attachements) ? $attachements : array($attachements);
            foreach($attachements as $attachement)
            {
                $obMail -> addAttachment($attachement);
            }

            // COPIAS ($ccs)
            $ccs = is_array($ccs) ? $ccs : array($ccs);
            foreach($ccs as $cc)
            {
                $obMail -> addCC($cc);
            }

            // NAO NULA ($bccs)
            $bccs = is_array($bccs) ? $bccs : array($bccs);
            foreach($bccs as $bcc)
            {
                $obMail -> addBCC($bcc);
            }

            // CORPO E MENSAGEM DO EMAIL
            $obMail -> isHTML(true);
            $obMail -> Subject = $subject;
            $obMail -> Body = $body;

            // ENVIAR EMAIL
            return $obMail -> send();
        } catch (PHPMailerException $e)
        {
            $this -> error = $e -> getMessage();
            return false;
        }
    }
}
?>
