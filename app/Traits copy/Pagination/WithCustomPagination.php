<?php

namespace App\TraitsCopy\Pagination;

use App\Traits\Helper\isClassUseTrait;
use App\Traits\Search\WithSearchAbleQuery;
use App\Traits\Selector\WithSelector;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait WithCustomPagination
{
    use isClassUseTrait;

    public int $page = 1;
    public int $perPage = 100;
    public int $total;

    public function setPageNumber(int $page) : void
    {
        $this->page = $page;
        $this->clearAfterPaginateAction();
    }

    public function resetPage() : void
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
        $this->clearAfterPaginateAction();
    }

    public function previousPage(): void
    {
        $this->page--;
        $this->clearAfterPaginateAction();
    }

    protected function getPage(): int {
        return $this->page;
    }

    protected function getPerPage(): int {
        return $this->perPage;
    }

    protected function paginate(QueryBuilder|EloquentBuilder $query): LengthAwarePaginator
    {
        $this->clearBeforePaginate();
        return $query->paginate($this->getPerPage(), page: $this->getPage());
    }

    private function clearAfterPaginateAction() {
        //IF the class uses WithSelector Trait then we will need reset selectors in table
        if($this->isClassUseTrait(WithSelector::class)) {
            $this->resetSelector();
        }
    }

    protected function clearBeforePaginate() {
        if($this->isClassUseTrait(WithSelector::class) && $this->isClassUseTrait(WithSearchAbleQuery::class)) {
            $this->clearSelectorAfterSearch();
        }
    }

    protected function clearPaginationWhenSearch() {
        $this->resetPage();
    }

}
