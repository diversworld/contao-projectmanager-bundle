<?php

namespace Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer;

use Diversworld\ContaoProjectmanagerBundle\Model\MilestoneDependencyModel;
use Diversworld\ContaoProjectmanagerBundle\Model\MilestoneModel;
use Diversworld\ContaoProjectmanagerBundle\Model\MilestoneTaskModel;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;

class MilestoneCompletionChecker
{
    public function canCompleteMilestone($milestoneId): bool
    {
        $dependencies = MilestoneDependencyModel::findBy('milestone_id', $milestoneId);
        foreach ($dependencies as $dependency) {
            $dependentMilestone = MilestoneModel::findByPk($dependency->depends_on_id);
            if ($dependentMilestone && $dependentMilestone->status !== 'Erledigt') {
                return false;
            }
        }
        return true;
    }

    public function updateProgress($taskId): void
    {
        $task = TaskModel::findByPk($taskId);
        if (!$task) {
            return;
        }

        $milestoneTasks = MilestoneTaskModel::findBy('task_id', $taskId);
        foreach ($milestoneTasks as $milestoneTask) {
            $milestone = MilestoneModel::findByPk($milestoneTask->milestone_id);

            // Fortschritt berechnen
            $progress = $this->calculateMilestoneProgress($milestone->id);
            $milestone->progress = $progress;
            $milestone->save();
        }
    }

    /**
     * Berechnet den Fortschritt eines Meilensteins basierend auf den zugehörigen Aufgaben.
     *
     * @param int $milestoneId Die ID des Meilensteins.
     * @return float Der berechnete Fortschritt in Prozent.
     */
    public function calculateMilestoneProgress(int $milestoneId): float
    {
        // Holen der Aufgaben, die zu diesem Meilenstein gehören
        $milestoneTasks = MilestoneTaskModel::findBy('milestone_id', $milestoneId);

        if (!$milestoneTasks) {
            return 0.0; // Wenn keine Aufgaben vorhanden sind, beträgt der Fortschritt 0%
        }

        $totalTasks = 0; // Die Gesamtanzahl der Aufgaben
        $completedProgress = 0.0; // Der gesamte Fortschritt (als Summe der Prozente)

        // Durchlaufe alle Aufgaben dieses Meilensteins
        foreach ($milestoneTasks as $milestoneTask) {
            $task = TaskModel::findByPk($milestoneTask->task_id);

            if ($task) {
                $totalTasks++; // Zähle die Aufgabe
                $completedProgress += (float) $task->progress; // Summiere den Fortschritt dieser Aufgabe
            }
        }

        // Berechne den Durchschnittsfortschritt, wenn Aufgaben vorhanden sind
        return $totalTasks > 0 ? round($completedProgress / $totalTasks, 2) : 0.0;
    }

}
