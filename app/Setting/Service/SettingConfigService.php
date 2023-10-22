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
namespace App\Setting\Service;

use App\Setting\Mapper\SettingConfigMapper;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\DependProxy;
use Mine\Annotation\Transaction;
use Mine\Cache\MineCache;
use Mine\Interfaces\ServiceInterface\ConfigServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;
use Yansongda\HyperfPay\Pay;

#[DependProxy(values: [ConfigServiceInterface::class])]
class SettingConfigService extends AbstractService implements ConfigServiceInterface
{
    /**
     * @var SettingConfigMapper
     */
    public $mapper;

    protected ContainerInterface $container;

    protected MineCache $redis;

    /**
     * SettingConfigService constructor.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(SettingConfigMapper $mapper, ContainerInterface $container)
    {
        $this->mapper = $mapper;
        $this->container = $container;
        $this->redis = $this->container->get(MineCache::class);
    }

    /**
     * 按key获取配置，并缓存.
     * @throws RedisException
     */
    public function getConfigByKey(string $key): ?array
    {
        if (empty($key)) {
            return [];
        }
        if ($data = $this->redis->getUploadCache($key)) {
            return unserialize($data);
        }
        $data = $this->mapper->getConfigByKey($key);
        if ($data) {
            $this->redis->setUploadCache($key, serialize($data));
            return $data;
        }
        return null;
    }

    /**
     * 清除缓存.
     * @throws RedisException
     */
    public function clearCache(): bool
    {
        $this->redis->delUploadOrUploadGroup();

        return true;
    }

    /**
     * 更新配置.
     */
    public function updated(string $key, array $data): bool
    {
        return $this->mapper->updateConfig($key, $data);
    }

    /**
     * 按 keys 更新配置.
     */
    #[Transaction]
    public function updatedByKeys(array $data): bool
    {
        foreach ($data as $name => $value) {
            $this->mapper->updateByKey((string) $name, $value);
        }
        return true;
    }
}
