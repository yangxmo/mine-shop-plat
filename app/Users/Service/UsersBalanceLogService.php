<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Users\Service;

use App\Users\Mapper\UsersBalanceLogMapper;
use Mine\Abstracts\AbstractService;

/**
 * 表注释服务类
 */
class UsersBalanceLogService extends AbstractService
{
    /**
     * @var UsersBalanceLogMapper
     */
    public $mapper;

    public function __construct(UsersBalanceLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}