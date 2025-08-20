<?php

$GLOBALS['TL_DCA']['tl_project_milestone_task'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id'           => 'primary',
                'milestone_id' => 'index',
                'task_id'      => 'index',
            ],
        ],
    ],

    'list' => [
        'sorting' => [
            'mode'        => 1, // Sortierung nach Meilenstein
            'fields'      => ['milestone_id', 'task_id'],
            'flag'        => 1,
            'panelLayout' => 'filter;sort,search,limit',
        ],
        'label' => [
            'fields' => ['milestone_id', 'task_id'],
            'format' => 'Meilenstein: %s - Aufgabe: %s',
        ],
        'operations' => [
            'edit',
            'copy',
            'cut',
            'delete',
            'toggle',
            'show',
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
        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'milestone_id' => [
            'label'     => ['Meilenstein', 'Verweise auf einen Meilenstein.'],
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_milestone.title',
            'eval'      => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'relation'  => ['type' => 'hasOne', 'load' => 'eager'],
            'sql'       => "int(10) unsigned NOT NULL",
        ],
        'task_id' => [
            'label'     => ['Aufgabe', 'Verweise auf eine Aufgabe.'],
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_task.title',
            'eval'      => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'relation'  => ['type' => 'hasOne', 'load' => 'eager'],
            'sql'       => "int(10) unsigned NOT NULL",
        ],
    ],
];
