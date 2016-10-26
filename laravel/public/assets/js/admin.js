"use strict";
$(function () {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
var  Helper = {
  initFun: {
    setLeftSidebarActiveItem: function () {
      var sidebarItem = $('#main-menu li[class!="gui-folder"]');
      if (!window.sessionStorage) {
          return false;
      }
      if (sidebarItem.length == 0) {
          sessionStorage.sidebarItem = 0;
          return false;
      }
      sidebarItem.each(function (k, v) {
          $(this).click(function (e) {
              sessionStorage.sidebarItem = k;
          });
      });
      var cur;
      if (sessionStorage.sidebarItem != undefined) {
          cur = sidebarItem.eq(sessionStorage.sidebarItem);
      } else {
          cur = sidebarItem.eq(1);
      }
      cur.find('a').addClass('active');
    },
  }
};
Helper.initFun.setLeftSidebarActiveItem();
