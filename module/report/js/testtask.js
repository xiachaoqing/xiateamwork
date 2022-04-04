function changeParams(obj)
{
    var account =$('#account option:selected') .val();

    var link = createLink('report', 'testtask', 'account=' + account);
    location.href=link;
}

