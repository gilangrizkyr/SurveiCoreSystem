<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyExportController extends Controller
{
    /**
     * Export survey responses to CSV
     */
    public function exportCsv(string $uuid)
    {
        $survey = Survey::query()
            ->where('uuid', $uuid)
            ->with(['sections.questions.options'])
            ->firstOrFail();

        $filename = 'survey-responses-' . $survey->title . '-' . date('Y-m-d-His') . '.csv';
        $filename = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $filename);
        
        return new StreamedResponse(function () use ($survey) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM

            // 1. Prepare Metadata & Questions
            $headers = [
                'Response UUID', 'Status', 'Submitted At', 
                'Respondent Name', 'Respondent Email', 'Respondent Phone', 'Respondent NIK',
                'Device Type', 'IP Address'
            ];

            $questionsMap = [];
            $optionsMap = []; // Cache all options: id => text

            foreach ($survey->sections as $section) {
                foreach ($section->questions as $question) {
                    $headers[] = $section->title . ' - ' . $question->title;
                    $questionsMap[$question->id] = $question;
                    
                    // Cache options
                    if ($question->options) {
                        foreach ($question->options as $option) {
                            $optionsMap[$option->id] = $option->label;
                        }
                    }
                }
            }
            fputcsv($handle, $headers);

            // 2. Stream Responses (Chunked for memory efficiency)
            $survey->responses()
                ->with(['answers'])
                ->where('status', 'completed')
                ->chunk(200, function ($responses) use ($handle, $questionsMap, $optionsMap) {
                    foreach ($responses as $response) {
                        $row = [
                            $response->uuid,
                            $response->status,
                            $response->submitted_at?->format('Y-m-d H:i:s'),
                            $response->respondent_name ?? 'Anonymous',
                            $response->respondent_email ?? '-',
                            $response->respondent_phone ?? '-',
                            $response->respondent_nik ?? '-',
                            $response->device_type ?? '-',
                            $response->ip_address,
                        ];

                        $answersMap = $response->answers->keyBy('question_id');

                        foreach ($questionsMap as $qId => $question) {
                            $answer = $answersMap->get($qId);
                            $val = '';

                            if ($answer) {
                                if ($answer->option_id) {
                                    $val = $optionsMap[$answer->option_id] ?? ('ID:'.$answer->option_id);
                                } elseif ($answer->answer_text) {
                                    $val = $answer->answer_text;
                                } elseif ($answer->answer_numeric !== null) {
                                    $val = $answer->answer_numeric;
                                } elseif ($answer->answer_date) {
                                    $val = $answer->answer_date;
                                } elseif ($answer->metadata) {
                                    // Handle checkboxes stored in JSON metadata
                                    if (isset($answer->metadata['answer_json'])) {
                                        $json = json_decode($answer->metadata['answer_json'], true);
                                        if (is_array($json)) {
                                            $mapped = array_map(function($item) use ($optionsMap) {
                                                return $optionsMap[$item] ?? $item;
                                            }, $json);
                                            $val = implode(', ', $mapped);
                                        } else {
                                            $val = (string)$json;
                                        }
                                    }
                                }
                            }
                            $row[] = $val;
                        }

                        fputcsv($handle, $row);
                    }
                });

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}