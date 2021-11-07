<?php

namespace App\Service;

use App\Entity\Category;
use App\Interfaces\CategoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService implements CategoryServiceInterface
{

    private EntityManagerInterface $em;

    /**
     * FanficService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createCategory(Category $category): void
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    /**
     * @param Category $category
     */
    public function editCategory(Category $category): void
    {
        $this->em->flush();
    }

    /**
     * @param Category $category
     */
    public function deleteCategory(Category $category): void
    {
        $this->em->remove($category);
        $this->em->flush();
    }
}