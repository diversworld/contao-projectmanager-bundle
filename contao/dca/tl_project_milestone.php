<?php

declare(strict_types=1);

use Contao\Backend;
use Contao\DataContainer;
use Contao\DC_Table;
use \Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer\MilestoneCompletionChecker;
/**
 * Table tl_project_milestone
 */
$GLOBALS['TL_DCA']['tl_project_milestone'] = [
    'config' => [
        'dataContainer'    => DC_Table::class,
        'ptable'           => 'tl_project',
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index'
            ]
        ],
    ],
    'list' => [
        'sorting' => [
            'mode'        => DataContainer::MODE_SORTABLE,
            'fields'      => ['title'],
            'flag'        => DataContainer::SORT_INITIAL_LETTER_ASC,
            'panelLayout' => 'filter;sort,search,limit'
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
            'edit'   => ['href' => 'act=edit', 'icon' => 'edit.svg'],
            'copy'   => ['href' => 'act=copy', 'icon' => 'copy.svg'],
            'delete' => [
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show' => [
                'href'       => 'act=show',
                'icon'       => 'show.svg',
                'attributes' => 'style="margin-right:3px"'
            ],
        ]
    ],
    'palettes' => [
        '__selector__' => ['addNotes'],
        // ➜ tasks-Feld in eigener Legende eingeblendet
        'default'      => '{title_legend},title,alias;{date_legend},milestoneDate,status,responsible,priority;{tasks_legend},tasks;{details_legend},description,addNotes;{publish_legend},published,start,stop',
    ],
    'subpalettes' => [
        'addNotes' => 'notes',
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
            'label'     => &$GLOBALS['TL_LANG']['tl_project_milestone']['title'],
            'inputType' => 'text',
            'search'    => true,
            'sorting'   => true,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'alias' => [
            'search'        => true,
            'inputType'     => 'text',
            'eval'          => ['rgxp' => 'alias', 'doNotCopy' => true, 'unique' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'save_callback' => [['tl_project_milestone', 'generateAlias']],
            'sql'           => "varchar(255) BINARY NOT NULL default ''"
        ],
        'milestoneDate' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project_milestone']['milestoneDate'],
            'inputType' => 'text',
            'filter'    => true,
            'eval'      => ['rgxp' => 'date', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''",
        ],
        'status' => [
            'inputType' => 'select',
            'label' => &$GLOBALS['TL_LANG']['tl_project_milestone']['status'],
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'options' => &$GLOBALS['TL_LANG']['tl_project_milestone']['itemStatus'],
            'reference' => &$GLOBALS['TL_LANG']['tl_project_milestone']['itemStatus'],
            'save_callback' => [MilestoneCompletionChecker::class, 'checkCompletion'],
            'eval' => ['includeBlankOption' => true, 'submitOnChange' => false, 'chosen' => true, 'mandatory' => false, 'tl_class' => 'w25'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'priority' => [
            'inputType' => 'select',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'options'   => ['1', '2', '3'],
            'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'responsible' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_project_milestone']['member_id'],
            'inputType'         => 'select',
            'exclude'           => true,
            'search'            => true,
            'filter'            => false,
            'sorting'           => true,
            'foreignKey'        => 'tl_member.CONCAT(firstname, " ", lastname)',
            'eval'              => ['submitOnChange' => true, 'includeBlankOption' => true, 'tl_class' => 'w25 clr'],
            'sql'               => "int(10) unsigned NOT NULL default 0",
            'relation'          => ['type' => 'hasOne', 'load' => 'lazy']
        ],
        'tasks' => [
            'label'     => ['Aufgaben', 'Wählen Sie die zugehörigen Aufgaben.'],
            'inputType' => 'checkboxWizard',
            'eval'      => ['multiple' => true, 'tl_class' => 'clr'],
            'relation'  => [
                'type'            => 'hasMany',
                'load'            => 'lazy',
                'table'           => 'tl_project_task',
                'field'           => 'id',
                'referenceTable'  => 'tl_project_milestone_task',
                'referenceColumn' => 'milestone_id',
                'targetColumn'    => 'task_id',
            ],
            'load_callback' => [['tl_project_milestone', 'loadTasksFromPivot']],
            'save_callback' => [['tl_project_milestone', 'saveTasksToPivot']],
            'sql' => "blob NULL",
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
            'sql'       => "text NULL"
        ],
        'published' => [
            'toggle'    => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy' => true],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'start' => [
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''"
        ],
        'stop' => [
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(10) NOT NULL default ''"
        ]
    ]
];

class tl_project_milestone extends Backend
{
    /**
     * Alias-Generator
     */
    public function generateAlias(mixed $varValue, DataContainer $dc): mixed
    {
        $aliasExists = static function (string $alias) use ($dc): bool {
            $result = Database::getInstance()
                ->prepare("SELECT id FROM tl_project_milestone WHERE alias=? AND id!=?")
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
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $varValue));
        } elseif ($aliasExists($varValue)) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        return $varValue;
    }

    /**
     * Options: alle Tasks des gleichen Projekts (pid)
     */
    public function getTaskOptionsForProject(DataContainer $dc): array
    {
        // Milestone-PID (Projekt-ID) ermitteln – robust für Neu- und Bearbeitungsfall
        $pid = 0;

        if ($dc->activeRecord && (int) $dc->activeRecord->pid > 0) {
            $pid = (int) $dc->activeRecord->pid;
        } elseif ((int) Input::get('pid') > 0) {
            $pid = (int) Input::get('pid');
        }

        // Fallback: ohne PID keine Optionen
        if ($pid <= 0) {
            return [];
        }

        $options = [];
        $db = Database::getInstance()
            ->prepare('SELECT id, title FROM tl_project_task WHERE pid=? ORDER BY title')
            ->execute($pid);

        while ($db->next()) {
            $options[$db->id] = $db->title;
        }

        return $options;
    }

    /**
     * Aufgaben aus der Pivot-Tabelle laden.
     */
    public function loadTasksFromPivot($value, DataContainer $dc): array
    {
        if (!$dc->id) {
            return [];
        }

        $db = Database::getInstance()
            ->prepare('SELECT task_id FROM tl_project_milestone_task WHERE milestone_id=?')
            ->execute($dc->id);

        $tasks = [];
        while ($db->next()) {
            $tasks[] = $db->task_id;
        }

        return $tasks;
    }


    /**
     * Aufgaben in die Pivot-Tabelle speichern.
     */
    public function saveTasksToPivot($value, DataContainer $dc): string
    {
        $value = StringUtil::deserialize($value, true);

        if ($dc->id) {
            // Bestehende Einträge löschen
            Database::getInstance()
                ->prepare('DELETE FROM tl_project_milestone_task WHERE milestone_id=?')
                ->execute($dc->id);

            // Neue Einträge hinzufügen
            foreach ($value as $taskId) {
                Database::getInstance()
                    ->prepare('INSERT INTO tl_project_milestone_task (milestone_id, task_id) VALUES (?, ?)')
                    ->execute($dc->id, $taskId);
            }
        }

        return serialize($value);
    }
}
