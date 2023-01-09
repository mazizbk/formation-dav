<?php

namespace App\Controller;

use App\Form\PriceSearchType;
use App\Service\Api\Fule\CallFuleApiService;
use App\Service\Api\Fule\FilterFuleData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;


class FirstController extends AbstractController
{
    /**
     * @param CallFuleApiService $callFuleApiService
     * @param Request $request
     * @param FilterFuleData $filter
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[Route('/first', name: 'home')]
    public function index(CallFuleApiService $callFuleApiService, Request $request, FilterFuleData $filter): Response
    {

        $fulePricesAll = $callFuleApiService->getPriceFule();

        $form = $this->createForm(PriceSearchType::class, $fulePricesAll);
        $form->handleRequest($request);
        $formView = $form->createView();
        $fulePricesFilter = $fulePricesAll;
        if ($form->isSubmitted()) {
            $fulePricesFilter = $filter->filter($fulePricesAll, $request);
        }
        return $this->render('first/index.html.twig', [
            'dataPriceFules' => $fulePricesFilter,
            'formView' => $formView

        ]);
    }
}
