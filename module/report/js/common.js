/**
 * Switch account 
 * 
 * @param  string $account 
 * @param  string $method 
 * @access public
 * @return void*/
$(document).ready(function()
{
    $('#verifyPassword').closest('form').find('#submit').click(function()
    {
        var password = $('input#verifyPassword').val().trim();
        var rand = $('input#verifyRand').val();
        $('input#verifyPassword').val(md5(md5(password) + rand));
    });
});

function switchAccount(account, method)
{
    if(method == 'dynamic')
    {
        link = createLink('report', method, 'period=' + period + '&account=' + account);
    }
    else if(method == 'todo')
    {
        link = createLink('report', method, 'account=' + account + '&type=' + type);
    }
    else
    {
        link = createLink('report', method, 'account=' + account);
    }
    location.href=link;
}

var mailsuffix = '';
var account    = new Array();
function setDefaultEmail(num)
{
    var mailValue = $('.email_' + num).val();
    if(mailValue.indexOf('@') <= 0) return;
    if(mailValue.indexOf('@') > 0) mailValue = mailValue.substr(mailValue.indexOf('@'));
    mailsuffix = mailValue;
}

function changeEmail(num)
{
    var mailValue = $('.email_' + num).val();
    if(mailsuffix != '' && (mailValue == '' || mailValue == account[num] + mailsuffix)) $('.email_' + num).val($('.account_' + num).val() + mailsuffix);
    account[num] = $('.account_' + num).val();
}

function checkPassword(password)
{
    $('#passwordStrength').html(password == '' ? '' : passwordStrengthList[computePasswordStrength(password)]);
    $('#passwordStrength').css('display', password == '' ? 'none' : 'table-cell');
}

function DateToUnix(string) {
    var f = string.split(' ', 2);
    var d = (f[0] ? f[0] : '').split('-', 3);
    var t = (f[1] ? f[1] : '').split(':', 3);
    return (new Date(
        parseInt(d[0], 10) || null,
        (parseInt(d[1], 10) || 1) - 1,
        parseInt(d[2], 10) || null,
        parseInt(t[0], 10) || null,
        parseInt(t[1], 10) || null,
        parseInt(t[2], 10) || null
        )).getTime() / 1000;
}
$(function()
{
    var options =
    {
        language: config.clientLang,
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        minView: 2,
        autoclose: true,
        todayBtn: true,
        format: 'yyyy-mm-dd',
        startDate:false
    };
    $('input#begin,input#end').fixedDate().datetimepicker(options);
    $("button#sub").click(function(){
        changeParams(this);
    });
});
