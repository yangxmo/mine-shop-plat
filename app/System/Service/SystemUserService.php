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

use App\System\Cache\UserCache;
use App\System\Mapper\SystemUserMapper;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\DependProxy;
use Mine\Cache\MineCache;
use Mine\Event\UserAdd;
use Mine\Event\UserDelete;
use Mine\Exception\MineException;
use Mine\Exception\NormalStatusException;
use Mine\Interfaces\ServiceInterface\UserServiceInterface;
use Mine\MineRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;

/**
 * 用户业务
 * Class SystemUserService.
 */
#[DependProxy(values: [UserServiceInterface::class])]
class SystemUserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var SystemUserMapper
     */
    public $mapper;

    #[Inject]
    protected MineRequest $request;

    protected ContainerInterface $container;

    protected SystemMenuService $sysMenuService;

    protected SystemRoleService $sysRoleService;

    protected UserCache $userCache;

    protected MineCache $mineCache;

    /**
     * SystemUserService constructor.
     */
    public function __construct(
        ContainerInterface $container,
        SystemUserMapper $mapper,
        UserCache $userCache,
        MineCache $mineCache,
        SystemMenuService $systemMenuService,
        SystemRoleService $systemRoleService
    ) {
        $this->mapper = $mapper;
        $this->sysMenuService = $systemMenuService;
        $this->sysRoleService = $systemRoleService;
        $this->container = $container;
        $this->userCache = $userCache;
        $this->mineCache = $mineCache;
    }

    /**
     * 获取用户信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getInfo(): array
    {
        if ($uid = user()->getId()) {
            return $this->getCacheInfo($uid);
        }
        throw new MineException(t('system.unable_get_userinfo'), 500);
    }

    /**
     * 新增用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function save(array $data): int
    {
        if ($this->mapper->existsByUsername($data['username'])) {
            throw new NormalStatusException(t('system.username_exists'));
        }
        $id = $this->mapper->save($this->handleData($data));
        $data['id'] = $id;
        event(new UserAdd($data));
        return $id;
    }

    /**
     * 更新用户信息.
     */
    #[CacheEvict(prefix: 'loginInfo', value: 'userId_#{id}', group: 'user')]
    public function update(int $id, array $data): bool
    {
        if (isset($data['username'])) {
            unset($data['username']);
        }
        if (isset($data['password'])) {
            unset($data['password']);
        }
        return $this->mapper->update($id, $this->handleData($data));
    }

    /**
     * 获取在线用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOnlineUserPageList(array $params = []): array
    {
        $userIds = [];
        $iterator = null;
        $key = $this->userCache->getScanOnlineUserKey();
        while (false !== ($users = $this->userCache->scanOnlineUser($iterator, 100))) {
            foreach ($users as $user) {
                if (preg_match("/{$key}(\\d+)$/", $user, $match) && isset($match[1])) {
                    $userIds[] = $match[1];
                }
            }
            unset($users);
        }

        if (empty($userIds)) {
            return [];
        }

        return $this->getPageList(array_merge(['userIds' => $userIds], $params));
    }

    /**
     * 删除用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function delete(array $ids): bool
    {
        if (! empty($ids)) {
            if (($key = array_search(env('SUPER_ADMIN'), $ids)) !== false) {
                unset($ids[$key]);
            }
            $result = $this->mapper->delete($ids);
            event(new UserDelete($ids));
            return $result;
        }

        return false;
    }

    /**
     * 真实删除用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function realDelete(array $ids): bool
    {
        if (! empty($ids)) {
            if (($key = array_search(env('SUPER_ADMIN'), $ids)) !== false) {
                unset($ids[$key]);
            }
            $result = $this->mapper->realDelete($ids);
            event(new UserDelete($ids));
            return $result;
        }

        return false;
    }

    /**
     * 强制下线用户.
     * @throws InvalidArgumentException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    public function kickUser(string $id): bool
    {
        user()->getJwt()->logout($this->userCache->getUserTokenCache((int) $id), 'default');
        $this->userCache->delUserTokenCache((int) $id);
        return true;
    }

    /**
     * 初始化用户密码
     */
    public function initUserPassword(int $id, string $password = '123456'): bool
    {
        return $this->mapper->initUserPassword($id, $password);
    }

    /**
     * 清除用户缓存.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    public function clearCache(int $userId = 0): bool
    {
        $iterator = null;
        while (false !== ($configKey = $this->mineCache->scan($iterator, 'config:*'))) {
            $this->mineCache->delScanKey($configKey);
        }
        while (false !== ($dictKey = $this->mineCache->scan($iterator, 'Dict:*'))) {
            $this->mineCache->delScanKey($dictKey);
        }
        $this->mineCache->delCrontabCache();
        $this->mineCache->delModuleCache();

        $userId && $this->userCache->delUserCache($userId);

        return true;
    }

    /**
     * 设置用户首页.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    #[CacheEvict(prefix: 'user', value: 'userInfo_#{params.id}', group: 'user')]
    public function setHomePage(array $params): bool
    {
        $res = ($this->mapper->getModel())::query()
            ->where('id', $params['id'])
            ->update(['dashboard' => $params['dashboard']]) > 0;

        $this->clearCache();
        return $res;
    }

    /**
     * 用户更新个人资料.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[CacheEvict(prefix: 'user', value: 'userInfo_#{params.id}', group: 'user')]
    public function updateInfo(array $params): bool
    {
        if (! isset($params['id'])) {
            return false;
        }

        $model = $this->mapper->getModel()::find($params['id']);
        unset($params['id'], $params['password']);
        foreach ($params as $key => $param) {
            $model[$key] = $param;
        }

        $this->clearCache();
        return $model->save();
    }

    /**
     * 用户修改密码
     */
    public function modifyPassword(array $params): bool
    {
        return $this->mapper->initUserPassword((int) user()->getId(), $params['newPassword']);
    }

    /**
     * 通过 id 列表获取用户基础信息.
     */
    public function getUserInfoByIds(array $ids): array
    {
        return $this->mapper->getUserInfoByIds($ids);
    }

    /**
     * 获取缓存用户信息.
     */
    #[Cacheable(prefix: 'user', ttl: 0, value: 'userInfo_#{id}', group: 'user')]
    protected function getCacheInfo(int $id): array
    {
        $user = $this->mapper->getModel()->find($id);
        $user->addHidden('deleted_at', 'password');
        $data['user'] = $user->toArray();
        if (user()->isSuperAdmin()) {
            $data['roles'] = ['superAdmin'];
            $data['routers'] = $this->sysMenuService->mapper->getSuperAdminRouters();
            $data['codes'] = ['*'];
        } else {
            $roles = $this->sysRoleService->mapper->getMenuIdsByRoleIds($user->roles()->pluck('id')->toArray());
            $ids = $this->filterMenuIds($roles);
            $data['roles'] = $user->roles()->pluck('code')->toArray();
            $data['routers'] = $this->sysMenuService->mapper->getRoutersByIds($ids);
            $data['codes'] = $this->sysMenuService->mapper->getMenuCode($ids);
        }

        return $data;
    }

    /**
     * 过滤通过角色查询出来的菜单id列表，并去重.
     */
    protected function filterMenuIds(array &$roleData): array
    {
        $ids = [];
        foreach ($roleData as $val) {
            foreach ($val['menus'] as $menu) {
                $ids[] = $menu['id'];
            }
        }
        unset($roleData);
        return array_unique($ids);
    }

    /**
     * 处理提交数据.
     * @param mixed $data
     */
    protected function handleData($data): array
    {
        if (! is_array($data['role_ids'])) {
            $data['role_ids'] = explode(',', $data['role_ids']);
        }
        if (($key = array_search(env('ADMIN_ROLE'), $data['role_ids'])) !== false) {
            unset($data['role_ids'][$key]);
        }
        if (! empty($data['post_ids']) && ! is_array($data['post_ids'])) {
            $data['post_ids'] = explode(',', $data['post_ids']);
        }
        if (! empty($data['dept_ids']) && ! is_array($data['dept_ids'])) {
            $data['dept_ids'] = explode(',', $data['dept_ids']);
        }
        return $data;
    }
}
