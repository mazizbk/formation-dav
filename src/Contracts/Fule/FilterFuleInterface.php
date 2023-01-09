<?php

namespace App\Contracts\Fule;

use Symfony\Component\HttpFoundation\Request;

interface FilterFuleInterface
{

    /**
     * @param array $data
     * @param Request $request
     * @return array
     */
    public function filter(array $data, Request $request): array;
}
