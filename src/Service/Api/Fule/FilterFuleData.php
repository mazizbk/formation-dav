<?php

namespace App\Service\Api\Fule;

use App\Contracts\Fule\FilterFuleInterface;
use Symfony\Component\HttpFoundation\Request;

class FilterFuleData implements FilterFuleInterface
{
    private array $output = [];

    /**
     * @param array $data
     * @param Request $request
     * @return array
     */
    public function filter(array $data, Request $request): array
    {
        $this->setOutput($data);
        if (isset(array_keys($request->request->all())[0])) {
            $formName = array_keys($request->request->all())[0];
            $formData = $request->request->all()[$formName];
            unset($formData['_token']);
            foreach ($formData as $key => $value) {
                $this->output =  $this->processFilterOutput($key, $value);
            }
        }
        return $this->getOutput();
    }


    /**
     * @param $key
     * @param $value
     * @return array
     */
    public function processFilterOutput($key, $value): array
    {

        $this->output = array_filter($this->output, function ($row) use ($key, $value) {
            return $value === '' || $row[$key] === $value;
        });
        return $this->output;
    }

    /**
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    /**
     * @param array $output
     * @return self
     */
    public function setOutput(array $output): self
    {
        $this->output = $output;
        return $this;
    }
}
