<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoodsClauseTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_clause', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('服务模板');
            $table->bigIncrements('id')->comment('主键');
            $table->string('name', 15)->comment('服务名称');
            $table->json('term')->nullable()->comment('服务条款');
            $table->integer('sort')->default(1)->comment('服务条款排序');

            $table->datetimes();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_clause');
    }
}
