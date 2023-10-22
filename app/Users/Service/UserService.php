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

use App\Users\Mapper\UserMapper;
use Mine\Abstracts\AbstractService;

/**
 * 用户数据表服务类
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
}