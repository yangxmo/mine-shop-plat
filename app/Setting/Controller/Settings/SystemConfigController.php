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
namespace App\Setting\Controller\Settings;

use App\Setting\Request\SettingConfigRequest;
use App\Setting\Service\SettingConfigService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 系统配置控制器
 * Class SystemConfigController.
 */
#[Controller(prefix: 'setting/config'), Auth]
class SystemConfigController extends MineController
{
    #[Inject]
    protected SettingConfigService $service;

    /**
     * 获取配置列表.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('setting:config, setting:config:index')]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getList($this->request->all()));
    }

    /**
     * 保存配置.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('save'), Permission('setting:config:save'), OperationLog]
    public function save(SettingConfigRequest $request): ResponseInterface
    {
        return $this->service->save($request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 更新配置.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('update'), Permission('setting:config:update'), OperationLog]
    public function update(SettingConfigRequest $request): ResponseInterface
    {
        return $this->service->updated($this->request->input('key'), $request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 按 keys 更新配置.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('updateByKeys'), Permission('setting:config:update'), OperationLog]
    public function updateByKeys(): ResponseInterface
    {
        return $this->service->updatedByKeys($this->request->all()) ? $this->success() : $this->error();
    }

    /**
     * 删除配置.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping('delete'), Permission('setting:config:delete'), OperationLog]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 清除配置缓存.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('clearCache'), Permission('setting:config:clearCache'), OperationLog]
    public function clearCache(): ResponseInterface
    {
        return $this->service->clearCache() ? $this->success() : $this->error();
    }

    /**
     * 远程万能通用列表接口.
     */
    #[PostMapping('remote'), RemoteState(true)]
    public function remote(): ResponseInterface
    {
        return $this->success($this->service->getRemoteList($this->request->all()));
    }
}
