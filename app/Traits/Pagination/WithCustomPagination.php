<?php

namespace App\Traits\Pagination;

trait WithCustomPagination
{
    public int $page = 1;

    public int $perPage = 100;

    public int $total;

    public function setPageNumber(int $page): void
    {
        $this->page = $page;
    }

    public function resetPage(): void
    {
        $this->page = 1;
    }

    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
        $this->page = 1;
    }

    public function nextPage(): void
    {
        $this->page++;
    }

    public function previousPage(): void
    {
        $this->page--;
    }

    protected function getPage(): int
    {
        return $this->page;
    }

    protected function getPerPage(): int
    {
        return $this->perPage;
    }
}
