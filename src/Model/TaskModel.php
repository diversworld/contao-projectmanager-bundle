<?php

declare(strict_types=1);

namespace Diversworld\ContaoProjectmanagerBundle\Model;

use Contao\Model;

class TaskModel extends Model
{
    protected static $strTable = 'tl_project_task';

    /**
     * Alle direkten Vorgänger dieser Task
     *
     * @return TaskModel[]
     */
    public function getPredecessors(): array
    {
        $deps = ProjectTaskDependencyModel::findBy(['pid=?'], [$this->id]);
        if (!$deps) {
            return [];
        }

        $tasks = [];
        while ($deps->next()) {
            $task = self::findById($deps->predecessor);
            if ($task) {
                $tasks[] = $task;
            }
        }
        return $tasks;
    }

    /**
     * Gibt ein Array von Vorgänger-IDs zurück (für Frappe Gantt)
     */
    public function getDependencies(): array
    {
        $deps = [];
        foreach ($this->getPredecessors() as $pred) {
            $deps[] = (string) $pred->id;
        }
        return $deps;
    }

    /**
     * Berechnet die Gesamtdauer vom Projektstart bis zu dieser Task
     */
    public function getPathDuration(): int
    {
        $duration = max(1, (int) ceil(($this->endDate - $this->startDate) / 86400)); // Dauer in Tagen
        $maxPredecessorDuration = 0;

        $predecessors = \Contao\StringUtil::deserialize($this->predecessor, true);

        foreach ($predecessors as $pid) {
            $task = self::findByPk($pid);
            if ($task) {
                $predecessorDuration = $task->getPathDuration();
                $maxPredecessorDuration = max($maxPredecessorDuration, $predecessorDuration);
            }
        }

        return $duration + $maxPredecessorDuration;
    }

    /**
     * Berechnet IDs aller Tasks auf dem kritischen Pfad (ohne DB-Update!)
     *
     * @return int[]
     */
    public static function calculateCriticalPath(): array
    {
        $tasks = self::findAll();
        if (!$tasks) {
            return [];
        }

        $durations = [];
        foreach ($tasks as $task) {
            $durations[$task->id] = $task->getPathDuration();
        }

        $maxDuration = max($durations);
        return array_keys(array_filter($durations, fn($d) => $d === $maxDuration));
    }
}
