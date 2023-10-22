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

namespace App\Users\Service\Api;

use Api\Assemble\UserInfoAssemble;
use App\Users\Mapper\UserMapper;
use Mine\Abstracts\AbstractService;
use Mine\Exception\NormalStatusException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 用户数据表服务类.
 */
class UserService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取当前登陆的用户信息.
     */
    public function getUserInfo(): array
    {
        $userInfo = app_verify()->getJwt()->getParserData();

        $userInfo = $this->mapper->read($userInfo['id']);

        return UserInfoAssemble::assembleUserInfo($userInfo->toArray());
    }

    /**
     * 修改用户信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function upUserInfo(array $params): bool
    {
        $userInfo = app_verify()->getJwt()->getParserData();
        // 检查用户信息
        $this->checkUserInfo($params, (int) $userInfo['id']);
        // 更新用户信息
        $this->mapper->upInfoByMobile($userInfo['mobile'], $params);
        // TODO 后续其他处理
        return true;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function checkUserInfo(array &$params, int $userId): void
    {
        // 检查手机号是否重复
        $existsMobile = $this->mapper->checkUserMobile($params['mobile'], $userId);
        // 手机号存在
        if ($existsMobile) {
            throw new NormalStatusException(t('user.user_mobile_exists'));
        }
        // 检查是否输入了密码
        if (! empty($params['password'])) {
            $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        }
        // 检查邮箱是否重复
        if (! empty($params['email'])) {
            $existsEmail = $this->mapper->checkUserEmail($params['email'], $userId);
            // 邮箱存在
            if ($existsEmail) {
                throw new NormalStatusException(t('user.user_email_exists'));
            }
        }
    }
}
