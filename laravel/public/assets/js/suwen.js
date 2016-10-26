var touchEvent = 'click';
var touchendEvent = 'click';
if ('ontouchstart' in window) {
  touchEvent = 'tap';
  touchendEvent = 'touchend';
}

function uploadBox(selector) {
  var box = $(selector);
  if (box.length == 0) {
    return;
  }
  box.find('input[type="file"]').on('change', function() {
    var file = this.files[0];
    if (file.size > 5 * 1024 * 1024) {
      $(this).val('');
    } else {
      var url = 'url(' + window.URL.createObjectURL(file) + ')';
      $(this).parent().css('background-image', url).addClass('uploaded');
    }
  });
  var target;
  var modal = $('.modal-confirm-uploader');
  modal.find('.confirm-yes').on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
    if (target) {
      target.find('input[type="file"]').click();
    }
  });
  modal.find('.confirm-no').on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
    if (target) {
      target.find('input[type="file"]')[0].value = '';
      target.find('input[type="hidden"]').val('');
      target.css('background-image', null).removeClass('uploaded');
    }
  });
  modal.on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
  });
  box.on(touchEvent, function() {
    if ($(this).hasClass('uploaded')) {
      target = $(this);
      modal.addClass('open');
    } else {
      $(this).find('input[type="file"]').click();
    }
  });
}

function uploadItem(selector) {
  var box = $(selector);
  if (box.length == 0) {
    return;
  }
  box.find('input[type="file"]').on('change', function() {
    var file = this.files[0];
    if (file.size > 5 * 1024 * 1024) {
      $(this).val('');
    } else {
      var p = $(this).parent();
      p.addClass('uploaded');
      p.find('img').attr('src', window.URL.createObjectURL(file));
    }
  });
  var target;
  var modal = $('.modal-confirm-uploader');
  modal.find('.confirm-yes').on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
    if (target) {
      target.find('input[type="file"]').click();
    }
  });
  modal.find('.confirm-no').on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
    if (target) {
      target.find('input[type="file"]')[0].value = '';
      target.removeClass('uploaded').find('img').attr('src', '');
    }
  });
  modal.on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
  });
  box.on(touchEvent, function() {
    if ($(this).hasClass('uploaded')) {
      target = $(this);
      modal.addClass('open');
    } else {
      $(this).find('input[type="file"]').click();
    }
  });
}

function bindProvinceCitySelect() {
  $('.js-province').on('change', function() {
    var p = $(this);
    $.getJSON(p.attr('data-api') + '/' + p.val(), function (data) {
      var city = $('.' + p.attr('data-r'));
      if (data.length == 0) {
        city.html('');
        return;
      }
      var html = '';
      for (var i = 0; i < data.length; i++) {
        html += '<option value="' + data[i][0] + '">' + data[i][1] + '</option>';
      }
      city.html(html);
      var selected = city.attr('data-selected');
      if (selected) {
        city.val(selected);
        if (city.val() != selected) {
          city.val(data[0][0]);
        }
      }
    });
  }).triggerHandler('change');
}

function bindSelectSpecialty() {
  var limit = 3;
  var page = $('.page-specialties');
  var input = $('.js-specialties');
  if (input.length == 0) {
    return;
  }
  input.on('focus', function(e) {
    e.preventDefault();
    input.blur();
    input.parent().find('input[type="hidden"]').each(function() {
      var value = $(this).val();
      if (value) {
        $('.ap-check.spec-' + value).addClass('checked');
      }
    });
    page.addClass('open');
  });
  page.find('.ap-check').on(touchEvent, function() {
    var d = $(this);
    if (d.hasClass('checked')) {
      d.removeClass('checked');
    } else {
      if ($('.ap-check.checked').length >= limit) {
        return;
      }
      d.addClass('checked');
    }
  });
  page.find('.ap-submit button').on(touchendEvent, function(e) {
    e.preventDefault();
    var checked = page.find('.ap-check.checked');
    var names = checked.map(function() {
      return $(this).find('.ap-check-name').text();
    }).get().join('、');
    input.val(names);
    input.parent().find('input[type="hidden"]').val('');
    checked.map(function(i, ele) {
      var name = 'specialty' + (i + 1) + '_id';
      input.parent().find('input[name="' + name + '"]').val($(ele).attr('data-value'));
    });
    page.removeClass('open');
  });
}

function bindAElement() {
  if (touchEvent != 'click') {
    $(document).on('click', 'a', function(e) {
      e.preventDefault();
    });
  }
  $(document).on(touchEvent, 'a', function(e) {
    var href = $(this).attr('href');
    if (typeof href == 'string' && href.substr(0, 11) != 'javascript:') {
      e.preventDefault();
      window.location.href = href;
    }
  });
  $(document).on(touchEvent, 'button[type="submit"]', function() {
    $(this).parents('form').submit();
  });
}

function bindSaveLawyerConfirm() {
  var btn = $('.js-save-lawyer');
  if (btn.length == 0) {
    return;
  }
  var confirm = $('.save-lawyer-confirm');
  confirm.find('.confirm-yes').on(touchendEvent, function(e) {
    e.preventDefault();
    confirm.removeClass('open');
    $('form').submit();
  });
  confirm.find('.confirm-no').on(touchendEvent, function(e) {
    e.preventDefault();
    confirm.removeClass('open');
  });
  btn.on(touchEvent, function() {
    confirm.addClass('open');
  });
}

function bindSearchBar() {
  $('.js-search').on('focus', function() {
    $(this).parents('.search-bar').addClass('open');
    $('.js-search-open').addClass('open');
  });
  $('.js-search-close').on(touchEvent, function() {
    $(this).parents('.search-bar').removeClass('open');
    $('.js-search-open').removeClass('open');
  });
}

function bindOpenSpecialties() {
  var toggler = $('.js-open-specs');
  if (toggler.length == 0) {
    return;
  }
  var p = toggler.parent();
  p.find('.la-specs-extra').on(touchEvent, 'a', function() {
    if (p.hasClass('open')) {
      window.location.href = $(this).attr('data-href');
    }
  });
  toggler.on(touchEvent, function() {
    p.toggleClass('open');
  });
}

function bindAdviseSpecialtyCheck() {
  $('.js-check-advise-spec').on(touchEvent, function() {
    var d = $(this);
    d.parent().find('.checked').removeClass('checked');
    d.children().addClass('checked');
    d.parent().find('input[type="hidden"]').val(d.attr('data-value'));
  });
}

function bindSelectStars() {
  var stars = $('.js-select-stars i');
  stars.each(function(i, d) {
    $(d).on(touchEvent, function() {
      $(this).parent().find('input').val(i+1).change();
      stars.each(function(j, e) {
        if (j <= i) {
          $(e).removeClass('icon-star-empty').addClass('icon-star-full');
        } else {
          $(e).removeClass('icon-star-full').addClass('icon-star-empty');
        }
      });
    });
  });
}

function bindSelectChangeSubmit() {
  var f = $('form.js-change-submit');
  f.find('select').on('change', function() {
    f.submit();
  });
}

function bindPublicRadio() {
  $(document).on(touchEvent, '.js-public', function() {
    $(this).toggleClass('checked');
    $.get($(this).attr('data-api') + '/' + ($(this).hasClass('checked') ? '1' : '0'));
  });
}

function bindUploadCert() {
  uploadBox('.js-upload-cert');
}

function bindUploadAvatar() {
  uploadItem('.js-upload-avatar');
}

function bindAdviseUpload() {
  uploadBox('.js-advise-upload');
}

function bindAnswerSection() {
  $('.js-answer-title').on(touchEvent, function() {
    $(this).parent().toggleClass('open');
  });
}

function bindCommentSubmit() {
  $('.js-comment-submit').on(touchEvent, function() {
    $(this).parents('form').submit();
  });
}

function bindUpdateAdvisePrice() {
  var items = $('.js-advise-price');
  items.on('change', function() {
    var data = {};
    var complete = true;
    items.each(function(i, e) {
      var value = $(e).val();
      data[$(e).attr('name')] = value;
      if (value == '') {
        complete = false;
      }
    });
    if (complete) {
      $.get(items.attr('data-api'), data, function(price) {
        $('.av-price .number').text(price);
      });
    }
  });
  items.eq(0).triggerHandler('change');
}

function bindFullViewImages() {
  $('img.js-full-view').on(touchEvent, function() {
    var html = '<img src="' + $(this).attr('src') + '">';
    $('.page-full-view-image').html(html).addClass('open');
  });
  $('.page-full-view-image').on(touchendEvent, function(e) {
    e.preventDefault();
    $(this).removeClass('open');
  });
}

function bindAlertModal() {
  $('.modal-alert .modal-btn').on(touchendEvent, function(e) {
    e.preventDefault();
    $(this).parents('.modal-alert').removeClass('open');
  });
}

function bindCheckLocation() {
  var modal = $('.modal-confirm-location');
  var target;
  $('.js-confirm-location').on(touchEvent, function() {
    target = $(this);
    modal.addClass('open');
  });
  modal.find('.confirm-yes').on(touchendEvent, function(e) {
    e.preventDefault();
    if (target) {
      modal.removeClass('open');
      window.location.href = target.attr('data-href');
    }
  });
  modal.find('.confirm-no').on(touchendEvent, function(e) {
    e.preventDefault();
    modal.removeClass('open');
  });
}

function bindSendSmsCode() {
  var a = $('.js-send-sms-code');
  a.on(touchEvent, function() {
    if (!a.hasClass('disable')) {
      var phone = a.parents('form').find('input[name="phone"]').val();
      if (/^1[34578][0-9]{9}$/.test(phone)) {
        $.post(a.attr('data-api') + '/' + phone, {
          _token: a.attr('data-token')
        }, function(data) {
          if (data.success) {
            a.addClass('disable').text('重新发送(' + 60 + ')').attr('data-clock', 60);
            var d = setInterval(function() {
              var n = parseInt(a.attr('data-clock')) - 1;
              a.attr('data-clock', n);
              if (n <= 0) {
                a.removeClass('disable').text('发送验证码');
                clearInterval(d);
              } else {
                a.text('重新发送(' + n + ')');
              }
            }, 1000);
          } else {
            $('.' + a.attr('data-modal')).addClass('open')
              .find('.modal-title-big')
              .text('短信发送失败');
          }
        });
      } else {
        $('.' + a.attr('data-modal')).addClass('open')
          .find('.modal-title-big')
          .text('请输入正确的手机号');
      }
    }
  });
}

function bindPaginate() {
  var paginate = $('.js-paginate');
  if (paginate.length > 0 && PaginatorHasMore) {
    var dEle = window.document.documentElement;
    var scrollFrameHandler = function() {
      if (paginate.hasClass('js-paginate-working')) {
        return;
      }
      var offset = dEle.offsetHeight - window.pageYOffset - dEle.clientHeight;
      if (offset >= 0 && offset < 20) {
        paginate.addClass('js-paginate-working');
        var page = parseInt(paginate.attr('data-page')) || 1;
        var url = window.location.href + (window.location.search ? '&page=' : '?page=') + (++page);
        $.get(url, function(html) {
          if (html) {
            paginate.append(html);
            paginate.attr('data-page', page);
          } else {
            paginate.addClass('js-paginate-stop');
            $(window).off('scroll', scrollFrameHandler);
          }
          paginate.removeClass('js-paginate-working');
        });
      }
    };
    $(window).on('scroll', scrollFrameHandler);
  }
}

$(function() {
  bindProvinceCitySelect();
  bindSelectSpecialty();
  bindAElement();
  bindSaveLawyerConfirm();
  bindSearchBar();
  bindOpenSpecialties();
  bindAdviseSpecialtyCheck();
  bindSelectStars();
  bindSelectChangeSubmit();
  bindPublicRadio();
  bindUploadCert();
  bindUploadAvatar();
  bindAdviseUpload();
  bindAnswerSection();
  bindCommentSubmit();
  bindUpdateAdvisePrice();
  bindFullViewImages();
  bindAlertModal();
  bindCheckLocation();
  bindSendSmsCode();
  bindPaginate();
});
