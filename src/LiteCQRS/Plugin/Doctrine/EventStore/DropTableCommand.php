<?php
namespace LiteCQRS\Plugin\Doctrine\EventStore;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

class DropTableCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('lite-cqrs:drop-event-store')
        ->setDescription('Drops the DBAL Event Store Schema')
        ->setHelp(<<<EOT
Drops the DBAL Event Store Schema.
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getConnection();

        $eventStoreTableSchema = new \LiteCQRS\Plugin\Doctrine\EventStore\TableEventStoreSchema();
        $connection->getSchemaManager()->dropTable($eventStoreTableSchema->getTableSchema());

        $output->write("Event Store dropped.");
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    private function getConnection()
    {
        return $this->getConnectionHelper()->getConnection();
    }

    /**
     * @return \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper
     */
    private function getConnectionHelper()
    {
        return $this->getHelper('db');
    }
}
