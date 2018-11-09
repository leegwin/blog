//form check
var flag=0;//检查按照何种排序规则;0 create time ;1 like count
jQuery(document).ready(function($) {
    var Request = new Object();
    Request = GetRequest();
    var key = Request['key'];

    var pgContainer = $("#pagination-container");
    var createTime = $('#create-time');
    var likeCount = $('#like-count');
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
            html = '<div class="main-font topic-box" onclick="'+'redirect(\'/reply?key='+item.tid+'\')'+'"><div><div>主题：'+item.topic+'</div> <div class="section-show">点赞数:'+Number(item.clickLike)+'</div><div class="section-show">创建时间:'+item.createTime+'</div> </div></div>';
            $(id).html(html);
        });
    }

    function instancePagination(key,flag)
    {
        pgContainer.pagination({
            dataSource: '/api/topic/list?key='+key+'&sort='+flag,
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

    createTime.on('click',function(){
        if(flag!=0)
        {
            likeCount.removeClass("focus-color");
            likeCount.addClass("unfocus-color");
            ////////
            $(this).removeClass("unfocus-color");
            $(this).addClass("focus-color");
        }
        flag=0;
        pgContainer.pagination('destroy');
        instancePagination(key,flag);
        pgContainer.pagination(1);

    });

    likeCount.on('click',function(){
        if(flag!=1)
        {
            $(this).removeClass("unfocus-color");
            $(this).addClass("focus-color");
            ////////
            createTime.removeClass("focus-color");
            createTime.addClass("unfocus-color");
        }
        flag=1;
        pgContainer.pagination('destroy');
        instancePagination(key,flag);
        pgContainer.pagination(1);
    });
    instancePagination(key,flag);

});