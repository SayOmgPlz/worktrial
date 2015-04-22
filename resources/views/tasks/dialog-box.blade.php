<div class="modal fade" id="task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">New message</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group clearfix">
                        <div class="col-md-6">
                            <label for="performer" class="control-label">Performer:</label>
                            <select type="text" class="form-control" name="performer" id="modal-performer">
                                    <option value="0">None</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="control-label">State:</label>
                            <select type="text" class="form-control" name="state" id="modal-state">
                                <option value="0">Closed</option>
                                <option value="1">Opened</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Message:</label>
                        <textarea class="form-control" id="modal-description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-modal">Save</button>
            </div>
        </div>
    </div>
</div>