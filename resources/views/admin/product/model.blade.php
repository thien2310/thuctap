<div class="modal fade" id="createTag" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" id="submitTagProduct">
        @csrf

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="semi-bold">Thêm thẻ tag</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Mã thẻ</label>
                        <span class="text-danger">(*)</span>
                        <input class="form-control" type="text" name="code" id="codeg">
                        <span class="text-danger error-text tag-code-error">
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tên thẻ</label>
                        <span class="text-danger">(*)</span>
                        <input class="form-control" type="text" name="name" id="nameTag">
                        <input type="hidden" name="type" value="10">
                        <span class="text-danger error-text tag-name-error" role="alert">
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Hủy</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>

    </form>

    <!-- /.modal-dialog -->
</div>