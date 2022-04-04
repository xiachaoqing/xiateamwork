function changeParams(obj)
{
    var begin   = DateToUnix($('#begin').val());
    var end     = DateToUnix($('#end').val());
    var account =$('#account option:selected') .val();
    if(begin>end){
        alert('结束时间不能小于开始或者开始时间不能大于结束时间');
        return false;
    }

    var link = createLink('report', 'story', 'account=' + account + '&begin=' + begin + '&end=' + end);
    location.href=link;
}
  /**       
       * 日期 转换为 Unix时间戳
       * @param <string> 2014-01-01 20:20:20 日期格式       
       * @return <int>    unix时间戳(秒)       
       */
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