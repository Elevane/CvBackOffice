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
     * @Route("/admin/blog/new", name="admin_blog_new")
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
            $this->service->newBlog($blog);
            $file->move($path, $filename );

            return $this->redirectToRoute('admin_index');
        }
        return $this->render('/backoffice/blog/new_or_edit.html.twig',[
            "form" => $form->createView(),
            "title" => "Creation d'un article de blog",
        ]);
    }

    /**
     * @Route("/admin/blog/edit/{id}", name="admin_blog_edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, int $id){

        $blog = new Blog();
        $api_blog = $this->service->getBlog($id);
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
                $this->service->editBlog($blog) ;
                return $this->redirectToRoute('admin_index');
            }
            return $this->render('backoffice/blog/edit.html.twig', [
                'editform' => $form->createView(),
                'blog' => $api_blog,
                'title' => 'Modification du Blog : '.$blog ->getTitle(),
            ]);
        }


        return $this->redirectToRoute('admin_index');
    }




    /**
     * @Route("/admin/blog/delete/{id}", name="admin_blog_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
    {
        $blog = $this->service->getProject($id);
        if($blog) {
            $this->service->deleteProject($id);
            return $this->redirectToRoute('admin_index');
        }
        return $this->redirectToRoute('admin_index');
    }
}