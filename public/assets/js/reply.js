//form check
jQuery(document).ready(function($) {

    var Request = new Object();
    Request = GetRequest();
    var key = Request['key'];
    var topicId = 0;

    var pgContainer = $("#pagination-container");
    var tpTitle = $("#topic-title");
    var tpTime = $("#topic-time");
    var tpContent = $("#topic-content");
    var pageSize = 12; // 每页显示多少条记录

    function clearContainer() {
        for(var index=0;index<pageSize;++index)
        {
            var id = "#num-"+index;
            html = '';
            $(id).html(html);
        }
    }
    function template(data) {

        var html;
        clearContainer();
        $.each(data, function(index, item){
            var id = "#num-"+index;
            html = '<div class="main-font reply-box"><div><div>'+item.content+'</div><div class="reply-show">'+item.time+'</div><div class="reply-show">'+item.index+'楼</div> </div></div>';
            $(id).html(html);
            $('#msg').html("");
        });
    }

    function instancePagination(key)
    {
        pgContainer.pagination({
            dataSource: '/api/reply/list?key='+key,
            locator: 'data.list',
            showGoInput: true,
            prevText: "&nbsp上一页&nbsp",
            nextText: "&nbsp下一页&nbsp",
            showGoButton: true,
            totalNumberLocator: function(response) {
                return response.data.total;
            },
            pageSize: pageSize,
            callback: function(data, pagination) {
                template(data);
            }
        });
    }
    var opt={
        type:"POST",
        url:"/api/topic/find",
        data:{tid:key},
        success:function(data){
            data = $.parseJSON(data);
            if(data.status){
                data = data.data;
                tpTitle.html(data.topic);
                tpTime.html(data.createTime);
                tpContent.html(data.content);
                topicId = key;
                instancePagination(key);

                ///////////////
                var ue = UE.getEditor('myEditor');
                $("#btn-submit").click(function(){
                    if(!UE.getEditor('myEditor').hasContents())
                    {
                        UE.getEditor('myEditor').focus();
                        return;
                    }
                    $.ajax({
                        type:"post",
                        url:"./api/reply/release",
                        data:{tid:topicId,
                            content:UE.getEditor('myEditor').getContent() },
                        success: function(data){
                            data=$.parseJSON(data);
                            if(!data.status)
                            {
                                $('#msg').html(data.msg);
                            }else
                                tip_msg("回复成功…");
                                instancePagination(key);
                                UE.getEditor('myEditor').setContent('');
                        }
                    });
                });
            }
        }
    };$.ajax(opt);
});