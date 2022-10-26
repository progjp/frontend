<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

final class BookDTO
{
    #[Assert\NotNull]
    private string $title;
    #[Assert\NotNull]
    private string $author;
    #[Assert\NotNull]
    #[Assert\Range(
        notInRangeMessage: 'You must be between {{ min }}cm and {{ max }}cm tall to enter',
        min: 0,
        max: 100,
    )]
    private int $pages;
    #[Assert\NotNull]
    #[Assert\Date]
    private string $releaseDate;

    public function __construct(
        string $title,
        string $author,
        int $pages,
        string $releaseDate
    )
    {
        $this->title = $title;
        $this->author = $author;
        $this->pages = $pages;
        $this->releaseDate = $releaseDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

}