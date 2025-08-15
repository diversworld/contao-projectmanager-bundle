<?php

// src/Resources/contao/dca/tl_pm_task_dependency.php
$GLOBALS['TL_DCA']['tl_pm_task_dependency'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id'                  => 'primary',
                'task_id'             => 'index',
                'depends_on_task_id'  => 'index',
            ],
        ],
    ],

    'list' => [
        'sorting' => [
            'mode'        => 1,
            'fields'      => ['task_id'],
            'flag'        => 1,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['task_id', 'depends_on_task_id'],
            'format' => 'Task: %s hängt ab von: %s',
        ],
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
        'default' => '{dependency_legend},task_id,depends_on_task_id',
    ],

    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
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
        'depends_on_task_id' => [
            'label'     => ['Vorgänger-Task', 'Wähle den Vorgänger-Task'],
            'exclude'   => true,
            'inputType' => 'select',
            'foreignKey'=> 'tl_pm_tasks.title',
            'eval'      => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
            'relation'  => ['type'=>'hasOne', 'load'=>'eager'],
        ],
    ],
];
