<?php

namespace Diversworld\ContaoProjectmanagerBundle\Controller\BackendModule;

use Contao\BackendModule;
use Contao\Input;
use Diversworld\ContaoProjectmanagerBundle\Model\ProjectModel;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;

class ProjectGanttModule extends BackendModule
{
    protected $strTemplate = 'be_project_gantt';

    protected function compile(): void
    {
        $do         = (string) Input::get('do');
        $table      = (string) Input::get('table');
        $selectedId = (int) (Input::get('id') ?: 0);

        // Projekte für die Auswahl (falls kein Projekt gewählt ist oder der Aufruf über das Menü kommt)
        $projects = [];
        if (null !== ($all = ProjectModel::findAll())) {
            foreach ($all as $p) {
                $projects[] = [
                    'id'    => (int) $p->id,
                    'title' => (string) $p->title,
                ];
            }
        }

        // Wenn keine ID gesetzt ist (Aufruf über Menü), zunächst nur Auswahl anzeigen
        if ($selectedId <= 0 && !empty($projects)) {
            $this->Template->projects          = $projects;
            $this->Template->selectedProjectId = 0;
            $this->Template->do                = $do ?: 'project_gantt';
            $this->Template->table             = $table ?: '';
            $this->Template->ganttTasks        = json_encode([], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            return;
        }

        // Tasks nach Projekt filtern
        $tasks = null;
        if ($selectedId > 0) {
            $tasks = TaskModel::findBy('pid', $selectedId);
        }

        $criticalIds = [];
        try {
            // Falls die Methode einen Projektkontext unterstützt, übergeben – andernfalls leer lassen
            if (method_exists(TaskModel::class, 'calculateCriticalPath')) {
                // Versuche, eine projektbezogene Berechnung zu nutzen
                // @phpstan-ignore-next-line
                $criticalIds = TaskModel::calculateCriticalPath($selectedId);
                if (!is_array($criticalIds)) {
                    $criticalIds = [];
                }
            }
        } catch (\Throwable $e) {
            $criticalIds = [];
        }

        $ganttTasks = [];

        if ($tasks) {
            foreach ($tasks as $task) {
                if (empty($task->startDate)) {
                    continue;
                }

                $isMilestone = !empty($task->milestone);
                $start = (int) $task->startDate;
                $end   = (int) $task->endDate ?: $start;

                if ($isMilestone) {
                    $end = $start + 86400; // +1 Tag für Milestone-Rendering
                }

                // Dependencies
                $dependencies = [];
                try {
                    if (method_exists($task, 'getDependencies')) {
                        $dependencies = $task->getDependencies();
                    }
                } catch (\Throwable $e) {
                    $dependencies = [];
                }

                if (is_string($dependencies)) {
                    $unser = @unserialize($dependencies);
                    $dependencies = ($unser !== false || $dependencies === 'b:0;') ? $unser : [];
                }
                if (!is_array($dependencies)) {
                    $dependencies = [$dependencies];
                }
                $dependencies = implode(',', array_filter(array_map('strval', $dependencies)));

                $isCritical = in_array((int) $task->id, $criticalIds, true);

                $ganttTasks[] = [
                    'id'           => (string) $task->id,
                    'name'         => (string) $task->title,
                    'start'        => date('Y-m-d', $start),
                    'end'          => date('Y-m-d', $end),
                    'progress'     => $isMilestone ? 100 : (int) ($task->progress ?? 0),
                    'dependencies' => $dependencies,
                    'custom_class' => $isMilestone ? 'milestone' : ($isCritical ? 'critical' : ''),
                ];
            }
        }

        // Sortierung nach Startdatum, dann Meilenstein, dann Name
        usort($ganttTasks, static function (array $a, array $b): int {
            $aStart = strtotime($a['start']);
            $bStart = strtotime($b['start']);
            if ($aStart === $bStart) {
                $aMilestone = ($a['custom_class'] ?? '') === 'milestone';
                $bMilestone = ($b['custom_class'] ?? '') === 'milestone';
                if ($aMilestone !== $bMilestone) {
                    return $aMilestone ? -1 : 1;
                }
                return strcmp($a['name'], $b['name']);
            }
            return $aStart <=> $bStart;
        });

        $this->Template->projects          = $projects;
        $this->Template->selectedProjectId = $selectedId;
        $this->Template->do                = $do ?: 'project_gantt';
        $this->Template->table             = $table ?: '';
        $this->Template->ganttTasks        = json_encode(
            $ganttTasks,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        );
    }
}
