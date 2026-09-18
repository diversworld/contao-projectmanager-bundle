<?php

$GLOBALS['TL_DCA']['tl_project_milestone_dependency'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id'                  => 'primary',
                'milestone_id'        => 'index',
                'depends_on_id'       => 'index',
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
            'fields' => ['milestone_id', 'depends_on_id'],
            'format' => '%s hängt ab von %s',
        ],
        'operations' => [
            'edit',
            'children',
            'copy',
            'cut',
            'delete',
            'toggle',
            'show',
        ],
    ],

    'palettes' => [
        'default' => '{dependency_legend},milestone_id,depends_on_id',
    ],

    'fields' => [
        'id' => [
            'sql' => "int unsigned NOT NULL auto_increment",
        ],
        'milestone_id' => [
            'label'     => ['Meilenstein', 'Auswählen'],
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_milestone.title',
            'eval'      => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql' => "int unsigned NOT NULL default 0",
            'relation'  => ['type' => 'hasOne', 'load' => 'eager'],
        ],
        'depends_on_id' => [
            'label'     => ['Abhängiger Meilenstein', 'Abhängigkeit definieren'],
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_milestone.title',
            'eval'      => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql' => "int unsigned NOT NULL default 0",
            'relation'  => ['type' => 'hasOne', 'load' => 'eager'],
        ],
    ],
];
