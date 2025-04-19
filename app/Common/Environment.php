<?php
namespace App\Common;

class Environment
{
    public static function load ($dir)
    {
        // VERIFICAR SE ARQUIVO .ENV EXISTE
        if (!file_exists($dir . DS . ".env"))
        {
            return false;
            exit();
        }

        // CARREGAR LINHA POR LINHA DO ARQUIVO .ENV
        $lines = file($dir . DS . ".env");
        foreach($lines as $line)
        {
            putenv(trim($line));
        }
    }
}
?>
