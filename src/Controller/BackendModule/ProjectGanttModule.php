<?php

namespace Diversworld\ContaoProjectmanagerBundle\Controller\BackendModule;

use Contao\BackendModule;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;

class ProjectGanttModule extends BackendModule
{
    protected $strTemplate = 'be_project_gantt';

    protected function compile(): void
    {
        $tasks = TaskModel::findAll();
        $criticalIds = TaskModel::calculateCriticalPath();

        foreach ($tasks as $task) {
            $task->is_critical = in_array($task->id, $criticalIds, true);
        }

        $ganttTasks = [];

        if ($tasks) {
            foreach ($tasks as $task) {
                if (empty($task->startDate)) {
                    continue;
                }

                $isMilestone = !empty($task->milestone);

                $start = (int)$task->startDate;
                $end   = (int)$task->endDate ?: $start;

                // Milestones: end auf start + 1 Tag setzen für Rendering
                if ($isMilestone) {
                    $end = $start + 86400; // +1 Tag
                }

                // Dependencies ermitteln
                $dependencies = [];
				
                try {
                    $dependencies = $task->getDependencies();
                } catch (\Throwable $e) {
                    $dependencies = [];
                }
				
                if (is_string($dependencies)) {
                    $unser = @unserialize($dependencies);
                    $dependencies = ($unser !== false || $dependencies === 'b:0;') ? $unser : [];
                }
				
                if (!is_array($dependencies)){
					$dependencies = [$dependencies];
				}
				
                $dependencies = implode(',', array_filter($dependencies));

                $ganttTasks[] = [
                    'id'           => (string)$task->id,
                    'name'         => $task->title,
                    'start'        => date('Y-m-d', $start),
                    'end'          => date('Y-m-d', $end),
                    'progress'     => $isMilestone ? 100 : (int)$task->progress,
                    'dependencies' => $dependencies,
                    'custom_class' => $isMilestone ? 'milestone' : ($task->is_critical ? 'critical' : '')
                ];
            }
        }

        // Fallback falls keine Tasks vorhanden
        if (empty($ganttTasks)) {
            $ganttTasks = [
                ['id'=>'1','name'=>'Task test 1','start'=>'2025-08-20','end'=>'2025-08-25','progress'=>50],
                ['id'=>'2','name'=>'Task test 2','start'=>'2025-08-26','end'=>'2025-08-30','progress'=>20],
                ['id'=>'3','name'=>'Meilenstein','start'=>'2025-08-28','end'=>'2025-08-29','progress'=>100,'custom_class'=>'milestone'],
            ];
        }
		
		// ---- Topologische Sortierung ----
		$sorted = [];
		$visited = [];

		$visit = function($taskId, &$ganttTasks, &$visited, &$sorted, $stack = []) use (&$visit) {
			if (isset($visited[$taskId])) {
				return;
			}
			$visited[$taskId] = true;

			// Finde Task
			foreach ($ganttTasks as $task) {
				if ($task['id'] === $taskId) {
					foreach ($task['deps'] as $depId) {
						$visit((string)$depId, $ganttTasks, $visited, $sorted, array_merge($stack, [$taskId]));
					}
					$sorted[$taskId] = $task;
				}
			}
		};

		foreach ($ganttTasks as $task) {
			$visit($task['id'], $ganttTasks, $visited, $sorted);
		}

	    $ganttTasks = array_values($sorted);		

		// ---- Zusätzliche Sortierung nach Datum, Meilenstein, Name ----
		usort($ganttTasks, static function ($a, $b) {
			$aStart = strtotime($a['start']);
			$bStart = strtotime($b['start']);

			if ($aStart === $bStart) {
				$aIsMilestone = ($a['custom_class'] ?? '') === 'milestone';
				$bIsMilestone = ($b['custom_class'] ?? '') === 'milestone';

				if ($aIsMilestone && !$bIsMilestone) {
					return -1;
				}
				if (!$aIsMilestone && $bIsMilestone) {
					return 1;
				}

				return strcmp($a['name'], $b['name']);
			}

			return $aStart <=> $bStart;
		});
		
        $this->Template->ganttTasks = json_encode(
            $ganttTasks,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        );
    }
}
