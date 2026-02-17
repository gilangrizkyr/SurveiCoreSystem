<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ResponseRepositoryInterface;
use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Collection;

class ResponseRepository extends BaseRepository implements ResponseRepositoryInterface
{
    public function __construct(SurveyResponse $model)
    {
        parent::__construct($model);
    }

    public function getResponsesBySurvey(int $surveyId): Collection
    {
        return $this->model->where('survey_id', $surveyId)->get();
    }
}