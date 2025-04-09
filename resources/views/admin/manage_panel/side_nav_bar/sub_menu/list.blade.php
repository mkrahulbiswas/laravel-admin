<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive boder" style="border-top-left-radius: 0; border-top-right-radius: 0; margin-bottom: 0px;">

            <div class="row">
                <div class="col-sm-12">
                    @if($itemPermission['add_item']=='1')
                    <div class="btn-group pull-right">
                        <button type="button" data-toggle="modal" data-target="#con-add-modal-subMenu"  class="btn addBtn waves-effect waves-light"><i class=""></i> Add Sub Menu</button>
                    </div>
                    @endif
                    <h4 class="header-title">Sub Menu List</h4>
                </div>
            </div>

            <p class="text-muted font-14 m-b-30"></p>

            <table id="setupAdmin-subMenu-listing" class="tableStyle table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Main Menu Name</th>
                        <th>Sub Menu Name</th>
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
        <div id="con-add-modal-subMenu" data-type="customizeButton" class="con-add-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Sub Menu</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="saveSubMenuForm" action="{{ route('admin.save.subMenu') }}" method="POST" novalidate="">
                        @csrf

                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="mainMenu">Main Menu<span class="text-danger">*</span></label>
                                    <select name="mainMenu" id="mainMenu" class="selectpicker" data-style="btn-primary btn-custom">
                                        <option value="">Select Button Type</option>
                                        @foreach ($mainMenu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span role="alert" id="mainMenuErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Sub Menu Name" class="form-control" id="name">
                                    <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="addAction">Add Action<span class="text-danger">*</span></label>
                                        <select name="addAction" id="addAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Add Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="addActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="editAction">Edit Action<span class="text-danger">*</span></label>
                                        <select name="editAction" id="editAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Edit Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="editActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="detailsAction">Details Action<span class="text-danger">*</span></label>
                                        <select name="detailsAction" id="detailsAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Details Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="detailsActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="deleteAction">Delete Action<span class="text-danger">*</span></label>
                                        <select name="deleteAction" id="deleteAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Delete Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="deleteActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="statusAction">Status Action<span class="text-danger">*</span></label>
                                        <select name="statusAction" id="statusAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Status Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="statusActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="otherAction">Other Action<span class="text-danger">*</span></label>
                                        <select name="otherAction" id="otherAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select other Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="otherActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="saveSubMenuBtn"  class="btn saveBtn waves-effect waves-light"><i class=""></i> <span>Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-edit-modal-subMenu" class="con-edit-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Sub MEnu</h4>
                        <button type="button" class="close Close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="updateSubMenuForm" action="{{ route('admin.update.subMenu') }}" method="POST" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <input type="hidden" name="id" id="id" value="">

                        <div class="modal-body">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="mainMenu">Main Menu<span class="text-danger">*</span></label>
                                    <select name="mainMenu" id="mainMenu" class="selectpicker" data-style="btn-primary btn-custom">
                                        <option value="">Select Button Type</option>
                                        @foreach ($mainMenu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span role="alert" id="mainMenuErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Sub Menu Name" class="form-control" id="name">
                                    <span role="alert" id="nameErr" style="color:red;font-size: 12px"></span>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="addAction">Add Action<span class="text-danger">*</span></label>
                                        <select name="addAction" id="addAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Add Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="addActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="editAction">Edit Action<span class="text-danger">*</span></label>
                                        <select name="editAction" id="editAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Edit Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="editActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="detailsAction">Details Action<span class="text-danger">*</span></label>
                                        <select name="detailsAction" id="detailsAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Details Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="detailsActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="deleteAction">Delete Action<span class="text-danger">*</span></label>
                                        <select name="deleteAction" id="deleteAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Delete Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="deleteActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="statusAction">Status Action<span class="text-danger">*</span></label>
                                        <select name="statusAction" id="statusAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select Status Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="statusActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="otherAction">Other Action<span class="text-danger">*</span></label>
                                        <select name="otherAction" id="otherAction" class="selectpicker" data-style="btn-success btn-custom">
                                            <option value="">Select other Action</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <span role="alert" id="otherActionErr" style="color:red;font-size: 12px"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="alert alert-danger" id="alert" style="display: none">
                            <center><strong id="validationAlert"></strong></center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn closeBtn waves-effect Close" data-dismiss="modal"><i class=""></i> Close</button>
                            <button type="submit" id="updateSubMenuBtn"  class="btn updateBtn waves-effect waves-light"><i class=""></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div id="con-detail-modal-subMenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail View Of Sub Menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="com-md-12">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mainMenu"><b>Main Menu: </b></label>
                                        <span id="mainMenu"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="subMenu"><b>Sub Menu: </b></label>
                                        <span id="subMenu"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="link"><b>Link: </b></label>
                                        <span id="link"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastSegment"><b>Last Segment: </b></label>
                                        <span id="lastSegment"></span>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="addAction"><b>Add Action: </b></label>
                                            <span id="addAction"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editAction"><b>Edit Action: </b></label>
                                            <span id="editAction"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="detailsAction"><b>Details Action: </b></label>
                                            <span id="detailsAction"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="deleteAction"><b>Delete Action: </b></label>
                                            <span id="deleteAction"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="statusAction"><b>Status Action: </b></label>
                                            <span id="statusAction"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="otherAction"><b>Other Action: </b></label>
                                            <span id="otherAction"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>