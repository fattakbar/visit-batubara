<div class="row layout-top-spacing" id="cancel-row">  
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <h5><b>List User</b></h5>
            <hr><br>
            <a href="#" class="btn btn-primary btn-icon mr-2" id="create" name=><i class="fas fa-plus"></i>Create</a>
            <div class="table-responsive mb-4 mt-4">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th width="70">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="boostrapModal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Input Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                        </div>
                        <?= form_open('backend/user/user/insert_edit_action', 'class="simple-example" id="form"') ?>
                            <div class="modal-body">
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <label  class="col-sm-8 control-label text-left">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-8 control-label text-left">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" id="form-group-password">
                                    <label  class="col-sm-8 control-label text-left">Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-8 control-label text-left">Status</label>
                                    <div class="col-sm-12">
                                        <select id="status" name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="2">Non Active</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="mod">
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                                <button type="submit" id="submit" class="btn btn-primary">Save</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>                                        
        </div>
    </div>
</div>
        
<script type="text/javascript">

    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    var table;
    table = $('#datatable').DataTable({ 
        processing: true, 
        serverSide: true,
        oLanguage: {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            sProcessing: "Loading..."
        }, 
        ajax: {
            url : "<?php echo site_url('backend/user/user/index_json') ?>",
            type:"POST"
        },
        "columns": [
            {"data": "id", searchable:false, orderable: false},
            {"data": "name"},
            {"data": "email"},
            {"data": "password"},
            {"data": "image"},
            {"data": "status"},
            {"data": "action", searchable:false, orderable: false},
        ],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });
    
    $('#create').click(function(){ 
        $('#myModalLabel').text('Input user');
        $('input[name="mod"]').val('create');    
        $('#form-group-password').show();  
        $('#submit').text('Save');   
        $('#form')[0].reset();
        $('#boostrapModal-1').modal('show');
    });

    $('#form').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType : "JSON",
            success: function(res) {
                if (res.status == true) {
                    $('#form')[0].reset();
                    table.ajax.reload();
                    $('#boostrapModal-1').modal('hide');
                    toastr["success"](res.alert);
                } else {
                    toastr["error"](res.alert);
                }
            }
        });
        return false;
    });

    function edit(id) {
        $.ajax({
            url: "<?php echo site_url('backend/user/user/get_action') ?>",
            data: {id: id},
            dataType :"JSON",
            success: function(res){
                $('#myModalLabel').text('Edit User'); 
                $('#submit').text('Update');   
                $('#form')[0].reset();
                $('#boostrapModal-1').modal('show');
                $('#form-group-password').hide();
                $('input[name="mod"]').val('edit');
                var _result = res.data;
                $('input[name="name"]').val(_result.name);
                $('input[name="email"]').val(_result.email);
                $('select[name="status"]').val(_result.status).change(); 
                $('input[name="id"]').val(_result.id);
            }
        });
    }

    function confirm_delete(id) {
        $.ajax({
            url: "<?php echo site_url('backend/user/user/delete_action') ?>",
            data: {id: id},
            dataType :"JSON",
            success: function(res){
                if (res.status == true) {
                    table.ajax.reload();
                    toastr["success"](res.msg);
                }else {
                    toastr["warning"](res.msg);
                }
                
            }
        });
    }
</script>    