<?php

declare(strict_types=1);

namespace OneSignal;

use function strlen;

final class Config
{
    /**
     * Prefix of the API keys introduced by OneSignal in November 2024.
     *
     * It is shared by the App API keys (`os_v2_app_`) and the Organization API
     * keys (`os_v2_org_`), the latter replacing the legacy user authentication
     * key. Keys carrying this prefix must be used against self::API_URL, legacy
     * keys keep using self::LEGACY_API_URL.
     */
    public const V2_KEY_PREFIX = 'os_v2_';

    public const API_URL = 'https://api.onesignal.com';

    public const LEGACY_API_URL = 'https://onesignal.com/api/v1';

    /**
     * @var non-empty-string
     */
    private string $applicationId;

    /**
     * @var non-empty-string
     */
    private string $applicationAuthKey;

    /**
     * @var non-empty-string|null
     */
    private ?string $userAuthKey;

    /**
     * @param non-empty-string      $applicationId
     * @param non-empty-string      $applicationAuthKey
     * @param non-empty-string|null $userAuthKey
     */
    public function __construct(string $applicationId, string $applicationAuthKey, ?string $userAuthKey = null)
    {
        $this->applicationId = $applicationId;
        $this->applicationAuthKey = $applicationAuthKey;
        $this->userAuthKey = $userAuthKey;
    }

    /**
     * Get OneSignal application id.
     *
     * @return non-empty-string
     */
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    /**
     * Get OneSignal application authentication key.
     *
     * @return non-empty-string
     */
    public function getApplicationAuthKey(): string
    {
        return $this->applicationAuthKey;
    }

    /**
     * Get user authentication key.
     *
     * @return non-empty-string|null
     */
    public function getUserAuthKey(): ?string
    {
        return $this->userAuthKey;
    }

    /**
     * Get the API url matching the given authentication key.
     *
     * Legacy keys are only served by the legacy url, while the keys introduced
     * in November 2024 are served by both. Picking the url from the key keeps
     * existing setups working without any configuration change.
     *
     * The url must be resolved from the key that actually authenticates the
     * request: requests authenticated with the user/organization key can use a
     * different key format than the application ones, for example while only
     * one of the two keys has been migrated yet.
     *
     * @param non-empty-string|null $authKey Authentication key used for the request,
     *                                       defaults to the application authentication key
     *
     * @return non-empty-string
     */
    public function getApiUrl(?string $authKey = null): string
    {
        return self::isV2Key($authKey ?? $this->applicationAuthKey) ? self::API_URL : self::LEGACY_API_URL;
    }

    /**
     * Whether the given authentication key is an App or Organization API key
     * created after November 2024.
     */
    public static function isV2Key(?string $authKey): bool
    {
        if ($authKey === null) {
            return false;
        }

        return strncmp($authKey, self::V2_KEY_PREFIX, strlen(self::V2_KEY_PREFIX)) === 0;
    }
}
