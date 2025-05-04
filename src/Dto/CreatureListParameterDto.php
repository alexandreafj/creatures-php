<?php

namespace App\Dto;

use InvalidArgumentException;

class CreatureListParameterDto
{
  public readonly int $page;
  public readonly int $limit;
  public readonly string $type; 
  public readonly string $minDangerLevel;
  public readonly string $search;
  public readonly string $sortBy; 
  public readonly string $sortOrder; 
  
  public readonly int $offset;

  private const ALLOWED_SORT_BY = [
    'name',
    'type',
    'habitat',
    'danger_level',
    'created_at',
    'updated_at',
  ];
  private const ALLOWED_SORT_ORDER = [
    'ASC',
    'DESC',
  ];
  private const DEFAULT_SORT_BY = 'name';
  private const DEFAULT_SORT_ORDER = 'ASC';
  private const DEFAULT_PAGE = 1;
  private const DEFAULT_LIMIT = 10;

  public function __construct(array $queryParams) {
    $page = filter_var($queryParams['page'] ?? self::DEFAULT_PAGE, FILTER_VALIDATE_INT);
    if($page === false || $page < 1) {
      throw new InvalidArgumentException('Invalid or missing "page" parameter');
    }
    $this->page = $page;

    $limit = filter_var($queryParams['limit'] ?? self::DEFAULT_LIMIT, FILTER_VALIDATE_INT);
    if($limit === false || $limit < 1) {
      throw new InvalidArgumentException('Invalid or missing "limit" parameter');
    }
    $this->limit = $limit;

    $this->type = trim($queryParams['type'] ?? '');
    $this->minDangerLevel = trim($queryParams['minDangerLevel'] ?? '');
    $this->search = trim($queryParams['search'] ?? '');

    $sortBy = trim($queryParams['sortBy'] ?? self::DEFAULT_SORT_BY);
    if(!in_array($sortBy, self::ALLOWED_SORT_BY)) {
      throw new InvalidArgumentException('Invalid "sortBy" parameter');
    }
    $this->sortBy = $sortBy;

    $sortOrder = strtoupper($queryParams['sortOrder'] ?? self::DEFAULT_SORT_ORDER);
    if(!in_array($sortOrder, self::ALLOWED_SORT_ORDER)) {
      throw new InvalidArgumentException('Invalid "sortOrder" parameter');
    }
    $this->sortOrder = $sortOrder;

    $this->offset = ($this->page - 1) * $this->limit;
  }
}