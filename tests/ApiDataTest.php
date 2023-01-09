<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\Api\Fule\CallFuleApiService;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ApiDataTest extends KernelTestCase
{

    protected $container;
    /**
     * @before
     * @return void
     */
    public function init()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $this->container = static::getContainer();
    }
    /**
     * Summary of if_data_returned_by_api_is_not_empty
     * @test
     */
    public function if_data_returned_by_api_is_not_empty(): void
    {
        $this->init();
        $prices =  $this->container->get(CallFuleApiService::class);
        $prices->setUrlApi('https://data.economie.gouv.fr/api/records/1.0/search/?dataset=prix-carburants-fichier-instantane-test-ods-copie&q=&rows=100&facet=id&facet=adresse&facet=ville&facet=prix_maj&facet=prix_nom&facet=com_arm_name&facet=epci_name&facet=dep_name&facet=reg_name&facet=services_service&facet=horaires_automate_24_24&refine.prix_maj=2023&refine.ville=LYON&refine.dep_name=Rh%C3%B4ne');
        $this->expectException(TransportExceptionInterface::class);

        $price = $prices->getPriceFule();
        $this->assertNotEmpty($price);
    }
}
