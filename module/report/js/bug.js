function changeParams(obj)
{
    var account =$('#account option:selected') .val();
    var link = createLink('report', 'bug', 'account=' + account);
    location.href=link;
}