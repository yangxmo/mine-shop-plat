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
namespace App\Setting\Controller\Tools;

use App\Setting\Request\SettingCrontabRequest;
use App\Setting\Service\SettingCrontabLogService;
use App\Setting\Service\SettingCrontabService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 定时任务控制器
 * Class CrontabController.
 */
#[Controller(prefix: 'setting/crontab'), Auth]
class CrontabController extends MineController
{
    /**
     * 计划任务服务
     */
    #[Inject]
    protected SettingCrontabService $service;

    /**
     * 计划任务日志服务
     */
    #[Inject]
    protected SettingCrontabLogService $logService;

    /**
     * 获取列表分页数据.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('setting:crontab, setting:crontab:index')]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 获取日志列表分页数据.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping('logPageList')]
    public function logPageList(): ResponseInterface
    {
        return $this->success($this->logService->getPageList($this->request->all()));
    }

    /**
     * 保存数据.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('save'), Permission('setting:crontab:save'), OperationLog]
    public function save(SettingCrontabRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 立即执行定时任务
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping('run'), Permission('setting:crontab:run'), OperationLog]
    public function run(): ResponseInterface
    {
        $id = $this->request->input('id', null);
        if (is_null($id)) {
            return $this->error();
        }
        return $this->service->run($id) ? $this->success() : $this->error();
    }

    /**
     * 获取一条数据信息.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping('read/{id}'), Permission('setting:crontab:read')]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新数据.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping('update/{id}'), Permission('setting:crontab:update'), OperationLog]
    public function update(int $id, SettingCrontabRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping('delete'), Permission('setting:crontab:delete')]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 删除定时任务日志.
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping('deleteCrontabLog'), Permission('setting:crontab:deleteCrontabLog'), OperationLog('删除定时任务日志')]
    public function deleteCrontabLog(): ResponseInterface
    {
        return $this->logService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 更改状态
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping('changeStatus'), Permission('setting:crontab:update'), OperationLog]
    public function changeStatus(): ResponseInterface
    {
        return $this->service->changeStatus((int) $this->request->input('id'), (string) $this->request->input('status'))
            ? $this->success() : $this->error();
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
