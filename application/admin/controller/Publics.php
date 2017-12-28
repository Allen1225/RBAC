{extend name="index/index" /}
{block name="main"}

<div class="content-page">

    <div class="content">

        <div class="page-heading">
            <h1><i class='fa fa-table'></i>角色管理</h1>
            <h3>角色修改</h3></div>

        <div class="row">

            <div class="col-md-12">
                <div class="widget"  >
                    <div class="widget-header transparent" style="margin-bottom:30px;">


                    </div>
                    <div class="widget-content">
                        <div >
                            <form class="form-horizontal" action="{:url('admin/role/update',['id'=>$data['id']])}" method="post">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">角色名</label>
                                    <div class="col-sm-5">
                                        <input type="input" class="form-control" id="username" name="name" value="{$data.name}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">说明</label>
                                    <div class="col-sm-5">
                                        <input type="input" class="form-control" id="name" name="remark" value="{$data.remark}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <!--<label>-->
                                                <!--<input type="radio" name="status" value="1" {if condition="$data.status eq '1'"}checked{/if} >启用-->
                                                <!--&nbsp;&nbsp;&nbsp;-->
                                                <!--<input type="radio" name="status" value="0" {if condition="$data.status eq '0'"}checked{/if}>禁用-->
                                            <!--</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:60px;">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">修改</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>


{/block}