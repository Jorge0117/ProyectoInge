<?php
/**
 * Este comando maneja la verificación de contraseña del usuario administrador
 * @author Daniel Diaz
 */

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class VerifyPasswdCommand extends Command
{
   
    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser
            ->addArgument('passwd', [
                'help' => 'La constraseña para acceder al usuario administrador',
                'required' => true
            ])
            ->addOption('help', [
                'help' => 'Mostrar este mensaje de ayuda',
                'boolean' => true
            ]);
        $parser
            ->setEpilog([
                "Este programa verifica los credenciales del administrador.",
                "Si la contraseña es válida retorna true."
            ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {

        $passwd = $args->getArgument('passwd');

        $path = Folder::addPathElement(CONFIG, 'passwd');

        if (!file_exists($path)) {
            
            $io->error('La contraseña del administrador no ha sido configurada');
            return false;
        }  
        $passwd_f = new File($path);
        if ($passwd_f->open('r')) {
            $content = $passwd_f->read();
            if ($content === false) {
                $io->error('No se pudo leer el contenido del archivo');
                $passwd_f->close();
                return false;
            } else {
                $result = password_verify($passwd, $content);
                if ($result) {
                    $io->out('true');
                } else {
                    $io->out('false');
                }
                $passwd_f->close();
                return $result; 
            }
        } else {
            $io->error('No se pudo abrir de archivo');
            return false;
        }
    }
}