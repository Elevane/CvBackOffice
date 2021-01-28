<?php


namespace App\Controller;


use App\Entity\Blog;

use App\Form\BlogType;

use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends BaseBackOfficeController{
    /**
     * @param Request $request
     * @return Response
     * @Route("/backoffice/blog/new", name="backoffice_blog_new")
     */
    public function newAction(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $filename = $file->getClientOriginalName();
            $path = "image/blog/";
            $pathFileName = $path . $filename;

            $blog->setImage($pathFileName);
            $this->blogService->newBlog($blog);
            $file->move($path, $filename );

            return $this->redirectToRoute('backoffice_index');
        }
        return $this->render('/backoffice/blog/new_or_edit.html.twig',[
            "form" => $form->createView(),
            "title" => "Creation d'un blog",
        ]);
    }

    /**
     * @Route("/backoffice/blog/edit/{id}", name="backoffice_blog_edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function editAction(Request $request, int $id){

        $blog = new Blog();
        $api_blog = $this->blogService->getBlog($id);
        if($api_blog){
            $blog ->setId($api_blog['id']);
            $blog ->setImage(new File($api_blog['image']));
            $blog ->setDate(new DateTime($api_blog['date']));
            $blog ->setText($api_blog['text']);
            $blog->setTitle($api_blog['title']);
            $form =$this->createForm(BlogType::class, $blog );
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $file = $form['image']->getData();
                if($file != null){
                    $filename = $file->getClientOriginalName();
                    $path = "image/blog/";
                    $pathFileName = $path . $filename;
                    $blog->setImage($pathFileName);
                    $file->move($path, $filename );
                }
                else{
                    $blog->setImage($api_blog['image']);
                }
                $this->blogService->editBlog($blog);
                return $this->redirectToRoute('backoffice_index');
            }
            return $this->render('backoffice/blog/new_or_edit.html.twig', [
                'form' => $form->createView(),
                'blog' => $api_blog,
                'title' => 'Modification du Blog : '.$blog ->getTitle(),
            ]);
        }


        return $this->redirectToRoute('backoffice_index');
    }




    /**
     * @Route("/backoffice/blog/delete/{id}", name="backoffice_blog_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
    {
        $blog = $this->blogService->getBlog($id);
        if($blog) {
            $this->blogService->deleteBlog($id);
            return $this->redirectToRoute('backoffice_index');
        }
        return $this->redirectToRoute('backoffice_index');
    }
}