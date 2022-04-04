function changeDate(date)
{
    location.href = createLink('report', 'todo', 'account=' + account + '&type=' + date.replace(/\-/g, ''));
}

function changeParams(obj)
{
    var account =$('#account option:selected') .val();

    var link = createLink('report', 'todo', 'account=' + account);
    location.href=link;
}
$(function()
{
    $(".colorbox").modalTrigger({width:960, type:'iframe'});
});
