<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;


/**
 * Class DocsCommand
 * @package App\Console\Commands
 */
class DocsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Crear documentación";

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * Execute the console command.
     *
     */
    public function fire()
    {
    	$actualDir = getcwd();
    	shell_exec("php artisan api:docs --output-file $actualDir/public/docs.md");

    	shell_exec("aglio --condense-nav --theme-variables slate -i $actualDir/public/docs.md --theme-template triple -o $actualDir/public/docs.html");
    	echo "php artisan api:docs --output-file $actualDir/public/docs.md\n\n";
    	echo "Si tenes instalado drafter y https://github.com/pixelfusion/blueman y seteada API_PATH en el .env, puedes ejecutar el siguiente comando: << php artisan postman >> para crear una coleccion que se puede importar directo a postman";
    }

}