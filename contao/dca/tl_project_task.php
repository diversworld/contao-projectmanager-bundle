<?php

declare(strict_types=1);

use Contao\Backend;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Input;
use Contao\System;
use Contao\Database;
use Contao\Date;
use Contao\Config;
use Contao\StringUtil;

/**
 * Table tl_project_task
 */
$GLOBALS['TL_DCA']['tl_project_task'] = [
    'config' => [
        'dataContainer'    => DC_Table::class,
        'ptable'           => 'tl_project',
		'ctable'           => ['tl_project_task_dependency'],
        'enableVersioning' => true,
		'onsubmit_callback' => [
			['tl_project_task', 'saveDependencies']
		],
        'sql'              => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
    ],
    'list' => [
        'sorting' => [
            'mode'        => DataContainer::MODE_PARENT,
            'fields'      => ['startDate'],
            'flag'        => DataContainer::SORT_DAY_ASC,
            'panelLayout' => 'filter;sort,search,limit',
            'headerFields'=> ['title', 'startDate', 'endDate'], // ← Felder aus Elterntabelle
            'child_record_callback' => [tl_project_task::class, 'listTask'],
        ],
        'label' => [
            'fields' => ['title'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'edit',
			'children',
            'copy',
            'delete',
			'cut',
            'show',
			'toggle'
        ]
    ],
    'palettes' => [
        '__selector__' => ['addNotes'],
        'default'      => '{title_legend},title,alias,priority,progress,status,assigned_to;{task_legend},predecessor,successor,milestone;{date_legend},startDate,endDate;{details_legend},description,addNotes;{publish_legend},published,start,stop',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'pid' => [
            'foreignKey' => 'tl_project.title',
            'relation'   => ['type' => 'belongsTo', 'load' => 'lazy'],
            'sql'        => "int(10) unsigned NOT NULL default 0",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'title' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['title'],
            'inputType' => 'text',
            'search'    => true,
            'sorting'   => true,
            'eval'      => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'alias' => [
            'search'        => true,
            'inputType'     => 'text',
            'eval'          => ['rgxp'=>'alias', 'doNotCopy'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'],
            'save_callback' => [
                ['tl_project_task', 'generateAlias']
            ],
            'sql'           => "varchar(255) BINARY NOT NULL default ''"
        ],
        'startDate' => [
			'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['startDate'],
			'inputType' => 'text',
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
			'eval'      => ['rgxp'=>'datim','datepicker'=>true, 'tl_class'=>'w50'],
			'sql'       => "varchar(10) NOT NULL default ''"
		],
		'endDate' => [
			'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['endDate'],
			'inputType' => 'text',
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
			'eval'      => ['rgxp'=>'datim','datepicker'=>true, 'tl_class'=>'w50'],
			'sql'       => "varchar(10) NOT NULL default ''"
		],
        'progress' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['progress'],
            'inputType' => 'text',
            'filter'    => true,
            'eval'      => ['rgxp'=>'digit','maxlength'=>3,'minval'=>0,'maxval'=>100,'tl_class'=>'w50'],
            'sql'       => "smallint(3) unsigned NOT NULL default 0",
        ],
		'predecessor' => [
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_task.title',
            'eval'      => ['includeBlankOption'=>true, 'multiple' => true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql' => "text default NULL"
        ],
		'successor' => [
            'inputType' => 'select',
            'foreignKey'=> 'tl_project_task.title',
            'eval'      => ['includeBlankOption'=>true, 'multiple' => true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql' => "text default NULL"
        ],
        'milestone' => [
            'inputType' => 'checkbox',
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'priority' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['priority'],
            'inputType' => 'select',
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'options'   => ['low','medium','high'],
            'reference' => &$GLOBALS['TL_LANG']['tl_project_task'],
            'eval'      => ['includeBlankOption'=>false, 'tl_class'=>'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'description' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project_task']['description'],
            'inputType' => 'textarea',
            'eval'      => ['rte'=>'tinyMCE', 'tl_class'=>'clr'],
            'sql'       => "text NULL",
        ],
        'status' => [
            'inputType' => 'select',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'reference' => &$GLOBALS['TL_LANG']['tl_project_task'],
            'options'   => ['ToDo', 'in Bearbeitung', 'Erledigt'],
            'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'assigned_to' => [
            'inputType' => 'select',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'foreignKey'=> "tl_member.CONCAT(firstname, ' ', lastname)",
            'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
            'relation'  => ['type' => 'hasOne', 'load' => 'lazy']
        ],
        'addNotes' => [
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'notes' => [
            'inputType' => 'textarea',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'eval'      => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
            'sql'       => 'text NULL'
        ],
        'published' => [
            'toggle'    => true,
            'filter'    => true,
            'flag'      => DataContainer::SORT_INITIAL_LETTER_DESC,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy'=>true],
            'sql'       => ['type' => 'boolean', 'default' => false]
        ],
        'start' => [
            'inputType' => 'text',
            'eval'      => ['rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''"
        ],
        'stop' => [
            'inputType' => 'text',
            'eval'      => ['rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''"
        ]
    ]
];

/**
 * Callbacks
 */
class tl_project_task extends Backend
{
    public function generateAlias(mixed $varValue, DataContainer $dc): mixed
    {
        $aliasExists = static function (string $alias) use ($dc): bool {
            $result = Database::getInstance()
                ->prepare("SELECT id FROM tl_project_task WHERE alias=? AND id!=?")
                ->execute($alias, $dc->id);
            return $result->numRows > 0;
        };

        if (!$varValue) {
            $varValue = System::getContainer()->get('contao.slug')->generate(
                $dc->activeRecord->title,
                [],
                $aliasExists
            );
        } elseif (preg_match('/^[1-9]\d*$/', $varValue)) {
            throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $varValue));
        } elseif ($aliasExists($varValue)) {
            throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        return $varValue;
    }

    public function listTask(array $row): string
    {
        $prio = ucfirst($row['priority'] ?? '');
        $prog = (string) ($row['progress'] ?? '0') . '%';

        $dates = [];
        if (!empty($row['startDate'])) {
            $dates[] = Date::parse(Config::get('dateFormat'), $row['startDate']);
        }
        if (!empty($row['endDate'])) {
            $dates[] = Date::parse(Config::get('dateFormat'), $row['endDate']);
        }
        $dateStr = empty($dates) ? '' : ' <span style="color:#888">(' . implode(' – ', $dates) . ')</span>';

        return '<div class="tl_content_left"><strong>'.StringUtil::specialchars($row['title']).'</strong>'.$dateStr.' — '
            . '<span>Prio: '.$prio.'</span>, <span>Fortschritt: '.$prog.'</span></div>';
    }
	
	public function saveDependencies(DataContainer $dc)
    {
        $taskId = $dc->id;
        $predecessors = StringUtil::deserialize($dc->activeRecord->predecessor, true);
    	$successors   = StringUtil::deserialize($dc->activeRecord->successor, true);

        $objDb = Database::getInstance();

        // Alte Abhängigkeiten löschen
        $objDb->prepare("DELETE FROM tl_project_task_dependency WHERE pid=?")
              ->execute($taskId);

        // Neue Abhängigkeiten speichern
        foreach ($predecessors as $predId) {
            $objDb->prepare("INSERT INTO tl_project_task_dependency (pid, predecessor) VALUES (?, ?)")
                  ->execute($taskId, $predId);
        }

        foreach ($successors as $succId) {
            $objDb->prepare("INSERT INTO tl_project_task_dependency (pid, successor) VALUES (?, ?)")
                  ->execute($taskId, $succId);
        }
    }
}
