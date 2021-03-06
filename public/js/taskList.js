ajax_request = function(method, url, obj, callback, async, dataType) {
    var json =  JSON.stringify(obj);
    async = async==false ? async : true;

    if(!dataType) {
        dataType = "json"
    }

    $.ajax({
        type: method,
        dataType: dataType,
        async:async,
        headers:  {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/javascript, text/html, application/xml, text/xml, */*'
        },
        url: url,
        data: obj,
        success: function(res){
            if(callback) {
                callback(res);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, jqXHR, errorThrown);
        }
    });
};
$(document).ready(function(){
try {
    if (!WebSocket) {
        console.log("no websocket support");
    } else {
        var socket = new WebSocket("ws://127.0.0.1:7778/");
        socket.addEventListener("open", function (e) {
            socket.send(JSON.stringify({user: configs.user}));
            console.log("open: ", e);
        });
        socket.addEventListener("error", function (e) {
            console.log("error: ", e);
        });
        socket.addEventListener("message", function (e) {
            TaskTable.getMyTasks();
            console.log("message: ", JSON.parse(e.data));
        });
        console.log("socket:", socket);
        window.socket = socket;
    }
} catch (e) {
    console.log("exception: " + e);
}

});

var ModalForm = new function() {
    var self = this;
    var modal = $();
    var mode = 'create';
    var taskId = '';

    this.init = function() {
        modal = $('#task-modal');
        modal.modal({show: false})
        modal.on('hide.bs.modal', function (e) {
            self.clearModal()
        })
    }

    this.events = function() {
        $('#submit-modal').click(function(){
            var postData = {
                description: $('#modal-description').val(),
                state: $('#modal-state').val(),
                performer: $('#modal-performer').val()
            }

            var method;
            var url;
            if(mode === 'create') {
                method = 'POST';
                url = configs.baseUrl + '/tasks';
            } else {
                method = 'PUT';
                url = configs.baseUrl + '/tasks/' + taskId;
            }

            ajax_request(method, url, postData, function(response) {
                if(!response.errors) {
                    // security problem

                    socket.send(JSON.stringify({'users': [response.data.owner, response.data.performer]}))
                    modal.modal('hide');
                    TaskTable.getMyTasks();
                }
            });
        });
    }

    this.fillModal = function(data) {
        if(data.performer) {
            $('#modal-performer').val(data.performer);
        }

        if(data.state) {
            $('#modal-state').val(data.state);
        }

        if(data.description) {
            $('#modal-description').val(data.description);
        }
    }

    this.clearModal = function() {
        mode = 'create';

        taskId = 0;

        modal.find('select').each(function(){
            $(this).val('0');
        });

        modal.find('input,textarea').each(function(){
            $(this).val('');
        });
    }

    this.open = function() {
        modal.modal('show');
    }

    this.setMode = function(modalMode) {
        mode = modalMode;
    }

    this.setTask = function(task) {
        taskId = task;
    }

    $(document).ready(function(){
        self.init();
        self.events();
    })

}

var TaskTable = new function() {
    var self = this;
    var sortedBy  = 'created_at'
    // 0 = 'ASC', 1 = 'DESC'
    var sortOrder = 0;

    this.events = function() {
        $('#task-header').on('click', 'a', function(){
            sortedBy = $(this).attr('data-sort');
            sortOrder = sortOrder ? 0 : 1;
            self.getMyTasks();
        });

        $('#container-task-list').on('click', '.icon-delete', function() {
            var taskId = $(this).parent().parent().attr('id').split('-')[1];

            ajax_request('DELETE', configs.baseUrl + '/tasks/' + taskId, {}, function(response){
                if(!response.errors) {
                    socket.send(JSON.stringify({'users': [response.data.owner, response.data.performer]}))
                    self.getMyTasks();
                }
            })
        });

        $('#add-new-task').click(function(){
            ModalForm.setMode('create');
            ModalForm.open();
        });

        $('#container-task-list').on('click', 'li', function() {
            ajax_request('GET', configs.baseUrl + '/tasks/' + $(this).attr('id').split('-')[1], {}, function(response){

                if(!response.errors) {
                    ModalForm.setTask(response.data.id);
                    ModalForm.setMode('update');
                    ModalForm.fillModal(response.data);
                    ModalForm.open();
                }
            });

        });
    }

    this.getMyTasks = function() {
        ajax_request('GET', configs.baseUrl + '/tasks/mytasks/' + sortedBy + '?order=' + sortOrder, {}, function(response){
            if(!response.errors) {
                $('#task-list').replaceWith(response.data.view);
            }
        })
    }

    $(document).ready(function(){
        self.events();
    })
}

