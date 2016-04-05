<?php

namespace OneSignal;

class Config
{
    /**
     * @var string
     */
    private $applicationId;

    /**
     * @var string
     */
    private $applicationAuthKey;

    /**
     * @var string
     */
    private $userAuthKey;

    /**
     * Set OneSignal application id.
     *
     * @param string $applicationId
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
    }

    /**
     * Get OneSignal application id.
     *
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set OneSignal application authentication key.
     *
     * @param string $applicationAuthKey
     */
    public function setApplicationAuthKey($applicationAuthKey)
    {
        $this->applicationAuthKey = $applicationAuthKey;
    }

    /**
     * Get OneSignal application authentication key.
     *
     * @return string
     */
    public function getApplicationAuthKey()
    {
        return $this->applicationAuthKey;
    }

    /**
     * Set user authentication key.
     *
     * @param string $userAuthKey
     */
    public function setUserAuthKey($userAuthKey)
    {
        $this->userAuthKey = $userAuthKey;
    }

    /**
     * Get user authentication key.
     *
     * @return string
     */
    public function getUserAuthKey()
    {
        return $this->userAuthKey;
    }
}
