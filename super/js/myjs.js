// 进行 post 传值的页面跳转
function Post(url, params) {
    var form = $("<form method='post'></form>");
    form.attr({"action":url});
    for (var pa in params) {
        var input = $("<input type='hidden'>");
        input.attr({"name":pa});
        input.val(params[pa]);
        form.append(input);
    }
    $("html").append(form);
    form.submit();
}
