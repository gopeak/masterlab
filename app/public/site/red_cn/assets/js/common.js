$(function(){
/*小屏幕导航点击关闭菜单*/
if (screen.width < 769){
  $(".navbar-collapse a").click(function(){
     $(".navbar-collapse").collapse("hide");
  }); 
}
/*animate动画插件*/
if (screen.width < 769){
  new WOW().init();
}

})
/*top 二维码显示*/
$('.top li.code').on('click',function(){
$('.top li.code .code_img').slideToggle()
})
// 选项卡
$(document).ready(function(){
  $(".tab li").click(function(){
  $(".tab li").eq($(this).index()).addClass("cur").siblings().removeClass('cur');
  $(".tab_details").hide().eq($(this).index()).show();
  });
});
//*案例模板页面banner切换*/
if (screen.width < 769){
          $('#case_modal').css('background-image','url(assets/img/caseBanner.jpg)')
          $('#case_modals').css('background-image','url(assets/img/modalBanner.png)')
        }
/*导航固定*/
$(window).scroll(function() { 
        var top = $(window).scrollTop();
        if(top>=100){
            $("nav").addClass("x_fixed");
        }else{
            $("nav").removeClass("x_fixed");
        }
}); 
if (screen.width < 769){
   $(window).scroll(function() { 
        var top = $(window).scrollTop();
        if(top>=30){
            $("nav").addClass("x_fixed");
        }else{
            $("nav").removeClass("x_fixed");
        }
   }); 
}
/*新闻中心 移动端控制字体多少*/
if (screen.width < 769){
$(".index_news .media-body p").each(function(){
var maxwidth=20;
if($(this).text().length>maxwidth){
$(this).text($(this).text().substring(0,maxwidth));
$(this).html($(this).html()+'...');
}
});
}