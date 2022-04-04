function changeParams(obj)
{
    var account =$('#account option:selected') .val();

    var link = createLink('report', 'dynamic', '&period=today&account=' + account);
    location.href=link;
}

