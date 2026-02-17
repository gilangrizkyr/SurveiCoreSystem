<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SurveyRepositoryInterface;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    public function __construct(Survey $model)
    {
        parent::__construct($model);
    }

    public function getSurveysByTenant(int $tenantId): Collection
    {
        return $this->model->where('tenant_id', $tenantId)->get();
    }

    public function getSurveysByCreator(int $creatorId): Collection
    {
        return $this->model->where('creator_id', $creatorId)->get();
    }
}