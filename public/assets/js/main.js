//form check
var flag=0;//检查按照何种排序规则;0 visit count ;1 topic count
jQuery(document).ready(function($) {

    var pgContainer = $("#pagination-container");
    var topicCount = $('#topic-count');
    var vistCount = $('#visit-count');

    function clearContainer() {
        var cell=4,html;// 每行显示多少条记录
        var row,column;
        for(var index=0;index<12;++index)
        {
            row=Math.floor(index/cell);
            column=index%cell;
            var id = "#num-"+row+"-"+column;
            html = '';
            $(id).html(html);
        }
    }
    function template(data) {

        var cell=4,html;// 每行显示多少条记录
        var row,column;
        clearContainer();
        $.each(data, function(index, item){
            row=Math.floor(index/cell);
            column=index%cell;
            var id = "#num-"+row+"-"+column;
            html = '<div class="main-font section-box" onclick="'+'redirect(\'/topic?key='+item.index+'\')'+'"><img class="imgSize" src="'+item.img+'"><div><div>'+item.name+'</div> <div class="section-show">'+item.mark+'</div> </div></div>';
            $(id).html(html);
        });
    }
    var pageSize = 12; // 每页显示多少条记录
    function instancePagination(flag)
    {
        pgContainer.pagination({
            dataSource: '/api/section/list?sort='+flag,
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
    instancePagination(flag);
    vistCount.on('click',function(){
        if(flag!=0)
        {
            $(this).removeClass("unfocus-color");
            $(this).addClass("focus-color");
            ////////
            topicCount.removeClass("focus-color");
            topicCount.addClass("unfocus-color");
        }
        flag=0;
        pgContainer.pagination('destroy');
        instancePagination(flag);
        pgContainer.pagination(1);
    });

    topicCount.on('click',function(){
        if(flag!=1)
        {
            vistCount.removeClass("focus-color");
            vistCount.addClass("unfocus-color");
            ////////
            $(this).removeClass("unfocus-color");
            $(this).addClass("focus-color");
        }
        flag=1;
        pgContainer.pagination('destroy');
        instancePagination(flag);
        pgContainer.pagination(1);

    });
});