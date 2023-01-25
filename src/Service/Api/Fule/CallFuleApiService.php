<?php

namespace App\Service\Api\Fule;

use App\Contracts\Fule\FormatFuleInterface;
use Exception;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallFuleApiService
{
    private HttpClientInterface $client;
    private FormatFuleInterface $formatFule;

    protected $urlApi = 'https://data.economie.gouv.fr/api/records/1.0/search/?dataset=prix-carburants-fichier-instantane-test-ods-copie&q=&rows=100&facet=id&facet=adresse&facet=ville&facet=prix_maj&facet=prix_nom&facet=com_arm_name&facet=epci_name&facet=dep_name&facet=reg_name&facet=services_service&facet=horaires_automate_24_24&refine.prix_maj=2023&refine.ville=LYON';
    public function __construct(HttpClientInterface $client, FormatFuleInterface $formatFule)
    {
        $this->client = $client;
        $this->formatFule = $formatFule;
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPriceFule(): array
    {
        try {

            $response = $this->client->request(
                'GET',

                $this->getUrlApi(),
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'http_version' => '1.1'
                ]
            );
            return $this->formatFule->format($response->toArray());
        } catch (Exception | TransportExceptionInterface $exception) {
            throw new TransportException("something wrong with Api Url! " . $exception->getMessage());
        }
    }

    public function setUrlApi(string $urlApi = "")
    {
        $this->urlApi = ($urlApi != '') ?? $this->urlApi;

        return  $this;
    }

    public function getUrlApi()
    {

        return $this->urlApi;
    }
}
