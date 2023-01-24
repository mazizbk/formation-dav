<?php

namespace App\Controller;

use App\Form\PriceSearchType;
use App\Service\Api\Fule\FilterFuleData;
use App\Service\Api\Fule\CallFuleApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

class FuelController extends AbstractController
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
    #[Route('/', name: 'home')]
    public function index(Request $request, CallFuleApiService $callFuleApiService, FilterFuleData $filter): Response
    {


        //dd($user);


        $this->addFlash('notice', 'Nombre d\'utilisateur ' . 0);




        //$localeSwitcher->setLocale('fr');

        //$message = $trans->trans('Your comment is pending approval');

        // dd($message);

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
