<?php


namespace App\Interfaces;


use App\Entity\Tag;

interface TagServiceInterface
{
    /**
     * @param Tag $tag
     */
    public function createTag(Tag $tag): void;

    /**
     * @param Tag $tag
     */
    public function editTag(Tag $tag): void;

    /**
     * @param Tag $tag
     */
    public function deleteTag(Tag $tag): void;
}