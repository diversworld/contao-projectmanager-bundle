<?php

namespace Diversworld\ContaoProjectmanagerBundle\EventListener;

use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;
use Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer\MilestoneCompletionChecker;
use Doctrine\ORM\Event\PostUpdateEventArgs;

class TaskUpdateListener
{
    private MilestoneCompletionChecker $completionChecker;

    public function __construct(MilestoneCompletionChecker $completionChecker)
    {
        $this->completionChecker = $completionChecker;
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof TaskModel) {
            return; // Nur für TaskModel reagieren
        }

        // Fortschritt des Meilensteins aktualisieren
        $task = $entity;

        $this->completionChecker->updateProgress($task->id);
    }


}
