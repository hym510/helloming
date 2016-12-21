<div class="modal fade" id="modal-equipment-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-inline" enctype="multipart/form-data" method="post" action="{{ action('Admin\EquipmentsController@postImportImg') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="img">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">上传文件</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">
                            文件
                        </label>
                        <div class="col-sm-8">
                            <input type="file" name="img">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        上传
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>