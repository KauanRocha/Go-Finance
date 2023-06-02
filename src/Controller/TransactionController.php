<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;




#[Route('/movimentacao')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_movimentacao_index', methods: ['GET'])]
    public function index(Request $request,TransactionRepository $movimentacaoRepository, Security  $security): Response
    {
        $descricao = $request->query->get('descricao');
        $user_id =$security->getUser()->getId();

        if (is_null($descricao)){

            return $this->render('movimentacao/index.html.twig', [
                'transactions' => $movimentacaoRepository->findByUserId($user_id),
                'descricao' => $descricao,
            ]);
        }

        
        return $this->render('movimentacao/index.html.twig', [
            'transactions' => $movimentacaoRepository->findByDescripitionAndId($descricao ,$user_id),
            'descricao' => $descricao,
        ]);
    }

    #[Route('/new', name: 'app_movimentacao_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionRepository $movimentacaoRepository,Security  $security): Response
    {
       
        $movimentacao = new Transaction();
        $form = $this->createForm(TransactionType::class, $movimentacao);

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                      
            $user_id = $security->getUser();
                  
            $movimentacao->setUserId($user_id);
                       
            $movimentacaoRepository->save($movimentacao, true);

            return $this->redirectToRoute('app_movimentacao_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movimentacao/new.html.twig', [
            'movimentacao' => $movimentacao,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_movimentacao_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $movimentacao, TransactionRepository $movimentacaoRepository): Response
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
    public function delete(Request $request, Transaction $movimentacao, TransactionRepository $movimentacaoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movimentacao->getId(), $request->request->get('_token'))) {
            $movimentacaoRepository->remove($movimentacao, true);
        }

        return $this->redirectToRoute('app_movimentacao_index', [], Response::HTTP_SEE_OTHER);
    }
}
