<?php
namespace Ultra\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModelCommand extends Command
{
    public $_namespace = 'Ultra\Model';

    protected function configure()
    {
        $this
            ->setName('make:model')
            ->setDescription('Create a new Eloquent model class')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of Model')
            ->addOption(
               'migration',
               null,
               InputOption::VALUE_NONE,
               'Create a new migration file for the model.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get Stub 
        $stub = $this->getStubString();
        
        // add Namespace
        $stub = $this->replaceNamespace($stub, $this->_namespace);

        // add Model Name
        $stub = $this->replaceClass($stub, $input->getArgument('name'));

        file_put_contents(COREPATH.'/models/'.ucfirst($input->getArgument('name')).'.php', $stub);

        if ($input->getOption('migration')) {
            // create migration, too, SOON
        }

        $output->writeln("Model created successfully.");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return COREPATH.'/stubs/model.stub';
    }

    /**
     * Get the stub string for the generator.
     *
     * @return string
     */
    protected function getStubString()
    {
        return file_get_contents($this->getStub());
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        return str_replace('DummyClass', $name, $stub);
    }
    
    /**
     * Replace the class namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceNamespace($stub, $name)
    {
        return str_replace('DummyNamespace', $name, $stub);
    }
}