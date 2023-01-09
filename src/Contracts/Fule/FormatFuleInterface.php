<?php

namespace App\Contracts\Fule;


interface FormatFuleInterface
{

    /**
     * @param array $data
     * @return array
     */
    public function format(array $data): array;
}
