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
namespace App\System\Service;

use App\System\Mapper\SystemDictDataMapper;
use Hyperf\Redis\Redis;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\DependProxy;
use Mine\Cache\MineCache;
use Mine\Interfaces\ServiceInterface\DictDataServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

/**
 * 字典类型业务
 * Class SystemLoginLogService.
 */
#[DependProxy(values: [DictDataServiceInterface::class])]
class SystemDictDataService extends AbstractService implements DictDataServiceInterface
{
    /**
     * @var SystemDictDataMapper
     */
    public $mapper;

    /**
     * 容器.
     */
    protected ContainerInterface $container;

    /**
     * Redis.
     */
    protected MineCache $redis;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(SystemDictDataMapper $mapper, ContainerInterface $container)
    {
        $this->mapper = $mapper;
        $this->container = $container;
        $this->redis = $this->container->get(MineCache::class);
    }

    /**
     * 查询多个字典.
     * @throws RedisException
     */
    public function getLists(?array $params = null): array
    {
        if (! isset($params['codes'])) {
            return [];
        }

        $codes = explode(',', $params['codes']);
        $data = [];

        foreach ($codes as $code) {
            $data[$code] = $this->getList(['code' => $code]);
        }

        return $data;
    }

    /**
     * 查询一个字典.
     * @throws RedisException
     */
    public function getList(?array $params = null, bool $isScope = false): array
    {
        if (! isset($params['code'])) {
            return [];
        }

        if ($data = $this->redis->getDictCache($params['code'])) {
            return unserialize($data);
        }

        $args = [
            'select' => ['id', 'label as title', 'value as key'],
            'status' => \Mine\MineModel::ENABLE,
            'orderBy' => 'sort',
            'orderType' => 'desc',
        ];
        $data = $this->mapper->getList(array_merge($args, $params), $isScope);

        $this->redis->setDictCache($params['code'], serialize($data));

        return $data;
    }

    /**
     * @throws RedisException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function clearCache(): bool
    {
        foreach ($this->redis->getKeys('Dict:*') as $item) {
            $this->redis->delScanKey($item);
        }
        return true;
    }
}
