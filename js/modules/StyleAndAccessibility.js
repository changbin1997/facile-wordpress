export default class StyleAndAccessibility {
  themeColor = null; // 当前主题配色

  /**
   * 主题配色、样式、导航栏菜单初始化
   */
  init() {
    this.themeColorInit();
    this.navMenu();
    this.style();
  }

  /**
   * 一些样式初始化
   */
  style() {
    // 和本站无关的链接在新窗口打开
    const currentDomain = window.location.hostname;
    $('a').each((index, el) => {
      const href = $(el).attr('href');
      if (href && !href.includes(currentDomain)) {
        $(el).attr('target', '_blank');
      }
    });

    // 评论列表的回复对象的链接鼠标移入就高亮回复对象
    $('.comment-list .parent').hover(
      (ev) => {
        const color = $('.dark-color').length ? '#212529' : '#F7E6D2';
        const id = $(ev.target).attr('data-parent');
        $(`#comment-${id}`).css('background', color);
      },
      (ev) => {
        const id = $(ev.target).attr('data-parent');
        $(`#comment-${id}`).css('background', 'none');
      }
    );

    // 评论列表的回复链接鼠标移入就高亮评论
    $('.comment-reply-link').hover(
      (ev) => {
        const color = $('.dark-color').length ? '#212529' : '#F7E6D2';
        $(ev.target).closest('.comment-item').css('background', color);
      },
      (ev) => {
        $(ev.target).closest('.comment-item').css('background', 'none');
      }
    );

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

    // 初始化 Bootstrap 工具提示
    $('[data-toggle="tooltip"]').tooltip();
  }

  /**
   * 主题配色相关的功能
   */
  themeColorInit() {
    // 根据当前的主题配色设置主题配色组件的选中状态
    if ($('#light-color').length && $('#dark-color').length) {
      // 浅色
      if ($('.light-color').length) {
        $('#light-color').prop('checked', true);
        this.themeColor = 'light-color';
      }
      // 深色
      if ($('.dark-color').length) {
        $('#dark-color').prop('checked', true);
        this.themeColor = 'dark-color';
      }
      // 跟随系统
      if ($('.auto-color').length) {
        const darkColor = window.matchMedia('(prefers-color-scheme: dark)');
        if (darkColor.matches) {
          $('#dark-color').prop('checked', true);
        } else {
          $('#light-color').prop('checked', true);
        }
        this.themeColor = 'auto-color';
      }
    }

    // 切换主题配色的 radio 改变
    $('.change-theme-color').on('change', (ev) => {
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
      $('body').removeClass(this.themeColor);
      $('body').addClass(color);
      this.themeColor = color;
    });
  }

  /**
   * 导航栏菜单
   */
  navMenu() {
    // 移动设备的展开和收起子菜单
    $('.navbar-nav .show-submenu').on('click', (ev) => {
      ev.preventDefault();
      ev.stopPropagation();
      const menuId = $(ev.target).attr('aria-controls');
      if ($(`#${menuId}`).attr('data-show') === 'false') {
        $(`#${menuId}`).dropdown('show');
        $(`#${menuId}`).attr('data-show', 'true');
        $(ev.target).attr('aria-expanded', 'true');
      } else {
        $(`#${menuId}`).dropdown('hide');
        $(`#${menuId}`).attr('data-show', 'false');
        $(ev.target).attr('aria-expanded', 'false');
      }
    });

    // 包含子菜单的项鼠标移入和移出
    $('.navbar-nav .dropdown-toggle').hover(
      (ev) => {
        if (window.innerWidth >= 768) {
          // 展开菜单
          const menuId = $(ev.target).attr('aria-controls');
          $(`#${menuId}`).dropdown('show');
          $(ev.target).attr('aria-expanded', 'true');
          $(`#${menuId}`).attr('data-show', 'true');
        }
      },
      (ev) => {
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
      }
    );

    // 导航栏子菜单链接跳转
    $('.navbar-nav .dropdown-menu a').on('click', (ev) => {
      location.href = $(ev.target).attr('href');
    });

    // 包含子菜单的链接获取和失去焦点
    $('.navbar-nav .dropdown-toggle').on({
      focus: (ev) => {
        $(ev.target).trigger('mouseover');
      },
      blur: (ev) => {
        $(ev.target).trigger('mouseout');
      }
    });
  }
}
