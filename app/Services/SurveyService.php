<?php

namespace App\Services;

use App\Repositories\Interfaces\SurveyRepositoryInterface;
use App\Models\Survey;
use App\Models\SurveySection;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class SurveyService
{
    protected SurveyRepositoryInterface $surveyRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function getAllSurveys(): Collection
    {
        return $this->surveyRepository->all();
    }

    public function getSurvey(int $id): ?Survey
    {
        $result = $this->surveyRepository->find($id);
        return $result instanceof Survey ? $result : null;
    }

    public function createSurvey(array $data): Survey
    {
        if (!isset($data['uuid'])) {
            $data['uuid'] = (string)Str::uuid();
        }

        $result = $this->surveyRepository->create($data);
        return $result;
    }

    public function updateSurvey(int $id, array $data): bool
    {
        return $this->surveyRepository->update($id, $data);
    }

    public function deleteSurvey(int $id): bool
    {
        return $this->surveyRepository->delete($id);
    }

    public function addSection(int $surveyId, array $data): SurveySection
    {
        $data['survey_id'] = $surveyId;
        return SurveySection::create($data);
    }

    public function addQuestion(int $sectionId, array $data): Question
    {
        $data['section_id'] = $sectionId;
        return Question::create($data);
    }

    public function getSurveyWithDetails(string $uuid): ?Survey
    {
        return Survey::with(['sections.questions.options'])
            ->where('uuid', '=', $uuid)
            ->first();
    }
}