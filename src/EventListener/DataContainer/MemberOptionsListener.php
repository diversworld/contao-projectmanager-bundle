<?php

namespace Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class MemberOptionsListener
{
    private Connection $db;
    private LoggerInterface $logger;

    public function __construct(Connection $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }


    #[AsCallback(table: 'tl_project_task', target: 'fields.assigned_to.options')]
    public function __invoke(?DataContainer $dc = null): array
    {
        $options = [];
        try {
            $members = $this->db->fetchAllAssociative("SELECT id, firstname, lastname FROM tl_member ORDER BY lastname, firstname");

            foreach ($members as $member) {
                $options[$member['id']] = $member['firstname'] . ' ' . $member['lastname'];
            }
        } catch (\Exception $e) {
            $this->logger->error('DB Error: ' . $e->getMessage());
        }

        return $options;
    }
}
