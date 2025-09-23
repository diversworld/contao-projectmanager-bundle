<?php

// contao/dca/tl_project_task_dependency.php
$GLOBALS['TL_DCA']['tl_project_task_dependency'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_project_task', // gehört zu einer Aufgabe
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id'          => 'primary',
				'pid'         => 'index',
				'predecessor' => 'index',
				'successor'   => 'index',
            ],
        ],
    ],
    'list' => [
        'sorting' => [
            'mode'         => 4,
            'fields'       => ['sorting'],
            'headerFields' => ['title'], // zeigt Aufgabenname im Header
            'panelLayout'  => 'filter;search,limit',
			'child_record_callback' => function ($row) {
				$db = \Contao\Database::getInstance();
				$pred = $db->prepare("SELECT title FROM tl_project_task WHERE id=?")->execute($row['predecessor']);
				$succ = $db->prepare("SELECT title FROM tl_project_task WHERE id=?")->execute($row['successor']);
				return '<div>Vorgänger: <strong>' . ($pred->title ?? '-') . '</strong></div>'
					. '<div>Nachfolger: <strong>' . ($succ->title ?? '-') . '</strong></div>';
			},
        ],
        'operations' => [
            'edit',
			'copy',
            'delete',
            'show',
			'cut',
			'toggle'
        ],
    ],
    'palettes' => [
        'default' => '{dependency_legend},predecessor,successor',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'pid' => [
            'foreignKey' => 'tl_project_task.title',
            'sql'        => "int(10) unsigned NOT NULL default 0",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'predecessor' => [
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_task.title',
            'eval'      => ['includeBlankOption'=>true, 'chosen'=>true, 'mandatory'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
        ],
        'successor' => [
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_task.title',
            'eval'      => ['includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
        ],
    ],
];
