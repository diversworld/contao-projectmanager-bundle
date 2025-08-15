<?php

// src/Resources/contao/dca/tl_pm_milestone_task.php
$GLOBALS['TL_DCA']['tl_pm_milestone_task'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id'           => 'primary',
                'milestone_id' => 'index',
                'task_id'      => 'index',
            ],
        ],
    ],

    'list' => [
        'sorting' => [
            'mode'        => 1,
            'fields'      => ['milestone_id'],
            'flag'        => 1,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['milestone_id', 'task_id'],
            'format' => 'Milestone: %s - Task: %s',
        ],
        'global_operations' => [],
        'operations' => [
            'edit' => [
                'label' => ['Bearbeiten', 'Datensatz bearbeiten'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],
            'delete' => [
                'label' => ['Löschen', 'Datensatz löschen'],
                'href'  => 'act=delete',
                'icon'  => 'delete.svg',
            ],
            'show' => [
                'label' => ['Details', 'Datensatzdetails anzeigen'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ],
    ],

    'palettes' => [
        'default' => '{relation_legend},milestone_id,task_id',
    ],

    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'milestone_id' => [
            'label'     => ['Milestone', 'Wähle den Milestone'],
            'exclude'   => true,
            'inputType' => 'select',
            'foreignKey'=> 'tl_pm_milestones.title',
            'eval'      => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
            'relation'  => ['type'=>'hasOne', 'load'=>'eager'],
        ],
        'task_id' => [
            'label'     => ['Task', 'Wähle den Task'],
            'exclude'   => true,
            'inputType' => 'select',
            'foreignKey'=> 'tl_pm_tasks.title',
            'eval'      => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
            'relation'  => ['type'=>'hasOne', 'load'=>'eager'],
        ],
    ],
];
