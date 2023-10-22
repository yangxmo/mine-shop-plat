<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
if (! function_exists('env')) {
    /**
     * 获取环境变量信息.
     */
    function env(string $key, mixed $default = null): mixed
    {
        return \Hyperf\Support\env($key, $default);
    }
}

if (! function_exists('data_set')) {
    /**
     * 获取环境变量信息.
     */
    function data_set(array &$data, string $key, mixed $value): void
    {
        \Hyperf\Collection\data_set($data, $key, $value);
    }
}

if (! function_exists('data_get')) {
    /**
     * 获取环境变量信息.
     */
    function data_get(array $data, string $key): array
    {
        return \Hyperf\Collection\data_get($data, $key);
    }
}

if (! function_exists('config')) {
    /**
     * 获取配置信息.
     */
    function config(string $key, mixed $default = null): mixed
    {
        return \Hyperf\Config\config($key, $default);
    }
}

if (! function_exists('make')) {
    /**
     * Create an object instance, if the DI container exist in ApplicationContext,
     * then the object will be created by DI container via `make()` method, if not,
     * the object will create by `new` keyword.
     */
    function make(string $name, array $parameters = [])
    {
        return \Hyperf\Support\make($name, $parameters);
    }
}

if (! function_exists('clientUserId')) {
    /**
     * Create an object instance, if the DI container exist in ApplicationContext,
     * then the object will be created by DI container via `make()` method, if not,
     * the object will create by `new` keyword.
     */
    function clientUserId(): ?int
    {
        $data = app_verify()->getJwt()->getParserData();

        return $data['id'] ?? null;
    }
}
