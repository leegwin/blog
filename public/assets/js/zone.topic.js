jQuery(document).ready(function ($) {
    $('#first-menu-1').addClass('active');
    $('#first-nav-1').addClass('in');
    $('#zone-topic').addClass('active-menu');

    $.ajax({
        type:"post",
        url:"/api/section/list",
        success: function(data){
            data=$.parseJSON(data);
            if(data.status)
            {
                arrayList = data.data;
                for(var i=0;i<arrayList.length;i++) {
                    if(i==0){
                        $('#section').append("<option index="+arrayList[i].index+" value="+arrayList[i].sec+">"+arrayList[i].sec+"</option>");
                    }else {
                        $('#section').append("<option index="+arrayList[i].index+" value="+arrayList[i].sec+">"+arrayList[i].sec+"</option>");
                    }
                }
            }
        }
    });
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('myEditor');
    $("#btn-submit").click(function(){
        if($("#topic").val().trim()=="")
        {
            $("#topic").focus();
        }
        if(!UE.getEditor('myEditor').hasContents())
        {
            UE.getEditor('myEditor').focus();
            return;
        }
        $.ajax({
            type:"post",
            url:"/api/topic/release",
            data:{index:$("#section").find("option:selected").attr("index").trim(),
                topic:$("#topic").val().trim(),
                content:UE.getEditor('myEditor').getContent() },
            success: function(data){
                data=$.parseJSON(data);
                if(!data.status)
                {
                    $('#msg').html(data.msg);
                }else
                    tip_msg("发帖成功……");
            }
        });
    });
});