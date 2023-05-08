<?php

namespace App\Foundation\Actions;

use Spatie\QueryBuilder\QueryBuilder;

abstract class FetchRecords
{
    protected QueryBuilder $queryBuilder;

    protected array $defaultSort = ['-id'];

    protected array $with = [];

    protected array $allowedFields = [];

    protected array $defaultSelect = ['*'];

    public function __construct()
    {
        $this->queryBuilder = $this->defaultQuery();
    }

    public function handle()
    {
        return $this->queryBuilder->jsonPaginate();
    }

    public function extendQuery(callable $callback): static
    {
        $callback($this->queryBuilder);

        return $this;
    }

    abstract public static function filterList(): array;

    private function defaultQuery(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->select($this->defaultSelect)
            ->with($this->with)
            ->allowedFields($this->allowedFields)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->getAllowedIncludes())
            ->allowedSorts($this->getAllowedSorts())
            ->defaultSort(...$this->defaultSort);
    }

    abstract protected function model(): string;

    abstract protected function getAllowedFilters(): array;

    protected function getAllowedIncludes(): array
    {
        return [];
    }

    protected function getAllowedSorts(): array
    {
        return [];
    }
}
