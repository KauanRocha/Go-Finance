<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Form\TransactionType;
use App\Repository\TransactionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movimentacao')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_movimentacao_index', methods: ['GET'])]
    public function index(TransactionsRepository $movimentacaoRepository): Response
    {
        return $this->render('movimentacao/index.html.twig', [
            'transactions' => $movimentacaoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movimentacao_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionsRepository $movimentacaoRepository): Response
    {
        $movimentacao = new Transactions();
        $form = $this->createForm(TransactionType::class, $movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movimentacaoRepository->save($movimentacao, true);

            return $this->redirectToRoute('app_movimentacao_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movimentacao/new.html.twig', [
            'movimentacao' => $movimentacao,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movimentacao_show', methods: ['GET'])]
    public function show(Transactions $movimentacao): Response
    {
        return $this->render('movimentacao/show.html.twig', [
            'movimentacao' => $movimentacao,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movimentacao_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transactions $movimentacao, TransactionsRepository $movimentacaoRepository): Response
    {
        $form = $this->createForm(TransactionType::class, $movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movimentacaoRepository->save($movimentacao, true);

            return $this->redirectToRoute('app_movimentacao_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movimentacao/edit.html.twig', [
            'movimentacao' => $movimentacao,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movimentacao_delete', methods: ['POST'])]
    public function delete(Request $request, Transactions $movimentacao, TransactionsRepository $movimentacaoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movimentacao->getId(), $request->request->get('_token'))) {
            $movimentacaoRepository->remove($movimentacao, true);
        }

        return $this->redirectToRoute('app_movimentacao_index', [], Response::HTTP_SEE_OTHER);
    }
}
