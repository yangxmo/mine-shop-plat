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

use Api\Event\LoginAfterEvent;
use Api\Handler\Interface\MiniAppInterface;
use App\Users\Mapper\UserMapper;
use App\Users\Mapper\UserPlatFormMapper;
use App\Users\Model\UsersUser;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Exception\NormalStatusException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\InvalidArgumentException;

class LoginService extends AbstractService
{
    /**
     * @var UserMapper
     */
    public $mapper;

    #[Inject]
    protected MiniAppInterface $miniApp;
    #[Inject]
    protected EventDispatcherInterface $eventDispatcher;
    #[Inject]
    protected UserPlatFormMapper $userPlatFormMapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 微信登陆.
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     */
    public function loginByMiniApp(array $params): string
    {
        $sessionKey = $this->miniApp::getSessionKey($params['code']);

        if (empty($sessionKey)) {
            throw new NormalStatusException(t('easywechat.session_key_empty'));
        }

        $userInfo = $this->miniApp->getUserInfo($sessionKey, $params['iv'], $params['encrypted_data']);
        // 获取用户信息失败
        if (empty($userInfo)) {
            throw new NormalStatusException(t('easywechat.get_user_info_empty'));
        }
        // 开始处理用户信息
        $userInfo = $this->userPlatFormMapper->getOrNewUserByWx($userInfo);
        // 检查用户是否已有信息
        $userInfo->user()->updateOrCreate(['mobile' => $userInfo['phone']], $userInfo);
        // 事件
        $this->eventDispatcher->dispatch(new LoginAfterEvent($userInfo->id));
        // 获取jwtToken
        return app_verify()->getToken($userInfo);
    }

    /**
     * 手机号密码登陆.
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     */
    public function loginByWap(array $params): string
    {
        /** @var UsersUser $userInfo */
        $userInfo = $this->mapper->getInfoByMobile($params['mobile']);
        // 密码检测
        if (! password_verify($params['password'], $userInfo->password)) {
            throw new NormalStatusException(t('login.login_password_error'));
        }
        // 事件
        $this->eventDispatcher->dispatch(new LoginAfterEvent($userInfo->id));
        // 获取jwtToken
        return app_verify()->getToken($userInfo->toArray());
    }


    /**
     * 退出登陆.
     * @return bool
     * @throws InvalidArgumentException
     */
    public function outLogin(): bool
    {
        return app_verify()->getJwt()->logout();
    }
}
