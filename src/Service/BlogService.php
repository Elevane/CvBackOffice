<?php


namespace App\Service;


use App\Entity\Blog;

class BlogService extends  ApiService
{
    public function getBlogs():array
    {
        return $this->getAll(Blog::NAME);
    }
    public function deleteBlog(int $id){
        return $this->delete(Blog::NAME, $id);
    }
    public function newBlog(Blog $blog){
        $this->post(Blog::NAME, $blog);
    }
    public function editBlog(Blog $blog){
        return $this->patch(Blog::NAME, $blog);
    }
    public function getBlog(int $id){
        return $this->get(Blog::NAME, $id);
    }
}