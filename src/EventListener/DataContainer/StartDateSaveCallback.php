<?php

namespace Diversworld\ContaoProjectmanagerBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_project_task', target: 'fields.endDate.save')]
class StartDateSaveCallback
{
    public function __invoke($value, DataContainer $dc)
    {
        $isMilestone = (string) ($dc->activeRecord->milestone ?? '') === '1';

        // Show an error if tl_content.text contains "foobar"
        if ($isMilestone) {
            $start = (string) ($dc->activeRecord->startDate ?? '');
            if ($start !== '') {
                return $start;
            }
        }
        // Return the processed value
        return $value;
    }
}
