function changeParams(obj)
{
    var begin   = DateToUnix($('#begin').val());
    var end     = DateToUnix($('#end').val());
    var account =$('#account option:selected') .val();
    if(begin>end){
        alert('结束时间不能小于开始或者开始时间不能大于结束时间');
        return false;
    }

    var link = createLink('report', 'testtask', 'account=' + account + '&begin=' + begin + '&end=' + end);
    location.href=link;
}

