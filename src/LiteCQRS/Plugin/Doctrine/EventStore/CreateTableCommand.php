<?php
namespace LiteCQRS\Plugin\Doctrine\EventStore;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

class CreateTableCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('lite-cqrs:create-event-store')
        ->setDescription('Creates the DBAL Event Store Schema')
        ->setHelp(<<<EOT
Creates the DBAL Event Store Schema.
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getConnection();
        $eventStoreTableSchema = new \LiteCQRS\Plugin\Doctrine\EventStore\TableEventStoreSchema();

        if ($connection->getSchemaManager()->tablesExist($eventStoreTableSchema->getTableSchema()->getName())) {
            $output->write("Event Store exists. Nothing to create.");
            return;
        }

        $connection->getSchemaManager()->createTable($eventStoreTableSchema->getTableSchema());

        $output->write("Event Store created.");
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
