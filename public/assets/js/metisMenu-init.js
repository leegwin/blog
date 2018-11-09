(function ($) {
    "use strict";
    /*MENU
     ----------------------------------*/
    $('#main-menu').metisMenu();
    $('#index-menu').metisMenu();

}(jQuery));
Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++)
    { if (this[i] == val) return i; }
    return -1;
};
Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1)
    { this.splice(index, 1); }
};//定义array原型方法。用于数组的遍历修改和删除。