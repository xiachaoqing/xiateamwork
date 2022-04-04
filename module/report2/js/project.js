function changeParams(obj)
{
    var account =$('#account option:selected') .val();
    var link = createLink('report', 'project', 'account=' + account);
    location.href=link;
}