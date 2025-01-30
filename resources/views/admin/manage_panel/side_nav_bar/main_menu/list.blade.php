<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive boder" style="border-top-left-radius: 0; border-top-right-radius: 0; margin-bottom: 0px;">

            <div class="row">
                <div class="col-sm-12">
                    @if($itemPermission['add_item']=='1')
                    <div class="btn-group pull-right">
                        <button type="button" data-toggle="modal" data-target="#con-add-modal-mainMenu"  class="btn addBtn waves-effect waves-light"><i class=""></i> Add Main Menu</button>
                    </div>
                    @endif
                    <h4 class="header-title">Main Menu List</h4>
                </div>
            </div>

            <p class="text-muted font-14 m-b-30"></p>

            <table id="setupAdmin-mainMenu-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Main Menu Name</th>
                        <th>Main Menu Icon</th>
                        <th>Create At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-add-modal-mainMenu" data-type="customizeButton" class="con-add-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Main Menu</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveMainMenuForm" action="{{ route('admin.save.mainMenu') }}" method="POST" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Main Menu Name" class="form-control" id="name">
                                    <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group">
                                    <label for="icon">Icon<span class="text-danger">*</span></label>
                                    <input type="text" name="icon" placeholder="Main Menu Icon" class="form-control" id="icon">
                                    <span role="alert" id="iconErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="saveMainMenuBtn"  class="btn saveBtn waves-effect waves-light"><i class=""></i> <span>Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-edit-modal-mainMenu" class="con-edit-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Main Menu</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateMainMenuForm" action="{{ route('admin.update.mainMenu') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="col-md-12">

                                <input type="hidden" name="id" id="id" value="">
                                
                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Main Menu Name" class="form-control" id="name">
                                    <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group">
                                    <label for="icon">Icon<span class="text-danger">*</span></label>
                                    <input type="text" name="icon" placeholder="Main Menu Icon" class="form-control" id="icon">
                                    <span role="alert" id="iconErr" style="color:red;font-size: 12px"></span>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="updateMainMenuBtn"  class="btn updateBtn waves-effect waves-light"><i class=""></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>