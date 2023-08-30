<?php $__env->startSection('title', '域名列表'); ?>
<?php $__env->startSection('content'); ?>
    <div id="vue" class="pt-3 pt-sm-0">
        <div class="card">
            <div class="card-header">
                域名列表
                <a href="#modal-add" data-toggle="modal" @click="storeInfo={}"
                   class="float-right btn btn-sm btn-primary">添加</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>平台</th>
                            <th>DomainId</th>
                            <th>域名</th>
                            <th title="可使用此域名的用户组">用户组</th>
                            <th>消耗积分</th>
                            <th>介绍</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody v-cloak="">
                        <tr v-for="(row,i) in data.data" :key="i">
                            <td>{{ row.did }}</td>
                            <td>{{ row.dns }}</td>
                            <td>{{ row.domain_id }}</td>
                            <td>{{ row.domain }}</td>
                            <td v-html="getDomainGroups(row.groups)"></td>
                            <td>{{ row.point }}</td>
                            <td v-html="row.desc"></td>
                            <td>{{ row.created_at }}</td>
                            <td>
                                <a href="#modal-update" class="btn btn-sm btn-info" data-toggle="modal"
                                   @click="storeInfo=Object.assign({},row)">修改
                                </a>
                                <a class="btn btn-sm btn-danger" @click="del(row.did)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer pb-0 text-center">
                <?php echo $__env->make('admin.layout.pagination', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="modal fade" id="modal-add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">域名添加</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-add">
                            <input type="hidden" name="action" value="add">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">解析平台</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select name="dns" class="form-control" v-model="dns">
                                            <option value="0">请选择域名解析平台</option>
                                            <?php $__currentLoopData = \App\Models\DnsConfig::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dns): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($dns->dns); ?>"><?php echo e($dns->dns); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="input-group-append" @click="getDomainList">
                                            <span class="input-group-text btn btn-success">获取</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">选择域名</label>
                                <div class="col-sm-9">
                                    <select name="domain" class="form-control">
                                        <option v-for="(domain,i) in domainList" :key="i"
                                                :value="domain.domain_id+','+domain.domain">
                                            {{ domain.domain }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">用户组</label>
                                <div class="col-sm-9">
                                    <div class="input_tips">
                                        <div class="form-check">
                                            <input type="checkbox" name="groups[]" value="0"
                                                   class="form-check-input" id="group-0">
                                            <label class="form-check-label"
                                                   for="group-0">所有组</label>
                                        </div>
                                        <?php $__currentLoopData = \App\Models\UserGroup::where('gid','>',99)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="groups[]" value="<?php echo e($group->gid); ?>"
                                                       class="form-check-input" id="group-<?php echo e($group->gid); ?>">
                                                <label class="form-check-label"
                                                       for="group-<?php echo e($group->gid); ?>"><?php echo e($group->name); ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="input_tips">选择可使用此域名的用户组</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">消耗积分</label>
                                <div class="col-sm-9">
                                    <input type="number" name="point" placeholder="输入用户添加每条解析消耗积分" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">域名介绍</label>
                                <div class="col-sm-9">
                                    <textarea name="desc" rows="5" placeholder="输入域名介绍内容"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="form('add')">添加</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-update">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">域名修改</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-update" v-if="storeInfo.did">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="did" :value="storeInfo.did">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">用户组</label>
                                <div class="col-sm-9">
                                    <div class="input_tips">
                                        <div class="form-check">
                                            <input type="checkbox" name="groups[]" value="0"
                                                   class="form-check-input" id="group-0"
                                                   :checked="storeInfo.groups==='0'">
                                            <label class="form-check-label"
                                                   for="group-0">所有组</label>
                                        </div>
                                        <?php $__currentLoopData = \App\Models\UserGroup::where('gid','>',99)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="groups[]" value="<?php echo e($group->gid); ?>"
                                                       class="form-check-input" id="group-<?php echo e($group->gid); ?>"
                                                       :checked="(storeInfo.groups.split(',')).indexOf('<?php echo e($group->gid); ?>')>-1">
                                                <label class="form-check-label"
                                                       for="group-<?php echo e($group->gid); ?>"><?php echo e($group->name); ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="input_tips">选择可使用此域名的用户组</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">消耗积分</label>
                                <div class="col-sm-9">
                                    <input type="number" name="point" placeholder="输入用户添加每条解析消耗积分" class="form-control"
                                           :value="storeInfo.point">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">域名介绍</label>
                                <div class="col-sm-9">
                                    <textarea name="desc" rows="5" placeholder="输入域名介绍内容" class="form-control"
                                              :value="storeInfo.desc"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="form('update')">添加</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('foot'); ?>
    <script>
        new Vue({
            el: '#vue',
            data: {
                search: {
                    page: 1
                },
                data: {},
                storeInfo: {},
                dns: 0,
                domainList: []
            },
            methods: {
                getDomainGroups: function (groups) {
                    if (groups === '0') {
                        return ' <span class="badge badge-danger">所有组</span>';
                    }
                    var str = '';
                    groups = groups.split(',');
                    <?php $__currentLoopData = \App\Models\UserGroup::where('gid','>',99)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    if (groups.indexOf('<?php echo e($group->gid); ?>') > -1) {
                        str += ' <span class="badge badge-info"><?php echo e($group->name); ?></span>';
                    }
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        return str;
                },
                getDomainList: function () {
                    var vm = this;
                    if (!this.dns) {
                        vm.$message('请选择域名解析平台', 'error');
                        return;
                    }
                    this.$post("/admin/domain", {action: 'domainList', dns: this.dns})
                        .then(function (data) {
                            if (data.status === 0) {
                                vm.domainList = data.data
                            } else {
                                vm.$message(data.message, 'error');
                            }
                        })
                },
                getList: function (page) {
                    var vm = this;
                    vm.search.page = typeof page === 'undefined' ? vm.search.page : page;
                    this.$post("/admin/domain", vm.search, {action: 'select'})
                        .then(function (data) {
                            if (data.status === 0) {
                                vm.data = data.data
                            } else {
                                vm.$message(data.message, 'error');
                            }
                        })
                },
                form: function (id) {
                    var vm = this;
                    this.$post("/admin/domain", $("#form-" + id).serialize())
                        .then(function (data) {
                            if (data.status === 0) {
                                vm.getList();
                                $("#modal-" + id).modal('hide');
                                vm.$message(data.message, 'success');
                            } else {
                                vm.$message(data.message, 'error');
                            }
                        });
                },
                del: function (id) {
                    if (!confirm('确认删除？')) return;
                    var vm = this;
                    this.$post("/admin/domain", {action: 'delete', id: id})
                        .then(function (data) {
                            if (data.status === 0) {
                                vm.getList();
                                vm.$message(data.message, 'success');
                            } else {
                                vm.$message(data.message, 'error');
                            }
                        });
                },
            },
            mounted: function () {
                this.getList();
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ftp/s/s3964999/wwwroot/src/resources/views/admin/domain/list.blade.php ENDPATH**/ ?>