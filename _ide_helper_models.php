<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $response_id
 * @property string $anomaly_type
 * @property string $severity
 * @property string|null $description
 * @property numeric|null $confidence_score
 * @property int $auto_flagged
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SurveyResponse $response
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereAnomalyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereAutoFlagged($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereConfidenceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiAnomalyDetection whereUpdatedAt($value)
 */
	class AiAnomalyDetection extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int|null $user_id
 * @property string $session_id
 * @property string $message
 * @property string $response
 * @property array<array-key, mixed>|null $context
 * @property string|null $intent
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereIntent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiChatConversation whereUserId($value)
 */
	class AiChatConversation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property string $insight_type
 * @property string $title
 * @property string|null $description
 * @property array<array-key, mixed>|null $data
 * @property numeric|null $confidence_score
 * @property \Illuminate\Support\Carbon $generated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereConfidenceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereInsightType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiInsight whereUpdatedAt($value)
 */
	class AiInsight extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property int $question_id
 * @property string $keyword
 * @property int $frequency
 * @property numeric|null $relevance_score
 * @property string|null $category
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereRelevanceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiKeywordExtraction whereSurveyId($value)
 */
	class AiKeywordExtraction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $response_id
 * @property int $question_id
 * @property int $answer_id
 * @property string $text_content
 * @property string $sentiment
 * @property numeric $confidence_score
 * @property string|null $emotion
 * @property \Illuminate\Support\Carbon $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ResponseAnswer $answer
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\SurveyResponse $response
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereConfidenceScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereEmotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereSentiment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereTextContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AiSentimentAnalysis whereUpdatedAt($value)
 */
	class AiSentimentAnalysis extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int|null $survey_id
 * @property string $dashboard_type
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $generated_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property-read \App\Models\Survey|null $survey
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereDashboardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsDashboard whereTenantId($value)
 */
	class AnalyticsDashboard extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property int|null $response_id
 * @property string $event_type
 * @property int|null $question_id
 * @property array<array-key, mixed>|null $metadata
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\SurveyResponse|null $response
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnalyticsEvent whereSurveyId($value)
 */
	class AnalyticsEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $uuid
 * @property int $tenant_id
 * @property string $name
 * @property string $client_id
 * @property string $client_secret
 * @property array<array-key, mixed>|null $redirect_uris
 * @property string $tier
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApiKey> $apiKeys
 * @property-read int|null $api_keys_count
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereClientSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereRedirectUris($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereTier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiClient withoutTrashed()
 */
	class ApiClient extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property string $key
 * @property string $secret
 * @property string $name
 * @property array<array-key, mixed>|null $scopes
 * @property array<array-key, mixed>|null $ip_whitelist
 * @property int $rate_limit
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $revoked_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ApiClient $client
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereIpWhitelist($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereRateLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereRevokedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereUpdatedAt($value)
 */
	class ApiKey extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property int|null $api_key_id
 * @property string $endpoint
 * @property string $method
 * @property int $status_code
 * @property int $response_time
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $request_signature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ApiKey|null $apiKey
 * @property-read \App\Models\ApiClient $client
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereApiKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereRequestSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereResponseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsageLog whereUserAgent($value)
 */
	class ApiUsageLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property int|null $user_id
 * @property string $action
 * @property string $model_type
 * @property int|null $model_id
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $auditable
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property int|null $response_id
 * @property string $consent_type
 * @property bool $given
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\SurveyResponse|null $response
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereConsentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereGiven($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsentRecord whereUserAgent($value)
 */
	class ConsentRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property string $data_type
 * @property int $retention_days
 * @property bool $auto_delete
 * @property \Illuminate\Support\Carbon|null $last_cleanup_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereAutoDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereLastCleanupAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereRetentionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataRetentionPolicy whereUpdatedAt($value)
 */
	class DataRetentionPolicy extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property string $type
 * @property string|null $credentials
 * @property array<array-key, mixed>|null $settings
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereCredentials($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Integration whereUpdatedAt($value)
 */
	class Integration extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int|null $subscription_id
 * @property numeric $amount
 * @property numeric $tax
 * @property numeric $total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $section_id
 * @property string $type
 * @property string $title
 * @property string|null $description
 * @property string|null $placeholder
 * @property string|null $help_text
 * @property bool $is_required
 * @property int $order
 * @property array<array-key, mixed>|null $validation_rules
 * @property array<array-key, mixed>|null $logic_rules
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResponseAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionOption> $options
 * @property-read int|null $options_count
 * @property-read \App\Models\SurveySection $section
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereHelpText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereLogicRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question wherePlaceholder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereValidationRules($value)
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $question_id
 * @property string $condition_type
 * @property int|null $source_question_id
 * @property string $operator
 * @property string|null $value
 * @property int|null $target_question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\Question|null $sourceQuestion
 * @property-read \App\Models\Question|null $targetQuestion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereConditionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereSourceQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereTargetQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionLogic whereValue($value)
 */
	class QuestionLogic extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $question_id
 * @property string $label
 * @property string $value
 * @property int $order
 * @property bool $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionOption whereValue($value)
 */
	class QuestionOption extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property string $endpoint
 * @property int $max_requests
 * @property int $window_seconds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ApiClient $client
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereMaxRequests($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RateLimit whereWindowSeconds($value)
 */
	class RateLimit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $response_id
 * @property numeric|null $sentiment_score
 * @property array<array-key, mixed>|null $keywords
 * @property numeric|null $anomaly_score
 * @property numeric|null $fraud_probability
 * @property array<array-key, mixed>|null $quality_metrics
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SurveyResponse $response
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereAnomalyScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereFraudProbability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereQualityMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereSentimentScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnalytics whereUpdatedAt($value)
 */
	class ResponseAnalytics extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $response_id
 * @property int $question_id
 * @property int|null $option_id
 * @property string|null $answer_text
 * @property numeric|null $answer_numeric
 * @property \Illuminate\Support\Carbon|null $answer_date
 * @property int|null $answer_file_id
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\QuestionOption|null $option
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\SurveyResponse $response
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereAnswerDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereAnswerFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereAnswerNumeric($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereAnswerText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseAnswer whereUpdatedAt($value)
 */
	class ResponseAnswer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $response_id
 * @property int $question_id
 * @property string $filename
 * @property string $file_path
 * @property int $file_size
 * @property string $mime_type
 * @property int $is_scanned
 * @property string|null $scan_result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereIsScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereScanResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResponseFile whereUpdatedAt($value)
 */
	class ResponseFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int $plan_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property bool $auto_renew
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoice> $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\SubscriptionPlan $plan
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereAutoRenew($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property numeric $price
 * @property string $currency
 * @property string $interval
 * @property array<array-key, mixed>|null $features
 * @property array<array-key, mixed>|null $limits
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereLimits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereUpdatedAt($value)
 */
	class SubscriptionPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $uuid
 * @property int $tenant_id
 * @property int $creator_id
 * @property int|null $template_id
 * @property int|null $theme_id
 * @property string $title
 * @property string|null $description
 * @property string|null $welcome_message
 * @property string|null $thank_you_message
 * @property string $status
 * @property string $type
 * @property array<array-key, mixed>|null $settings
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyResponse> $responses
 * @property-read int|null $responses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveySection> $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereThankYouMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereWelcomeMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey withoutTrashed()
 */
	class Survey extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property string $channel
 * @property array<array-key, mixed>|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WebhookLog> $links
 * @property-read int|null $links_count
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyDistribution whereUpdatedAt($value)
 */
	class SurveyDistribution extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $distribution_id
 * @property string $token
 * @property int|null $max_responses
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property int $used_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SurveyDistribution $distribution
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyResponse> $responses
 * @property-read int|null $responses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereDistributionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereMaxResponses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyLink whereUsedCount($value)
 */
	class SurveyLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property int $max_responses
 * @property int $current_count
 * @property array<array-key, mixed>|null $demographic_limits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereCurrentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereDemographicLimits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereMaxResponses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyQuota whereUpdatedAt($value)
 */
	class SurveyQuota extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $uuid
 * @property int $survey_id
 * @property int|null $respondent_id
 * @property int|null $link_id
 * @property string $status
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property int|null $completion_time_seconds
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $device_type
 * @property array<array-key, mixed>|null $geo_location
 * @property numeric|null $quality_score
 * @property bool $is_flagged
 * @property string|null $flag_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ResponseAnalytics|null $analytics
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResponseAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ResponseFile> $files
 * @property-read int|null $files_count
 * @property-read \App\Models\User|null $respondent
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereCompletionTimeSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereFlagReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereGeoLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereIsFlagged($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereQualityScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereRespondentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyResponse withoutTrashed()
 */
	class SurveyResponse extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property string $timezone
 * @property array<array-key, mixed>|null $recurrence
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereRecurrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySchedule whereUpdatedAt($value)
 */
	class SurveySchedule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property string|null $title
 * @property string|null $description
 * @property int $order
 * @property array<array-key, mixed>|null $logic
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereLogic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveySection whereUpdatedAt($value)
 */
	class SurveySection extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $survey_id
 * @property int $total_views
 * @property int $total_started
 * @property int $total_completed
 * @property numeric $completion_rate
 * @property numeric $avg_completion_time
 * @property array<array-key, mixed>|null $drop_off_points
 * @property array<array-key, mixed>|null $device_breakdown
 * @property array<array-key, mixed>|null $location_breakdown
 * @property \Illuminate\Support\Carbon|null $last_calculated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereAvgCompletionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereCompletionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereDeviceBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereDropOffPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereLastCalculatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereLocationBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereTotalCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereTotalStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereTotalViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyStatistic whereUpdatedAt($value)
 */
	class SurveyStatistic extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property string|null $description
 * @property string|null $category
 * @property array<array-key, mixed>|null $structure
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Survey> $surveys
 * @property-read int|null $surveys_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTemplate whereUpdatedAt($value)
 */
	class SurveyTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property string $primary_color
 * @property string $secondary_color
 * @property string $font_family
 * @property string|null $logo_url
 * @property string|null $background_image
 * @property string|null $custom_css
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Survey> $surveys
 * @property-read int|null $surveys_count
 * @property-read \App\Models\Tenant|null $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereBackgroundImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereCustomCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereFontFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereSecondaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveyTheme whereUpdatedAt($value)
 */
	class SurveyTheme extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string|null $domain
 * @property string|null $database
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\TenantSetting> $settings
 * @property string $status
 * @property string $subscription_tier
 * @property \Illuminate\Support\Carbon|null $subscription_expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApiClient> $apiClients
 * @property-read int|null $api_clients_count
 * @property-read int|null $settings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Survey> $surveys
 * @property-read int|null $surveys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSubscriptionExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSubscriptionTier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withoutTrashed()
 */
	class Tenant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantSetting whereValue($value)
 */
	class TenantSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $oauthApps
 * @property-read int|null $oauth_apps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyResponse> $responses
 * @property-read int|null $responses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Survey> $surveys
 * @property-read int|null $surveys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User definition()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int|null $survey_id
 * @property string $url
 * @property array<array-key, mixed> $events
 * @property string|null $secret
 * @property bool $is_active
 * @property int $retry_limit
 * @property int $timeout_seconds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WebhookLog> $logs
 * @property-read int|null $logs_count
 * @property-read \App\Models\Survey|null $survey
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereEvents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereRetryLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereTimeoutSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Webhook withoutTrashed()
 */
	class Webhook extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $webhook_id
 * @property string $event
 * @property array<array-key, mixed>|null $payload
 * @property int|null $status_code
 * @property string|null $response_body
 * @property int $attempt_number
 * @property \Illuminate\Support\Carbon|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $failed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Webhook $webhook
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereAttemptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereFailedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereResponseBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WebhookLog whereWebhookId($value)
 */
	class WebhookLog extends \Eloquent {}
}

