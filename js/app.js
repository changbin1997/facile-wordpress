import Lightbox from './modules/Lightbox.js';
import CodeAndMath from './modules/CodeAndMath.js';
import StyleAndAccessibility from './modules/StyleAndAccessibility.js';

$(() => {

  // 图片灯箱初始化
  const lightbox = new Lightbox();
  lightbox.init();

  // 代码高亮和数学公式初始化
  const codeAndMath = new CodeAndMath();
  codeAndMath.init();

  // 主题配色、样式、导航栏菜单初始化
  const styleAndAccessibility = new StyleAndAccessibility();
  styleAndAccessibility.init();


  // 全局快捷键
  $(document).on('keyup', ev => {
    // 如果按下的是右方向键就跳转到下一页
    if (ev.keyCode === 39) {
      if ($('.next-page-link').length && !lightbox.isShow) {
        location.href = $('.next-page-link').attr('href');
      }
    }
    // 如果按下的是左方向键就跳转到上一页
    if (ev.keyCode === 37) {
      if ($('.previous-page-link').length && !lightbox.isShow) {
        location.href = $('.previous-page-link').attr('href');
      }
    }
  });

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
});