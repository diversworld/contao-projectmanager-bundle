<?php

declare(strict_types=1);

namespace Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\Database;

#[AsCallback(table: 'tl_project_task', target: 'fields.successor.options')]
class SuccessorOptionsCallback
{

    public function __invoke(DataContainer $dc): array
    {
        $tasks = [];
        if (!$dc->activeRecord) {
            return $tasks;
        }

        // Das aktuelle Task-Objekt laden
        $currentTask = Database::getInstance()
            ->prepare("SELECT pid FROM tl_project_task WHERE id=?")
            ->execute($dc->activeRecord->id);

        if ($currentTask->numRows < 1) {
            return $tasks;
        }

        $projectId = (int) $currentTask->pid;

        // Alle Tasks aus diesem Projekt
        $objTasks = Database::getInstance()
            ->prepare("SELECT id, title FROM tl_project_task WHERE pid=? AND id!=? ORDER BY startDate")
            ->execute($projectId, $dc->activeRecord->id);

        while ($objTasks->next()) {
            $tasks[$objTasks->id] = $objTasks->title;
        }

        return $tasks;
	}
}
