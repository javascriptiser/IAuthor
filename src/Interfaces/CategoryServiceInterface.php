<?php


namespace App\Interfaces;


use App\Entity\Category;

interface CategoryServiceInterface
{
    /**
     * @param Category $category
     */
    public function createCategory(Category $category): void;

    /**
     * @param Category $category
     */
    public function editCategory(Category $category): void;

    /**
     * @param Category $category
     */
    public function deleteCategory(Category $category): void;
}