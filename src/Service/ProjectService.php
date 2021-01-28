<?php


namespace App\Service;


use App\Entity\Project;

class ProjectService extends ApiService
{
    public function editProject(Project $project){
        return $this->patch(Project::NAME, $project);}
    public function getProjects(): array
    {

        return $this->getAll(Project::NAME);
    }
    public function deleteProject(int $id){
        return $this->delete(Project::NAME, $id);
    }
    public function newProject(Project $project){
        $this->post(Project::NAME, $project);
    }
    public function getProject(int $id){
        return $this->get(Project::NAME, $id);
    }
}