<?php
namespace Ultra\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ClearLogsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('clear:logs')
            ->setDescription('Clear all logs from folder')
            ->addOption(
               'lasts',
               null,
               InputOption::VALUE_NONE,
               'Clear the lasts X items'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $total = $this->clearLogs();

        $output->writeln("------------------------------");
        $output->writeln("Logs cleared. Total: ". $total);
    }

    /**
     * Clear the logs
     *
     * @return integer Return total files cleared
     */
    protected function clearLogs()
    {
        $total = 0;
        
        //return LOGPATH.'/stubs/model.stub';
        
        foreach (glob(LOGPATH.'/*.log') as $filename) {

            echo $filename.PHP_EOL;

            @unlink($filename);
            $total++;

        }

        return $total;
    }

}