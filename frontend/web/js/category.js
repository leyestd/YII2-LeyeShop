/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var cid;
var navX;
var navY;
var category;

$('.category').hover(function(e){   
    cid=  "#"+"category"+$(this).data('id');
    navX=$(this).width()+45;
    navY=$(this).offset().top-100;
    $(cid).css("display","block");
    $(cid).css('top',navY);
    $(cid).css('left',navX);
    $(this).css('border-right','none');
    category=$(this);
    
    },function(e){
          if(e.pageY>$(this).offset().top+$(this).height()+19 || e.pageY<$(this).offset().top || e.pageX<$(this).offset().left) {
               $(cid).css("display","none");
               $(this).css('border-right','');
          }      
  });
  
  $('.children').mouseleave(function(){
      $(this).css('display','none');
      category.css('border-right','');
  });
