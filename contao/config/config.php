<?php

/*
 * This file is part of Project Manager.
 *
 * (c) Diversworld Eckhard Becker 2025 <info@diversworld.eu>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/diversworld/contao-projectmanager-bundle
 */

use Diversworld\ContaoProjectmanagerBundle\Model\MilestoneModel;
use Diversworld\ContaoProjectmanagerBundle\Model\MilestoneTaskModel;
use Diversworld\ContaoProjectmanagerBundle\Model\ProjectModel;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskDependencyModel;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['project_modules'] = [
    'project_collection' => [
        'tables' => [
            'tl_project',
            'tl_project_task',
            'tl_project_milestone',
            'tl_pm_milestone_task',
            'tl_pm_task_dependency',
        ],
    ],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_project']             = ProjectModel::class;
$GLOBALS['TL_MODELS']['tl_project_task']        = TaskModel::class;
$GLOBALS['TL_MODELS']['tl_project_milestone']   = MilestoneModel::class;
$GLOBALS['TL_MODELS']['tl_pm_milestone_task']   = MilestoneTaskModel::class;
$GLOBALS['TL_MODELS']['tl_pm_task_dependency']  = TaskDependencyModel::class;

// Frontend-Module registrieren
//$GLOBALS['FE_MOD']['project']['project_list'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectListModule::class;
//$GLOBALS['FE_MOD']['project']['project_calendar'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectCalendarModule::class;
//$GLOBALS['FE_MOD']['project']['project_gantt'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectGanttModule::class;
