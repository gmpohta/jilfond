<?php

declare(strict_types=1);

namespace App\Dtos;

final class ListDto
{
    public array $items;

    /** @var array<string, int> */
    public array $pagination;

    public function __construct(
        array $items,
        /** @var array<string, int> */
        array $pagination
    ) {
        $this->items = $items;
        $this->pagination = $pagination;
    }
}
