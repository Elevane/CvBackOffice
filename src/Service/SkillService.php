<?php


namespace App\Service;


use App\Entity\Skill;

class SkillService extends ApiService
{
    public function editSkill(Skill $skill){
        return $this->patch(Skill::NAME, $skill);
    }
    public function deleteSkill(int $id){
        return $this->delete(Skill::NAME, $id);
    }
    public function newSkill(Skill $skill){
        $this->post(Skill::NAME, $skill);
    }
    public function getSkill(int $id){
        return $this->get(Skill::NAME, $id);
    }
    public function getSkills():array
    {
        return $this->getAll(Skill::NAME);
    }
}