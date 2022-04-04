function changeParams(obj)
{
    var account =$('#account option:selected') .val();

    var link = createLink('report', 'story', 'account=' + account);
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