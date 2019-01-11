<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ url('/css/delete-modal.css') }}" />

<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">&#xE5CD;</i>
                </div>
                <h4 class="modal-title">Are you sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete the element with the ID <span id="deleted-element-id"></span> ? This process cannot be undone.</p>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-sm btn-danger  mr-auto" id="delete-confirmation">Delete</button>
                <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>