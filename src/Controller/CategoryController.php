<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/categoria')]

class CategoryController extends AbstractController
{
    
    #[Route('/', name: 'app_categoria_index', methods: ['GET'])]
    public function index(CategoryRepository $categoriaRepository): Response
    {
        //$this->denyAccessUnlessGranted("ROLE_USER");

        // restrigir apenas para os ROLE_USER
        return $this->render('category/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoriaRepository): Response
    {
        //$this->denyAccessUnlessGranted("ROLE_USER");
        $categorium = new Category();
        $form = $this->createForm(CategoryType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriaRepository->save($categorium, true);

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoria_show', methods: ['GET'])]

    public function show(Category $categorium): Response
    {
        //$this->denyAccessUnlessGranted("ROLE_USER");
        return $this->render('category/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $categorium, CategoryRepository $categoriaRepository): Response
    {
        //$this->denyAccessUnlessGranted("ROLE_USER");
        $form = $this->createForm(CategoryType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriaRepository->save($categorium, true);

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Category $categorium, CategoryRepository $categoriaRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

            try{

            $query = $em->createQuery('SELECT COUNT(t) FROM App\Entity\Transaction t WHERE t.category = :category_id');
            $query->setParameter('category_id', $categorium->getId());
            $transactionCount = $query->getSingleScalarResult();

            if ($transactionCount > 0) {
                // Trate o erro de categoria com transações vinculadas
                // Aqui você pode lançar uma exceção, exibir uma mensagem de erro, ou realizar outra ação adequada.
                throw new \Exception('Não é possível excluir a categoria porque existem transações vinculadas a ela.');
            }


            if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->request->get('_token'))) {
                $categoriaRepository->remove($categorium, true);

            }

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);

            }catch(\Exception $e){
            $errorMessage = $e->getMessage();

            return $this->render('category/index.html.twig', [
                'errorMessage' => $errorMessage,
                'categorias' => $categoriaRepository->findAll(),
            ]);
            }
    }
}
