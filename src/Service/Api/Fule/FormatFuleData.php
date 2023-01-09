<?php

namespace App\Service\Api\Fule;

use App\Contracts\Fule\FormatFuleInterface;

class FormatFuleData implements FormatFuleInterface
{

    /**
     * @param array $data
     * @return array
     */
    public function format(array $data): array
    {
        $output = [];

        if (isset($data['records'])) {
            $records = $data['records'];

            $output = array_column($records, 'fields');

            usort($output, function ($item1, $item2) {
                return $item2['adresse'] <=> $item1['adresse'];
            });
        }
        return $output;
    }
}
