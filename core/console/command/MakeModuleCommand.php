<?php
namespace Ultra\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Inflector\Inflector;
use Ultra\Config;
use function Stringy\create as s;

class MakeModuleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:module')
            // Don\'t use this in a production environment
            ->setDescription('Create a new Module')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of Module')
            ->addOption(
               'h',
               null,
               InputOption::VALUE_NONE,
               'Default host localhost'
            )
            ->addOption(
               'p',
               null,
               InputOption::VALUE_NONE,
               'Default port 8000'
            )
            ->addOption(
               'd',
               null,
               InputOption::VALUE_NONE,
               'Default document root .'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $modules_dir = Config::getConfig('admin_path').'/modules/';
        
        if (!is_writable($modules_dir)) {
            throw new Exception("Check permissions to folder modules admin: ".$modules_dir, 1);
        }

        $module_name        = (string) s($input->getArgument('name'))->trim()->upperCaseFirst();
        $module_file        = (string) s($module_name)->slugify();
        $module_path        = $modules_dir.$module_file;
        $module_path_lang   = $module_path.'/languages/';

        $module_slug   = (string) s($module_name)->slugify();
        $module_uri    = (string) s($module_name)->slugify();
        $module_view   = 'basic';
        $module_icon   = 'cog';
        $module_model  = (string) s(Inflector::singularize($module_name))->upperCamelize();
        $module_menu_position = 0;
        $module_controller = (string) s($module_name)->upperCamelize().'Controller';

        $output->writeln('Creating folder to module in: '.$module_path);

        // create folder of module
        mkdir($module_path);

        $output->writeln('Creating folder language to module in: '.$module_path_lang);
        // create language folder of module
        mkdir($module_path_lang);

        $output->writeln('Copy folder module with configs: ');
        $output->writeln('Locale: '.                Config::getConfig('language_locale'));
        $output->writeln('Module Slug Name: '.      $module_slug);
        $output->writeln('Module Name: '.           $module_name);
        $output->writeln('Module View: '.           $module_view);
        $output->writeln('Module Uri: '.            $module_uri);
        $output->writeln('Module Model: '.          $module_model);
        $output->writeln('Module Icon: '.           $module_icon);
        $output->writeln('Module Menu Position: '.  $module_menu_position);
        $output->writeln('Module Controller: '.     $module_controller);

        copy(COREPATH.'/stubs/module/languages/language.php', $module_path_lang.'/'.Config::getConfig('language_locale').'.php');
        copy(COREPATH.'/stubs/module/bootstrap.php', $module_path.'/bootstrap.php');
        copy(COREPATH.'/stubs/module/config.php', $module_path.'/config.php');
        copy(COREPATH.'/stubs/module/module.php', $module_path.'/'.$module_file.'.php');

        // change module Configs
        $module_new_config = file_get_contents($module_path.'/config.php');
        $module_new_config = str_replace('dummy_slug',      $module_slug, $module_new_config);
        $module_new_config = str_replace('dummy_name',      $module_name, $module_new_config);
        $module_new_config = str_replace('dummy_view',      $module_view, $module_new_config);
        $module_new_config = str_replace('dummy_uri',       $module_uri, $module_new_config);
        $module_new_config = str_replace('dummy_icon',      $module_icon, $module_new_config);
        $module_new_config = str_replace('dummy_model_name',$module_model, $module_new_config);
        $module_new_config = str_replace('dummy_position',  $module_menu_position, $module_new_config);
        file_put_contents($module_path.'/config.php', $module_new_config);

        // change module items on module file
        $module_new_content = file_get_contents($module_path.'/'.$module_file.'.php');
        $module_new_content = str_replace('DummyController', $module_controller, $module_new_content);
        file_put_contents($module_path.'/'.$module_file.'.php', $module_new_content);

        if ($input->getOption('h')) {
            $host = $input->getOption('h');
        }

        $output->writeln('Module created with success!');
        
    }

}