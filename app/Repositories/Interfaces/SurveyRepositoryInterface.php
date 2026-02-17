<?php

namespace App\Repositories\Interfaces;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;

interface SurveyRepositoryInterface extends BaseRepositoryInterface
{
    public function getSurveysByTenant(int $tenantId): Collection;
    public function getSurveysByCreator(int $creatorId): Collection;
}