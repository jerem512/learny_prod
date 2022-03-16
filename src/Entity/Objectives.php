<?php

namespace App\Entity;

use App\Repository\ObjectivesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjectivesRepository::class)
 */
class Objectives
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $goal_week;

    /**
     * @ORM\Column(type="integer")
     */
    private $goal_month;

    /**
     * @ORM\Column(type="integer")
     */
    private $goal_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoalWeek(): ?int
    {
        return $this->goal_week;
    }

    public function setGoalWeek(int $goal_week): self
    {
        $this->goal_week = $goal_week;

        return $this;
    }

    public function getGoalMonth(): ?int
    {
        return $this->goal_month;
    }

    public function setGoalMonth(int $goal_month): self
    {
        $this->goal_month = $goal_month;

        return $this;
    }

    public function getGoalYear(): ?int
    {
        return $this->goal_year;
    }

    public function setGoalYear(int $goal_year): self
    {
        $this->goal_year = $goal_year;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
