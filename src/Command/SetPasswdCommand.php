<?php
/**
 * Este comando maneja el cambio de contraseña del usuario administrador
 * @author Daniel Diaz
 */

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class SetPasswdCommand extends Command
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
                "Este programa genera el hash de la contraseña de administrador.",
                "La misma se guarda en un archivo <project_root>/config/passwd",
                "se recomienda cambiar los permisos del archivo para que el usuario",
                "bajo el cual corre la aplicación web solo tenga permisos lectura.",
                "Con este motivo, el archivo se crea con permisos 640 por defecto."
            ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {

        $passwd = $args->getArgument('passwd');

        if (strlen($passwd) < 6) {
            $io->error('La contraseña debe tener al menos 6 caracteres');
            return 1;
        } 

        $path = Folder::addPathElement(CONFIG, 'passwd');

        // $io->info($path);

        if (file_exists($path)) {
            // Sobreescribir
            $selection = $io->askChoice('Ya existe el archivo de contraseña, ¿desea reescribirlo?', ['y', 'n']);

            if ($selection === 'n') {
                return 0;
            }
        }


        $timeTarget = 0.05; // 50 milliseconds 
        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash($passwd, PASSWORD_DEFAULT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);


        $hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => $cost]);
        // $io->info('Costo optimo: ' .$cost);
        // $io->info('hash: ' . $hash);        


        if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            // Servidor Windows

            $passwd_f = new File($path);

            if ($passwd_f->open('w')) {
                if ($passwd_f->write($hash)) {
                    $io->out('Clave escrita con éxito.');
                    $passwd_f->close();
                    return 0;
                }
                $io->error('No se pudo escribir al archivo.');
                $passwd_f->close();
                return 1;
            } else {
                $iot->error('No se puedo abrir el archivo');
                return 1;
            }
        } else {
            // Otros (se asume UNIX)
            $script = Folder::addPathElement(ROOT, ["bin", "set_admin_passwd.bash"]);

            exec($script . " '$hash'", $output, $ret);
            if ($ret === 0) {
                $io->out('Clave escrita con éxito.');
            } else {
                $io->error('Error al tratar de guardar la contraseña: ' . $ret);
                foreach ($output as $line) {
                    $io->error($line);
                }
                return 1;
            }
            return 0;
        }

    }
}