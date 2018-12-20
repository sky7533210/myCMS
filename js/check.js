/**
 * Created by sky on 2018/11/14.
 */
function checkidisnum(userid) {
    var isnumber= /^\d+$/.test(userid);
    if(!isnumber){
        $("#message").text('用户名只能为数字');
        $("#cover").fadeIn(1000);
        $("#userid")[0].focus();
        return true;
    }
    return false;
}