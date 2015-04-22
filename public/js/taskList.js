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

var TaskTable = new function() {
    var self = this;

    this.events = function() {
        $('#task-header').on('click', 'a', function(){
            ajax_request('GET', configs.baseUrl + '/tasks/mytasks/' + $(this).attr('data-sort'), {}, function(response){
               if(!response.errors) {
                   $('#task-list').replaceWith(response.data);
               }
            })
        });
    }

    $(document).ready(function(){
        self.events();
    })
}

var DialogBox = new function() {

}