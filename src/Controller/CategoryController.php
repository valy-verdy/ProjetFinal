<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



 #[Route("/category")]
 
class CategoryController extends AbstractController
{

    
     #[Route("/", name:"app_category_index")]
    
    public function index(CategoryRepository $categoryRepository): Response
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            return $this->render('category/index.html.twig', [
                'categories' => $categoryRepository->findAll(),
            ]);
        } catch (AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas les droits necessaires pour accèder à cette fonction");
            return $this->redirectToRoute('home');
        }
    }




    
    #[Route("/new", name:"app_category_new")]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        try {

            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $category = new Category();
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $categoryRepository->add($category);
                return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('category/new.html.twig', [
                'category' => $category,
                'form' => $form,
            ]);
        } catch (AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas les droits necessaires pour accèder à cette fonction");
            return $this->redirectToRoute('home');
        }
    }


    
    #[Route("/{id}", name:"app_category_show")]
    
    public function show(Category $category): Response
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            return $this->render('category/show.html.twig', [
                'category' => $category,
            ]);
        } catch (AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas les droits necessaires pour accèder à cette fonction");
            return $this->redirectToRoute('home');
        }
    }


    
    #[Route("/{id}/edit", name:"app_category_edit")]
     
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $categoryRepository->add($category);
                return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('category/edit.html.twig', [
                'category' => $category,
                'form' => $form,
            ]);
        } catch (AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas les droits necessaires pour accèder à cette fonction");
            return $this->redirectToRoute('home');
        }
    }


    
    #[Route("/{id}", name:"app_category_delete")]
     
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
                $categoryRepository->remove($category);
            }

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        } catch (AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas les droits necessaires pour accèder à cette fonction");
            return $this->redirectToRoute('home');
        }
    }
}
