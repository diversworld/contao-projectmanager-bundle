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

use Diversworld\ContaoProjectmanagerBundle\Model\ProjectModel;
use Diversworld\ContaoProjectmanagerBundle\Model\TaskModel;
use Diversworld\ContaoProjectmanagerBundle\Model\ProjectTaskDependencyModel;
use Diversworld\ContaoProjectmanagerBundle\Controller\BackendModule\ProjectGanttModule;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['project_modules'] = [

    'project_collection' => [
        'tables' =>  ['tl_project', 'tl_project_task', 'tl_project_task_dependency','tl_content'],
        'gantt'  => [
            'callback' => ProjectGanttModule::class,
        ],

    ],

    'project_gantt' => [
        'callback'   => ProjectGanttModule::class,
        'icon'       => 'bundles/contaoprojectmanager/gantt.svg',
    ],
];
/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_project'] = ProjectModel::class;
$GLOBALS['TL_MODELS']['tl_project_task'] = TaskModel::class;
$GLOBALS['TL_MODELS']['tl_project_task_dependency'] = ProjectTaskDependencyModel::class;

// Frontend-Module registrieren
//$GLOBALS['FE_MOD']['project']['project_list'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectListModule::class;
//$GLOBALS['FE_MOD']['project']['project_calendar'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectCalendarModule::class;
//$GLOBALS['FE_MOD']['project']['project_gantt'] = \Diversworld\ContaoProjectmanagerBundle\Module\ProjectGanttModule::class;
