<?php

namespace UserTestProject;

/**
 * Class Config
 */
class Config
{
    /**
     * @var array|mixed
     */
    private $settings;

    /**
     * Config constructor
     * @param string $configPath
     */
    public function __construct(string $configPath)
    {
        $this->settings = require $configPath;
    }

    /**
     * @param string $key
     * @param $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}