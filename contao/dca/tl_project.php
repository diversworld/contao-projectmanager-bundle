<?php

declare(strict_types=1);

/*
 * This file is part of Project Manager.
 *
 * (c) Diversworld Eckhard Becker 2025 <info@diversworld.eu>
 * @license GPL-3.0-or-later
 * @link https://github.com/diversworld/contao-projectmanager-bundle
 */

use Contao\Backend;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Input;
use Contao\Database;
use Contao\System;

/**
 * Table tl_project
 */
$GLOBALS['TL_DCA']['tl_project'] = [
    'config' => [
        'dataContainer'    => DC_Table::class,
        'ctable'           => ['tl_project_task'],
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary'
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
        'default'      => '{title_legend},title,alias;{date_legend},startDate,endDate;{details_legend},description,addNotes;{publish_legend},published,start,stop',
    ],

    'subpalettes' => [
        'addNotes' => 'notes'
    ],

    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],
        'title' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project']['title'],
            'inputType' => 'text',
            'search'    => true,
            'sorting'   => true,
            'eval'      => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'alias' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project']['alias'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['rgxp'=>'alias', 'doNotCopy'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'],
            'save_callback' => [
                [tl_project::class, 'generateAlias']
            ],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],
        'startDate' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project']['startDate'],
			'inputType' => 'text',
			'filter'    => true,
			'eval'      => ['rgxp'=>'datim','datepicker'=>true, 'tl_class'=>'w50'],
			'sql'       => "int(10) unsigned NOT NULL default 0",
        ],
        'endDate' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project']['endDate'],
            'inputType' => 'text',
			'filter'    => true,
            'eval'      => ['rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50'],
            'sql'       => "int(10) unsigned NOT NULL default 0",
        ],
        'description' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_project']['description'],
            'inputType' => 'textarea',
            'eval'      => ['rte'=>'tinyMCE', 'tl_class'=>'clr'],
            'sql'       => "text NULL",
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
            'flag'      => DataContainer::SORT_INITIAL_LETTER_DESC,
            'inputType' => 'checkbox',
            'eval'      => ['doNotCopy'=>true],
            'sql'       => "char(1) NOT NULL default ''"
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
    ],
];

class tl_project extends Backend
{
    /**
     * Auto-generate the project alias if it has not been set yet
     */
    public function generateAlias(mixed $varValue, DataContainer $dc): mixed
    {
        $aliasExists = static function (string $alias) use ($dc): bool {
            $result = Database::getInstance()
                ->prepare("SELECT id FROM tl_project WHERE alias=? AND id!=?")
                ->execute($alias, $dc->id);
            return $result->numRows > 0;
        };

        // Generate the alias if there is none
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
}
