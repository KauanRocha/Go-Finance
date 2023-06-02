<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TransactionRepository;


class ApiController extends AbstractController
{
    #[Route('/api/transaction', name: 'api_transaction')]
    public function transaction(TransactionRepository $movimentacaoRepository): Response
    {
        $listaTransactions = $movimentacaoRepository->findAll();
        return $this->json($listaTransactions, 200, [], ['groups' => ['api_list']]);
    }
}
