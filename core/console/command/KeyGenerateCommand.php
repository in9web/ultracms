<?php
namespace Ultra\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KeyGenerateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('key:generate')
            ->setDescription('Set the application key')
            ->addOption(
               'show',
               null,
               InputOption::VALUE_NONE,
               'If set, display the key instead of modifying files'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $this->generateRandomKey();

        if ($input->getOption('show')) {
            return $output->writeln('<comment>'.$key.'</comment>');
        }

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        $this->setKeyInEnvironmentFile($key);

        \Ultra\Config::getConfig('encryption_key', $key);

        $output->writeln("Application key [$key] set successfully.");
    }

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $key
     * @return void
     */
    protected function setKeyInEnvironmentFile($key)
    {
        file_put_contents($this->environmentFilePath(), str_replace(
            'APP_KEY='.\Ultra\Config::getConfig('encryption_key'),
            'APP_KEY='.$key,
            file_get_contents($this->environmentFilePath())
        ));
    }
    
    /**
     * Get path to default .env file
     *
     * @return string
     */
    protected function environmentFilePath()
    {
        return \Ultra\Config::getConfig('base_path').'/.env';
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(random_bytes(
            // $this->laravel['config']['app.cipher'] == 'AES-128-CBC' ? 16 : 32
            16
        ));
    }
}