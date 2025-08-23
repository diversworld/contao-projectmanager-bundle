<?php

namespace Diversworld\ContaoProjectmanagerBundle\EventListener;

use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;
use Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer\MilestoneCompletionChecker;

class TaskUpdateListener
{
    private MilestoneCompletionChecker $completionChecker;

    public function __construct(MilestoneCompletionChecker $completionChecker)
    {
        $this->completionChecker = $completionChecker;
    }

    public function postUpdate(TaskModel $task): void
    {
        // Fortschritt des Meilensteins aktualisieren
        $this->completionChecker->updateProgress($task->id);
    }
}
