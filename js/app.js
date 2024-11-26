$(() => {
  let maxImg = false;  // 是否开启图片灯箱
  let themeColor = null;  // 当前主题配色

  // 图片灯箱初始化
  imageLightboxInit();

  // 代码高亮初始化
  codeHighlightInit();

  // 和本站无关的链接在新窗口打开
  const currentDomain = window.location.hostname;
  $('a').each((index, el) => {
    const href = $(el).attr('href');
    if (href && !href.includes(currentDomain)) {
      $(el).attr('target', '_blank');
    }
  });

  // 移动设备的展开和收起子菜单
  $('.navbar-nav .show-submenu').on('click', ev => {
    ev.preventDefault();
    ev.stopPropagation();
    const menuId = $(ev.target).attr('aria-controls');
    if ($(`#${menuId}`).attr('data-show') === 'false') {
      $(`#${menuId}`).dropdown('show');
      $(`#${menuId}`).attr('data-show', 'true');
      $(ev.target).attr('aria-expanded', 'true');
    }else {
      $(`#${menuId}`).dropdown('hide');
      $(`#${menuId}`).attr('data-show', 'false');
      $(ev.target).attr('aria-expanded', 'false');
    }
  });

  // 包含子菜单的项鼠标移入和移出
  $('.navbar-nav .dropdown-toggle').hover(ev => {
    if (window.innerWidth >= 768) {
      // 展开菜单
      const menuId = $(ev.target).attr('aria-controls');
      $(`#${menuId}`).dropdown('show');
      $(ev.target).attr('aria-expanded', 'true');
      $(`#${menuId}`).attr('data-show', 'true');
    }
  }, ev => {
    if (window.innerWidth >= 768) {
      const menuId = $(ev.target).attr('aria-controls');
      const timeout = setTimeout(() => {
        $(`#${menuId}`).dropdown('hide');
        $(ev.target).attr('aria-expanded', 'false');
        $(`#${menuId}`).attr('data-show', 'false');
      }, 100);

      $(`#${menuId}`).on({
        mouseenter: () => {
          clearTimeout(timeout);
        },
        mouseleave: () => {
          // 鼠标离开菜单列表后收起菜单
          $(`#${menuId}`).dropdown('hide');
          $(ev.target).attr('aria-expanded', 'false');
          $(`#${menuId}`).attr('data-show', 'false');
        }
      });

      $(`#${menuId} a`).on({
        focusin: () => {
          clearTimeout(timeout);
        },
        focusout: () => {
          // 焦点离开菜单列表后收起菜单
          setTimeout(() => {
            if (!$(`#${menuId}`).has(':focus').length) {
              $(`#${menuId}`).dropdown('hide');
              $(ev.target).attr('aria-expanded', 'false');
              $(`#${menuId}`).attr('data-show', 'false');
            }
          }, 0);
        }
      });
    }
  });

  // 导航栏子菜单链接跳转
  $('.navbar-nav .dropdown-menu a').on('click', ev => {
    location.href = $(ev.target).attr('href');
  });

  // 包含子菜单的链接获取和失去焦点
  $('.navbar-nav .dropdown-toggle').on({
    focus: ev => {
      $(ev.target).trigger('mouseover');
    },
    blur: ev => {
      $(ev.target).trigger('mouseout');
    }
  });

  // 评论列表的回复对象的链接鼠标移入就高亮回复对象
  $('.comment-list .parent').hover(ev => {
    const color = $('.dark-color').length ? '#212529' : '#F7E6D2';
    const id = $(ev.target).attr('data-parent');
    $(`#comment-${id}`).css('background', color);
  }, ev => {
    const id = $(ev.target).attr('data-parent');
    $(`#comment-${id}`).css('background', 'none');
  });

  // 评论列表的回复链接鼠标移入就高亮评论
  $('.comment-reply-link').hover(ev => {
    const color = $('.dark-color').length ? '#212529' : '#F7E6D2';
    $(ev.target).closest('.comment-item').css('background', color);
  }, ev => {
    $(ev.target).closest('.comment-item').css('background', 'none');
  });

  // 调整取消回复的链接
  if ($('#reply-title #cancel-comment-reply-link').length) {
    const link = `
    <a rel="nofollow" class="btn btn-outline-primary ml-2" href="${$('#cancel-comment-reply-link').attr('href')}">
      ${$('#cancel-comment-reply-link').html()}
    </a>
    `;
    $('#cancel-comment-reply-link').remove();
    $('#submit-comment').after(link);
  }

  // 根据当前的主题配色设置主题配色组件的选中状态
  if ($('#light-color').length && $('#dark-color').length) {
    // 浅色
    if ($('.light-color').length) {
      $('#light-color').prop('checked', true);
      themeColor = 'light-color'
    }
    // 深色
    if ($('.dark-color').length) {
      $('#dark-color').prop('checked', true);
      themeColor = 'dark-color'
    }
    // 跟随系统
    if ($('.auto-color').length) {
      const darkColor = window.matchMedia('(prefers-color-scheme: dark)');
      if (darkColor.matches) {
        $('#dark-color').prop('checked', true);
      }else {
        $('#light-color').prop('checked', true);
      }
      themeColor = 'auto-color';
    }
  }

  // 切换主题配色的 radio 改变
  $('.change-theme-color').on('change', ev => {
    // 获取选中的颜色
    const color = $(ev.target).attr('id');
    // 获取当前的时间戳
    let time = Date.parse(new Date());
    // 在当前的时间戳上 + 180天
    time += 15552000000;
    time = new Date(time);
    // 写入主题配色 cookie
    document.cookie = `facile-theme-color=${color};expires=Tue, ${time.toGMTString()};path=/`;
    // 通过更换 class 来更改配色
    $('body').removeClass(themeColor);
    $('body').addClass(color);
    themeColor = color;
  });

  // 全局快捷键
  $(document).on('keyup', ev => {
    // 如果是 ESC 就关闭大图
    if (ev.keyCode === 27 && $('#max-img-box').length) {
      $('.max-img-features-btn .hide-img').click();
    }
    // 如果按下的是 + 就放大图片
    if (ev.keyCode === 107 && $('#max-img-box').length) {
      $('.max-img-features-btn .big').click();
    }
    // 如果按下的是 - 就缩小图片
    if (ev.keyCode === 109 && $('#max-img-box').length) {
      $('.max-img-features-btn .small').click();
    }
    // 如果按下的是右方向键就跳转到下一页
    if (ev.keyCode === 39) {
      if ($('.next-page-link').length) {
        location.href = $('.next-page-link').attr('href');
      }
    }
    // 如果按下的是左方向键就跳转到上一页
    if (ev.keyCode === 37) {
      if ($('.previous-page-link').length) {
        location.href = $('.previous-page-link').attr('href');
      }
    }
  });

  // 文章内是否有表格
  if ($('.post-content table').length > 0) {
    // 把 wordpress 输出的表格替换为 bootstrap 的响应式表格
    $('.post-content table').addClass('table table-bordered table-striped table-hover');
    $('.post-content table').wrap('<div class="table-responsive"></div>');
  }

  // 监听滚动条
  $(document).on('scroll', () => {
    // 返回顶部的按钮是否存在
    if ($('#to-top-btn').length) {
      // 如果滚动条高度 > 屏幕高度
      if ($(document).scrollTop() > window.innerHeight) {
        // 显示返回顶部按钮
        $('#to-top-btn').removeClass('d-none');
      }else {
        // 隐藏返回顶部按钮
        $('#to-top-btn').addClass('d-none');
      }
    }
  });

  // 返回顶部按钮点击
  $('#to-top-btn').on('click', () => {
    // 返回顶部，让第一个链接获取焦点
    $('html').animate({
      scrollTop: 0
    }, 400);
    $('header .navbar-brand').get(0).focus();
    return false;
  });

  // 初始化 Bootstrap 工具提示
  $('[data-toggle="tooltip"]').tooltip();

  // 代码高亮初始化
  function codeHighlightInit() {
    if ($('body').attr('data-codehighlight') === '1' && $('pre').length) {
      for (let i = 0;i < $('pre').length;i ++) {
        // 是否是代码块
        if ($('pre').eq(i).children('code').length) {
          // 添加代码高亮样式
          hljs.highlightBlock($('pre code').eq(i).get(0));

          // 创建和添加拷贝按钮
          const btnEl = document.createElement('button');
          btnEl.className = 'copy-code-btn btn btn-outline-secondary btn-sm';
          btnEl.setAttribute('type', 'button');
          btnEl.innerHTML = '<i class="icon-copy"></i>';
          btnEl.setAttribute('aria-label', facileTranslations.copyCodeBtn);
          btnEl.setAttribute('data-clipboard-target', '#code-' + i);
          btnEl.setAttribute('title', facileTranslations.copyCodeBtn);
          btnEl.setAttribute('data-toggle', 'tooltip');
          btnEl.setAttribute('data-placement', 'left');
          btnEl.setAttribute('id', 'copy-btn-' + i);
          $('pre').eq(i).prepend(btnEl);
          // 给代码块添加一个 id 方便拷贝
          $('pre code').eq(i).attr('id', 'code-' + i);
          // 初始化拷贝模块
          const clipboard = new ClipboardJS('.copy-code-btn');
          // 拷贝成功
          clipboard.on('success', ev => {
            // 把工具提示更改为拷贝成功
            $(ev.trigger).attr('title', facileTranslations.copySuccess);
            $(ev.trigger).attr('data-original-title', facileTranslations.copySuccess);
            $(ev.trigger).tooltip('update');
            $(ev.trigger).tooltip('show');
            // 延迟 1 秒后把工具提示更改为拷贝代码
            setTimeout(() => {
              $(ev.trigger).attr('title', facileTranslations.copyCodeBtn);
              $(ev.trigger).attr('data-original-title', facileTranslations.copyCodeBtn);
            }, 1000);
          });
          // 拷贝出错
          clipboard.on('error', ev => {
            $(ev.trigger).attr('title', facileTranslations.copyError);
            $(ev.trigger).attr('data-original-title', facileTranslations.copyError);
            $(ev.trigger).tooltip('hide');
            $(ev.trigger).tooltip('show');
            setTimeout(() => {
              $(ev.trigger).attr('title', facileTranslations.copyCodeBtn);
              $(ev.trigger).attr('data-original-title', facileTranslations.copyCodeBtn);
            }, 1000);
          });
        }
      }
    }
  }

  // 图片灯箱初始化
  function imageLightboxInit() {
    let imgWH = '';  // 记录图片的宽高
    let imgDirection = 0;  // 图片方向
    let contentImgSize = null;  // 文章区域的图片尺寸

    $('.post-content img').on('click', ev => {
      // 如果图片还没有加载完成
      if ($(ev.target).attr('class') === 'load-img') return false;
      // 获取图片的真实尺寸
      const imgSize = {
        w: ev.target.naturalWidth,
        h: ev.target.naturalHeight
      };

      // 获取文章内的图片尺寸
      contentImgSize = {
        w: $(ev.target).width(),
        h: $(ev.target).height(),
        l: $(ev.target).offset().left,
        t: $(ev.target).offset().top
      };

      // 如果图片的真实尺寸超出屏幕尺寸就重新设置大图的尺寸
      if (imgSize.w > window.innerWidth) {
        imgSize.p = imgSize.h / imgSize.w * 100;
        imgSize.w = window.innerWidth;
        imgSize.h = imgSize.w * imgSize.p / 100;
      }
      if (imgSize.h > window.innerHeight) {
        imgSize.p = imgSize.w / imgSize.h * 100;
        imgSize.h = window.innerHeight;
        imgSize.w = imgSize.h * imgSize.p / 100;
      }

      // 图片灯箱HTML
      const maxImgTemplate = `
    <div id="max-img-box" role="dialog" aria-modal="true" aria-labelledby="img-info">
      <div id="max-img-bg"></div>
      <div class="btn-group max-img-features-btn">
          <button type="button" class="btn big" aria-label="${facileTranslations.zoomIn}" title="${facileTranslations.zoomIn}">
              <i class="icon-zoom-in"></i>
          </button>
          <button type="button" class="btn small" aria-label="${facileTranslations.zoomOut}" title="${facileTranslations.zoomOut}">
              <i class="icon-zoom-out"></i>
          </button>
          <button type="button" class="btn spin-left" aria-label="${facileTranslations.rotateLeft}" title="${facileTranslations.rotateLeft}">
              <i class="icon-undo"></i>
          </button>
          <button type="button" class="btn spin-right" aria-label="${facileTranslations.rotateRight}" title="${facileTranslations.rotateRight}">
              <i class="icon-redo"></i>
          </button>
          <button type="button" class="btn hide-img" aria-label="${facileTranslations.closeImage}" title="${facileTranslations.closeImage}">
              <i class="icon-cancel-circle"></i>
          </button>
      </div>
      <img src="" alt="image" class="shadow" id="max-img">
      <p id="img-info" class="text-light text-center"></p>
    </div>
    `;
      // 把图片灯箱插入到页面
      $('body').append(maxImgTemplate);

      // 显示大图
      $('#max-img-box').show();
      // 显示半透明背景
      $('#max-img-bg').fadeIn(250);
      // 设置大图的初始尺寸和位置
      $('#max-img').css({
        display: 'inline',
        width: contentImgSize.w,
        height: contentImgSize.h,
        top: contentImgSize.t,
        left: contentImgSize.l
      });
      // 把大图移动到屏幕中心
      $('#max-img').animate({
        width: imgSize.w,
        height: imgSize.h,
        left: window.innerWidth / 2 - imgSize.w / 2,
        top: $(document).scrollTop() + window.innerHeight / 2 - imgSize.h / 2
      }, 250, 'linear', () => {
        // 显示图片操作按钮
        $('.max-img-features-btn').css('display', 'flex');
        // 让关闭图片的按钮获取焦点
        $('.max-img-features-btn .hide-img').focus();
        // 显示和设置图片描述
        $('#img-info').show();
        $('#img-info').html($(ev.target).attr('alt'));
        // 把图片灯箱的状态设置为开启
        maxImg = true;
      });
      // 设置大图的 src 和 alt
      $('#max-img').attr({
        src: $(ev.target).attr('src'),
        alt: $(ev.target).attr('alt')
      });
      // 把图片角度设置为默认
      if (imgDirection !== 0) {
        imgDirection = 0;
        $('#max-img').css('transform', 'rotate(' + imgDirection + 'deg)');
      }
      // 禁止滚动
      $('html').addClass('stop-scrolling');

      // 给图片灯箱添加事件
      // 在图片灯箱开启的情况下滑动屏幕禁止页面滚动
      $('#max-img-bg, .max-img-features-btn, #img-info').on('touchmove', ev => {
        if (maxImg) {
          ev.preventDefault();
          return false;
        }
      });

      // 大图手指拖拽
      $('#max-img').on('touchstart', ev => {
        const X = ev.touches[0].pageX - $(ev.target).get(0).offsetLeft;
        const Y = ev.touches[0].pageY - $(ev.target).get(0).offsetTop;

        $(document).on('touchmove', ev => {
          $('#max-img').css({
            left: ev.touches[0].pageX - X,
            top: ev.touches[0].pageY - Y
          });
        });

        $(document).on('touchend', () => {
          $(document).off('touchmove');
        });
        return false;
      });

      // 大图拖拽
      $('#max-img').on('mousedown',  ev => {
        const X = ev.clientX - $(ev.target).get(0).offsetLeft;
        const Y = ev.clientY - $(ev.target).get(0).offsetTop;

        $(document).on('mousemove', ev => {
          $('#max-img').css({
            left: ev.clientX - X,
            top: ev.clientY - Y
          });
        });

        $(document).on('mouseup', ev => {
          $(document).off('mousemove');
        });
        return false;
      });

      // 大图左旋转
      $('.max-img-features-btn .spin-left').on('click', () => {
        imgDirection -= 90;
        $('#max-img').css('transition', '0.3s');
        $('#max-img').css('transform', `rotate(${imgDirection}deg)`);
        setTimeout(function () {
          $('#max-img').css('transition', '0s');
        }, 300);
      });

      // 大图右旋转
      $('.max-img-features-btn .spin-right').on('click', () => {
        imgDirection += 90;
        $('#max-img').css('transition', '0.3s');
        $('#max-img').css('transform', `rotate(${imgDirection}deg)`);
        setTimeout(function () {
          $('#max-img').css('transition', '0s');
        }, 300);
      });

      // 图片放大
      $('.max-img-features-btn .big').on('click',  () => {
        $('#max-img').animate({
          width: $('#max-img').width() + $('#max-img').width() / 5,
          height: $('#max-img').height() + $('#max-img').height() / 5
        }, 250);
      });

      // 图片缩小
      $('.max-img-features-btn .small').on('click', () => {
        // 如果图片的宽度或高度 < 40px 将不再缩小
        if ($('#max-img').width() <= 80 || $('#max-img').height() <= 80) return false;
        $('#max-img').animate({
          width: $('#max-img').width() - $('#max-img').width() / 5,
          height: $('#max-img').height() - $('#max-img').height() / 5
        }, 250);
      });

      // 大图鼠标滚动
      $('#max-img').on('mousewheel DOMMouseScroll', ev => {
        if (!maxImg) return false;
        if (ev.originalEvent.wheelDelta === undefined) return false;
        if (ev.originalEvent.wheelDelta >  0) {
          // 放大图片
          $('.max-img-features-btn .big').click();
        }else {
          // 缩小图片
          $('.max-img-features-btn .small').click();
        }
      });

      // 大图的关闭按钮点击
      $('.max-img-features-btn .hide-img').on('click', () => {
        maxImg = false;
        // 隐藏半透明背景
        $('#max-img-bg').fadeOut(250);
        // 隐藏图片描述
        $('#img-info').hide();
        // 隐藏图片功能区按钮
        $('.max-img-features-btn').hide();
        $('html').removeClass('stop-scrolling');
        $('#max-img').animate({
          width: contentImgSize.w,
          height: contentImgSize.h,
          top: contentImgSize.t,
          left: contentImgSize.l
        }, 250, 'linear', () => {
          $('#max-img').hide();
          $('#max-img').attr({
            src: '',
            alt: ''
          });
          $('#max-img-box').hide();
          $('#max-img-box').remove();
        });
      });

      // 关闭大图按钮按下 tab
      $('.max-img-features-btn .hide-img').on('keydown', ev => {
        ev.preventDefault();
        if (ev.keyCode === 9) {
          // 让放大图片按钮获取焦点
          $('.max-img-features-btn .big').focus();
        }
        if (ev.keyCode === 13) {
          $('.max-img-features-btn .hide-img').click();
        }
      });
    });
  }
});