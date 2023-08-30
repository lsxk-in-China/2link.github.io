<?php $__env->startSection('title', '后台首页'); ?>
<?php $__env->startSection('content'); ?>
    <div id="vue" class="pt-3 pt-sm-0">
        <div class="card">
            <div class="card-header">
                添加域名简单教程
            </div>
            <div class="card-body">
                <div class="list-group-item">
                    1、点击菜单栏的<a href="/admin/config/dns">接口配置</a>，先对你使用的域名解析平台的接口进行配置！
                </div>
                <div class="list-group-item">
                    2、点击菜单栏的<a href="/admin/domain/list">域名列表</a>，然后点击添加》选择你配置的解析平台》获取，然后选择你要添加的域名，然后保存！
                </div>
<div class="list-group-item">
				    3、推荐主机：<a href="http://www.zeiyun.cn">www.zeiyun.cn</a>长期运营稳定的主机商
				</div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ftp/s/s3964999/wwwroot/src/resources/views/admin/index.blade.php ENDPATH**/ ?>