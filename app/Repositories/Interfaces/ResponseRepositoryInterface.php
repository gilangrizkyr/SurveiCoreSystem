<?php

namespace App\Repositories\Interfaces;

use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Collection;

interface ResponseRepositoryInterface extends BaseRepositoryInterface
{
    public function getResponsesBySurvey(int $surveyId): Collection;
}